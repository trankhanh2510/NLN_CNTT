@extends('admin_layout')<!--mo rong call file layout -->
@section('admin_content')<!--tao section home -->

  <div class="table-agile-info">
    <div class="panel panel-default">
      <div class="panel-heading">
        Thông tin khách hàng
      </div>
     
      <div class="table-responsive">
        <table class="table table-striped b-t b-light">
          <thead>
            <tr>
              
              <th>ID</th>
              <th>Tên</th>
              <th>Email</th>
              <th>SĐT</th>
            </tr>
          </thead>
          <tbody>
             <tr>
                <td>{{$ttkh->kh_id}}</td>
                <td>{{$ttkh->kh_Ten}}</td>
                <td>{{$ttkh->kh_email}}</td>
                <td>{{$ttkh->kh_sdt}}</td>
              </tr>

          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div class="table-agile-info" >
    <div class="panel panel-default">
      <div class="panel-heading">
        Danh sách thông tin gửi hàng
      </div>
      <?php
        $message = Session::get('mess');
        if($message){
          echo '<span class="error_login">' .$message. '</span>';
          Session::put('mess',null);
        }
      ?>
      <div class="table-responsive">
        <table class="table table-striped b-t b-light" >
          <thead>
            <tr>
              <th>ID</th>
              <th>Tên người nhận</th>
              <th>Địa chỉ</th>
              <th>SĐT</th>
              <th>Ghi chú</th>
              <th>Phí vận chuyển</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            @if(Session::get('message'))
              <tr><td colspan="6" style="color:red;text-align: center; " >
                <?php
                  $message = Session::get('message');
                  if($message){
                    echo '<span class="error_login">' .$message. '</span>';
                    Session::put('message',null);
                  }
                ?>
              </td></tr>
            @else
              @foreach($ttch as $key => $sh) <!-- tao vong lap voi $cate_pro la valuse -->
                <tr>
                  
                  <td><span class="text-ellipsis">{{$sh->shipping_id}} </span></td>
                  <td><span class="text-ellipsis">{{$sh->shipping_ten}} </span></td>
                  <td><span class="text-ellipsis">{{$sh->shipping_diachi}} </span></td>
                  <td><span class="text-ellipsis">{{$sh->shipping_sdt}} </span></td>
                  <td><span class="text-ellipsis">{{$sh->shipping_note}} </span></td>
                  <td><span class="text-ellipsis">{{$sh->phi}} </span></td>
                  @if($sh->shipping_trangthai == 0)
                    <td>
                      <a onclick="return confirm('Bạn có chắc muốn xóa không?')" href="{{URL::to('xoa-shipping/'.$sh->shipping_id)}}" class="active styling_edit" ui-toggle-class="">
                        <i class="fa fa-times text-danger text"></i>
                      </a>
                    </td>
                  @endif
                </tr>
              @endforeach
            @endif
          </tbody>
        </table>
      </div>
     
    </div>
  </div>
  <div class="table-agile-info" >
  <div class="panel panel-default">
    <div class="panel-heading" style="background-color: #008000a8 ! important;" >
      Danh sách đơn hàng
    </div>
   
    <div class="table-responsive">
      <table class="table table-striped b-t b-light" id="myTable">
        <thead>
          <tr> 
            <th>ID</th>
            <th>Tổng đơn hàng</th>
            <th>Phí vận chuyển</th>
            <th>Tổng thanh toán</th> 
            <th>Ngày giờ đặt hàng</th>
            <th>Quản lý</th>
            <th style="width: 5%;">Xem</th>
          </tr>
        </thead>
        <tbody>
          @foreach($ttdh as $key => $donhang) <!-- tao vong lap voi $donhang la valuse -->  
            <tr>
              <td>{{$donhang->dh_id}}</td>
              <td><span class="text-ellipsis">
                {{number_format($donhang->dh_tongtien,'0',',','.')}}<small> &#8363; </small>
              </span></td>
              <td><span class="text-ellipsis">
                {{number_format($donhang->dh_phi_vc,'0',',','.')}}<small> &#8363; </small>
              </span></td>
              <td><span class="text-ellipsis">
                {{number_format($donhang->dh_tongdh,'0',',','.')}}<small> &#8363; </small>
              </span></td>
              <td>{{$donhang->created_at}}</td>
            <?php 
            if($donhang->dh_trangthai==0){
            ?>
              <td>
                <span class="text-ellipsis"> 
                  <a href="{{URL::to('/xacnhan-dh/'.$donhang->dh_id)}}"class="active styling_edit">Xác nhận</a>
                    ||
                  <a onclick="return confirm('Bạn có chắc muốn xóa đơn hàng này không?')" href="{{URL::to('xoa-dh/'.$donhang->dh_id)}}" class="active styling_edit" ui-toggle-class="">Xóa</a>
                      {{-- <i class="fa fa-times text-danger text"></i></a> --}}
                </span>
              </td>
            <?php
              }else{
            ?>
              <td><span class="text-ellipsis"> 
                      <a href="{{URL::to('/huy-dh/'.$donhang->dh_id)}}"class="active styling_edit">Hủy</a>
                    </span>
              </td>
            <?php
              }
            ?>
              <td>
                <a href="{{URL::to('/chitiet-dh/'.$donhang->dh_id)}}" class="active styling_edit" ui-toggle-class="">
                  <i class="fa fa-folder-open"></i>
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