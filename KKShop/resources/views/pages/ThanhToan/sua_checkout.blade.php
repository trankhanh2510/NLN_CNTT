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

			<div class="shopper-informations">
				<div class="row">
					<div class="col-sm-12 clearfix">
						<div class="bill-to">
							<p>Thông tin gửi hàng</p>
							<div class="form-one">
									<form action="{{URL::to('capnhat-shipping')}}" method="post">
										{{ csrf_field() }}
											<input type="text" name="shipping_ten" value="{{$shipping_data->shipping_ten}}" required="" style="margin-bottom: 15px;width: 240px;">
											<input type="text" name="shipping_sdt" value="{{$shipping_data->shipping_sdt}}" pattern="[0]{1}[0-9]{9}" required title="SĐT gồm 10 chữ số đầu số là 0" style="width: 150px;">
											<p>Địa chỉ cũ: {{$shipping_data->shipping_diachi}}</p>
											<div class="form-group">
		                                       <select name="city" id="city" class="form-control input-sm m-bot15 choose city">
		                                            <option value="">--Chọn Tỉnh thành phố--</option>
		                                            @foreach($city as $key => $tp)
		                                                <option value="{{$tp->matp}}">{{$tp->tp_ten}}</option>
		                                            @endforeach
		                                        </select>
			                                </div>
			                                <div class="form-group">
			                                    {{-- <label for="exampleInputPassword1">Chọn quận huyện</label> --}}
			                                       <select name="province" id="province" class="form-control input-sm m-bot15 province choose">
			                                           <option value="">--Chọn quận huyện--</option>
			                                        </select>
			                                </div>
			                                <div class="form-group">
			                                       <select name="wards" id="wards" class="form-control input-sm m-bot15 wards choose">
			                                            <option value="">--Chọn xã phường thị trấn--</option>
			                                            
			                                        </select>
			                                </div>
											<input style="width: 300px;margin-bottom: 15px;" type="text" name="shipping_diachi" placeholder="địa chỉ" >
											
											<textarea name="shipping_note" rows="5">{{$shipping_data->shipping_note}}</textarea>
											<input style="font-size: 20px;height: 40px;width: 150px;line-height: 0.5;" type="submit" value="Cập nhật" name="sua-checkout" class="btn btn-primary btn-sm">
									</form>
							</div>
							
						</div>
					</div>
									
				</div>
			</div>

		</div>
	</section> <!--/#cart_items-->

@endsection