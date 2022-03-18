@extends('layout') <!--mo rong call file layout -->
@section('content')<!--tao section home -->
{{-- @foreach($chitiet_sp as $key => $sanpham) --}}
	<div class="product-details"><!--product-details-->
		<style>
			li.active {
	    		border: 2px solid blue;
			}
		</style>
		{{-- đường dẫn --}}
		<nav aria-label="breadcrumb">
		  <ol class="breadcrumb" style="background: none;font-size: 15px;">
		    <li class="breadcrumb-item"><a href="{{url('/')}}">Trang chủ</a></li>
		    <li class="breadcrumb-item"><a href="{{URL::to('loai-sp/'.$chitiet_sp->l_id)}}">{{$chitiet_sp->Category->Ten}}</a></li>
		    <li class="breadcrumb-item active" aria-current="page">{{$chitiet_sp->sp_Ten}}</li>
		  </ol>
		</nav>
		<div class="col-sm-6">
			<ul id="imageGallery">
				{{-- ajax --}}
				@foreach($gallery as $key => $gal)
					<li data-thumb="{{asset('public/uploads/product/'.$gal->asp_hinhanh)}}" data-src="{{asset('public/uploads/product/'.$gal->asp_hinhanh)}}">
						<center><img style="max-width: 100%;max-height: 400px;" alt="{{$gal->asp_ten}}" src="{{asset('public/uploads/product/'.$gal->asp_hinhanh)}}" /></center>
					</li>
					{{-- data-thumb ảnh nhỏ
						data-src chi tiết ảnh
						cuối là ảnh lớn --}}
				@endforeach
			</ul>
		</div>
		<div class="col-sm-6">
			<div class="product-information"><!--/product-information-->
			
				<h2>{{$chitiet_sp->sp_Ten}}</h2>
				<br>
				<p><b>Sản phẩm ID:</b> {{$chitiet_sp->sp_id}}</p>
				<?php 
						if($chitiet_sp->sp_soluong==0){
					?>
						<p style="color:blue;font-size:20px "><b>Hết hàng</b></p>
					<?php
						}else{
					?>
						<p><b>Số lượng tồn: </b>{{$chitiet_sp->sp_soluong}}</p>
					<?php
						}
					?>
				
				<p><b>Loại sản phẩm: </b>{{$chitiet_sp->Category->Ten}}</p>
				<p><b>Thương hiệu:</b> {{$chitiet_sp->Brand->th_Ten}}</p>
				 <form > 
	                @csrf
	            {{-- hideen là ẩn --}}
	                <input type="hidden" value="{{$chitiet_sp->sp_id}}" class="gh_sp_id_{{$chitiet_sp->sp_id}}">

	                <input type="hidden" value="{{$chitiet_sp->sp_Ten}}" class="gh_sp_ten_{{$chitiet_sp->sp_id}}">

	                <input type="hidden" value="{{$anh_sp->asp_hinhanh}}" class="gh_sp_hinhanh_{{$chitiet_sp->sp_id}}">

	                <input type="hidden" value="{{$chitiet_sp->sp_gia}}" class="gh_sp_gia_{{$chitiet_sp->sp_id}}">

				{{-- dung cho bumbummen99 <form action="{{URL::to('luu-giohang')}}" method="POST"> --}}
					{{-- {{csrf_field()}} --}}
					<span>Giá: {{number_format($chitiet_sp->sp_gia,'0',',','.')}}<small><small> &#8363;</small></small></span>
					<br>
					<span>
						@if($chitiet_sp->sp_soluong>0)
							<?php
                                $test =0;
                                $slgh=0;
                            ?>
							@if(Session::get('giohang'))
                                @foreach(Session::get('giohang') as $key => $val)
                                    <?php
                                        $slgh++;
                                    ?>
                                    @if($val['sanpham_id']==$chitiet_sp->sp_id)
                                         <p style="color:blue;margin-bottom: 1.8px;font-size:20px;"><b>Đã thêm vào giỏ hàng</b></p>
                                         @break;
                                    @else 
                                         <?php
                                            $test++;
                                        ?>
                                    @endif
                                @endforeach
                                @if($test==$slgh)
                                <label style="font-size:20px; ">Số lượng</label>
								<input {{-- name="soluong" --}} class="gh_sp_soluong_{{$chitiet_sp->sp_id}}" type="number" min="1" max="{{$chitiet_sp->sp_soluong}}" value="1" required="" />
								{{-- dùng cho bumbummen99 <input name="sanpham_id_order" type="hidden" value="{{$chitiet_sp->sp_id}}" />  --}}
								{{-- hidden la ẩn --}}
								{{-- <button type="submit" class="btn btn-fefault cart">
									<i class="fa fa-shopping-cart"></i>
									Thêm giỏ hàng
								</button> --}}
							<br><br>
							 <button class="btn btn-default add-to-cart " data-id_sp="{{$chitiet_sp->sp_id}}"type="button" name="add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm giỏ hàng</button>
	                    	{{-- button dua vao data-id de lay id san pham chinh xac data là mặc định còn tên là id_sp --}}
                                @endif
                            @else 
                            	<label style="font-size:20px; ">Số lượng</label>
								<input {{-- name="soluong" --}} class="gh_sp_soluong_{{$chitiet_sp->sp_id}}" type="number" min="1" max="{{$chitiet_sp->sp_soluong}}" value="1" required="" />
								{{-- dùng cho bumbummen99 <input name="sanpham_id_order" type="hidden" value="{{$chitiet_sp->sp_id}}" />  --}}
								{{-- hidden la ẩn --}}
								{{-- <button type="submit" class="btn btn-fefault cart">
									<i class="fa fa-shopping-cart"></i>
									Thêm giỏ hàng
								</button> --}}
								<br><br>
								 <button class="btn btn-default add-to-cart " data-id_sp="{{$chitiet_sp->sp_id}}"type="button" name="add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm giỏ hàng</button>
		                    	{{-- button dua vao data-id de lay id san pham chinh xac data là mặc định còn tên là id_sp --}}  
                            @endif
						@endif
					</span>
				</form>
				
			</div><!--/product-information-->
		</div>
	</div><!--/product-details-->

	<div class="shop-details-tab"><!--category-tab-->
		<div class="category-tab">
			<div class="col-sm-12">
				<ul class="nav nav-tabs">
					<li  class="active"><a href="#details" data-toggle="tab">Mô tả sản phẩm</a></li>
					<li><a href="#companyprofile" data-toggle="tab">Chi tiết sản phẩm</a></li>
				</ul>
			</div>
		</div>
		<div class="tab-content" style="background-color:#cccccc;margin-top: -40px;" >
			<div class="tab-pane fade active in" id="details" style="overflow:scroll;max-height:600px;">
				<p style="margin: 10px;">{!!$chitiet_sp->sp_MoTa!!}</p>
				{{-- <style type="text/css">
					
				</style>  --}}
				<br>
				{{-- có thể dùng {!!sadsa!!} đúng định dạng --}}
			</div>

			
		<div class="tab-pane fade" id="companyprofile" style="overflow:scroll;max-height:600px;">
			<p style="margin-left: 15px;">{!!$chitiet_sp->sp_noidung!!}</p>
			<br>
		</div>
			
			
		</div>
	</div><!--category-tab-->
	{{-- @endforeach --}}
	@if(Session::get('test_lienquan')!=null)
		<div class="recommended_items"><!--recommended_items-->
			<h2 class="title text-center">Sản phẩm gợi ý</h2>
			
			<div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
				<div class="carousel-inner">
					<div class="item active">
						<?php $k=0; ?>	
						@foreach($sp_lienquan as $key => $lienquan)
							<?php $k++;?>
						@if($k==4)
							@break
						@endif
						
							<div class="col-sm-4">
								<div class="product-image-wrapper">
									<div class="single-products">
										<div class="productinfo text-center">
											<form > 
                                                @csrf
                                                {{-- hideen là ẩn --}}
                                                <input type="hidden" value="{{$lienquan->sp_id}}" class="gh_sp_id_{{$lienquan->sp_id}}">

                                                <input id="wishlist_sp_ten{{$lienquan->sp_id}}" type="hidden" value="{{$lienquan->sp_Ten}}" class="gh_sp_ten_{{$lienquan->sp_id}}">

                                                <input type="hidden" value="{{$lienquan->asp_hinhanh}}" class="gh_sp_hinhanh_{{$lienquan->sp_id}}">

                                                <input type="hidden" value="{{$lienquan->sp_gia}}" class="gh_sp_gia_{{$lienquan->sp_id}}">

                                                <input type="hidden" id="wishlist_sp_gia{{$lienquan->sp_id}}" value="{{number_format($lienquan->sp_gia,'0',',','.')}}đ">

                                                <input type="hidden" value="1" class="gh_sp_soluong_{{$lienquan->sp_id}}">
		                                        <a id="wishlist_sp_url{{$lienquan->sp_id}}" href="{{URL::to('/chi-tiet-sp/'.$lienquan->sp_id)}}">
													<img id="wishlist_sp_hinhanh{{$lienquan->sp_id}}" src="{{URL::to('public/uploads/product/'.$lienquan->asp_hinhanh)}}" alt="" height="200" width="100" />
													<h2>{{number_format($lienquan->sp_gia,'0',',','.')}}<small style="color: blue;"> <b>&#8363;</b></small></h2>
													<p>{{$lienquan->sp_Ten}}</p>
												</a>
											{{-- <button type="button" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm giỏ hàng</button> --}}
											@if($lienquan->sp_soluong>0)
                                                @if(Session::get('giohang'))
                                                <?php
                                                    $test =0;
                                                    $slgh=0;
                                                ?>
                                                    @foreach(Session::get('giohang') as $key => $val)
                                                        <?php
                                                            $slgh++;
                                                        ?>
                                                        @if($val['sanpham_id']==$lienquan->sp_id)
                                                            <p style="color:blue;margin-bottom: -6px;width: 50%;float: left;margin-left:10px;margin-top: 3%;"><b>Đã thêm giỏ hàng</b></p>
                                                             @break;
                                                        @else 
                                                             <?php
                                                                $test++;
                                                            ?>
                                                        @endif
                                                    @endforeach
                                                    @if($test==$slgh)
                                                        <button class="btn btn-default add-to-cart " data-id_sp="{{$lienquan->sp_id}}" type="button" name="add-to-cart"><i class="fa fa-cart-plus"></i>Thêm giỏ hàng</button>
                                                    @endif
                                    			@else 
                                         			<button class="btn btn-default add-to-cart " data-id_sp="{{$lienquan->sp_id}}" type="button" name="add-to-cart"><i class="fa fa-cart-plus"></i>Thêm giỏ hàng</button>
                                   					{{-- button dua vao data-id de lay id san pham chinh xac data là mặc định còn tên là id_sp --}}
                               
                                    			@endif
                                            @else 
                                                <p style="color:blue;margin-bottom: -6px;width: 50%;float: left;margin-left:10px;margin-top: 3%;"><b>Hết hàng</b></p>
                                           
                                            @endif
                                            <button class="btn btn-default xemnhanh " data-id_sp="{{$lienquan->sp_id}}" data-toggle="modal" data-target="#xemnhanh" type="button" name="xemnhanh">Xem nhanh</button>
                                            </form>

                                        {{-- </form> --}}

										</div>
									</div>
									<div class="choose" style="float: right;">
                                        <ul class="nav nav-pills nav-justified">

                                            <li>
                                                <button class="button_wishlist" id="{{$lienquan->sp_id}}" onclick="add_wishlist(this.id);"><i class="fa fa-plus-square"></i><span> Yêu thích</span></button>
                                            </li>
                                            
                                            {{-- <li><a href="#"><i class="fa fa-plus-square"></i>Yêu thích</a></li> --}}
                                        </ul>
                                    </div>
								</div>
							</div>
						
						@endforeach
					</div>

					<?php $test =0; ?>
					@foreach($sp_lienquan as $key => $lienquan)
					<?php $test++;?>
					@endforeach
					@if($test>3)
						<div class="item">	
							<?php $N =0; ?>
							@foreach($sp_lienquan as $key => $lienquan)
							<?php $N++;?>
							@if($N<=3)
								@continue
							@endif
								<div class="col-sm-4">
									<div class="product-image-wrapper">
										<div class="single-products">
											<div class="productinfo text-center">
												<form > 
                                                @csrf
                                                {{-- hideen là ẩn --}}
                                                <input type="hidden" value="{{$lienquan->sp_id}}" class="gh_sp_id_{{$lienquan->sp_id}}">

                                                <input type="hidden" id="wishlist_sp_ten{{$lienquan->sp_id}}" value="{{$lienquan->sp_Ten}}" class="gh_sp_ten_{{$lienquan->sp_id}}">

                                                <input type="hidden" value="{{$lienquan->asp_hinhanh}}" class="gh_sp_hinhanh_{{$lienquan->sp_id}}">

                                                <input type="hidden" value="{{$lienquan->sp_gia}}" class="gh_sp_gia_{{$lienquan->sp_id}}">

                                                <input type="hidden" id="wishlist_sp_gia{{$lienquan->sp_id}}" value="{{number_format($lienquan->sp_gia,'0',',','.')}}đ">

                                                <input type="hidden" value="1" class="gh_sp_soluong_{{$lienquan->sp_id}}">
		                                        <a id="wishlist_sp_url{{$lienquan->sp_id}}" href="{{URL::to('/chi-tiet-sp/'.$lienquan->sp_id)}}">
													<img id="wishlist_sp_hinhanh{{$lienquan->sp_id}}" src="{{URL::to('public/uploads/product/'.$lienquan->asp_hinhanh)}}" alt="" height="200" width="100" />
													<h2>{{number_format($lienquan->sp_gia,'0',',','.')}}<small style="color: blue;"> <b>&#8363;</b></small></h2>
													<p>{{$lienquan->sp_Ten}}</p>
												</a>
												
												{{-- <button type="button" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm giỏ hàng</button> --}}
												@if($lienquan->sp_soluong>0)
                                                @if(Session::get('giohang'))
                                                <?php
                                                    $test =0;
                                                    $slgh=0;
                                                ?>
                                                    @foreach(Session::get('giohang') as $key => $val)
                                                        <?php
                                                            $slgh++;
                                                        ?>
                                                        @if($val['sanpham_id']==$lienquan->sp_id)
                                                            <p style="color:blue;margin-bottom: -6px;width: 50%;float: left;margin-left:10px;margin-top: 3%;"><b>Đã thêm giỏ hàng</b></p>
                                                             @break;
                                                        @else 
                                                             <?php
                                                                $test++;
                                                            ?>
                                                        @endif
                                                    @endforeach
                                                    @if($test==$slgh)
                                                        <button class="btn btn-default add-to-cart " data-id_sp="{{$lienquan->sp_id}}" type="button" name="add-to-cart"><i class="fa fa-cart-plus"></i>Thêm giỏ hàng</button>
                                                    @endif
                                    			@else 
                                         			<button class="btn btn-default add-to-cart " data-id_sp="{{$lienquan->sp_id}}" type="button" name="add-to-cart"><i class="fa fa-cart-plus"></i>Thêm giỏ hàng</button>
                                   					{{-- button dua vao data-id de lay id san pham chinh xac data là mặc định còn tên là id_sp --}}
                               
                                    			@endif
                                            @else 
                                                <p style="color:blue;margin-bottom: -6px;width: 50%;float: left;margin-left:10px;margin-top: 3%;"><b>Hết hàng</b></p>
                                           
                                            @endif
                                            <button class="btn btn-default xemnhanh " data-id_sp="{{$lienquan->sp_id}}" data-toggle="modal" data-target="#xemnhanh" type="button" name="xemnhanh">Xem nhanh</button>
                                                </form>
											</div>
										</div>
										<div class="choose" style="float: right;">
	                                        <ul class="nav nav-pills nav-justified">

	                                            <li>
	                                                <button class="button_wishlist" id="{{$lienquan->sp_id}}" onclick="add_wishlist(this.id);"><i class="fa fa-plus-square"></i><span> Yêu thích</span></button>
	                                            </li>
	                                            
	                                            {{-- <li><a href="#"><i class="fa fa-plus-square"></i>Yêu thích</a></li> --}}
	                                        </ul>
	                                    </div>
									</div>
								</div>
							@endforeach											
						</div>
					@endif
				</div>
				 <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
					<i class="fa fa-angle-left"></i>
				  </a>
				  <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
					<i class="fa fa-angle-right"></i>
				  </a>			
			</div>
		</div><!--/recommended_items-->
		<?php
			Session::put('test_lienquan',null);
		?>
	@endif
	 <!-- Modal -->
    <div class="modal fade" id="xemnhanh" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document"style="overflow:scroll;max-height:700px;">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">
                <a href="{{URL::to('/chi-tiet-sp/'.$lienquan->sp_id)}}" >
                    <span id="sanpham_xn_ten"></span>
                </a>
            </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="row">
                <div class="col-md-5">
                    <span id="sanpham_xn_khoanh"></span>
                </div>
                <div class="col-md-7">
                    <p style="color:red;font-size: 16px;"><b>ID:</b> <span id="sanpham_xn_id"></span></p>   
                    <p style="color:blue;font-size: 20px;">Giá: <span id="sanpham_xn_gia"></span></p>
                    <p>Số lượng tồn: <span id="sanpham_xn_tonkho"></span></p> 
                    <p><span id="sanpham_xn_mota"></span></p><br>
                    <p style="font-size: 20px;color: blue;"><b>Cấu hình chi tiết</b></p>
                    <p><span id="sanpham_xn_noidung"></span></p>   
  
                </div>          
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
            {{-- <button type="button" class="btn btn-primary" style="margin-top: 0px;">Save changes</button> --}}
          </div>
        </div>
      </div>
    </div>
<style>
    span#sanpham_xn_khoanh img {
    width: 100%;
    }
    .col-md-7 img {
    width: 100%;
    }
    
</style>

@endsection