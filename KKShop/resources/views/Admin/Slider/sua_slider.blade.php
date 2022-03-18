@extends('admin_layout')<!--mo rong call file layout -->
@section('admin_content')<!--tao section home -->
        <div class="row">
            <div class="col-lg-10" style="margin-left: 8%;">
                    <section class="panel">
                        <header class="panel-heading">
                            Sửa slider
                        </header>
                        <div class="panel-body">
                            
                            <div class="position-center">
                                <form role="form" action="{{URL::to('capnhat-slider/'.$sua_slider->slider_id)}}" method="post" enctype="multipart/form-data">
                                    {{--them hinh anh phai co entype="multipart/form-data thi moi gui anh qua duoc"--}}
                                    {{ csrf_field() }} {{--tao token bao mat--}}

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên</label>
                                    <input type="text" name="ten_slider"class="form-control" id="exampleInputEmail1" value="{{$sua_slider->slider_ten}}" required="">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Hình ảnh</label>
                                    <input type="file" name="hinhanh_slider"class="form-control" id="exampleInputEmail1">
                                    <img src="{{URL::to('public/uploads/slider/'.$sua_slider->slider_hinhanh)}}" alt="{{$sua_slider->slider_hinhanh}}" height="100" width="200">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Mô tả</label>
                                    <textarea name="mota_slider" class="form-control" id="ckeditorssp" required="">{{$sua_slider->slider_mota}}</textarea> 
                                </div>
                                
                                <button type="submit" name="capnhat_slider"class="btn btn-info">Cập nhật</button>
                            </form>
                            </div>
                           
                        </div>
                    </section>
            </div>
</div>
@endsection