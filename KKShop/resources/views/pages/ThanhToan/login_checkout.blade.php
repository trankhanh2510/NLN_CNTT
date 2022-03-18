@extends('layout')
@section('content')
	<section id="form"><!--form-->
		<div class="container" style="width: 100%;">
			<div class="breadcrumbs">
				<ol class="breadcrumb">
				  <li><a href="{{URL::to('/')}}">Trang chủ</a></li>
				  <li class="active">Đăng nhập hoặc đăng ký</li>
				</ol>
			</div><!--/breadcrums-->
			<div class="row">
				<div class="col-sm-5 col-sm-offset-1">
					<div class="login-form"><!--login form-->
						<h2><b>Đăng nhập tài khoản</b></h2>
						<?php
							$message = Session::get('errordnmessage');
							if($message){
								echo '<span class="error_login">' .$message. '</span>';
								Session::put('errordnmessage',null);
							}
						?>
						<form action="{{URL::to('login-customer')}}" method="post">
							{{ csrf_field() }} {{--tạo token bảo mật hơn khi đăng nhập  --}}
							<input type="email" name="email_kh" placeholder="Email" required />
							<input type="password" name="password_kh" placeholder="mật khẩu" required />

							<button type="submit" class="btn btn-default" style="margin-left: 30%;">Đăng nhập</button>

						</form>
					</div><!--/login form-->
				</div>
				<div class="col-sm-1">
					<h2 class="or">Hoặc</h2>
				</div>
				<div class="col-sm-6">
					<div class="signup-form"><!-- sign up form-->
						<h2><b>Tạo tài khoản mới!</b></h2>
						<?php
							$message = Session::get('errorttkmess');
							if($message){
								echo '<span class="error_login">' .$message. '</span>';
								Session::put('errorttkmess',null);
							}
						?>
						<form action="{{URL::to('them-khachhang')}}" method="POST">
							{{ csrf_field() }} 
							<input type="text" name="ten_kh" placeholder="Họ và Tên" required/>

							<input type="email" name="mail" placeholder="Email"required/>

							<input type="text" name="sdt_kh" placeholder="SĐT" pattern="[0]{1}[0-9]{9}" required title="SĐT gồm 10 chữ số đầu số là 0"/>

							<input type="password" name="password_kh" placeholder="Mật khẩu" pattern=".{6,}" required title="Mật khẩu phải hơn 6 ký tự"/>
							<input type="password" name="password_khtest" placeholder="Xác nhận mật khẩu" pattern=".{6,}" required title="Mật khẩu phải hơn 6 ký tự"/>
							<button type="submit" class="btn btn-default" style="margin-left: 33%;">Tạo tài khoản</button>
						</form>
					</div><!--/sign up form-->
				</div>
			</div>
		</div>
	</section><!--/form-->
	


@endsection