
@extends('admin_layout')<!--mo rong call file layout -->
@section('admin_content')<!--tao section home -->

<div class="table-agile-info">
  <div class="panel panel-default">
    <div class="panel-heading">
      Danh sách slider
    </div>
   
    <div class="table-responsive">
      <table class="table table-hover b-t b-light" {{-- id="myTable" --}}>
        <thead>
          <tr>
            <th style="width: 20%;">Tên</th>
            <th style="width: 50%;">Hình ảnh</th>
            <th style="width:10%;">Mô tả</th>
            <th>Hiển thị</th>
            <th style="width:30px;"></th>
          </tr>
        </thead>
        <tbody>
          @foreach($slider as $key => $slider) 
          <tr>
          
            <td>{{$slider->slider_ten}}</td>
            <td><span class="text-ellipsis"><img src="public/uploads/slider/{{$slider->slider_hinhanh}}" alt="{{$slider->slider_hinhanh}}" height="100" width="250"></span></td>
            <td><span class="text-ellipsis">{{$slider->slider_mota}}</span></td>
            <td><span class="text-ellipsis"> 
              <?php 
                if($slider->slider_trangthai==1){
                ?>
                  <a href="{{URL::to('an-slider/'.$slider->slider_id)}}"><span class="fa-thumd-styling fa fa-check-circle-o"></span></a>
                <?php
                }else{
                ?>
                  <a href="{{URL::to('hienthi-slider/'.$slider->slider_id)}}"><span class="fa-thumd-styling-down fa fa-times-circle-o"></span></a>
               <?php
                }
                ?>
            </span></td>
            <td>
              <a href="{{URL::to('/sua-slider/'.$slider->slider_id)}}" class="active styling_edit" ui-toggle-class="">
                 <box-icon name='edit-alt' color='#2086ee' ></box-icon>
              </a>
              <a onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này không?')" href="{{URL::to('xoa-slider/'.$slider->slider_id)}}" class="active styling_edit" ui-toggle-class="">
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