@extends('admin_layout')<!--mo rong call file layout -->
@section('admin_content')<!--tao section home -->

<div class="table-agile-info" >
  <div class="panel panel-default">
    <div class="panel-heading">
      Danh sách thông tin gửi hàng không có đơn đặt hàng
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
            <th>Tên khách hàng</th>
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
            @foreach($data as $key => $sh) <!-- tao vong lap voi $cate_pro la valuse -->
              <tr>
                
                <td><span class="text-ellipsis">{{$sh->shipping_id}} </span></td>
                <td><span class="text-ellipsis">{{$sh->KhachHang->kh_Ten}}</span></td>
                <td><span class="text-ellipsis">{{$sh->shipping_ten}} </span></td>
                <td><span class="text-ellipsis">{{$sh->shipping_diachi}} </span></td>
                <td><span class="text-ellipsis">{{$sh->shipping_sdt}} </span></td>
                <td><span class="text-ellipsis">{{$sh->shipping_note}} </span></td>
                <td><span class="text-ellipsis">{{$sh->phi}} </span></td>
                <td>
                  <a onclick="return confirm('Bạn có chắc muốn xóa không?')" href="{{URL::to('xoa-shipping/'.$sh->shipping_id)}}" class="active styling_edit" ui-toggle-class="">
                    <box-icon name='trash' rotate='90' animation='tada' color='#ee2020' ></box-icon>
                  </a>
                </td>
              </tr>
            @endforeach
          @endif
        </tbody>
      </table>
    </div>
   
  </div>
</div>
@endsection