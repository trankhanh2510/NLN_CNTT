@extends('admin_layout')<!--mo rong call file layout -->
@section('admin_content')<!--tao section home -->
        <div class="row">
            <div class="col-lg-8" style="margin-left: 17%;">
                    <section class="panel">
                        <header class="panel-heading">
                            Thêm thương hiệu sản phẩm
                        </header>
                        <div class="panel-body">
                            <?php
                                 $message = Session::get('message'); //get la lay data tu CategoryProduct truyen qua
                                if($message){
                                     echo '<span class="error_login">' .$message. '</span>';
                                     Session::put('message',null); //gan message = null
                                   }
                            ?>
                            <div class="position-center">
                                <form role="form" action="{{URL::to('luu-th-sp')}}" method="post">
                                    {{ csrf_field() }} {{--tao token bao mat--}}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên thương hiệu sản phẩm</label>
                                    <input type="text" name="ten_th_sp"class="form-control" id="exampleInputEmail1" placeholder="tên thương hiệu sản phẩm" required="">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Mô tả</label>
                                    <textarea name="mota_th_sp" class="form-control" id="ckeditorth" placeholder="mô tả" required=""></textarea> 
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Hiển thị</label>
                                       <select name="trangthai_th_sp" class="form-control input-sm m-bot15">
                                            <option value="0">Ẩn</option>
                                            <option value="1">Hiển thị</option>
                                        </select>
                                </div>
                                <button type="submit" name="luu_th_sp"class="btn btn-info">Thêm thương hiệu sản phẩm</button>
                                 <button type="reset" class="btn btn-info">Xóa</button>
                            </form>
                            </div>

                        </div>
                    </section>
            </div>
</div>
@endsection