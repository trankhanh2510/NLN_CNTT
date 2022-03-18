@extends('admin_layout')<!--mo rong call file layout -->
@section('admin_content')<!--tao section home -->

        <div class="row">
            <div class="col-lg-8" style="margin-left: 17%;">
                    <section class="panel">
                        <header class="panel-heading">
                            Đổi mật khẩu ADMIN {{session::get('admin_name')}}
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
                                <form role="form" action="{{URL::to('capnhat-password-admin')}}" method="post">
                                    {{ csrf_field() }} 
                                    {{--tao token bao mat--}}
                                <div class="form-group"><br>
                                    <label for="exampleInputPassword1">Mật khẩu cũ</label><br>
                                    <input style="width: 60%;" type="password" name="admin_passwordold" placeholder="Mật khẩu cũ" require />
                                </div>
                                <div class="form-group"><br>
                                    <label for="exampleInputPassword1">Mật khẩu mới</label><br>
                                    <input style="width: 60%;" type="password" name="admin_passwordnew" placeholder="Mật khẩu mới" required title="Mật khẩu phải hơn 6 ký tự"/>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Xác nhận lại mật khẩu</label><br>
                                    <input style="width: 60%;" type="password" name="test_admin_passwordnew" placeholder="Xác nhận lại mật khẩu" required title="Mật khẩu phải hơn 6 ký tự"/>
                                </div>
                                <button type="submit" name="capnhat-password-admin"class="btn btn-info">Cập nhật</button>
                            </form>
                            </div>
                        {{-- @endforeach --}}
                        </div>
                    </section>
            </div>
</div>


@endsection