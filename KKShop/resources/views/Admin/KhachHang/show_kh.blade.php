
@extends('admin_layout')<!--mo rong call file layout -->
@section('admin_content')<!--tao section home -->

<div class="table-agile-info" >
  <div class="panel panel-default">
    <div class="panel-heading">
      Danh sách khách hàng
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
            <th>ID</th>
            <th>Tên</th>
            <th>Email</th>
            <th>SĐT</th>
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
          @foreach($data_kh as $key => $kh) <!-- tao vong lap voi $cate_pro la valuse -->  
          <tr>
            
            <td><span class="text-ellipsis">{{$kh->kh_id}}</span></td>
            <td><a href="{{URL::to('chitiet-khachhang/'.$kh->kh_id)}}"><span class="text-ellipsis">{{$kh->kh_Ten}}</span></a></td>
            <td><span class="text-ellipsis">{{$kh->kh_email}}</span></td>
            <td><span class="text-ellipsis">{{$kh->kh_sdt}}</span></td>
            <td>
              <a onclick="return confirm('Tất cả đơn hàng và thông tin gừi hàng về khách hàng này sẽ bị xóa, bạn có chắc muốn xóa khách hàng này không?')" href="{{URL::to('xoa-khachhang/'.$kh->kh_id)}}" class="active styling_edit" ui-toggle-class="">
                <box-icon name='trash' rotate='90' animation='tada' color='#ee2020' ></box-icon>
              </a>
            </td>
          </tr>
         @endforeach
        </tbody>
      </table>
    </div>
   
  </div>
</div>
@endsection