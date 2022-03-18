<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use DB;
use App\Http\Requests; //lay yeu cau data tu post 
use Illuminate\Support\Facades\Redirect; //nhuw return tra ve nhung chi vao ten tren link
use App\Models\Slider;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
session_start();


class HomeController extends Controller
{
    public function index(){
        //Slider
        $slider = Slider::orderby('slider_id','DESC')->where('slider_trangthai','1')->get();
        $loai_sp = Category::orderby('l_id','desc')->where('TrangThai','1')->get();
        $thuonghieu_sp = Brand::orderby('th_id','desc')->where('th_TrangThai','1')->get();
        // $sanpham = Product::where('sp_TrangThai','1')->orderby('sp_id','desc')->take(6)->get();
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
            $sanpham = DB::table('SanPham')->where('sp_TrangThai','1')
            ->join('AnhSanPham','SanPham.sp_id','=','AnhSanPham.sp_id')
            ->where('AnhSanPham.asp_trangthai',1)->whereBetween('sp_gia',[$min_price,$max_price])
            ->select('SanPham.*','AnhSanPham.asp_hinhanh')->paginate(6)->appends(request()->query());
        }elseif(isset($_GET['brand'])){
            $brand_filter = $_GET['brand'];
            $brand_arr = explode(",", $brand_filter);
            $sanpham = DB::table('SanPham')->where('sp_TrangThai','1')
            ->join('AnhSanPham','SanPham.sp_id','=','AnhSanPham.sp_id')
            ->where('AnhSanPham.asp_trangthai',1)->whereIn('th_id',$brand_arr)
            ->select('SanPham.*','AnhSanPham.asp_hinhanh')->paginate(6)->appends(request()->query());

        }elseif(isset($_GET['category'])){
            $category_filter = $_GET['category'];
            $category_arr = explode(",", $category_filter);
            $sanpham = DB::table('SanPham')->where('sp_TrangThai','1')
            ->join('AnhSanPham','SanPham.sp_id','=','AnhSanPham.sp_id')
            ->where('AnhSanPham.asp_trangthai',1)->whereIn('l_id',$category_arr)
            ->select('SanPham.*','AnhSanPham.asp_hinhanh')->paginate(6)->appends(request()->query());

        }else{
            $sanpham = DB::table('SanPham')->where('sp_TrangThai','1')
            ->join('AnhSanPham','SanPham.sp_id','=','AnhSanPham.sp_id')
            ->where('AnhSanPham.asp_trangthai',1)->orderby($A,$B)
            ->select('SanPham.*','AnhSanPham.asp_hinhanh')->paginate(6)->appends(request()->query());
        }
    	return view('pages.home')->with('loai_sp',$loai_sp)->with('thuonghieu_sp',$thuonghieu_sp)->with('sanphams',$sanpham)->with('slider',$slider); //goi trang layout.blade.php
    }
    public function search_sp(Request $request){
    	$key = $request->keywords_submit;
        $slider = Slider::orderby('slider_id','DESC')->where('slider_trangthai','1')->get();
        $loai_sp = Category::orderby('l_id','desc')->where('TrangThai','1')->get();
        $thuonghieu_sp = Brand::orderby('th_id','desc')->where('th_TrangThai','1')->get();
        $search_sanpham = DB::table('SanPham')->where('sp_TrangThai','1')->where('sp_Ten','Like','%'.$key.'%')
        ->join('AnhSanPham','SanPham.sp_id','=','AnhSanPham.sp_id')
        ->where('AnhSanPham.asp_trangthai',1)
        ->select('SanPham.*','AnhSanPham.asp_hinhanh')->get();//paginate(3);

    	return view('pages.SanPham.search')->with('loai_sp',$loai_sp)->with('thuonghieu_sp',$thuonghieu_sp)->with('search_sanpham',$search_sanpham)->with('slider',$slider)->with('key',$key); //goi trang layout.blade.php

    }
    public function autocomplete_ajax(Request $request){
        $data = $request->all();
        if($data['kq']){
            // $sp_search = Product::where('sp_TrangThai',1)->where('sp_Ten','LIKE','%'.$data['kq'].'%')->get();
            $sp_search = DB::table('SanPham')->where('sp_TrangThai','1')->where('sp_Ten','LIKE','%'.$data['kq'].'%')
            ->join('AnhSanPham','SanPham.sp_id','=','AnhSanPham.sp_id')
            ->where('AnhSanPham.asp_trangthai',1)
            ->select('SanPham.*','AnhSanPham.asp_hinhanh')->get();
            $output = '<ul class="dropdown-menu" style="display:block;position:absolute;background-color: #ccc;z-index: 3;overflow:scroll; max-height: 500px;">';
            foreach ($sp_search as $key => $value) {
                $output .= '
                    <li>
                        <a href="'.url('/chi-tiet-sp/'.$value->sp_id).'">
                            <div class="row">
                                <div class="col-sm-3">
                                    <img src="'.asset('public/uploads/product/'.$value->asp_hinhanh).'" alt="" style="width:100%; height: 80px;">      
                                </div>
                                <div class="col-sm-9" >
                                    <p>'.$value->sp_Ten.'</p>
                                    <p style="color:red;">'.number_format($value->sp_gia,'0',',','.').'<small style="color: red;"> <b>&#8363; </b></small></p>      
                                </div>    
                            </div>

                           
                        </a>
                    </li>';
            }
            $output .= '</ul>';
            echo $output;
        }
    }    
}

// controller dieu kien moi hoat dong cua view