@extends('layout') <!--mo rong call file layout -->
@section('content')
<section id="cart_items">
	<div class="container" style="width: 100%;">
		<div class="breadcrumbs">
			<ol class="breadcrumb">
			  <li><a href="{{URL::to('/')}}">Trang chủ</a></li>
			  <li class="active">Đơn hàng của {{Session::get('kh_ten')}}</li>
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

			@csrf 
			{{-- sửa lỗi 419 --}}
			@foreach($thongtindh as $k => $thongtindh)
				<?php
					$id_dh = $thongtindh->dh_id;
				?>
				<table class="table table-condensed">
				<thead>
					<tr class="cart_menu">
						<td class="image" style="width: 15%;">Hình ảnh</td>
						<td class="description" style="width:40%;">Tên</td>
						<td class="price">Giá</td>
						<td class="quantity">Số lượng</td>
						<td class="total">Đơn giá</td>
						<td></td>
					</tr>
				</thead>
				<tbody>
				<?php
					foreach ($thongtin as $key => $value) {
						if($id_dh==$value->dh_id){
				?>
				{{-- @foreach($content as $v_content) sài cho bumbummen99--}}	
					<tr>
						<td class="cart_product">
							<a><img src="{{URL::to('public/uploads/product/'.$value->asp_hinhanh)}}" alt="{{$value->asp_hinhanh}}"  width="100"></a>
						</td>
						<td class="cart_description">
							<p><b><a href="{{URL::to('chi-tiet-sp/'.$value->sp_id)}}">{{$value->sp_ten}}</a></b></p>
							<p>ID: {{$value->sp_id}}</p>

						</td>
						<td class="cart_price">
							{{number_format($value->sp_gia,'0',',','.')}}<small> <b>&#8363;</b></small>
						</td>
						<td class="cart_quantity" style="text-align:center; ">
							<p>{{$value->ctdh_soluong}}</p>
						</td>
						<td class="cart_total">
							<p class="cart_total_price">
								{{number_format($value->ctdh_dongia,'0',',','.')}}<small> <b>&#8363;</b></small>
							</p>
							
						</td>
						<td class="cart_delete">
							@if($value->dh_trangthai==1)
								<p><i class="fa fa-check-square" style="font-size: 23px;color: rgb(20, 53, 195);padding: 5px 7px;"></i></p>
							@else
								<a onclick="return confirm('Bạn có chắc muốn xóa đơn hàng này không?')" href="{{url('xoa-ctdh-kh/'.$value->ctdh_id)}}" class="cart_quantity_delete" ui-toggle-class=""><box-icon name='trash' animation='tada' color='blue' ></box-icon></a>
							@endif
						</td>
					</tr>
					
				</tbody>
				
					
			
		<?php
				}
			}
		?>
		@if($thongtindh->dh_trangthai == 0)
			<tr>
				<td colspan="4"></td>
				<td style="font-size: 20px;color: red;">
					xóa đơn hàng
				</td>
				<td class="cart_delete">
					<a onclick="return confirm('Bạn có chắc muốn xóa đơn hàng này không?')" href="{{url('xoa-dh-kh/'.$thongtindh->dh_id)}}" class="cart_quantity_delete" ui-toggle-class=""><box-icon name='trash' animation='tada' color='blue' ></box-icon></i></a>
				</td>
			</tr>
		@endif	
		<tr style="font-size:18px;background-color: #eeeeee;">
			<td colspan="2"><b>Ngày đặt hàng:</b> {{$thongtindh->created_at}}</td>
			<td colspan="2"><b>Tổng đơn hàng:</b></td>
			<td style="color:rgb(20, 53, 195);" colspan="2">
				
				{{number_format($thongtindh->dh_tongtien,'0',',','.')}}<small> <b>&#8363;</b></small>
			</td>
		</tr>
		<tr style="font-size:18px;background-color: #eeeeee;">
			<td colspan="2" style="background-color: #eeeeee;"><b>Thông tin giao hàng: </b></td>
			<td colspan="2"><b>Phí vận chuyển:</b></td>
			<td style="color:rgb(20, 53, 195);" colspan="2">
				
				{{number_format($thongtindh->dh_phi_vc,'0',',','.')}}<small> <b>&#8363;</b></small>
			</td>
		</tr>
		<tr style="background-color: #eeeeee;">
			<td colspan="2">Tên người nhận hàng: 
			{{$thongtindh->shipping_ten}}
			</td>
			<td colspan="2" style="font-size:18px;"><b>Tổng thanh toán:</b></td>
			<td style="color:rgb(20, 53, 195);font-size:18px;" colspan="2">
				
				{{number_format($thongtindh->dh_tongdh,'0',',','.')}}<small> <b>&#8363;</b></small>
			</td>
		</tr>
		<tr style="background-color: #eeeeee;">
			<td colspan="2"> Địa chỉ: 
			{{$thongtindh->shipping_diachi}}
			</td>
			<td colspan="4"></td>
		</tr>
		<tr style="background-color: #eeeeee;">
			<td colspan="2">SDT: 
			{{$thongtindh->shipping_sdt}}
			</td>
			<td colspan="4"></td>
		</tr>
		<tr style="background-color: #eeeeee;">
			<td colspan="2">Ghi Chú: 
			{{$thongtindh->shipping_note}}
			</td>
			<td colspan="4"></td>
		</tr>
		
		</table>
		<br><br>	
		@endforeach
		</div>
	</div>
</section> <!--/#cart_items-->

			


@endsection