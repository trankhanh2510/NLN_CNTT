
@extends('admin_layout')<!--mo rong call file layout -->
@section('admin_content')<!--tao section home -->

<div class="table-agile-info" >
  <div class="panel panel-default">
    <div class="panel-heading" style="background-color: #008000a8 ! important;" >
      Danh sách đơn hàng đang chờ duyệt
    </div>
   
    <div class="table-responsive">
      <table class="table table-striped b-t b-light" id="myTable">
        <thead>
          <tr>
            
            <th>ID</th>
            <th>Tên khách hàng</th>
            <th>Tổng đơn hàng</th>
            <th>Phí vận chuyển</th>
            <th>Tổng thanh toán</th> 
            <th>Ngày giờ đặt hàng</th>
            <th>Quản lý</th>
            <th style="width: 5%;">Xem</th>
          </tr>
        </thead>
        <tbody>
          @foreach($danhsach_dh as $key => $donhang) <!-- tao vong lap voi $donhang la valuse -->  
            <?php 
              if($donhang->dh_trangthai==0){
            ?>
              <tr>
                <td>{{$donhang->dh_id}}</td>
                <td>{{$donhang->kh_Ten}}</td>
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
                <td><span class="text-ellipsis"> 
                      <a href="{{URL::to('/xacnhan-dh/'.$donhang->dh_id)}}"class="active styling_edit">Xác nhận ||</a>
                    
                      <a onclick="return confirm('Bạn có chắc muốn xóa đơn hàng này không?')" href="{{URL::to('xoa-dh/'.$donhang->dh_id)}}"><box-icon name='trash' rotate='90' animation='tada' color='#ee2020' ></box-icon></a>
                          {{-- <i class="fa fa-times text-danger text"></i></a> --}}
                    </span></td>
                <td>
                  <a href="{{URL::to('/chitiet-dh/'.$donhang->dh_id)}}" class="active styling_edit" ui-toggle-class="">
                    <box-icon name='folder' color='#656565' ></box-icon>
                  </a>
                 
                </td>
              </tr>   
            <?php
              }
            ?>
         @endforeach
        </tbody>
      </table>
    </div>
   
  </div>
</div>
<br>
<br>

<div class="table-agile-info" >
  <div class="panel panel-default">
    <div class="panel-heading" style="background-color: #ff0000bd ! important;" >
      Danh sách đơn hàng đã duyệt
    </div>
   
    <div class="table-responsive">
      <table class="table table-striped b-t b-light" id="myTable">
        <thead>
          <tr>
            <th>ID</th>
            <th>Tên khách hàng</th>
            <th>Tổng đơn hàng</th>
            <th>Phí vận chuyển</th>
            <th>Tổng thanh toán</th> 
            <th>Ngày giờ đặt hàng</th>
            <th>Quản lý</th>
            <th style="width: 5%;">Xem</th>
            <th style="width: 5%;">Xuất</th>
          </tr>
        </thead>
        <tbody>
          @foreach($danhsach_dh as $key => $donhang) <!-- tao vong lap voi $donhang la valuse -->  
          <?php 
              if($donhang->dh_trangthai==1){
            ?>
                <tr>
                <td>{{$donhang->dh_id}}</td>
                <td>{{$donhang->kh_Ten}}</td>
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
                <td><span class="text-ellipsis"> 
                      <a href="{{URL::to('/huy-dh/'.$donhang->dh_id)}}"class="active styling_edit">Hủy</a>
                    </span>
                </td>
                <td>
                  <a href="{{URL::to('/chitiet-dh/'.$donhang->dh_id)}}" class="active styling_edit" ui-toggle-class="">
                    <box-icon name='folder' color='#656565' ></box-icon>
                  </a>
                 
                </td>
                <td>
                  <a target="_blank" href="{{url('print-order/'.$donhang->dh_id)}}" class="active styling_edit"><box-icon name='printer' type='solid' animation='tada' color='#535252' ></box-icon></a>
                </td>
              </tr>   
            <?php
              }
            ?>
         @endforeach
        </tbody>
      </table>
    </div>
   
  </div>
</div>

@endsection