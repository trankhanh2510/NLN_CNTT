
@extends('admin_layout')<!--mo rong call file layout -->
@section('admin_content')<!--tao section home -->

<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Danh sách Sản Phẩm
    </div>
    <?php
      $message = Session::get('message'); //get la lay data tu CategoryProduct truyen qua
      if($message){
           echo '<span class="error_login">' .$message. '</span>';
           Session::put('message',null); //gan message = null
         }
      $i = 1;
    ?>
    <div class="table-responsive">
      <table class="table table-striped b-t b-light" id="myTable">
        <thead>
          <tr style="background-color:#838383;">
            <th>STT</th>
            <th style="width: 30%;">Tên sản phầm</th>
            <th>Loại</th>
            <th>Thương hiệu</th>
            <th>Giá</th>
            <th style="width:10%;">Số lượng</th>
            <th>Thư viện ảnh</th>
            <th>Hiển thị</th>
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
          @foreach($danhsach_sp as $key => $sp) <!-- tao vong lap voi $sp la valuse -->  
          <tr>
            <td>{{$i}}</td>
            <?php $i++;?>
            <td>{{$sp->sp_Ten}}</td>
            <td><span class="text-ellipsis">{{$sp->Category->Ten}}</span></td>
            <td><span class="text-ellipsis">{{$sp->Brand->th_Ten}}</span></td>
            <td><span class="text-ellipsis">
              {{number_format($sp->sp_gia,'0',',','.')}}<small> &#8363; </small>
            </span></td>
            <td><span class="text-ellipsis">{{$sp->sp_soluong}}</span></td>
            <td><span class="text-ellipsis"> 
              <a href="{{URL::to('chitiet-asp/'.$sp->sp_id)}}"><box-icon name='image-add' animation='tada' color='#1f7eee' ></box-icon></a>   
            </span></td>
            <td><span class="text-ellipsis"> 
              <?php 
                if($sp->sp_TrangThai==1){
                ?>
                  <a href="{{URL::to('an-sp/'.$sp->sp_id)}}"><span class="fa-thumd-styling fa fa-check-circle-o"></span></a>
                <?php
                }else{
                ?>
                  <a href="{{URL::to('hienthi-sp/'.$sp->sp_id)}}"><span class="fa-thumd-styling-down fa fa-times-circle-o"></span></a>
               <?php
                }
                ?>
            </span></td>
            <td>
              <a href="{{URL::to('/sua-sp/'.$sp->sp_id)}}" class="active styling_edit" ui-toggle-class="">
                <box-icon name='edit-alt' color='#2086ee' ></box-icon>  
              </a>
              <a onclick="return confirm('Bạn có chắc muốn xóa {{$sp->sp_Ten}} ?\nToàn bộ đơn hàng thuộc sản phẩm này sẽ bị xóa')" href="{{URL::to('xoa-sp/'.$sp->sp_id)}}" class="active styling_edit" ui-toggle-class="">
                <box-icon name='trash' rotate='90' animation='tada' color='#ee2020' ></box-icon>
              </a>
            </td>
          </tr>
         @endforeach
        </tbody>
      </table>
    </div>
    {{-- phân trang --}}
    {{-- <span>{!!$danhsach_sp->render()!!}</span> --}}
  </div>
</div>
@endsection