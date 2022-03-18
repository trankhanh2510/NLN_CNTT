@extends('layout')
@section('content')
<section id="cart_items">
		<div class="container" style="width: 100%;">
			<div class="breadcrumbs">
				<ol class="breadcrumb">
				  <li><a href="{{URL::to('/')}}">Trang chủ</a></li>
				  <li class="active">Sửa thông tin khách hàng </li>
				</ol>
			</div><!--/breadcrums-->
			
			<div class="shopper-informations">
				<div class="row">
					<div class="col-sm-12 clearfix">
						<div class="bill-to">
							<p>Thông tin khách hàng</p>
							<?php
								$message = Session::get('errorcntkmessage');
								if($message){
									echo '<span class="error_login">' .$message. '</span>';
									Session::put('errorcntkmessage',null);
								}
							?>
							<div class="form-one">
									<form action="{{URL::to('capnhat-profile')}}" method="post">
										{{ csrf_field() }}
											<input type="hidden" name="kh_id" value="{{$kh_data->kh_id}}">
											<input type="text" name="kh_ten" value="{{$kh_data->kh_Ten}}" required="">
											<input type="text" name="kh_email" value="{{$kh_data->kh_email}}" required="">
											<input type="text" name="kh_sdt" value="{{$kh_data->kh_sdt}}" required="">
											<input type="password" name="kh_password" placeholder="mật khẩu" required />
											<input type="submit" value="Cập nhật" name="capnhat-profile" class="btn btn-primary btn-sm">
									</form>
							</div>
							
						</div>
					</div>
									
				</div>
			</div>

		</div>
	</section> <!--/#cart_items-->

@endsection