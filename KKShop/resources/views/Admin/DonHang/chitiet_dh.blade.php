
@extends('admin_layout')<!--mo rong call file layout -->
@section('admin_content')<!--tao section home -->

<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Chi tiết đơn hàng
    </div>
   
    <div class="table-responsive">
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            
            <th>Tên sản phẩm</th>
            <th>Giá</th>
            <th>Số lượng mua</th>
            <th>Đơn giá</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
         
         @foreach($danhsach_ctdh as $key => $chitietdonhang) <!-- tao vong lap voi $chitietdonhang la valuse -->  
          <tr>
            <td>{{$chitietdonhang->sp_ten}}</td>
            <td>
              {{number_format($chitietdonhang->sp_gia,'0',',','.')}}<small> &#8363; </small>
            </td>
            <td>{{$chitietdonhang->ctdh_soluong}}</td>
            <td>
              {{number_format($chitietdonhang->ctdh_dongia,'0',',','.')}}<small> &#8363; </small>
            </td>
            <td>
              @if($danhsach_ttdh->dh_trangthai==0)
              <a onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này khỏi đơn hàng?')" href="{{URL::to('xoa-ctdh/'.$chitietdonhang->ctdh_id)}}" class="active styling_edit" ui-toggle-class="">
                    <box-icon name='trash' rotate='90' animation='tada' color='#ee2020' ></box-icon>
              </a>
              @endif
             
            </td>
          </tr>
         @endforeach
          <tr>
            <td></td>
            <td></td>
            <td><b>Phí vận chuyển: </b></td>
            <td><b>{{number_format($danhsach_ttdh->dh_phi_vc,'0',',','.')}}<small> &#8363; </small></b></td>
          </tr>
          <tr>
            <td colspan="2"></td>
            {{-- @if($danhsach_ttdh->dh_trangthai==1)
              <td style="font-size: 20px;"><a target="_blank" href="{{url('print-order/'.$danhsach_ttdh->dh_id)}}"><b>IN ĐƠN HÀNG</b></a></td>
            @else
              <td></td>
            @endif --}}
            <td><b>Tổng thanh toán: </b></td>
            <td><b>{{number_format($danhsach_ttdh->dh_tongdh,'0',',','.')}}<small> &#8363; </small></b></td>
          </tr>
        </tbody>
      </table>
    </div>
      
  </div>
</div>
<br>


<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Thông tin khách mua
    </div>
   
    <div class="table-responsive">
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            
            <th>Tên</th>
            <th>Email</th>
            <th>SĐT</th>
          </tr>
        </thead>
        <tbody>
           <tr>
              <td>{{$danhsach_ttdh->kh_Ten}}</td>
              <td>{{$danhsach_ttdh->kh_email}}</td>
              <td>{{$danhsach_ttdh->kh_sdt}}</td>
            </tr>

        </tbody>
      </table>
    </div>
  </div>
</div>

<br> 
<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Thông tin gửi đơn hàng
    </div>
   
    <div class="table-responsive">
      <table class="table table-striped b-t b-light">
        <thead>
          <tr>
            
            <th>Tên người nhận</th>
            <th>Địa chỉ</th>
            <th>SĐT</th>
            <th>Ghi chú đơn hàng</th>
          </tr>
        </thead>
        <tbody>
        <tr>
            <td>{{$danhsach_ttdh->shipping_ten}}</td>
            <td>
              {{$danhsach_ttdh->shipping_diachi}} 
            </td>
            <td>{{$danhsach_ttdh->shipping_sdt}}</td>
            <td>{{$danhsach_ttdh->shipping_note}}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection