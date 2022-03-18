<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use DateTime;
use Session;
use App\Models\Slider;
use App\Models\KhachHang;
use App\Models\Product;  
use App\Models\Category;
use App\Models\Shipping;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Brand;
use App\Http\Requests; //lay yeu cau data tu post 
use Illuminate\Support\Facades\Redirect; //nhuw return tra ve nhung chi vao ten tren link
use PDF;
session_start();

class OrderController extends Controller
{

//kiểm tra xem khách hàng đã đăng nhập chưa
     public function Authlogin_kh(){
        //test nếu bị admin xóa tài khoản thì session kh_id không tồn tại trong table KhachHang
        $kh_id = KhachHang::find(Session::get('kh_id'));
        if($kh_id){
            return Redirect::to('trang-chu');
        }else{
            Session::put('kh_id',null); //cho bằng null nếu tài khoản đã bị admin xóa 
            Session::put('kh_ten',null);
            return Redirect::to('login-checkout')->send();
        }
    } 


//--------------------------ĐẶT HÀNG-TRANG KHÁCH------------------//
    public function dat_hang(Request $request){
        $this->Authlogin_kh();
        // insert table đặt hàng
        $tongtien = 0;
        foreach (Session::get('giohang') as $key => $giohang) {
            $subtotal = $giohang["sanpham_gia"] * $giohang["sanpham_soluong"];
            $tongtien += $subtotal;
        }
        $phi = Shipping::find(Session::get('shipping_id'));
        $data_dh = array();
        $data_dh['shipping_id'] = Session::get('shipping_id');
        $data_dh['dh_tongtien'] = $tongtien;
        $data_dh['dh_phi_vc'] = $phi->phi;
        $tongdh = $tongtien + $phi->phi;
        $data_dh['dh_tongdh'] = $tongdh;
        $data_dh['dh_trangthai'] = 0;
        $data_dh['created_at'] = new DateTime('now');
        $dathang_id = DB::table('DatHang')->insertGetId($data_dh); //insertGetId() là lấy luôn dl đã insert 


        //insert table chi tiết đặt hàng
        foreach (Session::get('giohang') as $key => $giohang) {
            
            $subtotal = $giohang["sanpham_gia"] * $giohang["sanpham_soluong"];
            // NOT MODELS
            // $data_ctdh =array();
            // $data_ctdh['dh_id'] = $dathang_id;
            // $data_ctdh['sp_id'] = $giohang['sanpham_id'];
            // $data_ctdh['sp_ten'] = $giohang['sanpham_ten'];
            // $data_ctdh['sp_gia'] = $giohang["sanpham_gia"];
            // $data_ctdh['ctdh_soluong'] = $giohang['sanpham_soluong'];
            // $data_ctdh['ctdh_dongia'] = $subtotal;
            // DB::table('ChiTietDatHang')->insert($data_ctdh); //insertGetId() là lấy luôn dl đã insert 

            $data_ctdh = new OrderDetails();
            $data_ctdh->dh_id = $dathang_id;
            $data_ctdh->sp_id = $giohang['sanpham_id'];
            $data_ctdh->sp_ten = $giohang['sanpham_ten'];
            $data_ctdh->sp_gia =$giohang["sanpham_gia"];
            $data_ctdh->ctdh_soluong = $giohang['sanpham_soluong'];
            $data_ctdh->ctdh_dongia = $subtotal;
            $data_ctdh->save(); 
            //cập nhất lại số lượng
            $soluong_ton = Product::find($giohang['sanpham_id']);
            $soluong_con = $soluong_ton->sp_soluong - $giohang['sanpham_soluong'];
            Product::where('sp_id',$giohang['sanpham_id'])->update(['sp_soluong' => $soluong_con]);
            // cập nhật lại trạng thái shipping
            Shipping::where('shipping_id',Session::get('shipping_id'))->update(['shipping_trangthai' => 1]);
        
        }

        Session::forget('giohang');
        
       return Redirect::to('don-hang');
    }



//-------------------------ĐƠN HÀNG-TRANG KHÁCH------------------//
    public function don_hang(){
        $this->Authlogin_kh();
        $id_kh = Session::get('kh_id');

        $slider = Slider::orderby('slider_id','DESC')->where('slider_trangthai','1')->get();
        $loai_sp = Category::orderby('l_id','desc')->where('TrangThai','1')->get();
        $thuonghieu_sp = Brand::orderby('th_id','desc')->where('th_TrangThai','1')->get();
      
        $thongtin =  DB::table('DatHang')
       ->join('ChiTietDatHang','DatHang.dh_id','=','ChiTietDatHang.dh_id')
       ->join('AnhSanPham','ChiTietDatHang.sp_id','=','AnhSanPham.sp_id')
       ->join('Shipping','DatHang.shipping_id','=','Shipping.shipping_id')
       ->where('Shipping.kh_id',$id_kh)->where('AnhSanPham.asp_trangthai',1)
       ->select('DatHang.*','AnhSanPham.asp_hinhanh','ChiTietDatHang.*')->get(); 

      $thongtindh =  DB::table('DatHang')
       ->join('Shipping','DatHang.shipping_id','=','Shipping.shipping_id')
       ->where('Shipping.kh_id',$id_kh)
       ->select('Shipping.*','DatHang.*')->orderby('DatHang.created_at','DESC')->get(); 

        return view('pages.DonHang.show_don_hang')->with('loai_sp',$loai_sp)->with('thuonghieu_sp',$thuonghieu_sp)->with('thongtin',$thongtin)->with('thongtindh',$thongtindh)->with('slider',$slider);
    }

