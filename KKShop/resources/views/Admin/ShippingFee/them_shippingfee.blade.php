@extends('admin_layout')<!--mo rong call file layout -->
@section('admin_content')<!--tao section home -->
            <div class="col-lg-12" >
                    <section class="panel">
                        <header class="panel-heading">
                            Thêm phí vận chuyển
                        </header>
                        <div class="panel-body">
                           {{--  <?php
                                 $message = Session::get('error_shippingfee'); //get la lay data tu CategoryProduct truyen qua
                                if($message){
                                     echo '<span class="error_login">' .$message. '</span>';
                                     Session::put('error_shippingfee',null); //gan message = null
                                   }
                            ?> --}}
                            <div id="thongbao"></div>
                            <div class="position-center">
                                <form> 
                                    {{-- ajax --}}
                                    @csrf {{--tao token bao mat--}}
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Chọn thành phố</label>
                                       <select name="city" id="city" class="form-control input-sm m-bot15 choose city">
                                            <option value="">--Tỉnh Thành phố--</option>
                                            @foreach($city as $key => $tp)
                                                <option value="{{$tp->matp}}">{{$tp->tp_ten}}</option>
                                            @endforeach
                                        </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Chọn quận huyện</label>
                                       <select name="province" id="province" class="form-control input-sm m-bot15 province choose">
                                           <option value="">--Quận huyện--</option> 
                                        </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Chọn xã phường thị trấn</label>
                                       <select name="wards" id="wards" class="form-control input-sm m-bot15 wards choose">
                                            <option value="">--xã phường thị trấn--</option>
                                            
                                        </select>
                                </div>
                                 <div class="form-group">
                                    <label for="exampleInputEmail1">Phí</label>
                                    <input type="number" min="1000" name="fee"class="form-control fee" required="">
                                </div>
                                {{-- button không reload lại trang - submit ngược lại--}}
                                <button type="button" name="them_shippingfee" class="btn btn-info them_shippingfee">Thêm phí vận chuyển</button>
                                 <button type="reset" class="btn btn-info">Xóa</button>
                            </form>
                            </div>
                        <div id ="load_shippingfee">
                            
                        </div>

                        </div>
                    </section>
            </div>
@endsection