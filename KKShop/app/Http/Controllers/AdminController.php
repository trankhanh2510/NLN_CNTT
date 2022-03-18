<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Product;
use App\Models\Admin;
use App\Models\KhachHang;
use Session;
use App\Models\Shipping;
use App\Http\Requests; 
use Illuminate\Support\Facades\Redirect; //nhu return tra ve nhung chi vao ten tren link

session_start();
class AdminController extends Controller
{
    //kiem tra xem co dang nhap hay khong neu khong tra ve login admin
    public function Authlogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('admin.dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    } 

    public function index(){
    	return view('admin_login'); //goi trang php
	}
    //post
    public function login(Request $request){
    	$admin_email = $request->admin_email;
    	$admin_password = md5($request->admin_password);

        //not model
    	// $result = DB::table('tbl_admin')->where('admin_email',$admin_email)->where('admin_password',$admin_password)->first();
 
    	$result = Admin::where('admin_email',$admin_email)->where('admin_password',$admin_password)->first();
        if($result){
    		Session::put('admin_name',$result->admin_name); //gan ten admin vao admin_name
    		Session::put('admin_id',$result->admin_id);
    		return Redirect::to('/dashboard'); //goi ten ten tren link
    	}else{
    		Session::put('message','Mật khẩu hoặc email sai! Hãy đăng nhập lại'); //put la gan chuoi vao message
    		return Redirect::to('/admin');
    	}

    }
    public function show_dashboard(){
        $this->Authlogin();
        return view('admin.dashboard'); //goi trang php
    }
     public function logout(){
        $this->Authlogin(); //goi kt co login chua
    	Session::put('admin_name',null);
    	Session::put('admin_id',null);
    	return Redirect::to('/admin'); 

    }
//--------------------------------Profile Admin----------------//

    public function profile_admin(){
        $this->Authlogin();

       $profile = Admin::find(Session::get('admin_id'));

       $ql_profile = view('admin.ThongTin.show_tt_admin')->with('profile',$profile);
       return view('admin_layout')->with('admin.ThongTin.show_tt_admin',$ql_profile );
    }

    public function sua_profile_admin(){
        $this->Authlogin(); //goi kt co login chua
        $profile = Admin::find(Session::get('admin_id'));

       $ql_profile = view('admin.ThongTin.sua_tt_admin')->with('profile',$profile);
       return view('admin_layout')->with('admin.ThongTin.sua_tt_admin',$ql_profile );
    }

    public function capnhat_profile_admin( Request $request){
        $this->Authlogin(); //goi kt co login chua de khong luu vao database
        
        $data = $request->all();
        $Admin = Admin::find(Session::get('admin_id'));
        $Admin->admin_name = $data['admin_name'];
        $Admin->admin_email = $data['admin_email'];
        $Admin->admin_phone = $data['admin_phone'];
        $testpass = md5($request['admin_password']);
        $kq = Admin::where('admin_password',$testpass)->first();
        if($kq){
            $Admin->save();
            Session::put('message','Cập nhật thành công!'); //put la gan chuoi vao message
            return Redirect::to('profile-admin');
        }else{
            Session::put('message','Sai mật khẩu,Cập nhật không thành công!'); //put la gan chuoi vao message
            return Redirect()->back();
        }
    }

    public function password_admin(){
        $this->Authlogin();

       $ql_pass = view('admin.ThongTin.sua_password_admin');
       return view('admin_layout')->with('admin.ThongTin.sua_password_admin',$ql_pass );
    }

     public function capnhat_password_admin(Request $request){
        $this->Authlogin(); //goi kt co login chua de khong luu vao database
        
        $data = $request->all();
        $Admin = Admin::find(Session::get('admin_id'));
        $Admin->admin_password = md5($data['admin_passwordnew']);
        $testpasswordold = md5($request['admin_passwordold']);
        $kq = Admin::where('admin_password',$testpasswordold)->first();

        if($kq){
             if($request->admin_passwordnew==$request->test_admin_passwordnew){
                $Admin->save();
                Session::put('message','Cập nhật password thành công!'); //put la gan chuoi vao message
                return Redirect::to('profile-admin');
            }else{
               Session::put('message','Xác nhận lại mật khẩu sai! Hãy đăng nhập lại'); //put la gan chuoi vao message
                return Redirect()->back();
            }
        }else{
            Session::put('message','Sai mật khẩu,Cập nhật không thành công!'); //put la gan chuoi vao message
            return Redirect()->back();
        }
    }


    // ------------------DS-KHÁCH HÀNG-------------------//
    public function danhsach_kh(){
        $data = KhachHang::all();
        return view('Admin.KhachHang.show_kh')->with('data_kh',$data);
    }

    public function xoa_khachhang($kh_id){
        //cập nhật lại số lượng nếu có đơn hàng
        $sanpham = DB::table('Shipping')
        ->join('DatHang','Shipping.shipping_id','=','DatHang.shipping_id')
        ->join('ChiTietDatHang','DatHang.dh_id','=','DatHang.dh_id')
        ->join('SanPham','ChiTietDatHang.sp_id','=','SanPham.sp_id')  
        ->where('Shipping.kh_id',$kh_id)
        ->where('DatHang.dh_trangthai','0')
        ->select('SanPham.*','ChiTietDatHang.ctdh_soluong')
        ->get();
            foreach ($sanpham as $key => $val) {
              $soluong_con = $val->ctdh_soluong + $val->sp_soluong;
                Product::where('sp_id',$val->sp_id)->update(['sp_soluong' => $soluong_con]);   
            }
        Session::put('message','Xóa khách hàng thành công!');
        KhachHang::destroy($kh_id);
        return Redirect('danhsach-kh');
    }
    public function chitiet_khachhang($kh_id){
        $ttkh = KhachHang::find($kh_id);
        $ttch = Shipping::where('Shipping.kh_id',$kh_id)->get();
        $ttdh = DB::table('Shipping')
        ->join('DatHang','Shipping.shipping_id','=','DatHang.shipping_id')
        ->where('Shipping.kh_id',$kh_id)->select('DatHang.*')->get();
        return view('Admin.KhachHang.show_ctkh')->with('ttkh',$ttkh)->with('ttch',$ttch)->with('ttdh',$ttdh);
    }
}
?>