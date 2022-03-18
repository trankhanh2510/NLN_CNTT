@extends('admin_layout')<!--mo rong call file layout -->
@section('admin_content')<!--tao section home -->
        <div class="row">
            <div class="col-lg-8" style="margin-left: 17%;">
                    <section class="panel">
                        <header class="panel-heading">
                            Sửa loại sản phẩm
                        </header>
                        <div class="panel-body">

                            <div class="position-center">
                                <form role="form" action="{{URL::to('capnhat-loai-sp/'.$sua_loai_sp->l_id)}}" method="post">
                                    {{ csrf_field() }} {{--tao token bao mat--}}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên loại sản phẩm</label>
                                    <input type="text" value="{{$sua_loai_sp->Ten}}" name="ten_loai_sp"class="form-control" id="exampleInputEmail1" required="" >
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Mô tả</label>
                                    <textarea name="mota_loai_sp" class="form-control" id="ckeditorsl" required="">{{$sua_loai_sp->MoTa}}</textarea> 
                                </div>
                                <button type="submit" name="sua_loai_sp"class="btn btn-info">Cập nhật loại sản phẩm</button>
                            </form>
                            </div>
                       
                        </div>
                    </section>
            </div>
</div>
@endsection