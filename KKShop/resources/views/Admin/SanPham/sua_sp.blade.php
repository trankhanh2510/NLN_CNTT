@extends('admin_layout')<!--mo rong call file layout -->
@section('admin_content')<!--tao section home -->
        <div class="row">
            <div class="col-lg-12" >
                    <section class="panel">
                        <header class="panel-heading">
                            Sửa sản phẩm
                        </header>
                        <div class="panel-body">
                            
                            <div class="position-center">
                                <form role="form" action="{{URL::to('capnhat-sp/'.$sua_sp->sp_id)}}" method="post" enctype="multipart/form-data">
                                    {{--them hinh anh phai co entype="multipart/form-data thi moi gui anh qua duoc"--}}
                                    {{ csrf_field() }} {{--tao token bao mat--}}

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên sản phẩm</label>
                                    <input type="text" name="ten_sp"class="form-control" id="exampleInputEmail1" value="{{$sua_sp->sp_Ten}}" required="">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Mô tả sản phẩm</label>
                                    <textarea name="mota_sp" class="form-control ckeditor" required="">{{$sua_sp->sp_MoTa}}</textarea> 
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Nội dung sản phẩm</label>
                                    <textarea name="noidung_sp" class="form-control ckeditor" required="">{{$sua_sp->sp_noidung}}</textarea> 
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Giá sản phẩm</label>
                                    <input type="number" min="1000" name="gia_sp" class="form-control" id="exampleInputEmail1" value="{{$sua_sp->sp_gia}}" required="">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Loại sản phẩm</label>
                                       <select name="loai_sp" class="form-control input-sm m-bot15">
                                            <option value="{{$sua_sp->l_id}}">{{$sua_sp->Category->Ten}}</option>
                                        @foreach($loai_sp as $key => $loai )
                                            <option value="{{$loai->l_id}}">{{$loai->Ten}}</option>
                                        @endforeach
                                        </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Thương hiệu sản phẩm</label>
                                       <select name="thuonghieu_sp" class="form-control input-sm m-bot15">
                                            <option value="{{$sua_sp->th_id}}">{{$sua_sp->Brand->th_Ten}}</option>
                                        @foreach($thuonghieu_sp as $key => $thuonghieu)
                                            <option value="{{$thuonghieu->th_id}}">{{$thuonghieu->th_Ten}}</option>
                                        @endforeach
                                        </select>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Số lượng sản phẩm</label>
                                    <input type="number" min="1" name="soluong_sp"class="form-control" id="exampleInputEmail1" value="{{$sua_sp->sp_soluong}}" required="">
                                </div>
                                <button type="submit" name="capnhat_sp"class="btn btn-info">Cập nhật sản phẩm</button>
                            </form>
                            </div>
                        </div>
                    </section>
            </div>
</div>
@endsection