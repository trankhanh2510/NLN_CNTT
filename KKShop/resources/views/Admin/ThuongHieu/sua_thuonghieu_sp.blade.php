@extends('admin_layout')<!--mo rong call file layout -->
@section('admin_content')<!--tao section home -->
        <div class="row">
            <div class="col-lg-8" style="margin-left: 17%;">
                    <section class="panel">
                        <header class="panel-heading">
                            Sửa thương hiệu sản phẩm
                        </header>
                        <div class="panel-body">
                            {{-- @foreach($sua_th_sp as $key => $sua_th_sp) --}}
                            {{-- dùng models thì không cần foreach vì lấy 1 thương hiệu --}}

                            <div class="position-center">
                                <form role="form" action="{{URL::to('capnhat-th-sp/'.$sua_th_sp->th_id)}}" method="post">
                                    {{ csrf_field() }} 
                                    {{--tao token bao mat--}}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên thương hiệu sản phẩm</label>
                                    <input type="text" value="{{$sua_th_sp->th_Ten}}" name="ten_th_sp"class="form-control" id="exampleInputEmail1" placeholder="tên thương hiệu sản phẩm" required="">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Mô tả</label>
                                    <textarea name="mota_th_sp" class="form-control" id="ckeditorsth" placeholder="mô tả" required="">{{$sua_th_sp->th_MoTa}}</textarea> 
                                </div>
                                <button type="submit" name="sua_th_sp"class="btn btn-info">Cập nhật thương hiệu sản phẩm</button>
                            </form>
                            </div>
                        {{-- @endforeach --}}
                        </div>
                    </section>
            </div>
</div>
@endsection