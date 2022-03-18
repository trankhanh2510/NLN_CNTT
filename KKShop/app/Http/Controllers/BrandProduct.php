<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Brand;
use App\Models\Slider;
use App\Models\Category;
use App\Models\Product;
use App\Models\Gallery;
use App\Models\Order;
use App\Models\OrderDetails;
use Session;
use App\Http\Requests; //lay yeu cau data tu post 
use Illuminate\Support\Facades\Redirect; //nhuw return tra ve nhung chi vao ten tren link
session_start();

class BrandProduct extends Controller
{

     //------------------ADMIN---------------//
     //
    //kiem tra xem co dang nhap hay khong neu khong tra ve login admin
    public function Authlogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('admin.dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    } 

    //goi page 
    public function them_th_sp(){
        $this->Authlogin();
    	return view('admin.ThuongHieu.them_thuonghieu_sp');

    }
    //lay data 
    public function danhsach_th_sp(){
        $this->Authlogin();
        //không dùng models
       //$danhsach_th_sp =  DB::table('ThuongHieu')->get(); //truy xuat database lay data
       
       //sử dụng models
       $danhsach_th_sp = Brand::orderby('th_id','DESC')->get();
       //take(1) lấy 1 
       
       $ql_danhsach_th_sp = view('admin.ThuongHieu.danhsach_thuonghieu_sp')->with('danhsach_th_sp',$danhsach_th_sp); 

       return view('admin_layout')->with('admin.ThuongHieu.danhsach_th_sp',$ql_danhsach_th_sp); 
    }


    //save data vao database
     public function luu_th_sp(Request $request){
        $this->Authlogin(); //goi kt co login chua de khong luu vao database
        //không dùng models
    	// $data  = array();
    	// $data['th_Ten'] = $request->ten_th_sp;
    	// $data['th_MoTa'] = $request->mota_th_sp;
    	// $data['th_TrangThai'] = $request->trangthai_th_sp;
    	// DB::table('ThuongHieu')->insert($data); 
         
        //sử dụng Models
        $data = $request->all();
        $brand = new Brand();
        $brand->th_Ten = $data['ten_th_sp'];
        $brand->th_MoTa = $data['mota_th_sp'];
        $brand->th_TrangThai = $data['trangthai_th_sp'];
        $brand->save();
    	Session::put('message','Thêm thương hiệu sản phẩm thành công!'); //gan thong diep cho bien message 
    	return Redirect::to('them-th-sp'); //dua ve page co dui them-th-sp
    }
    
    //sua data voi id truyen vao
    public function hienthi_th_sp($id_th_sp){
        $this->Authlogin(); 
        Brand::where('th_id',$id_th_sp)->update(['th_TrangThai'=>1]);
        Product::where('th_id',$id_th_sp)->update(['sp_TrangThai'=>1]);
        Session::put('message','cập nhật thương hiệu sản phẩm thành công!');
        return Redirect::to('danhsach-th-sp');
    }

    public function an_th_sp($id_th_sp){
        $this->Authlogin(); 
        Brand::where('th_id',$id_th_sp)->update(['th_TrangThai'=>0]);
        Product::where('th_id',$id_th_sp)->update(['sp_TrangThai'=>0]);
        Session::put('message','cập nhật thương hiệu sản phẩm thành công!');
        return Redirect::to('danhsach-th-sp');
    }
     //lay data tu mot id truyen vao
    public function sua_th_sp($id_th_sp){
        $this->Authlogin(); 

        //không dùng controller
        //$sua_th_sp =  DB::table('ThuongHieu')->where('th_id',$id_th_sp)->get();
        
        //dùng models
        $sua_th_sp =  Brand::find($id_th_sp); //không cần xài foreach
        //hoặc Brand::where('th_id',$id_th_sp)->get(); cần xài foreach

       $ql_danhsach_th_sp = view('admin.ThuongHieu.sua_thuonghieu_sp')->with('sua_th_sp',$sua_th_sp);
       return view('admin_layout')->with('admin.ThuongHieu.sua_th_sp',$ql_danhsach_th_sp );
    }
    //thay doi data cua database
    public function capnhat_th_sp( Request $request,$id_th_sp){
        $this->Authlogin(); 
        
        // không dùng models
        //  $data = array();
        // $data['th_Ten']= $request->ten_th_sp;
        // $data['th_Mota'] = $request->mota_th_sp;
        // DB::table('ThuongHieu')->where('th_id',$id_th_sp)->update($data);
        

        //dùng models
        $data = $request->all();
        $brand = Brand::find($id_th_sp);
        $brand->th_Ten = $data['ten_th_sp'];
        $brand->th_MoTa = $data['mota_th_sp'];
        $brand->save();
        Session::put('message','cập nhật thương hiệu sản phẩm thành công!');
        return Redirect::to('danhsach-th-sp');
    }
    //xoa data cua database
    public function xoa_th_sp($id_th_sp){
        $this->Authlogin(); 
        // Brand::destroy($id_th_sp);
        // return Redirect::to('danhsach-th-sp');

        $sp = Product::where('th_id',$id_th_sp)->get();
        foreach ($sp as $key => $value_sp) {
            $hinh = Gallery::where('sp_id',$value_sp->sp_id)->get();
            if($hinh){
              foreach ($hinh as $key => $value) {
                unlink('public/uploads/product/'.$value->asp_hinhanh);
              }
            }
            // cập nhật lại tổng tiền đơn hàng nếu sản phẩm của đơn hàng đó bị xóa 
            $test_ctdh = OrderDetails::where('sp_id',$value_sp->sp_id)->first();
            if($test_ctdh){
                $ctdh = OrderDetails::where('sp_id',$value_sp->sp_id)->get();
                foreach ($ctdh as $key => $val) {
                    $dh = Order::where('dh_id',$val->dh_id)->first();
                    $dh->dh_tongtien = $dh->dh_tongtien - $val->ctdh_dongia;
                    $dh->dh_tongdh = $dh->dh_tongdh - $val->ctdh_dongia;
                    $dh->save();
                }
            }
        }
        Brand::destroy($id_th_sp);

        // xóa đơn hàng nếu không có chi tiết đơn hàng
        $del_dh = Order::orderby('dh_tongtien','ASC')->get();
        foreach ($del_dh as $key => $valu) {
            if($valu->dh_tongtien == 0){
                Order::destroy($valu->dh_id);
            }
        }
        Session::put('message','Xóa thương hiệu sản phẩm thành công!');
        return Redirect::to('danhsach-th-sp');
    
    }
     //------------------End function ADMIN---------------//
     //
     



    //------------------TRANG BÁN HÀNG---------------//
    public function show_th_sp_home($id_th_sp){
        $slider = Slider::orderby('slider_id','DESC')->where('slider_trangthai','1')->get();
        $loai_sp = Category::orderby('l_id','desc')->where('TrangThai','1')->get();
        $thuonghieu_sp = Brand::orderby('th_id','desc')->where('th_TrangThai','1')->get();
        $loai_sp_th = DB::table('LoaiSanPham')->where('th_TrangThai','1')
        ->join('SanPham','SanPham.l_id','=','LoaiSanPham.l_id')
        ->join('ThuongHieu','ThuongHieu.th_id','=','SanPham.th_id')
        ->where('ThuongHieu.th_id',$id_th_sp)
        ->select('LoaiSanPham.*')->get();
        if($id_th_sp=='gio-hang'){
            return Redirect::to('gio-hang');
        }else{
            // kiểm tra nếu Admin xóa thương hiệu này rồi thì về trang home
            $test_th_sp_id = Product::where('sp_TrangThai','1')->where('th_id',$id_th_sp)->first();
            if($test_th_sp_id){
                if($test_th_sp_id){
                if(isset($_GET['sort_by'])){
                    $sort_by = $_GET['sort_by'];
                    if($sort_by == 'tang_dan'){
                       $A = 'sp_gia';
                       $B = 'ASC';
                    }elseif($sort_by == 'giam_dan'){
                        $A = 'sp_gia';
                        $B = 'DESC';
                    }elseif($sort_by == 'kytu_az'){
                        $A = 'sp_Ten';
                        $B = 'ASC';
                    }elseif($sort_by == 'kytu_za'){
                        $A = 'sp_Ten';
                        $B = 'DESC';
                    }
                }else{
                    $A = 'sp_id';
                    $B = 'DESC';
                }
                if(isset($_GET['start_price']) && isset($_GET['end_price'])){
                    if($_GET['start_price'] == '' || $_GET['end_price'] == ''){
                        $_GET['start_price'] = Product::min('sp_gia');
                        $_GET['end_price'] = Product::max('sp_gia');
                    }
                    $min_price = $_GET['start_price'];
                    $max_price = $_GET['end_price'];
                    $th_sp_id = DB::table('SanPham')->where('sp_TrangThai','1')
                    ->join('AnhSanPham','SanPham.sp_id','=','AnhSanPham.sp_id')
                    ->where('th_id',$id_th_sp)->where('AnhSanPham.asp_trangthai',1)->whereBetween('sp_gia',[$min_price,$max_price])
                    ->select('SanPham.*','AnhSanPham.asp_hinhanh')->paginate(3)->appends(request()->query());
                }elseif(isset($_GET['category'])){
                    $category_filter = $_GET['category'];
                    $category_arr = explode(",", $category_filter);
                    $th_sp_id = DB::table('SanPham')->where('sp_TrangThai','1')
                    ->join('AnhSanPham','SanPham.sp_id','=','AnhSanPham.sp_id')
                    ->where('th_id',$id_th_sp)->where('AnhSanPham.asp_trangthai',1)->whereIn('l_id',$category_arr)
                    ->select('SanPham.*','AnhSanPham.asp_hinhanh')->paginate(3)->appends(request()->query());
                    

                }else{
                    $th_sp_id = DB::table('SanPham')->where('sp_TrangThai','1')
                    ->join('AnhSanPham','SanPham.sp_id','=','AnhSanPham.sp_id')
                    ->where('th_id',$id_th_sp)->where('AnhSanPham.asp_trangthai',1)->orderby($A,$B)
                    ->select('SanPham.*','AnhSanPham.asp_hinhanh')->paginate(3)->appends(request()->query());
                }
                $th_ten = Brand::find($id_th_sp);
                return view('pages.ThuongHieu.show_thuonghieu_sp')->with('loai_sp',$loai_sp)->with('thuonghieu_sp',$thuonghieu_sp)->with('th_sp_id',$th_sp_id)->with('th_ten',$th_ten)->with('slider',$slider)->with('loai_sp_th',$loai_sp_th);
            }else{
                return Redirect::to('trang-chu');
                }
            
            }
       }
    }
}
?>
