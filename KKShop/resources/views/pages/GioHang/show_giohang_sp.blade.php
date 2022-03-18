@extends('layout') <!--mo rong call file layout -->
@section('content')

<section id="cart_items">
	<div class="container" style="width: 100%;">
		<div class="breadcrumbs">
			<ol class="breadcrumb">
			  <li><a href="{{URL::to('/')}}">Trang chủ</a></li>
			  <li class="active">Giỏ hàng của bạn</li>
			</ol>
		</div>
		
		@if(Session()->has('message'))
			<div class="alert alert-success">
				{{ session()->get('message')}}
				{{Session::put('message',null)}}
			</div>
		@endif
		<div class="table-responsive cart_info">

			{{-- <?php
				$content= Cart::content();
				sài cho bumbummen99
			?> --}}


		<form action="{{url('capnhat-gh')}}" method="POST" >
			@csrf 
			{{-- sửa lỗi 419 --}}
			<table class="table table-condensed">
				<thead>
					<tr class="cart_menu">
						<td class="image" style="width: 15%;">Hình ảnh</td>
						<td class="description" style="width:40%;">Tên</td>
						<td class="price">Giá</td>
						<td class="quantity" style="width: 11%;">Số lượng</td>
						<td class="total">Đơn giá</td>
						<td></td>
					</tr>
				</thead>
				<tbody>
				@php
					$tongtien=0;
						
				@endphp
				@if(Session::get('giohang')==true)
					{{-- @foreach($content as $v_content) sài cho bumbummen99--}}

					@foreach(Session::get('giohang') as $key => $giohang)
					<tr>
						<td class="cart_product">
							<a><img src="{{URL::to('public/uploads/product/'.$giohang["sanpham_hinhanh"])}}" alt="{{$giohang["sanpham_hinhanh"]}}"  width="100"></a>
						</td>
						<td class="cart_description">
							<p><b><a href="{{URL::to('chi-tiet-sp/'.$giohang["sanpham_id"])}}">{{$giohang["sanpham_ten"]}}</a></b></p>
							<p style="color: red;">ID: {{$giohang["sanpham_id"]}}</p>
						</td>
						<td class="cart_price">
							
								{{number_format($giohang['sanpham_gia'],'0',',','.')}}<small> <b>&#8363;</b></small>
                                                
							
						</td>
						<td class="cart_quantity">
							<div class="cart_quantity_button">
								<a class="cart_quantity_up" href="{{URL::to('tang-sl-gh/'.$giohang["gh_id"])}}"> + </a>
								
								<p class="cart_quantity_input" style="width: 25px;">{{$giohang["sanpham_soluong"]}}</p>
								<a class="cart_quantity_down" href="{{URL::to('giam-sl-gh/'.$giohang["gh_id"])}}"> - </a>
																 	
							</div>
						</td>
						<td class="cart_total">
							<p class="cart_total_price">
								<?php 
									$subtotal = $giohang["sanpham_gia"] * $giohang["sanpham_soluong"];
									$tongtien += $subtotal;
									

								?>
								{{number_format($subtotal,'0',',','.')}}<small> <b>&#8363;</b></small>
							
							</p>
						</td>
						<td class="cart_delete">
							<a class="cart_quantity_delete" href="{{url('xoa-sp-gh/'.$giohang["gh_id"])}}"><box-icon name='trash' animation='tada' color='blue' ></box-icon></a>
						</td>
					</tr>
					@endforeach
					<tr>
						<td ><a style="margin-bottom: 10px;" class="btn btn-default check_out" href="{{url('xoa-all-sp-gh')}}">Xóa tất cả</a></td>
						<td >@if(Session::get('kh_id')!=null)
									<a style="margin-bottom: 10px;" class="btn btn-default check_out" href="{{URL::to('checkout')}}">Đặt hàng</a>
									
								@else
									<a  style="margin-bottom: 10px;" class="btn btn-default check_out" href="{{URL::to('login-checkout')}}">Đặt hàng</a>
								@endif
						</td>
						<td colspan="2" style="font-size: 20px;"><b>Tổng giỏ hàng</b></td>
						<td colspan="2" style="color:rgb(20, 53, 195);font-size: 20px;">{{number_format($tongtien,'0',',','.')}}<small> <b>&#8363;</b></small></td>

					</tr>
					
				@else
					<tr><td colspan="6" style="color:rgb(20, 53, 195); font-size:20px; "><center><b>Chưa có sản phẩm nào trong giỏ hàng</b></center></td></tr>
				@endif
				</tbody>
				
					
			</table>
			</form>
		</div>
	</div>
</section> <!--/#cart_items-->




@endsection