    public function xoa_ctdh_kh($ctdh_id){
        $this->Authlogin_kh();
        $thongtin_dh =  DB::table('ChiTietDatHang')
       ->join('DatHang','ChiTietDatHang.dh_id','=','DatHang.dh_id')
       ->join('Shipping','DatHang.shipping_id','=','Shipping.shipping_id')->where('ChiTietDatHang.ctdh_id',$ctdh_id)
       ->select('DatHang.*','ChiTietDatHang.*','Shipping.*')->first(); //truy xuat database lay data
       
      //cập nhật lại số lượng
      $sp_soluong = Product::find($thongtin_dh->sp_id);
      $soluong_con = $thongtin_dh->ctdh_soluong + $sp_soluong->sp_soluong;
      Product::where('sp_id',$thongtin_dh->sp_id)->update(['sp_soluong' => $soluong_con]);  

      //cập nhật lại tổng tiền đơn hàng đơn hàng
      $tongtiencon = $thongtin_dh->dh_tongtien - $thongtin_dh->ctdh_dongia;
      $tongdhcon = $thongtin_dh->dh_tongdh - $thongtin_dh->ctdh_dongia;
      Order::where('dh_id',$thongtin_dh->dh_id)->update(['dh_tongtien' => $tongtiencon ]);
      Order::where('dh_id',$thongtin_dh->dh_id)->update(['dh_tongdh' => $tongdhcon ]);  

      OrderDetails::destroy($thongtin_dh->ctdh_id);
      $id_dh = OrderDetails::where('dh_id',$thongtin_dh->dh_id)->first();
      
      if($id_dh==null){
          Order::destroy($thongtin_dh->dh_id);
          $id_shipping = Order::where('shipping_id',$thongtin_dh->shipping_id)->first();
          if($id_shipping==null){
            Shipping::destroy($thongtin_dh->shipping_id);
          }
        }
        Session::put('message','Xóa đơn hàng thành công!');
        return Redirect()->back();
      }
       public function xoa_dh_kh($dh_id){
        $this->Authlogin_kh(); 
        $shipping = Order::find($dh_id); //lấy shipping để xem có thể xóa không
        $sanpham = OrderDetails::where('dh_id',$dh_id)->get();
        Order::destroy($dh_id);

        //cập nhật lại số lượng
        foreach ($sanpham as $key => $val) {
          $sp_soluong = Product::find($val->sp_id);
          $soluong_con = $val->ctdh_soluong + $sp_soluong->sp_soluong;
            Product::where('sp_id',$val->sp_id)->update(['sp_soluong' => $soluong_con ]);   
        }
        
        $test_shpping = Order::where('shipping_id',$shipping->shipping_id)->first();
        //kiểm tra xem nếu shpping không tồn tại trong đơn hàng thì xóa shipping
        if($test_shpping==null){
          Shipping::destroy($shipping->shipping_id);
          return Redirect()->back();
        }else{
          return Redirect()->back();
          }
        }




 //------------------ĐƠN HÀNG-ADMIN---------------//

