<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slider;
use Session;
use App\Http\Requests; //lay yeu cau data tu post 
use Illuminate\Support\Facades\Redirect; //nhuw return tra ve nhung chi vao ten tren link
session_start();

class SliderController extends Controller {
	 //kiem tra xem co dang nhap hay khong neu khong tra ve login admin
    public function Authlogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('admin.dashboard');
        }else{
            return Redirect::to('admin')->send();
        }
    } 

    public function danhsach_slider(){
    	$slider = Slider::orderby('slider_id','DESC')->get();
    	return view('Admin.Slider.danhsach_slider')->with(compact('slider'));
    }

    public function them_slider(){
    	return view('Admin.Slider.them_slider');
    }

    public function luu_slider(Request $request){
    	$this->Authlogin(); //goi kt co login chua de khong luu vao database
    	$get_image = $request->file('hinhanh_slider');
        $data = $request->all();

        if($get_image){
            $get_name_image = $get_image->getClientOriginalName(); // lay ten hinh anh bao gom luon dui
            $name_image = current(explode('.', $get_name_image)); //tach lay ten hinh anh tu dau den dau cham (explode phan tach ra 2 chuoi tu dau .) (current lay chuoi dau // end lay chuoi cuoi)
            //Extension lay dui mo rong //rand() la lay ngau nhien
            $new_image =$name_image . rand(0,99).'.'.$get_image->getClientOriginalExtension(); 
            $get_image->move('public/uploads/slider',$new_image); //luu vao public/uploads/product

            $sl = new Slider();
	       	$sl->slider_ten = $data['ten_slider'];
	        $sl->slider_mota = $data['mota_slider'];
	        $sl->slider_trangthai = $data['trangthai_slider'];
            $sl->slider_hinhanh = $new_image;
            $sl->save(); 
           Session::put('message','Thêm slider thành công!'); 
            return Redirect::to('them-slider');
        }else{
        Session::put('message','Thiếu hình ảnh!');  
        return Redirect::to('them-slider');
    	}
    }

    public function sua_slider($id_slider){
        $this->Authlogin(); //goi kt co login chua
        $sua_slider = Slider::find($id_slider);
       $ql_slider = view('admin.Slider.sua_slider')->with('sua_slider',$sua_slider);
       return view('admin_layout')->with('Admin.Slider.sua_slider',$ql_slider );
    }

    //thay doi data cua database
    public function capnhat_slider( Request $request,$id_slider){
       $this->Authlogin(); 
    	$get_image = $request->file('hinhanh_slider');
        $data = $request->all();
        $sl = Slider::find($id_slider);
	    $sl->slider_ten = $data['ten_slider'];
	    $sl->slider_mota = $data['mota_slider'];

        if($get_image){
            $hinh = Slider::where('slider_id',$id_slider)->value('slider_hinhanh');
            unlink("public/uploads/slider/".$hinh); //xoa hinh khoi file product
            $get_name_image = $get_image->getClientOriginalName(); // lay ten hinh anh bao gom luon dui
            $name_image = current(explode('.', $get_name_image)); //tach lay ten hinh anh tu dau den dau cham (explode phan tach ra 2 chuoi tu dau .) (current lay chuoi dau // end lay chuoi cuoi)
            //lay dui mo rong //rand() la lay ngau nhien
            $new_image =$name_image . rand(0,99).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('public/uploads/slider',$new_image); //luu vao public/uploads/product
            $sl->slider_hinhanh = $new_image;
            $sl->save(); 
           Session::put('message','Cập nhật slider thành công!'); 
            return Redirect::to('danhsach-slider'); }
        $sl->save();
        return Redirect::to('danhsach-slider'); 
    }


    //xoa data cua database
    public function xoa_slider($id_slider){
        $this->Authlogin(); 
        $hinh = Slider::where('slider_id',$id_slider)->value('slider_hinhanh');
        unlink('public/uploads/slider/'.$hinh);
        Slider::destroy($id_slider);
        return Redirect::to('danhsach-slider');
    
    }

     //sua data voi id truyen vao
    public function hienthi_slider($id_slider){
        $this->Authlogin();
        Slider::where('slider_id',$id_slider)->update(['slider_trangthai'=>1]);
        return Redirect::to('danhsach-slider');
    }

    public function an_slider($id_slider){
        $this->Authlogin(); 
        Slider::where('slider_id',$id_slider)->update(['slider_trangthai'=>0]);
        return Redirect::to('danhsach-slider');
    }
}
