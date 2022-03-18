<!DOCTYPE html>
<head>
<title>Đăng Nhập Admin</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- bootstrap-css -->
<link rel="stylesheet" href="{{asset('public/backend/css/bootstrap.min.css')}}" >
<!-- //bootstrap-css -->
<!-- Custom CSS -->
<link href="{{asset('public/backend/css/style.css')}}" rel='stylesheet' type='text/css' />
<!-- font CSS -->
<link href='//fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
</head>
<body class="login_bg">
	<div class="log-w3">
		<div class="w3layouts-main">
			<h2>Đăng nhập</h2>
			<?php
				$message = Session::get('message');
				if($message){
					echo '<span class="error_login">' .$message. '</span>';
					Session::put('message',null);
				}
			?>
				<form action="{{URL::to('admin-dashboard')}}" method="post">
					{{ csrf_field() }} {{--tạo token bảo mật hơn khi đăng nhập  --}}
					<input type="email" class="ggg" name="admin_email" placeholder="Nhập E-MAIL" required="">
					<input type="password" class="ggg" name="admin_password" placeholder="Nhập PASSWORD" required="">
					<input type="submit" value="Đăng nhập" name="login">
				</form>
			
		</div>
	</div>
</body>
</html>
