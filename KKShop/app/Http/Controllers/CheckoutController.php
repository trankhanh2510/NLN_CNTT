<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DateTime;
use Session;
use App\Models\City;
use App\Models\Wards;
use App\Models\Province;
use App\Models\ShippingFee;
use App\Models\Slider;
use App\Models\KhachHang;
use App\Models\Shipping;
use App\Models\Category;
use App\Models\Brand;
use App\Http\Requests; //lay yeu cau data tu post 
use Illuminate\Support\Facades\Redirect; //nhuw return tra ve nhung chi vao ten tren link
session_start();


class CheckoutController extends Controller
{
    //kiểm tra xem khách hàng đã đăng nhập chưa
     public function Authlogin_kh(){
        //test nếu bị admin xóa tài khoản thì session kh_id không tồn tại trong table KhachHang
        // $kh_id = DB::table('KhachHang')->where('kh_id',Session::get('kh_id'))->first();
        $kh_id = KhachHang::find(Session::get('kh_id'));
        if($kh_id){
            return Redirect::to('trang-chu');
        }else{
            Session::put('kh_id',null); //cho bằng null nếu tài khoản đã bị admin xóa 
            Session::put('kh_ten',null);
            return Redirect::to('login-checkout')->send();
        }
    } 


//---------------------PROFILE KHÁCH HÀNG--------------//
    public function login_checkout(){ //trang đăng nhập đăng ký

        $slider = Slider::orderby('slider_id','DESC')->where('slider_trangthai','1')->get();
        $loai_sp = Category::orderby('l_id','desc')->where('TrangThai','1')->get();
        $thuonghieu_sp = Brand::orderby('th_id','desc')->where('th_TrangThai','1')->get();
    	return view('pages.ThanhToan.login_checkout')->with('loai_sp',$loai_sp)->with('thuonghieu_sp',$thuonghieu_sp)->with('slider',$slider);
    	
    }
    public function them_khachhang(Request $request){
    	$data =  array();
    	$data['kh_Ten'] = $request->ten_kh;
    	$data['kh_email'] = $request->mail;
    	$data['kh_password'] = md5($request->password_kh);
    	$data['kh_sdt'] = $request->sdt_kh;
        $email = KhachHang::orderby('kh_id','DESC')->get();
        $test = 0;
        foreach ($email as $key => $value) {
            if($value->kh_email == $data['kh_email']){
                $test=1;
                break;
            }
        }
        if($test == 0){
            if($request->password_kh==$request->password_khtest){
            	$kh_id = DB::table('KhachHang')->insertGetId($data); //insertGetId() là lấy luôn dl đã insert 
            	Session::put('kh_id',$kh_id);
                $ten = KhachHang::find($kh_id);
                Session::put('kh_ten',$ten->kh_Ten);
            	return Redirect::to('them-checkout');
            }else{
                Session::put('errorttkmess','Xác nhận mật khẩu không đúng! Hãy nhập lại'); 
                return Redirect::to('login-checkout');
            }
        }else{
            Session::put('errorttkmess','Email này đã dùng để đăng ký một tài khoản khác! Hãy nhập lại'); 
            return Redirect::to('login-checkout');
        }
    }
	public function login_customer(Request $request){
    	$kh_email = $request->email_kh;
    	$kh_password = md5($request->password_kh);

        $email =  KhachHang::where('kh_email',$kh_email)->first();
            if($email){

            	$result = KhachHang::where('kh_email',$kh_email)->where('kh_password',$kh_password)->first();
            	if($result){ 
            		Session::put('kh_id',$result->kh_id);
                    Session::put('kh_ten',$result->kh_Ten);
                    $shipping = Shipping::where('kh_id',$result->kh_id)->orderby('shipping_id','desc')->first();
                    if($shipping){
                        Session::put('shipping_id',$shipping->shipping_id);
                    }
            		return Redirect::to('don-hang'); //goi ten ten tren link
            	}else{
            		Session::put('errordnmessage','Mật khẩu hoặc email sai! Hãy đăng nhập lại'); //put la gan chuoi vao message
            		return Redirect::to('login-checkout');
            	}
            }else{
                Session::put('errordnmessage','Không tồn tại tài khoản này! Hãy tạo tài khoản mới');
                    return Redirect::to('login-checkout');
            }
    }

    public function logout_customer(){
        Session::flush();
    	return Redirect::to('login-checkout'); 

    }

    //-----------------Profile------------//
    public function profile_customer(){
        $this->Authlogin_kh();

        $slider = Slider::orderby('slider_id','DESC')->where('slider_trangthai','1')->get();
        $loai_sp = Category::orderby('l_id','desc')->where('TrangThai','1')->get();
        $thuonghieu_sp = Brand::orderby('th_id','desc')->where('th_TrangThai','1')->get();
        $profile = KhachHang::find(Session::get('kh_id'));
        return view('pages.KhachHang.show_tt_kh')->with('loai_sp',$loai_sp)->with('thuonghieu_sp',$thuonghieu_sp)->with('profile',$profile)->with('slider',$slider);
    }

