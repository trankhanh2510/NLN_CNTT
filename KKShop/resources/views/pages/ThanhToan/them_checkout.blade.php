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


			<div class="register-req">
				<p style="color:red;"><b>Hãy điền thông tin gửi hàng</b></p>
			</div><!--/register-req-->

			<div class="shopper-informations">
				<div class="row">
					<div class="col-sm-12 clearfix">
						<div class="bill-to">
							<p><b>Thông tin gửi hàng</b></p>
							<form action="{{URL::to('save-shipping')}}" method="post">

									{{ csrf_field() }}
									<input type="text" class="shipping_ten" placeholder="Họ và tên" required="" style="margin-bottom: 15px;width: 240px;">
									<input type="text" class="shipping_sdt" placeholder="SĐT" pattern="[0]{1}[0-9]{9}" required title="SĐT gồm 10 chữ số đầu số là 0" style="width: 150px;">
									<div class="form-group">
                                       <select name="city" id="city" class="form-control input-sm m-bot15 choose city">
                                            <option value="">--Tỉnh Thành phố--</option>
                                            @foreach($city as $key => $tp)
                                                <option value="{{$tp->matp}}">{{$tp->tp_ten}}</option>
                                            @endforeach
                                        </select>
	                                </div>
	                                <div class="form-group">
	                 
	                                       <select name="province" id="province" class="form-control input-sm m-bot15 province choose">
	                                           <option value="">--Quận huyện--</option> 
	                                        </select>
	                                </div>
	                                <div class="form-group">
	                                       <select name="wards" id="wards" class="form-control input-sm m-bot15 wards choose">
	                                            <option value="">--xã phường thị trấn--</option>
	                                            
	                                        </select>
	                                </div>
									<input type="text" class="shipping_diachi" placeholder="Địa chỉ" required="" style="width: 300px;margin-bottom: 15px;">
									<textarea style="margin-bottom: 15px;" class="shipping_note"  placeholder="Ghi chú đơn hàng của bạn" rows="5" required=""></textarea>
									<button type="button" name="save-shipping" class="btn btn-info save_shipping">Lưu</button>
                                 	<button type="reset" class="btn btn-info">Xóa</button>
									
							</form>
							
						</div>
					</div>
									
				</div>
			</div>

		</div>
	</section> <!--/#cart_items-->

	



@endsection