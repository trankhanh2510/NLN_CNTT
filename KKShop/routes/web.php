<?php

use Illuminate\Support\Facades\Route; 
//su dung cac Controller
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryProduct;
use App\Http\Controllers\BrandProduct;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\ShippingFeeController;
use App\Http\Controllers\GalleryController;




		//frontend --------TRANG CHỦ------------//
		
		
		
		
Route::get('/',[HomeController::class, 'index']); //lay public index cua HomeController

Route::get('/trang-chu', [HomeController::class, 'index']); //lay public cua HomeController

//----------------tìm kiếm sản phẩm-------------//
Route::post('/search-sp', [HomeController::class, 'search_sp']);
Route::post('/autocomplete-ajax', [HomeController::class, 'autocomplete_ajax']);


//lấy public show_loai_sp_home cua CategoryProduct
Route::get('/loai-sp/{id_loai_sp}', [CategoryProduct::class, 'show_loai_sp_home']); 

//lấy public show_th_sp_home cua CategoryProduct
Route::get('/thuonghieu-sp/{id_th_sp}', [BrandProduct::class,'show_th_sp_home']);
//lấy public chi_tiet_sp cua ProductController
Route::get('/chi-tiet-sp/{id_sp}', [ProductController::class,'chi_tiet_sp']);
// xem nhanh sản phẩm
Route::post('/xemnhanh',[ProductController::class,'xemnhanh']);
	


			//--------------GIỎ HÀNG-------------//
			//
// bumbummen99//
// Route::post('/luu-giohang', [CartController::class, 'luu_giohang']); //dua ve public login de xu ly dang nhap cua CartController

			//--------------AJAX------------------//
Route::post('/them-gh-ajax', [CartController::class, 'them_gh_ajax']); //dua ve public login de xu ly dang nhap cua CartController
// Route::post('/capnhat-gh',[CartController::class,'capnhat_gh']);

Route::get('/gio-hang',[CartController::class,'gio_hang']);

Route::get('/show-sl-gh',[CartController::class,'show_sl_gh']);

Route::get('/show-gh-hover',[CartController::class,'show_gh_hover']);

Route::get('/xoa-sp-gh/{gh_id}',[CartController::class,'xoa_sp_gh']);

Route::get('/xoa-all-sp-gh',[CartController::class,'xoa_all_sp_gh']);

Route::get('/tang-sl-gh/{gh_id}',[CartController::class,'tang_sl_gh']);

Route::get('/giam-sl-gh/{gh_id}',[CartController::class,'giam_sl_gh']);


//------------------------end giỏ hàng------------------------//



// ------------------------KHÁCH HÀNG-----------------------//
// 
// ----------------------trang đăng nhập đăng ký----------------//
Route::get('/login-checkout',[CheckoutController::class,'login_checkout']);

// tạo tài khoản
Route::post('/them-khachhang',[CheckoutController::class,'them_khachhang']); 
//login
Route::post('/login-customer',[CheckoutController::class,'login_customer']);
//logout
Route::get('/logout-customer',[CheckoutController::class,'logout_customer']);


//-----------------------thông tin khách hàng--------------------//
Route::get('/profile-customer',[CheckoutController::class,'profile_customer']);
//sửa thông tin khách hàng
Route::get('/sua-profile',[CheckoutController::class,'sua_profile']);
//cập nhất thông tin khách hàng
Route::post('/capnhat-profile',[CheckoutController::class,'capnhat_profile']);
//sua pass khách hàng
Route::get('/sua-pass',[CheckoutController::class,'sua_pass']);
//cập nhất pass khách hàng
Route::post('/capnhat-pass',[CheckoutController::class,'capnhat_pass']);



//------------------trang điền thông tin nhận hàng-----------------//
Route::get('/checkout',[CheckoutController::class,'checkout']);
//thêm thông tin nhận hàng
Route::get('/them-checkout',[CheckoutController::class,'them_checkout']);
//đua về trang sửa thông tin gửi hàng
Route::get('/sua-checkout',[CheckoutController::class,'sua_checkout']);
//cập nhật thông tin gửi hàng
Route::post('/capnhat-shipping',[CheckoutController::class,'capnhat_shipping']);
//luu thông tin gửi hang
Route::post('/save-shipping',[CheckoutController::class,'save_shipping']);
//------------VẬN CHUYỂN------//
Route::post('/select-shippingfee-home',[CheckoutController::class,'select_shippingfee_home']);
// Route::post('/select-fee-home',[CheckoutController::class,'select_fee_home']);


