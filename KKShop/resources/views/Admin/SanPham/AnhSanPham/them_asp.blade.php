@extends('admin_layout')<!--mo rong call file layout -->
@section('admin_content')<!--tao section home -->
        <div class="row">
            <div class="col-lg-12" >
                    <section class="panel">
                        <header class="panel-heading">
                            Thêm ảnh sản phẩm {{$sp_Ten->sp_Ten}}
                        </header>
                        <div class="panel-body">
                            <?php
                                 $message = Session::get('message'); //get la lay data tu CategoryProduct truyen qua
                                if($message){
                                     echo '<span class="error_login">' .$message. '</span>';
                                     Session::put('message',null); //gan message = null
                                   }
                            ?>
                            <input type="hidden" name="id_sp" class="id_sp" value="{{$id_sp}}">
                            <form action="{{url('luu-anhsp/'.$id_sp)}}" method="POST" enctype="multipart/form-data">
                            @csrf
                                <div class="row">
                                    <div class="col-md-3" align="right">
                                        
                                    </div>  
                                    <div class="col-md-6">
                                        <input type="file" id="file" class="form-control" name="file[]" accept="image/*" multiple required="">
                                        <span id="error_anh"></span>
                                    </div> 
                                     <div class="col-md-3">
                                        <input type="submit" name="upload" name="taianh" value="Tải ảnh" class="btn btn-success">
                                    </div> 
                                </div>  
                            </form>
                            <form>
                                @csrf
                                <div id="load_anh">
                                    
                                      
                                </div>
                            </form>
                        </div>
                    </section>
            </div>
</div>
@endsection