    public function sua_profile(){
        $this->Authlogin_kh();

        $slider = Slider::orderby('slider_id','DESC')->where('slider_trangthai','1')->get();
        $loai_sp = Category::orderby('l_id','desc')->where('TrangThai','1')->get();
        $thuonghieu_sp = Brand::orderby('th_id','desc')->where('th_TrangThai','1')->get();
        $kh_data = KhachHang::find(Session::get('kh_id'));
        return view('pages.KhachHang.sua_tt_kh')->with('loai_sp',$loai_sp)->with('thuonghieu_sp',$thuonghieu_sp)->with('kh_data',$kh_data)->with('slider',$slider);
        
    }

     public function capnhat_profile(Request $request){
        $this->Authlogin_kh();
        $data = KhachHang::find(Session::get('kh_id'));
        $data->kh_Ten = $request->kh_ten;
        $data->kh_email = $request->kh_email;
        $data->kh_sdt = $request->kh_sdt;
        $testpass = md5($request['kh_password']);
        $kh_test = KhachHang::orderby('kh_id','DESC')->whereNotIn('kh_id',[Session::get('kh_id')])->get();
        $test_email = 0;
        foreach ($kh_test as $key => $va) {
            if($va->kh_email == $request->kh_email){
                $test_email = 1;
                break;
            }
        }
        if($data->kh_password==$testpass){
            if($test_email == 0){
                $data->save();
                Session::put('cntkmessage','Cập nhật thành công!'); //put la gan chuoi vao message
                return Redirect::to('profile-customer');
            }else{
                Session::put('errorcntkmessage','Email này đã có người dùng,Cập nhật không thành công!'); 
                return Redirect()->back();
            }
        }else{
            Session::put('errorcntkmessage','Sai mật khẩu,Cập nhật không thành công!'); 
            return Redirect()->back();
        }
    }


    public function sua_pass(){
        $this->Authlogin_kh();

        $slider = Slider::orderby('slider_id','DESC')->where('slider_trangthai','1')->get();
        $loai_sp = Category::orderby('l_id','desc')->where('TrangThai','1')->get();
        $thuonghieu_sp = Brand::orderby('th_id','desc')->where('th_TrangThai','1')->get();
        return view('pages.KhachHang.sua_pass')->with('loai_sp',$loai_sp)->with('thuonghieu_sp',$thuonghieu_sp)->with('slider',$slider);
        
    }

    public function capnhat_pass(Request $request){
        $this->Authlogin_kh();
        $khachhang = KhachHang::find($request->kh_id);
        
        if($khachhang->kh_id==$request->kh_id && $khachhang->kh_password==md5($request->kh_passold)){ 
            if($request->kh_passnew==$request->kh_passnewtest){
                KhachHang::where('kh_id',$request->kh_id)->update(['kh_password' => md5($request->kh_passnew)]);
                return Redirect::to('trang-chu'); //goi ten ten tren link
            }else{
               Session::put('message','Xác nhận lại mật khẩu sai! Hãy đăng nhập lại'); 
                return Redirect::to('sua-pass'); 
            }
        }else{
            Session::put('message','Mật khẩu sai! Hãy đăng nhập lại'); 
            return Redirect::to('sua-pass');
        }
    }


    //------------THÔNG TIN NHẬN HÀNG-----------//
    //
    public function select_shippingfee_home(Request $request){
       $data = $request->all();
        if($data['action']){
            $output = '';
            if($data['action']=="city"){
                $select_province = Province::where('matp',$data['ma_id'])->orderby('maqh','ASC')->get();
                    $output.='<option>---Quận huyện---</option>';
                foreach($select_province as $key => $province){
                    $output.='<option value="'.$province->maqh.'">'.$province->qh_ten.'</option>';
                }

            }else{

                $select_wards = Wards::where('maqh',$data['ma_id'])->orderby('xaid','ASC')->get();
                    $output.='<option>---xã phường thị trấn---</option>';
                foreach($select_wards as $key => $ward){
                    $output.='<option value="'.$ward->xaid.'">'.$ward->xptt_ten.'</option>';
                }
            }
            echo $output;
        }
    }
    public function checkout(){
        $this->Authlogin_kh();

        $slider = Slider::orderby('slider_id','DESC')->where('slider_trangthai','1')->get();
        $loai_sp = Category::orderby('l_id','desc')->where('TrangThai','1')->get();
        $thuonghieu_sp = Brand::orderby('th_id','desc')->where('th_TrangThai','1')->get();
        $city = City::orderby('matp','ASC')->get();
        $shipping_test = Shipping::where('kh_id',Session::get('kh_id'))->orderby('shipping_id','desc')->first();
        if($shipping_test){
            $shipping_data = Shipping::find($shipping_test->shipping_id);
            Session::put('shipping_id',$shipping_test->shipping_id);
            return view('pages.ThanhToan.show_checkout')->with('loai_sp',$loai_sp)->with('thuonghieu_sp',$thuonghieu_sp)->with('shipping_data',$shipping_data)->with('slider',$slider);
    
        }else{
             return view('pages.ThanhToan.them_checkout')->with('loai_sp',$loai_sp)->with('thuonghieu_sp',$thuonghieu_sp)->with('slider',$slider)->with('city',$city);
        }
    }

