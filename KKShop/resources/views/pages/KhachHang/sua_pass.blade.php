@extends('layout')
@section('content')
<section id="cart_items">
	<div class="container" style="width: 100%;">
		<div class="breadcrumbs">
			<ol class="breadcrumb">
			  <li><a href="{{URL::to('/')}}">Trang chủ</a></li>
			  <li class="active">Đổi mật khẩu khách hàng {{Session::get('kh_ten')}}</li>
			</ol>
		</div><!--/breadcrums-->
	
			<div class="shopper-informations" style="width: 40%;">
				<div class="row">
					<div class="col-sm-12 clearfix">
						<div class="bill-to">
							<p>Thông tin khách hàng</p>
							<?php
								$message = Session::get('message');
								if($message){
									echo '<span class="error_login">' .$message. '</span>';
									Session::put('message',null);
								}
							?>
							<div class="form-one">
									<form action="{{URL::to('capnhat-pass')}}" method="post">
										{{ csrf_field() }}
											<input type="hidden" name="kh_id" value="{{Session::get('kh_id')}}">
											<input type="password" name="kh_passold" placeholder="mật khẩu cũ" required >
											<input type="password" name="kh_passnew" placeholder="mật khẩu mới"required title="Mật khẩu phải hơn 6 ký tự">
											<input type="password" name="kh_passnewtest" placeholder="Nhập lại mật khẩu mới" pattern=".{6,}" required title="Mật khẩu phải hơn 6 ký tự">
											<input type="submit" value="Cập nhật" name="capnhat-pass" class="btn btn-primary btn-sm">
									</form>
							</div>
							
						</div>
					</div>
									
				</div>
			</div>

		</div>
	</section> <!--/#cart_items-->

@endsection