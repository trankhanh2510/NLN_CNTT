@extends('layout')
@section('content')
<section id="cart_items">
		<div class="container" style="width: 100%;">
			<div class="breadcrumbs">
				<ol class="breadcrumb">
				  <li><a href="{{URL::to('/')}}">Trang chủ</a></li>
				  <li class="active">Thông tin khách hàng</li>
				</ol>
			</div><!--/breadcrums-->

			<div class="shopper-informations" style="width: 60%;">
				<div class="row">
					<div class="col-sm-12 clearfix">
						<div class="bill-to">
							<p style="font-size: 30px;"><b>Thông tin Khách hàng</b></p>
							<?php
								$message = Session::get('cntkmessage');
								if($message){
									echo '<span class="error_login">' .$message. '</span>';
									Session::put('cntkmessage',null);
								}
							?>
							<div class="form-one" style="width: 100%;">

									<form action="{{URL::to('dat-hang')}}" method="post">
										{{ csrf_field() }}
											<p><b>ID: </b>{{$profile->kh_id}}</p>
											<p><b>Tên: </b> {{$profile->kh_Ten}}</p>
											<p><b>Email:</b> {{$profile->kh_email}}</p>
											<p><b>SĐT: </b>{{$profile->kh_sdt}}</p>
										
										
										<a style="margin-left: 0;" class="btn btn-default check_out" href="{{URL::to('sua-profile')}}">Đổi thông tin</a>
										
									</form>
						
							</div>
							
						</div>
					</div>
									
				</div>
			</div>
		</div>
	</section> <!--/#cart_items-->

	



@endsection