    public function them_checkout(){
        $this->Authlogin_kh();

        $slider = Slider::orderby('slider_id','DESC')->where('slider_trangthai','1')->get();
        $loai_sp = Category::orderby('l_id','desc')->where('TrangThai','1')->get();
        $thuonghieu_sp = Brand::orderby('th_id','desc')->where('th_TrangThai','1')->get();
        $city = City::orderby('matp','ASC')->get();
        return view('pages.ThanhToan.them_checkout')->with('loai_sp',$loai_sp)->with('thuonghieu_sp',$thuonghieu_sp)->with('slider',$slider)->with('city',$city);
    }
    public function sua_checkout(){
        $this->Authlogin_kh();
        if(Session::get('shipping_id')){

            $slider = Slider::orderby('slider_id','DESC')->where('slider_trangthai','1')->get();
            $loai_sp = Category::orderby('l_id','desc')->where('TrangThai','1')->get();
            $thuonghieu_sp = Brand::orderby('th_id','desc')->where('th_TrangThai','1')->get();
            $city = City::orderby('matp','ASC')->get();
            $shipping_data = Shipping::find(Session::get('shipping_id'));
            return view('pages.ThanhToan.sua_checkout')->with('loai_sp',$loai_sp)->with('thuonghieu_sp',$thuonghieu_sp)->with('shipping_data',$shipping_data)->with('slider',$slider)->with('city',$city);
        }else{
            return Redirect::to('them-checkout');
        }
    }

    public function capnhat_shipping(Request $request){
        $this->Authlogin_kh();
        $data = Shipping::find(Session::get('shipping_id'));
        $data->kh_id = Session::get('kh_id');
        $data->shipping_ten = $request->shipping_ten;
        $data->shipping_sdt = $request->shipping_sdt;
        $data->shipping_note = $request->shipping_note;
        
        if($request->city && $request->province && $request->wards && $request->shipping_diachi){
            $ten_tp = City::find($request->city);
            $ten_qh = Province::find($request->province);
            $ten_xptt = Wards::find($request->wards);
            $data_diachi = '';
            $data_diachi .= ''.$request->shipping_diachi.' '.$ten_xptt->xptt_ten.' '.$ten_qh->qh_ten.' '.$ten_tp->tp_ten;
            $data->shipping_diachi = $data_diachi;
            $shippingfee = ShippingFee::where('xaid',$request->wards)->first();
            if ($shippingfee) {
                $data->phi = $shippingfee->fee;
            }else{
                $data->phi = 35000;
            }
        }
        $data->save();
        Session::put('message','Cập nhật thành công!'); 
        return Redirect::to('checkout');
    }

    public function save_shipping(Request $request){
        $this->Authlogin_kh();
        $ten_tp = City::find($request->matp);
        $ten_qh = Province::find($request->maqh);
        $ten_xptt = Wards::find($request->xaid);
        $diachi = '';
        $diachi.=''.$request->diachi.' '.$ten_xptt->xptt_ten.' '.$ten_qh->qh_ten.' '.$ten_tp->tp_ten;
        $data =  array();
        $data['kh_id'] = Session::get('kh_id');
        $data['shipping_ten'] = $request->hoten;
        $data['shipping_diachi'] = $diachi;
        $data['shipping_sdt'] = $request->sdt;
        $data['shipping_note'] = $request->note;
        $data['shipping_trangthai'] = 0;
        if($request->xaid){
            $shippingfee = ShippingFee::where('xaid',$request->xaid)->first();
        } 
        if ($shippingfee) {
            $data['phi'] = $shippingfee->fee;
        }else{
            $data['phi'] = 35000;
        }
        
        $shipping_id = DB::table('Shipping')->insertGetId($data); //insertGetId() là lấy luôn dl đã insert 
        Session::put('shipping_id',$shipping_id);
        return Redirect::to('checkout');
    }
  

//----------------------ADMIN------------------//
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

        //------------------Shipping--------------//
    public function danhsach_shipping(){
        $this->Authlogin();
        $test = Shipping::where('shipping_trangthai',0)->first();
        if($test){
            $data = Shipping::where('shipping_trangthai',0)->get();
            return view('Admin.DonHang.show_shipping')->with('data',$data);
        }else{
            Session::put('message','Trống');
            return view('Admin.DonHang.show_shipping');
        }
    }
    public function xoa_shipping($shipping_id){
        $this->Authlogin();
        Session::put('mess','Xóa thành công!');
        Shipping::destroy($shipping_id);
        return Redirect()->back();
    }

}

