@extends('admin_layout')<!--mo rong call file layout -->
@section('admin_content')<!--tao section home -->
        <div class="row">
            <div class="col-lg-10" style="margin-left: 8%;">
                    <section class="panel">
                        <header class="panel-heading">
                            Thêm slider
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
                                <form role="form" action="{{URL::to('luu-slider')}}" method="post" enctype="multipart/form-data">
                                    {{--them hinh anh phai co entype="multipart/form-data thi moi gui anh qua duoc"--}}
                                    {{ csrf_field() }} {{--tao token bao mat--}}

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên</label>
                                    <input type="text" name="ten_slider"class="form-control" id="exampleInputEmail1" placeholder="tên" required="">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Hình ảnh</label>
                                    <input type="file" name="hinhanh_slider"class="form-control" id="exampleInputEmail1" required="">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Mô tả sản phẩm</label>
                                    <textarea name="mota_slider" class="form-control" id="ckeditorsp" placeholder="mô tả" required=""></textarea> 
                                </div>
                               

                                <div class="form-group">
                                    <label for="exampleInputPassword1">Hiển thị</label>
                                       <select name="trangthai_slider" class="form-control input-sm m-bot15">
                                            <option value="0">Ẩn</option>
                                            <option value="1">Hiển thị</option>
                                        </select>
                                </div>
                                <button type="submit" name="luu_slider"class="btn btn-info">Thêm sản phẩm</button>
                                 <button type="reset" class="btn btn-info">Xóa</button>
                            </form>
                            </div>

                        </div>
                    </section>
            </div>
</div>
@endsection