    //kiem tra xem co dang nhap hay khong neu khong tra ve login admin
    public function Authlogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('admin.dashboard');
        }else{
            return Redirect::to('admin');
        }
    }

    


    //-----------------------đơn hàng ADMIN---------------//
    //
     public function quanly_donhang(){
        $this->Authlogin(); 
       $danhsach_dh =  DB::table('DatHang')
       ->join('Shipping','DatHang.shipping_id','=','Shipping.shipping_id')
       ->join('KhachHang','KhachHang.kh_id','=','Shipping.kh_id')->orderby('dh_id','DESC')
       ->select('DatHang.*','KhachHang.kh_Ten')->get(); 
       $ql_danhsach_dh = view('admin.DonHang.quanly_donhang')->with('danhsach_dh',$danhsach_dh); 
       return view('admin_layout')->with('admin.DonHang.quanly_donhang',$ql_danhsach_dh);  //dua ve admin va danh sach sp 
      }

    public function chitiet_dh($dh_id){
        $this->Authlogin();
       $danhsach_ttdh =  DB::table('DatHang')
        ->join('Shipping','DatHang.shipping_id','=','Shipping.shipping_id')
        ->join('KhachHang','KhachHang.kh_id','=','Shipping.kh_id')
        ->where('DatHang.dh_id',$dh_id)
        ->select('DatHang.*','KhachHang.*','Shipping.*')->first(); 

       $danhsach_ctdh =  OrderDetails::where('dh_id',$dh_id)->get(); 

       $ql_danhsach_ctdh = view('admin.DonHang.chitiet_dh')->with('danhsach_ctdh',$danhsach_ctdh)->with('danhsach_ttdh',$danhsach_ttdh); 
       return view('admin_layout')->with('admin.DonHang.chitiet_dh',$ql_danhsach_ctdh);  //dua ve admin va danh sach sp 
    }

    public function xacnhan_dh($dh_id){
        $this->Authlogin(); 
        Order::where('dh_id',$dh_id)->update(['dh_trangthai'=>1]);
        return Redirect::to('quanly-donhang');
    }

    public function huy_dh($dh_id){
        $this->Authlogin(); 
        Order::where('dh_id',$dh_id)->update(['dh_trangthai'=>0]);
        return Redirect::to('quanly-donhang');
    }

    public function xoa_dh($dh_id){
        $this->Authlogin(); 
        $shipping = Order::find($dh_id); //lấy shipping để xem có thể xóa không
        $sanpham = OrderDetails::where('dh_id',$dh_id)->get();
        Order::destroy($dh_id);

        //cập nhật lại số lượng
        foreach ($sanpham as $key => $val) {
          $sp_soluong = Product::find($val->sp_id);
          $soluong_con = $val->ctdh_soluong + $sp_soluong->sp_soluong;
            Product::where('sp_id',$val->sp_id)->update(['sp_soluong' => $soluong_con ]);   
        }
        
        $test_shpping = Order::where('shipping_id',$shipping->shipping_id)->first();
        //kiểm tra xem nếu shpping không tồn tại trong đơn hàng thì xóa shipping
        if($test_shpping==null){
          Shipping::destroy($shipping->shipping_id);
          return Redirect::to('quanly-donhang');
        }else{
          return Redirect::to('quanly-donhang');
          }
        }
          

    public function xoa_ctdh($ctdh_id){
        $this->Authlogin(); 
        $thongtin_dh =  DB::table('ChiTietDatHang')
       ->join('DatHang','ChiTietDatHang.dh_id','=','DatHang.dh_id')
       ->join('Shipping','DatHang.shipping_id','=','Shipping.shipping_id')->where('ChiTietDatHang.ctdh_id',$ctdh_id)
       ->select('DatHang.*','ChiTietDatHang.*','Shipping.shipping_id')->first(); 
      //cập nhật lại số lượng
      $sp_soluong = Product::find($thongtin_dh->sp_id);
      $soluong_con = $thongtin_dh->ctdh_soluong + $sp_soluong->sp_soluong;
      Product::where('sp_id',$thongtin_dh->sp_id)->update(['sp_soluong' => $soluong_con ]);  

      //cập nhật lại tổng tiền đơn hàng đơn hàng
      $tongtiencon = $thongtin_dh->dh_tongtien - $thongtin_dh->ctdh_dongia;
      $tongdhcon = $thongtin_dh->dh_tongdh - $thongtin_dh->ctdh_dongia;
      Order::where('dh_id',$thongtin_dh->dh_id)->update(['dh_tongtien' => $tongtiencon ]);
      Order::where('dh_id',$thongtin_dh->dh_id)->update(['dh_tongdh' => $tongdhcon ]);  

      OrderDetails::destroy($thongtin_dh->ctdh_id);

      $id_dh = OrderDetails::where('dh_id',$thongtin_dh->dh_id)->first();
      
      if($id_dh==null){
          Order::destroy($thongtin_dh->dh_id);
          $id_shipping = Order::where('shipping_id',$thongtin_dh->shipping_id)->first();
          
          if($id_shipping==null){
            Shipping::destroy($thongtin_dh->shipping_id);
            return Redirect::to('quanly-donhang');
          }else{
            return Redirect::to('quanly-donhang');
          }
        }else{
          return Redirect()->back();
          } 
    }

    public function print_order($dh_id){
      $pdf = \App::make('dompdf.wrapper');
      $pdf->loadHTML($this->print_order_convert($dh_id)); //$this là App::  
      return $pdf->stream();
    }
    public function print_order_convert($dh_id){
      $data = Order::find($dh_id);
      $sp = Shipping::find($data->shipping_id);
      $khachhang = KhachHang::find($sp->kh_id);
      $ctdh = OrderDetails::where('dh_id',$dh_id)->get();
      // $sanpham = Product::
      $output = '';
      $output.=' 
        <style>
          body{
            font-family: DejaVu Sans;
            }
            table {
              width: 100%;
              border-collapse: collapse;
            }  
            .edit td{
              border: 1px solid black;
            } 
            .edit th{
              border: 1px solid black;
            }  
        </style>  
        <h2><center><b style="color:blue;font-size:25px;">HÓA ĐƠN BÁN HÀNG K&K-SHOP</b></center></h2>
        <p><i>Thứ... ngày... tháng... năm 20..</i></p>
        <table>
            <tr>
              <th style ="font-size:20px;text-align:left;">Thông tin khách hàng</th>
            </tr>
            <tr>
              <td>Họ và tên: '.$khachhang->kh_Ten.'</td>
            </tr>
            <tr>
              <td>Email: '.$khachhang->kh_email.'</td>
            </tr>
            <tr>
              <td>SĐT: '.$khachhang->kh_sdt.'</td> 
            </tr>
        </table><br>
        <table>
            <tr>
              <th style ="font-size:20px;text-align:left;">Thông tin nguời nhận</th>
            </tr>
            <tr>
              <td>Họ và tên người nhận: '.$sp->shipping_ten.'</td>
            </tr>
            <tr>
              <td>Đia chỉ: '.$sp->shipping_diachi.' 
              </td>
            </tr>
            <tr>
              <td>SDT: '.$sp->shipping_sdt.'</td> 
            </tr>
            <tr>
              <td>Ghi chú: '.$sp->shipping_note.'</td> 
            </tr>
        </table>
        <br>
        <h2><center>Thông tin đơn hàng</center></h2>
        <div class="edit">
        <table>
            <tr>
              <th>Tên sản phẩm</th>
              <th>Giá</th>
              <th>SL</th>
              <th>Đơn giá</th>
            </tr>';
            foreach ($ctdh as $key => $value) {
              $output.=
              '<tr>
                <td>'.$value->sp_ten.'</td>
                <td>'.number_format($value->sp_gia ,'0',',','.').'<small> &#8363; </small></td>
                <td>'.$value->ctdh_soluong.'</td> 
                <td>'.number_format($value->ctdh_dongia ,'0',',','.').'<small> &#8363; </small></td>
              </tr>
              ';
            };
            $output .='
              <tr>
                <td colspan="3" style="text-align:right;">Tổng đơn hàng </td>
                <td>'.number_format($data->dh_tongtien ,'0',',','.').'<small> &#8363; </small></td>
              </tr>
              <tr>
                <td colspan="3" style="text-align:right;">Phí vận chuyển </td>
                <td>'.number_format($data->dh_phi_vc ,'0',',','.').'<small> &#8363; </small></td>
              </tr>
              <tr>
                <td colspan="3" style="text-align:right;">Tổng thanh toán </td>
                <td>'.number_format($data->dh_tongdh ,'0',',','.').'<small> &#8363; </small></td>
              </tr>

            ';
            $output.='</table></div>
            <p><i>Ký tên</i></p>
            <table>
              <tr>
                <th style="with:50%">Người lập phiếu</th>
                <th style="with:50%">Người nhận</th>
              </tr>
              <tr>
                <td style="text-align:center;"><i>(Ký, ghi rõ họ tên)</i></td>
                <td style="text-align:center;"><i>(Ký, ghi rõ họ tên)</i></td>
              </tr>
            </table>
            ';


      return $output;
    }

}

