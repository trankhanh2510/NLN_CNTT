
@extends('admin_layout')<!--mo rong call file layout -->
@section('admin_content')<!--tao section home -->

<div class="table-agile-info" >
  <div class="panel panel-default">
    <div class="panel-heading" style="background-color: #f2b10c ! important;">
      Danh sách thương hiệu Sản Phẩm
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
            <th>Tên thương hiệu sản phầm</th>
            <th >Mô tả</th>
            <th>Hiển thị</th>
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
          @foreach($danhsach_th_sp as $key => $cate_pro) <!-- tao vong lap voi $cate_pro la valuse -->  
          <tr>
            
            <td>{{$cate_pro->th_Ten}}</td>
            <td style="width:30%;"><span class="text-ellipsis">
              <?php
                echo $cate_pro->th_MoTa;
              ?>
            </span></td>
            <td><span class="text-ellipsis"> 
              <?php 
                if($cate_pro->th_TrangThai==1){
                ?>
                  <a href="{{URL::to('/an-th-sp/'.$cate_pro->th_id)}}"><span class="fa-thumd-styling fa fa-check-circle-o"></span></a>
                <?php
                }else{
                ?>
                  <a href="{{URL::to('/hienthi-th-sp/'.$cate_pro->th_id)}}"><span class="fa-thumd-styling-down fa fa-times-circle-o"></span></a>
               <?php
                }
                ?>
            </span></td>
            <td>
              <a href="{{URL::to('/sua-th-sp/'.$cate_pro->th_id)}}" class="active styling_edit" ui-toggle-class="">
               <box-icon name='edit-alt' color='#2086ee' ></box-icon>
              </a>
              <a onclick="return confirm('Bạn có chắc muốn xóa thương hiệu {{$cate_pro->th_Ten}} này không?\nToàn bộ sản phẩm và đơn hàng thuộc thương hiệu {{$cate_pro->th_Ten}} sẽ bị xóa')" href="{{URL::to('xoa-th-sp/'.$cate_pro->th_id)}}" class="active styling_edit" ui-toggle-class="">
                <box-icon name='trash' rotate='90' animation='tada' color='#ee2020' ></box-icon>
              </a>
            </td>
          </tr>
         @endforeach
        </tbody>
      </table>
    {{-- </div> --}}
     {{-- phân trang --}}
      {{-- <span>{!!$danhsach_th_sp->render()!!}</span> --}}
    {{-- </div>    --}}
  </div>
@endsection