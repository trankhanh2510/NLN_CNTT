  
@extends('admin_layout')<!--mo rong call file layout -->
@section('admin_content')<!--tao section home -->

<div class="table-agile-info" {{-- style="width: 60%; margin-right:auto;margin-left: auto;  "--}}>
  <div class="panel panel-default">
    <div class="panel-heading" style="background-color: #2424e3db ! important;">
      Danh sách loại Sản Phẩm
    </div>
    <?php
      $message = Session::get('message'); //get la lay data tu CategoryProduct truyen qua
      if($message){
         echo '<span class="error_login">' .$message. '</span>';
         Session::put('message',null); //gan message = null
       }
    ?>
    <div class="table-responsive">
      <table class="table table-striped b-t b-light" id="myTable">
        <thead>
          <tr>
            <th>Tên loại sản phầm</th>
            <th>Mô tả</th>
            <th>Hiển thị</th>
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
          @foreach($danhsach_loai_sp as $key => $cate_pro) <!-- tao vong lap voi $cate_pro la valuse -->  
          <tr>
            
            <td>{{$cate_pro->Ten}}</td>
            <td><span class="text-ellipsis">
              <?php
                echo $cate_pro->MoTa;
              ?>
              </span></td>
            <td><span class="text-ellipsis"> 
              <?php 
                if($cate_pro->TrangThai==1){
                ?>
                  <a href="{{URL::to('/an-loai-sp/'.$cate_pro->l_id)}}"><span class="fa-thumd-styling fa fa-check-circle-o"></span></a>
                <?php
                }else{
                ?>
                  <a href="{{URL::to('/hienthi-loai-sp/'.$cate_pro->l_id)}}"><span class="fa-thumd-styling-down fa fa-times-circle-o"></span></a>
               <?php
                }
                ?>
            </span></td>
            <td>
              <a href="{{URL::to('/sua-loai-sp/'.$cate_pro->l_id)}}" class="active styling_edit" ui-toggle-class="">
               <box-icon name='edit-alt' color='#2086ee' ></box-icon>
              </a>
              <a onclick="return confirm('Bạn có chắc muốn xóa {{$cate_pro->Ten}}?\nToàn bộ sản phẩm và đơn hàng thuộc loại {{$cate_pro->Ten}} sẽ bị xóa')" href="{{URL::to('xoa-loai-sp/'.$cate_pro->l_id)}}" class="active styling_edit" ui-toggle-class="">
                <box-icon name='trash' rotate='90' animation='tada' color='#ee2020' ></box-icon>        
              </a>
            </td>
          </tr>
         @endforeach
        </tbody>
      </table>
    {{-- </div> --}}
    {{-- phân trang --}}
    {{-- <span>{!!$danhsach_loai_sp->render()!!}</span> --}}
  {{-- </div> --}}
</div>  
@endsection