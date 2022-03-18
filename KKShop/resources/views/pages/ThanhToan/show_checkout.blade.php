@extends('layout')
@section('content')
<section id="cart_items">
		<div class="container" style="width: 100%;">
			<div class="breadcrumbs">
				<ol class="breadcrumb">
				  <li><a href="{{URL::to('/')}}">Trang chủ</a></li>
				  <li class="active">Thông tin đặt hàng của {{Session::get('kh_ten')}}</li>
				</ol>
			</div><!--/breadcrums-->
			<div class="shopper-informations" style="width: 75%;">
				<div class="row">
					<div class="col-sm-12 clearfix">
						<div class="bill-to">
							<p style="font-size: 25px;"><b>Thông tin đặt hàng</b></p>
							<?php
								$message = Session::get('message');
								if($message){
									echo '<span class="error_login">' .$message. '</span>';
									Session::put('message',null);
									}
							?>
							<div class="form-one" style="width: 100%;">

									<form action="{{URL::to('dat-hang')}}" method="post">
										{{ csrf_field() }}
											<p><b>Tên: </b> {{$shipping_data->shipping_ten}}</p>
											<p><b>SDT: </b> {{$shipping_data->shipping_sdt}}</p>
											<p><b>Địa chỉ: </b>{{$shipping_data->shipping_diachi}}</p>
											<p><b>Phí: </b>{{number_format($shipping_data->phi,'0',',','.')}}<small> &#8363;</small></p>
											<p><b>Ghi chú: </b>{{$shipping_data->shipping_note}}</p>
										@if($shipping_data->shipping_trangthai==0)
											<a style="margin-left: 0;" class="btn btn-default check_out" href="{{URL::to('sua-checkout')}}">Thay đổi thông tin nhận hàng</a>
										@endif
										<a style="margin-left: 0; " class="btn btn-default check_out" href="{{URL::to('them-checkout')}}">Thêm mới thông tin nhận hàng</a>
										@if(Session::get('giohang')!=null)
										<a onclick="return confirm('Bạn có chắc muốn đặt đơn hàng này?')">
											<b><input style="width: 100px; height: 30px; font-size:14px;margin-bottom: -3; " type="submit" value="Đặt hàng" name="dat-hang" class="btn btn-primary btn-sm"></b>
										</a>
										@endif
									</form>
							</div>
						</div>
					</div>				
				</div>
			</div>
		@if(Session::get('giohang')==true)
			<div class="review-payment">
				<h2><b>Xem lại giỏ hàng</b></h2>
				<div class="table-responsive cart_info" style="font-size: 14px;">

				{{-- <?php
					$content= Cart::content();
					sài cho bumbummen99
				?> --}}
				<table class="table table-condensed">
					<thead>
						<tr class="cart_menu">
							<td class="image" style="width:17%;">Hình ảnh</td>
							<td class="description">Tên</td>
							<td class="price">Giá</td>
							<td class="quantity" style="width: 7%;">SL</td>
							<td class="total" style="width:15%">Tổng</td>
						</tr>
					</thead>
					<tbody>
					@php
						$tongtien=0;
							
					@endphp
					
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
								{{number_format($giohang['sanpham_gia'],'0',',','.')}}<small> <b> &#8363;</b></small>
								
							</td>
							<td>{{$giohang["sanpham_soluong"]}}</td>
							<td class="cart_total">
								<p class="cart_total_price">
									<?php 
										$subtotal = $giohang["sanpham_gia"] * $giohang["sanpham_soluong"];
										$tongtien += $subtotal;
										
									?>
									{{number_format($subtotal,'0',',','.')}}<small> <b> &#8363;</b></small>
								</p>
							</td>
						</tr>
						@endforeach
						<tr style="font-size: 16px;">
							<td></td>
							<td></td>
							<td colspan="2" >Tổng giỏ hàng</td>
							<td style="color:rgb(20, 53, 195);">{{number_format($tongtien,'0',',','.')}}<small><b> &#8363;</b></small></td>
						</tr>
						<tr style="font-size: 16px;">
							<td></td>
							<td></td>
							<td colspan="2">Phí vận chuyển</td>
							<td style="color:rgb(20, 53, 195);">{{number_format($shipping_data->phi,'0',',','.')}}<small><b> &#8363;</b></small></td>
						</tr>
						@php
							$tongdh = $tongtien + $shipping_data->phi;
						@endphp
						<tr style="font-size: 17px;">
							<td></td>
							<td></td>
							<td colspan="2"><b>Tổng đơn hàng</b></td>
							<td style="color:rgb(20, 53, 195);"><b>{{number_format($tongdh,'0',',','.')}}<small> &#8363;</small></b></td>
						</tr>

					</tbody>	
				</table>
			</div>
			</div>
			
		@endif
		</div>
	</section> <!--/#cart_items-->

	



@endsection