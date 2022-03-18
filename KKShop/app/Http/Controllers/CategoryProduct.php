<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Models\Slider;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Gallery;
use App\Models\Brand;
use App\Models\Product;
use App\Http\Requests; //lay yeu cau data tu post 
use Illuminate\Support\Facades\Redirect; //nhuw return tra ve nhung chi vao ten tren link
session_start();


class CategoryProduct extends Controller
{

    //------------------ADMIN---------------//
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
    public function them_loai_sp(){
        $this->Authlogin(); 
    	return view('admin.LoaiSanPham.them_loai_sp');

    }
     //save data vao database
     public function luu_loai_sp(Request $request){
        $this->Authlogin(); 
        $category = new Category();
        $category->Ten = $request->ten_loai_sp;
        $category->MoTa = $request->mota_loai_sp;
        $category->TrangThai = $request->trangthai_loai_sp;
        $category->save(); 
        Session::put('message','Thêm loại sản phẩm thành công!'); 
        return Redirect::to('them-loai-sp');
    }
    //lay data 
    public function danhsach_loai_sp(){
        $this->Authlogin(); 
       $danhsach_loai_sp =  Category::orderby('l_id','DESC')->get(); 
       $ql_danhsach_loai_sp = view('admin.LoaiSanPham.danhsach_loai_sp')->with('danhsach_loai_sp',$danhsach_loai_sp); 
       return view('admin_layout')->with('admin.LoaiSanPham.danhsach_loai_sp',$ql_danhsach_loai_sp);  
    }
    
    //sua data voi id truyen vao
    public function hienthi_loai_sp($id_loai_sp){
        $this->Authlogin(); 
        Category::where('l_id',$id_loai_sp)->update(['TrangThai'=>1]);
        Product::where('l_id',$id_loai_sp)->update(['sp_TrangThai'=>1]);
        Session::put('message','cập nhật loại sản phẩm thành công!');
        return Redirect::to('danhsach-loai-sp');
    }

    public function an_loai_sp($id_loai_sp){
        $this->Authlogin(); 
        Category::where('l_id',$id_loai_sp)->update(['TrangThai'=>0]);
        Product::where('l_id',$id_loai_sp)->update(['sp_TrangThai'=>0]);
        Session::put('message','cập nhật loại sản phẩm thành công!');
        return Redirect::to('danhsach-loai-sp');
    }
     //lay data tu mot id truyen vao
    public function sua_loai_sp($id_loai_sp){
        $this->Authlogin(); 
        $sua_loai_sp =  Category::find($id_loai_sp);
        $ql_danhsach_loai_sp = view('admin.LoaiSanPham.sua_loai_sp')->with('sua_loai_sp',$sua_loai_sp);
       return view('admin_layout')->with('admin.LoaiSanPham.sua_loai_sp',$ql_danhsach_loai_sp );
    }
    //thay doi data cua database
    public function capnhat_loai_sp( Request $request,$id_loai_sp){
        $this->Authlogin(); 
        $category = Category::find($id_loai_sp);
        $category->Ten = $request->ten_loai_sp;
        $category->MoTa = $request->mota_loai_sp;
        Session::put('message','cập nhật loại sản phẩm thành công!');
        $category->save();
        return Redirect::to('danhsach-loai-sp');
    }
    //xoa data cua database
    public function xoa_loai_sp($id_loai_sp){
        $this->Authlogin(); 
        // Category::destroy($id_loai_sp);
        // return Redirect::to('danhsach-loai-sp');
    
        $sp = Product::where('l_id',$id_loai_sp)->get();
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
        Category::destroy($id_loai_sp);

        // xóa đơn hàng nếu không có chi tiết đơn hàng
        $del_dh = Order::orderby('dh_tongtien','ASC')->get();
        foreach ($del_dh as $key => $valu) {
            if($valu->dh_tongtien == 0){
                Order::destroy($valu->dh_id);
            }
        }
        Session::put('message','Xóa thương hiệu sản phẩm thành công!');
        return Redirect::to('danhsach-loai-sp');
    }
     //------------------End function ADMIN---------------//



     //------------------TRANG BÁN HÀNG---------------//
     public function show_loai_sp_home($id_loai_sp){
        $slider = Slider::orderby('slider_id','DESC')->where('slider_trangthai','1')->get();
        $loai_sp = Category::orderby('l_id','desc')->where('TrangThai','1')->get();
        $thuonghieu_sp = Brand::orderby('th_id','desc')->where('th_TrangThai','1')->get();
        // $loai_sp_id = Product::where('sp_TrangThai','1')->where('l_id',$id_loai_sp)->get();
        $thuonghieu_sp_l = DB::table('ThuongHieu')->where('th_TrangThai','1')
        ->join('SanPham','SanPham.th_id','=','ThuongHieu.th_id')
        ->join('LoaiSanPham','LoaiSanPham.l_id','=','SanPham.l_id')
        ->where('LoaiSanPham.l_id',$id_loai_sp)
        ->select('ThuongHieu.*')->get();
        // chỉnh đường dẫn cho thêm giỏ hàng và đi đến giỏ hàng
        if($id_loai_sp=='gio-hang'){
            return Redirect::to('gio-hang');
        }else{
            // kiểm tra nếu Admin xóa Loại sp này rồi thì về trang home
            $test_loai_sp_id = Category::where('l_id',$id_loai_sp)->first();
            if($test_loai_sp_id){
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
                    $loai_sp_id = DB::table('SanPham')->where('sp_TrangThai','1')
                    ->join('AnhSanPham','SanPham.sp_id','=','AnhSanPham.sp_id')
                    ->where('l_id',$id_loai_sp)->where('AnhSanPham.asp_trangthai',1)
                    ->whereBetween('sp_gia',[$min_price,$max_price])
                    ->select('SanPham.*','AnhSanPham.asp_hinhanh')->paginate(3)->appends(request()->query());
                }elseif(isset($_GET['brand'])){
                    $brand_filter = $_GET['brand'];
                    $brand_arr = explode(",", $brand_filter);
                    $loai_sp_id = DB::table('SanPham')->where('sp_TrangThai','1')
                    ->join('AnhSanPham','SanPham.sp_id','=','AnhSanPham.sp_id')
                    ->where('l_id',$id_loai_sp)->whereIn('th_id',$brand_arr)->where('AnhSanPham.asp_trangthai',1)
                    ->select('SanPham.*','AnhSanPham.asp_hinhanh')->paginate(3)->appends(request()->query());

                }else{
                    $loai_sp_id = DB::table('SanPham')->where('sp_TrangThai','1')
                    ->join('AnhSanPham','SanPham.sp_id','=','AnhSanPham.sp_id')
                    ->where('l_id',$id_loai_sp)->where('AnhSanPham.asp_trangthai',1)->orderby($A,$B)
                    ->select('SanPham.*','AnhSanPham.asp_hinhanh')->paginate(3)->appends(request()->query());
                }
                $lsp_ten = Category::find($id_loai_sp);
                return view('pages.Loai.show_loai_sp')->with('loai_sp',$loai_sp)->with('thuonghieu_sp',$thuonghieu_sp)->with('loai_sp_id',$loai_sp_id)->with('ten_lsp',$lsp_ten)->with('slider',$slider)->with('thuonghieu_sp_l',$thuonghieu_sp_l);
            }else{
                return Redirect::to('trang-chu');
            }             
        }
    }
}
?>

