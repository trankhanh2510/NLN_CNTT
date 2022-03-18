@extends('admin_layout')<!--mo rong call file layout -->
@section('admin_content')<!--tao section home -->

        <div class="row">
            <div class="col-lg-8" style="margin-left: 17%;">
                    <section class="panel">
                        <header class="panel-heading">
                            Cập nhật thông tin ADMIN {{session::get('admin_name')}}
                        </header>
                        <?php
                          $message = Session::get('message');
                          if($message){
                            echo '<span class="error_login">' .$message. '</span>';
                            Session::put('message',null);
                          }
                        ?>
                        <div class="panel-body">
                            {{-- @foreach($sua_th_sp as $key => $sua_th_sp) --}}
                            {{-- dùng models thì không cần foreach vì lấy 1 thương hiệu --}}

                            <div class="position-center">
                                <form role="form" action="{{URL::to('capnhat-profile-admin')}}" method="post">
                                    {{ csrf_field() }} 
                                    {{--tao token bao mat--}}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Họ và Tên</label>
                                    <input style="width: 60%;" type="text" value="{{$profile->admin_name}}" name="admin_name"class="form-control" id="exampleInputEmail1" required="">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Email</label>
                                     <input style="width: 60%;" type="email" value="{{$profile->admin_email}}" name="admin_email"class="form-control" id="exampleInputEmail1" required="">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">SĐT</label>
                                     <input style="width: 60%;" type="text" value="{{$profile->admin_phone}}" name="admin_phone"class="form-control" id="exampleInputEmail1" pattern="[0]{1}[0-9]{9}" required title="SĐT gồm 10 chữ số đầu số là 0">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Mật khẩu</label><br>
                                    <input style="width: 60%;" type="password" name="admin_password" placeholder="Mật khẩu" required />
                                </div>

                                <button type="submit" name="sua_profile_admin"class="btn btn-info">Cập nhật</button>
                            </form>
                            </div>
                        {{-- @endforeach --}}
                        </div>
                    </section>
            </div>
</div>


@endsection