//---------------------------ĐẶT HÀNG-TRANG KHÁCH -------------------//
//trang đặt hàng
Route::post('/dat-hang',[OrderController::class,'dat_hang']);
//trang đơn hàng
Route::get('/don-hang',[OrderController::class,'don_hang']);
//xóa đơn hàng
Route::get('/xoa-ctdh-kh/{ctdh_id}',[OrderController::class,'xoa_ctdh_kh']);
Route::get('/xoa-dh-kh/{dh_id}',[OrderController::class,'xoa_dh_kh']);





// ------------------------ END KHÁCH HÀNG-----------------------//




//---------------------------ADMIN------------------------//
//
//
				//backend --server
Route::get('/admin', [AdminController::class, 'index']); //dua ve public index cua AdminController
Route::get('/dashboard', [AdminController::class,'show_dashboard']); //dua ve public dashbroad cua AdminController
Route::get('/logout', [AdminController::class, 'logout']); //dua ve public logout cua AdminController
Route::post('/admin-dashboard', [AdminController::class, 'login']); //dua ve public login de xu ly dang nhap cua AdminController

Route::get('/profile-admin',[AdminController::class,'profile_admin']);

Route::get('/sua-profile-admin',[AdminController::class,'sua_profile_admin']);

Route::post('/capnhat-profile-admin',[AdminController::class,'capnhat_profile_admin']);

Route::get('/password-admin',[AdminController::class,'password_admin']);

Route::post('/capnhat-password-admin',[AdminController::class,'capnhat_password_admin']);





//-----------------Slider----------------//
//hiển thị 
Route::get('danhsach-slider',[SliderController::class,'danhsach_slider']);
Route::get('/them-slider', [SliderController::class,'them_slider']); 
//them 
Route::post('/luu-slider', [SliderController::class, 'luu_slider']); 
//an hien 
Route::get('/hienthi-slider/{id_slider}', [SliderController::class,'hienthi_slider']); 
Route::get('/an-slider/{id_slider}', [SliderController::class, 'an_slider']); 
//sua 
Route::get('/sua-slider/{id_slider}', [SliderController::class, 'sua_slider']); 
//cap nhat 
Route::post('/capnhat-slider/{id_slider}', [SliderController::class, 'capnhat_slider']); 
Route::get('/xoa-slider/{id_slider}', [SliderController::class, 'xoa_slider']);


//-----------------------PHÍ VẬN CHUYỂN----------//
Route::get('/them-shippingfee',[ShippingFeeController::class,'them_shippingfee']);
Route::post('/select-shippingfee',[ShippingFeeController::class,'select_shippingfee']);
Route::post('/luu-shippingfee',[ShippingFeeController::class,'luu_shippingfee']);
Route::post('/xem-shippingfee',[ShippingFeeController::class,'xem_shippingfee']);
Route::post('/luu-fee',[ShippingFeeController::class,'luu_fee']);

//-----------------------LOẠI SẢN PHẨM----------------//
//thêm 
Route::get('/them-loai-sp', [CategoryProduct::class,'them_loai_sp']); //dua ve public them_loai_sp  cua CategoryProduct
//danh sách sản phẩm 
Route::get('/danhsach-loai-sp', [CategoryProduct::class, 'danhsach_loai_sp']); //dua ve public danhsach_loai_sp  cua CategoryProduct

//them loai san pham
Route::post('/luu-loai-sp', [CategoryProduct::class, 'luu_loai_sp']); //dua ve public luu_loai_sp  cua CategoryProduct

//an hien loai sp
Route::get('/hienthi-loai-sp/{id_loai_sp}', [CategoryProduct::class,'hienthi_loai_sp']); //dua ve public hienthi_loai_sp va gui id_loai_sp cua CategoryProduct
Route::get('/an-loai-sp/{id_loai_sp}', [CategoryProduct::class, 'an_loai_sp']); //dua ve public an_loai_sp va gui id_loai_sp cua CategoryProduct

//sua loai sp
Route::get('/sua-loai-sp/{id_loai_sp}', [CategoryProduct::class, 'sua_loai_sp']); //dua ve public sua_loai_sp va gui id_loai_sp cua CategoryProduct
//cap nhat loai sp
Route::post('/capnhat-loai-sp/{id_loai_sp}', [CategoryProduct::class, 'capnhat_loai_sp']); //dua ve public capnhat_loai_sp  cua CategoryProduct 

//xóa loại sản phẩm
Route::get('/xoa-loai-sp/{id_loai_sp}', [CategoryProduct::class, 'xoa_loai_sp']);//dua ve public xoa_loai_sp va gui id_loai_sp cua CategoryProduct




//---------------------------------THƯƠNG HIỆU--------------------//

//thêm 
Route::get('/them-th-sp', [BrandProduct::class,'them_th_sp']); //dua ve public them_th_sp  cua BrandProduct
//hiển thị 
Route::get('/danhsach-th-sp', [BrandProduct::class, 'danhsach_th_sp']); //dua ve public danhsach_th_sp  cua BrandProduct

