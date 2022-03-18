<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Models\Slider;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Gallery;
use App\Http\Requests; //lay yeu cau data tu post 
use App\Models\Order;
use App\Models\OrderDetails;
use Illuminate\Support\Facades\Redirect; //nhuw return tra ve nhung chi vao ten tren link
session_start();

class ProductController extends Controller
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

    public function them_sp(){
        $this->Authlogin(); 
        $loai_sp = Category::orderby('l_id','desc')->get();
        $thuonghieu_sp = Brand::orderby('th_id','desc')->get();
    	return view('admin.SanPham.them_sp')->with('loai_sp',$loai_sp)->with('thuonghieu_sp',$thuonghieu_sp);

    }
//save data vao database
     public function luu_sp(Request $request){
        $this->Authlogin(); 
        $data = array();
        $data['sp_Ten'] = $request->ten_sp;
        $data['l_id'] = $request->loai_sp;
        $data['th_id'] = $request->thuonghieu_sp;
        $data['sp_gia'] = $request->gia_sp;
        $data['sp_TrangThai'] = $request->trangthai_sp;
        $data['sp_soluong'] = $request->soluong_sp;
        $data['sp_MoTa'] = $request->mota_sp;
        $data['sp_noidung'] = $request->noidung_sp;
        if($data['sp_MoTa'] && $data['sp_noidung']){
            $sp_id = DB::table('SanPham')->insertGetId($data);
            $get_image =  $request->file('file');
            if($get_image){
                foreach ($get_image as $key => $val) {
                    $get_name_image = $val->getClientOriginalName(); // lay ten hinh anh bao gom luon dui
                    $name_image = current(explode('.', $get_name_image)); //tach lay ten hinh anh tu dau den dau cham (explode phan tach ra 2 chuoi tu dau .) (current lay chuoi dau // end lay chuoi cuoi)
                    //lay dui mo rong //rand() la lay ngau nhien
                    $new_image =$name_image . rand(0,99).'.'.$val->getClientOriginalExtension();
                    $val->move('public/uploads/product',$new_image); 
                    $gallery = new Gallery();
                    $gallery->asp_ten = $new_image;
                    $gallery->asp_hinhanh = $new_image;
                    $gallery->sp_id = $sp_id;
                    if($key==0){
                      $gallery->asp_trangthai = 1;
                    }else{
                      $gallery->asp_trangthai = 0;
                    }
                    $gallery->save();
                    
                }
              }
        // $get_image = $request->file('hinhanh_sp');

        // if($get_image){
        //     $get_name_image = $get_image->getClientOriginalName(); // lay ten hinh anh bao gom luon dui
        //     $name_image = current(explode('.', $get_name_image)); //tach lay ten hinh anh tu dau den dau cham (explode phan tach ra 2 chuoi tu dau .) (current lay chuoi dau // end lay chuoi cuoi)
        //     //lay dui mo rong //rand() la lay ngau nhien
        //     $new_image =$name_image . rand(0,99).'.'.$get_image->getClientOriginalExtension();
        //     $get_image->move('public/uploads/product',$new_image); 
        //     $data->sp_hinhanh= $new_image;
        //     $data->save(); 
        //     Session::put('message','Thêm sản phẩm thành công!'); 
        //     return Redirect::to('them-sp'); 
        // }
        // $data->save(); 
            Session::put('message','Thêm sản phẩm thành công!'); 
        }else{
            Session::put('message','Thiếu thông tin mô tả hoặc nội dung sản phẩm, Thêm sản phẩm không thành công!'); 
        }
        return Redirect::to('them-sp'); 
    }

    //lay data 
    public function danhsach_sp(){
        $this->Authlogin();
        
        // phân trang
        $danhsach_sp=Product::orderby('sp_id','desc')->orderby('sp_id','DESC')->get();
        // NOT MODELS
       //  $danhsach_sp =  DB::table('SanPham')
       // ->join('LoaiSanPham','LoaiSanPham.l_id','=','SanPham.l_id')
       // ->join('ThuongHieu','ThuongHieu.th_id','=','SanPham.th_id')
       // ->orderby('SanPham.sp_id','desc')->get(); //->paginate(3); //truy xuat database lay data
       //join là lấy dữ liệu của bảng LoaiSanPham và ThuongHieu với từng id = id của bảng SanPham 
      
       $ql_danhsach_sp = view('admin.SanPham.danhsach_sp')->with('danhsach_sp',$danhsach_sp); //gan data vao bien danhsach_sp de sd o page danh sach sp 
       return view('admin_layout')->with('admin.SanPham.danhsach_sp',$ql_danhsach_sp);  //dua ve admin va danh sach sp 
    }
    
    //sua data voi id truyen vao
    public function hienthi_sp($id_sp){
        $this->Authlogin(); 
        Product::where('sp_id',$id_sp)->update(['sp_TrangThai'=>1]);
        Session::put('message','Cập nhật sản phẩm thành công!'); 
        return Redirect::to('danhsach-sp');
    }

    public function an_sp($id_sp){
        $this->Authlogin(); 
        Product::where('sp_id',$id_sp)->update(['sp_TrangThai'=>0]);
        Session::put('message','Cập nhật sản phẩm thành công!'); 
        return Redirect::to('danhsach-sp');
    }

     //lay data tu mot id truyen vao
    public function sua_sp($id_sp){
        $this->Authlogin(); 
        $sua_sp =  Product::find($id_sp);
        $loai_sp = Category::orderby('l_id','desc')->whereNotIn('l_id',[$sua_sp->l_id])->get();
        $thuonghieu_sp = Brand::orderby('th_id','desc')->whereNotIn('th_id',[$sua_sp->th_id])->get();
       $ql_danhsach_sp = view('admin.SanPham.sua_sp')->with('sua_sp',$sua_sp)
       ->with('loai_sp',$loai_sp)->with('thuonghieu_sp',$thuonghieu_sp);
       return view('admin_layout')->with('admin.SanPham.sua_sp',$ql_danhsach_sp );
    }

    //thay doi data cua database
    public function capnhat_sp( Request $request,$id_sp){
        $this->Authlogin();
        $data  = Product::find($id_sp);
        $data->sp_Ten = $request->ten_sp;
        $data->l_id = $request->loai_sp;
        $data->th_id = $request->thuonghieu_sp;
        $data->sp_MoTa = $request->mota_sp;
        $data->sp_noidung = $request->noidung_sp;
        $data->sp_gia = $request->gia_sp;
        $data->sp_soluong = $request->soluong_sp;
        $data->save();
        Session::put('message','Cập nhật sản phẩm thành công!'); 
        return Redirect::to('danhsach-sp');
    }


    //xoa data cua database
    public function xoa_sp($id_sp){
        $this->Authlogin();
        $hinh = Gallery::where('sp_id',$id_sp)->get();
        if($hinh){
          foreach ($hinh as $key => $value) {
            unlink('public/uploads/product/'.$value->asp_hinhanh);
          }
        }
        // cập nhật lại tổng tiền đơn hàng nếu sản phẩm của đơn hàng đó bị xóa 
        $test_ctdh = OrderDetails::where('sp_id',$id_sp)->first();
        if($test_ctdh){
            $ctdh = OrderDetails::where('sp_id',$id_sp)->get();
            foreach ($ctdh as $key => $val) {
                $dh = Order::where('dh_id',$val->dh_id)->first();
                $dh->dh_tongtien = $dh->dh_tongtien - $val->ctdh_dongia;
                $dh->dh_tongdh = $dh->dh_tongdh - $val->ctdh_dongia;
                $dh->save();
            }
        }
        Product::destroy($id_sp);
        // xóa đơn hàng nếu không có chi tiết đơn hàng
        $del_dh = Order::orderby('dh_tongtien','ASC')->get();
        foreach ($del_dh as $key => $valu) {
            if($valu->dh_tongtien == 0){
                Order::destroy($valu->dh_id);
            }
        }
        Session::put('message','Xóa sản phẩm thành công!'); 
        return Redirect::to('danhsach-sp');
    
    }

     //------------------End function ADMIN---------------//
     //
     



     //--------------------TRANG BÁN HÀNG------------//
     public function xemnhanh(Request $request){
        $id = $request->id;
        $vitri = $request->vitri;
        $data = explode('/', $vitri); //xác định vị trí của trang để hiển thị ảnh
            $sanpham = Product::find($id);
            $anhsanpham = Gallery::where('sp_id',$id)->get();
            $output['sp_id']=$sanpham->sp_id;
            $output['sp_Ten']=$sanpham->sp_Ten;
            $output['sp_soluong']=$sanpham->sp_soluong;
            $output['sp_mota']=$sanpham->sp_MoTa;
            $output['sp_noidung']=$sanpham->sp_noidung;
            $output['sp_gia']= number_format($sanpham->sp_gia,'0',',','.').'<small style="color: blue;"><b>&#8363;</b></small>';
            $output['sp_khoanh'] = '';
            foreach ($anhsanpham as $key => $value) {
                if(end($data) == '' or end($data) == 'trang-chu' or end($data) == 'search-sp'){
                    $output['sp_khoanh'] .= '<p><img src="public/uploads/product/'.$value->asp_hinhanh.'"></p>';
                }else{
                    $output['sp_khoanh'] .= '<p><img src="../public/uploads/product/'.$value->asp_hinhanh.'"></p>';
                }
            }
            echo json_encode($output);


     }
     public function chi_tiet_sp($id_sp){

        $slider = Slider::orderby('slider_id','DESC')->where('slider_trangthai','1')->get();
        $loai_sp = Category::orderby('l_id','desc')->where('TrangThai','1')->get();
        $thuonghieu_sp = Brand::orderby('th_id','desc')->where('th_TrangThai','1')->get();
        if($id_sp=='gio-hang'){
          return Redirect::to('gio-hang');
        }else{
         //  $chitiet_sp =  DB::table('SanPham')
         // ->join('LoaiSanPham','LoaiSanPham.l_id','=','SanPham.l_id')
         // ->join('ThuongHieu','ThuongHieu.th_id','=','SanPham.th_id')
         // ->where('SanPham.sp_id',$id_sp)->get(); 
         //join là lấy dữ liệu của bảng LoaiSanPham và ThuongHieu với từng id = id của bảng SanPham 
         $chitiet_sp =  Product::find($id_sp);
         $anh_sp = Gallery::where('sp_id',$id_sp)->where('asp_trangthai',1)->first();
         $gallery = Gallery::where('sp_id',$id_sp)->get();
         $loai_id=null;
         if($chitiet_sp){
            $loai_id = $chitiet_sp->l_id;
            // NOT MODEL
            // $sp_lienquan =  DB::table('SanPham')
            // ->join('LoaiSanPham','LoaiSanPham.l_id','=','SanPham.l_id')
            // ->where('LoaiSanPham.l_id',$loai_id)->whereNotIn('SanPham.sp_id',[$id_sp])
            // ->where('sp_TrangThai',1)->paginate(6);
            //join là lấy dữ liệu của bảng LoaiSanPham và ThuongHieu với từng id = id của bảng SanPham 
            // $test_lienquan =  DB::table('SanPham')
            // ->join('LoaiSanPham','LoaiSanPham.l_id','=','SanPham.l_id')
            // ->where('LoaiSanPham.l_id',$loai_id)
            // ->whereNotIn('SanPham.sp_id',[$id_sp])->where('sp_TrangThai',1)->first(); 
            //join là lấy dữ liệu của bảng LoaiSanPham và ThuongHieu với từng id = id của bảng SanPham 
            // $sp_lienquan =  Product::where('l_id',$loai_id)->where('sp_TrangThai',1)
            // ->whereNotIn('sp_id',[$id_sp])->paginate(6);
            
            $sp_lienquan = DB::table('SanPham')->where('sp_TrangThai','1')
            ->join('AnhSanPham','SanPham.sp_id','=','AnhSanPham.sp_id')
            ->where('l_id',$loai_id)
            ->where('AnhSanPham.asp_trangthai',1)
            ->whereNotIn('SanPham.sp_id',[$id_sp])
            ->select('SanPham.*','AnhSanPham.asp_hinhanh')->paginate(6);
           
            $test_lienquan = Product::where('l_id',$loai_id)->where('sp_TrangThai',1)->whereNotIn('sp_id',[$id_sp])->first();
            if($test_lienquan){
              Session::put('test_lienquan',$test_lienquan->sp_id);
            }
            return view('pages.SanPham.show_chitiet_sp')->with('loai_sp',$loai_sp)->with('thuonghieu_sp',$thuonghieu_sp)->with('chitiet_sp',$chitiet_sp)->with('anh_sp',$anh_sp)->with('sp_lienquan',$sp_lienquan)->with('slider',$slider)->with('gallery',$gallery);
        
          }else{
            return Redirect::to('trang-chu');
            }
        }
    }

}
?>