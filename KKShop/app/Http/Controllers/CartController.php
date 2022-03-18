<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use DB;
use Cart; // sài cho bumbummen99
use App\Models\Slider;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Session;
use App\Http\Requests; //lay yeu cau data tu post 
use Illuminate\Support\Facades\Redirect; //nhuw return tra ve nhung chi vao ten tren link
session_start();

class CartController extends Controller
{

 //------------------TRANG BÁN HÀNG--------------//   
    public function show_sl_gh(){
        $output = '';
        if(Session::get('giohang')){
            $sl = count(Session::get('giohang'));
            $output .= '<span class="badges">'.$sl.'</span>';
        }
        echo $output;
    }
    public function show_gh_hover(){
        // {{asset('public/uploads/product/10047065-loa-bluetooth-sony-srs-xb43-xanh-duong-489.jpg')}}
        $output = '';
        if(Session::get('giohang')){
            // $cart = Session::get('giohang');
            $output .=  '<ul class="hover-cart" style="overflow:scroll; max-height: 300px;margin-top:10px;">';
            foreach (Session::get('giohang') as $key => $value_cart) {
                 $output .=  '<li><a style="font-size:12px;" href="'.url('/chi-tiet-sp/'.$value_cart['sanpham_id']).'">
                                <div class="row" >
                                    <div class="col-sm-4">
                                        <img src="'.asset('public/uploads/product/'.$value_cart['sanpham_hinhanh']).'" alt="" style="width:100%; height: 100%;">
                                    </div>
                                    <div class="col-sm-8">
                                        <p><b>'.$value_cart['sanpham_ten'].'</b></p>
                                        <p>Số lượng: '.$value_cart['sanpham_soluong'].'
                                            <a class="cart_quantity_delete" href="'.url('xoa-sp-gh/'.$value_cart['gh_id']).'"><box-icon name="trash" animation="tada" color="blue" ></box-icon></a></p>
                                        <p style="color:red;">'.number_format($value_cart['sanpham_gia'],'0',',','.').'<small style="color: red;"> <b>&#8363; </b></small></p>

                                    </div>
                                </div>
                                </a></li>';
            }
            $output .= '</ul>';
        }else{
            $output .=  '<ul class="hover-cart">
                            <li>
                                <p>Giỏ hàng trống</p>
                            </li>
                        </ul>';
        }
        echo $output;
    }
    // public function gio_hang(Request $request){
    public function gio_hang(){    
        $slider = Slider::orderby('slider_id','DESC')->where('slider_trangthai','1')->get();
        $loai_sp = Category::orderby('l_id','desc')->where('TrangThai','1')->get();
        $thuonghieu_sp = Brand::orderby('th_id','desc')->where('th_TrangThai','1')->get();
        return view('pages.GioHang.show_giohang_sp')->with('loai_sp',$loai_sp)->with('thuonghieu_sp',$thuonghieu_sp)->with('slider',$slider);
    }
    public function them_gh_ajax(Request $request){
        $data = $request->all();
        $giohang = Session::get('giohang');
        $gh_id = substr(md5(microtime()),rand(0,26),5); //md5 microtime lấy micro giây cắt 5 ký tự từ vị trí rand(0-26)
        $tsl = Product::find($data['gh_sp_id']);
        if($data['gh_sp_soluong'] > $tsl->sp_soluong){
            $data['gh_sp_soluong'] = $tsl->sp_soluong;
        }
        if($giohang == true){
            $is_avaiable = 0;
            foreach ($giohang as $key => $val) {
                if($val['sanpham_id']==$data['gh_sp_id']){
                    $is_avaiable++;
                }

            }
            if($is_avaiable==0){
                $giohang[] = array('gh_id' =>$gh_id , 
                            'sanpham_ten' => $data['gh_sp_ten'],
                            'sanpham_id' => $data['gh_sp_id'],
                            'sanpham_hinhanh' => $data['gh_sp_hinhanh'],
                            'sanpham_soluong' => $data['gh_sp_soluong'],
                            'sanpham_gia' => $data['gh_sp_gia'],
                            );
                Session::put('giohang',$giohang);
            }
        }else{
            $giohang[] = array('gh_id' =>$gh_id , 
                            'sanpham_ten' => $data['gh_sp_ten'],
                            'sanpham_id' => $data['gh_sp_id'],
                            'sanpham_hinhanh' => $data['gh_sp_hinhanh'],
                            'sanpham_soluong' => $data['gh_sp_soluong'],
                            'sanpham_gia' => $data['gh_sp_gia'],
                            );
            Session::put('giohang',$giohang);
        }
        // Session::put('giohang',$giohang);
        Session::save();

    }



    public function xoa_sp_gh($gh_id){
        $giohang = Session::get('giohang');
        if($giohang){
            foreach($giohang as $key => $val){
                if($val["gh_id"]==$gh_id){
                    unset($giohang[$key]);
                    //xóa sản phẩmm thứ $key
                }
            }
            Session::put('giohang',$giohang);
            return Redirect()->back()->with('message','xóa sản phẩm thành công');
        }else{
            return Redirect()->back()->with('message','xóa sản phẩm không thành công');
        }
    }

    public function xoa_all_sp_gh(){
        $giohang = Session::get('giohang');
        if($giohang==true){
            Session::forget('giohang');
            return Redirect()->back()->with('message','Xóa tất cả giỏ hàng thành công');
        }
    }


    public function tang_sl_gh($gh_id){
        $giohang = Session::get('giohang');
        foreach ($giohang as $key => $value) {
            if($value['gh_id']==$gh_id){
                $soluong_ton = Product::find($value['sanpham_id']);
                if($soluong_ton->sp_soluong==$value['sanpham_soluong']){
                     return Redirect()->back()->with('message','Không thể tăng thêm số lượng sản phẩm');
                    }
                $giohang[$key]['sanpham_soluong']++;
            }
        }
        Session::put('giohang',$giohang);
        return Redirect()->back()->with('message','Tăng thêm số lượng sản phẩm thành công');
    }

    public function giam_sl_gh($gh_id){
        $giohang = Session::get('giohang');
        foreach ($giohang as $key => $value) {
            if($value['gh_id']==$gh_id){
                if($value['sanpham_soluong']==1){
                     return Redirect()->back()->with('message','Không thể giảm số lượng sản phẩm');
                    }
                $giohang[$key]['sanpham_soluong']--;
            }
        }
        Session::put('giohang',$giohang);
        return Redirect()->back()->with('message','Giảm số lượng sản phẩm thành công');
               
    }


// sài cho bumbummen99
    // public function luu_giohang(Request $request){
    // 	//sài bumbummen99  
    // 	$sp_id = $request->sanpham_id_order;
    // 	$soluong = $request->soluong;
    // 	$sanpham_info = DB::table('SanPham')->where('sp_id',$sp_id)->first();

    // 	$loai_sp = DB::table('LoaiSanPham')->where('TrangThai','1')->orderby('l_id','desc')->get();
    //     $thuonghieu_sp = DB::table('ThuongHieu')->where('th_TrangThai','1')->orderby('th_id','desc')->get();
    //     $data['id'] = $sanpham_info->sp_id;
    //     $data['qty'] = $soluong;
    //     $data['name']= $sanpham_info->sp_Ten;
    //     $data['price'] = $sanpham_info->sp_gia;
    //     $data['weight'] = $sanpham_info->sp_gia;
    //     $data['options']['hinhanh'] = $sanpham_info->sp_hinhanh;
    //      Cart::add($data);
    //    // Cart::Destroy();
        
    //     return Redirect::to('gio-hang');
    	
    // }
}
