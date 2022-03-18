@extends('admin_layout')<!--mo rong call file layout -->
@section('admin_content')<!--tao section home -->
        <div class="row">
            <div class="col-lg-12" >
                    <section class="panel">
                        <header class="panel-heading">
                            Thêm sản phẩm
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
                                <form role="form" action="{{URL::to('luu-sp')}}" method="post" enctype="multipart/form-data">
                                    {{--them hinh anh phai co entype="multipart/form-data thi moi gui anh qua duoc"--}}
                                    {{ csrf_field() }} {{--tao token bao mat--}}

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên sản phẩm</label>
                                    <input type="text" name="ten_sp"class="form-control" id="exampleInputEmail1" placeholder="tên sản phẩm" required="">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Hình ảnh sản phẩm</label>
                                    <input type="file" id="file" class="form-control" name="file[]" accept="image/*" multiple required="">
                                    <span id="error_anh"></span>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputPassword1">Mô tả sản phẩm</label>
                                    <textarea name="mota_sp" class="form-control ckeditor" placeholder="mô tả" required=""></textarea> 
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Nội dung sản phẩm</label>
                                    <textarea name="noidung_sp" class="form-control ckeditor" placeholder="nội dung" required=""></textarea> 
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Giá sản phẩm</label>
                                    <input type="number" name="gia_sp"class="form-control" id="exampleInputEmail1" required="" min="1000">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Loại sản phẩm</label>
                                       <select name="loai_sp" class="form-control input-sm m-bot15">
                                        @foreach($loai_sp as $key => $loai )
                                            <option value="{{$loai->l_id}}">{{$loai->Ten}}</option>
                                        @endforeach
                                        </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Thương hiệu sản phẩm</label>
                                       <select name="thuonghieu_sp" class="form-control input-sm m-bot15">
                                        @foreach($thuonghieu_sp as $key => $thuonghieu)
                                            <option value="{{$thuonghieu->th_id}}">{{$thuonghieu->th_Ten}}</option>
                                        @endforeach
                                        </select>
                                </div>
                                 <div class="form-group">
                                    <label for="exampleInputEmail1">Số lượng sản phẩm</label>
                                    <input type="number" min="1" name="soluong_sp"class="form-control" id="exampleInputEmail1"  required="">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputPassword1">Hiển thị</label>
                                       <select name="trangthai_sp" class="form-control input-sm m-bot15">
                                            <option value="0">Ẩn</option>
                                            <option value="1">Hiển thị</option>
                                        </select>
                                </div>
                                <button type="submit" name="luu_sp"class="btn btn-info">Thêm sản phẩm</button>
                                 <button type="reset" class="btn btn-info">Xóa</button>
                            </form>
                            </div>

                        </div>
                    </section>
            </div>
</div>
@endsection