<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Gallery;
use App\Http\Requests; //lay yeu cau data tu post 
use Illuminate\Support\Facades\Redirect; //nhuw return tra ve nhung chi vao ten tren link
session_start();
class GalleryController extends Controller
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
    public function chitiet_asp($sp_id){
        $this->Authlogin(); 
        $id_sp = $sp_id;
        $sp_Ten = Product::find($sp_id);
        return view('Admin.SanPham.AnhSanPham.them_asp')->with(compact('id_sp'))->with(compact('sp_Ten'));;
    }
    public function luu_anhsp(Request $request,$id_sp){
        $this->Authlogin(); 
        $get_image =  $request->file('file');
        // if($get_image){
        foreach ($get_image as $val) {
            $get_name_image = $val->getClientOriginalName(); // lay ten hinh anh bao gom luon dui
            $name_image = current(explode('.', $get_name_image)); //tach lay ten hinh anh tu dau den dau cham (explode phan tach ra 2 chuoi tu dau .) (current lay chuoi dau // end lay chuoi cuoi)
            //lay dui mo rong //rand() la lay ngau nhien
            $new_image =$name_image . rand(0,99).'.'.$val->getClientOriginalExtension();
            $val->move('public/uploads/product',$new_image); 
            $gallery = new Gallery();
            $gallery->asp_ten = $new_image;
            $gallery->asp_hinhanh = $new_image;
            $gallery->sp_id = $id_sp;
            $gallery->asp_trangthai = 0;
            $gallery->save();
            
        }

        Session::put('message','Thêm ảnh sản phẩm thành công!'); 
        return redirect()->back();
        // }else{
        //     Session::put('message','Thêm ảnh không thành công bạn hãy tải ảnh lên!'); 
        //     return redirect()->back();
        // } 
    }
    public function capnhat_ten_asp(Request $request){
        $this->Authlogin();
        $gallery = Gallery::find($request->asp_id);
        $gallery->asp_ten = $request->ten;
        $gallery->save();
    }
    public function xoa_anhsanpham(Request $request){
        $this->Authlogin();
        $gallery = Gallery::find($request->asp_id);
        unlink("public/uploads/product/".$gallery->asp_hinhanh);
        Gallery::destroy($request->asp_id);
        return redirect()->back();
    }
    public function hienthidau_asp($id_asp){
        $this->Authlogin(); 
        Gallery::where('asp_id',$id_asp)->update(['asp_trangthai'=>1]);
        $id_sp = Gallery::find($id_asp);
        Gallery::where('sp_id',$id_sp->sp_id)->whereNotIn('asp_id',[$id_asp])->update(['asp_trangthai'=>0]);
        return Redirect::to('chitiet-asp/'.$id_sp->sp_id);
        // return redirect()->back();
    }
    public function select_anhsanpham(Request $request){
        $this->Authlogin(); 
        $gallery = Gallery::where('sp_id',$request->id_sp)->get();
        $gallery_count = $gallery->count();
        $output = '
            <table class="table table-hover">
                <thead>
                  <tr>
                    <th>STT</th>
                    <th>Tên hình ảnh</th>
                    <th>Hình ảnh</th>
                    <th>Hiển thị đầu</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                    <form>
                        '.csrf_field();
        if($gallery_count>0){
            $i=0;
            foreach ($gallery as $key => $value) {
                $i++; 
                $output .='
                        <tr>
                            <td>'.$i.'</td>
                            <td class="edit_asp" contenteditable data-asp_id="'.$value->asp_id.'">'.$value->asp_ten.'</td>
                            <td><img style="max-width: 100px;max-height: 100px;"src="'.url('public/uploads/product/'.$value->asp_hinhanh).'" alt="'.$value->asp_hinhanh.'" ></td>
                            <td>';
                                if($value->asp_trangthai==0){
                                    $output .='
                                    <a href="'.url('hienthidau-asp/'.$value->asp_id).'"><span class="fa-thumd-styling-down fa fa-times-circle-o"></span></a>';
                                }else{
                                    $output .='
                                    <span class="fa-thumd-styling fa fa-check-circle-o"></span>
                                    ';
                                    }
                                    $output .='</td>
                            <td>';

                                if($value->asp_trangthai==0){
                                $output .= '
                                    <button type="button" data-asp_id="'.$value->asp_id.'" class="btn btn-xs btn-danger delete-anh">Xóa</button>';}
                            
                            $output .='
                            </td>
                        </tr>';

            }
        }else{
            $output .='
                <tr>
                    <td colspan="4">Sản phẩm này chưa có ảnh</td>
                </tr>';
        }
        $output .='
                </tbody>
            </table>
                    </form>';
            
        echo $output;

    }
}