//them th san pham
Route::post('/luu-th-sp', [BrandProduct::class, 'luu_th_sp']); //dua ve public luu_th_sp  cua BrandProduct

//an hien th sp
Route::get('/hienthi-th-sp/{id_th_sp}', [BrandProduct::class,'hienthi_th_sp']); //dua ve public hienthi_th_sp va gui id_th_sp cua BrandProduct
Route::get('/an-th-sp/{id_th_sp}', [BrandProduct::class, 'an_th_sp']); //dua ve public an_th_sp va gui id_th_sp cuaBrandProduct

//sua th sp
Route::get('/sua-th-sp/{id_th_sp}', [BrandProduct::class, 'sua_th_sp']); //dua ve public sua_th_sp va gui id_th_sp cua BrandProduct 
Route::post('/capnhat-th-sp/{id_th_sp}', [BrandProduct::class, 'capnhat_th_sp']); //dua ve public capnhat_th_sp  cua BrandProduct 


Route::get('/xoa-th-sp/{id_th_sp}', [BrandProduct::class, 'xoa_th_sp']);//dua ve public xoa_th_sp va gui id_th_sp cua BrandProduct
//cap nhat th sp



//---------------------------SẢN PHẨM------------------------------//

//thêm 
Route::get('/them-sp', [ProductController::class,'them_sp']); //dua ve public them_sp  cua ProductController
//hiển thị 
Route::get('/danhsach-sp', [ProductController::class, 'danhsach_sp']); //dua ve public danhsach_th_sp  cua ProductController

//them san pham
Route::post('/luu-sp', [ProductController::class, 'luu_sp']); //dua ve public luu_sp  cua ProductController

//an hien sp
Route::get('/hienthi-sp/{id_sp}', [ProductController::class,'hienthi_sp']); //dua ve public hienthi_sp va gui id_sp cua ProductController
Route::get('/an-sp/{id_sp}', [ProductController::class, 'an_sp']); //dua ve public an_sp va gui id_sp cua ProductController

//sua sp
Route::get('/sua-sp/{id_sp}', [ProductController::class, 'sua_sp']); //dua ve public sua_sp va gui id_sp cua ProductController
//cap nhat sp
Route::post('/capnhat-sp/{id_sp}', [ProductController::class, 'capnhat_sp']); //dua ve public capnhat_sp  cua ProductController

Route::get('/xoa-sp/{id_sp}', [ProductController::class, 'xoa_sp']);//dua ve public xoa_sp va gui id_sp cua ProductController

//-----------------------------THƯ VIỆN ẢNH -GALLERY--------------------------//
Route::get('/chitiet-asp/{id_sp}',[GalleryController::class,'chitiet_asp']);
Route::post('/select-anhsanpham', [GalleryController::class, 'select_anhsanpham']); 
Route::post('/luu-anhsp/{id_sp}', [GalleryController::class, 'luu_anhsp']); 
Route::post('/capnhat-ten-asp', [GalleryController::class, 'capnhat_ten_asp']); 
Route::post('/xoa-anhsanpham', [GalleryController::class, 'xoa_anhsanpham']); 
Route::get('hienthidau-asp/{id_asp}',[GalleryController::class, 'hienthidau_asp']);


//---------------------------ĐƠN HÀNG-ADMIN----------------//
Route::get('/quanly-donhang',[OrderController::class,'quanly_donhang']);

Route::get('/chitiet-dh/{dh_id}',[OrderController::class,'chitiet_dh']);

Route::get('/xacnhan-dh/{dh_id}',[OrderController::class,'xacnhan_dh']);

Route::get('/huy-dh/{dh_id}',[OrderController::class,'huy_dh']);

Route::get('/xoa-dh/{dh_id}',[OrderController::class,'xoa_dh']);

Route::get('/xoa-ctdh/{ctdh_id}',[OrderController::class,'xoa_ctdh']);

Route::get('/print-order/{dh_id}',[OrderController::class,'print_order']);

		//--------------shippng---------//

Route::get('/danhsach-shipping',[CheckoutController::class,'danhsach_shipping']);
Route::get('/xoa-shipping/{shipping_id}',[CheckoutController::class,'xoa_shipping']);


//--------------------KHÁCH HÀNG--------------------//
Route::get('/danhsach-kh',[AdminController::class,'danhsach_kh']);
Route::get('/xoa-khachhang/{kh_id}',[AdminController::class,'xoa_khachhang']);
Route::get('/chitiet-khachhang/{kh_id}',[AdminController::class,'chitiet_khachhang']);


