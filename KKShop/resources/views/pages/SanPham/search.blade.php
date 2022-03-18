@extends('layout') <!--mo rong call file layout -->
@section('content')<!--tao section home -->
<div class="features_items"><!--features_items-->
                        <h2 class="title text-center">{{$key}}</h2>
                        @foreach($search_sanpham as $key => $sanpham )
                            
                            <div class="col-sm-4">
                                <div class="product-image-wrapper">
                                    <div class="single-products">
                                            <div class="productinfo text-center">
                                                <form > 
                                                    @csrf
                                                {{-- hideen là ẩn --}}
                                                <input type="hidden" value="{{$sanpham->sp_id}}" class="gh_sp_id_{{$sanpham->sp_id}}">

                                                <input type="hidden" id="wishlist_sp_ten{{$sanpham->sp_id}}" value="{{$sanpham->sp_Ten}}" class="gh_sp_ten_{{$sanpham->sp_id}}">

                                                <input type="hidden" value="{{$sanpham->asp_hinhanh}}" class="gh_sp_hinhanh_{{$sanpham->sp_id}}">

                                                <input type="hidden" value="{{$sanpham->sp_gia}}" class="gh_sp_gia_{{$sanpham->sp_id}}">

                                                <input type="hidden" value="1" class="gh_sp_soluong_{{$sanpham->sp_id}}">

                                                <input type="hidden" id="wishlist_sp_gia{{$sanpham->sp_id}}" value="{{number_format($sanpham->sp_gia,'0',',','.')}}đ">

                                                <a id="wishlist_sp_url{{$sanpham->sp_id}}" href="{{URL::to('/chi-tiet-sp/'.$sanpham->sp_id)}}">
                                                    <img id="wishlist_sp_hinhanh{{$sanpham->sp_id}}" src="{{URL::to('public/uploads/product/'.$sanpham->asp_hinhanh)}}" alt="{{$sanpham->asp_hinhanh}}" height="200" width="100" />
                                                    <h2>{{number_format($sanpham->sp_gia).' '.'vnd'}}</h2>
                                                    <p>{{$sanpham->sp_Ten}}</p>
                                                 </a>
                                                
                                                  @if($sanpham->sp_soluong>0)
                                                    @if(Session::get('giohang'))
                                                    <?php
                                                        $test =0;
                                                        $slgh=0;
                                                    ?>
                                                        @foreach(Session::get('giohang') as $key => $val)
                                                            <?php
                                                                $slgh++;
                                                            ?>
                                                            @if($val['sanpham_id']==$sanpham->sp_id)
                                                                <p style="color:blue;margin-bottom: -6px;width: 50%;float: left;margin-left:10px;margin-top: 3%;"><b>Đã thêm giỏ hàng</b></p>
                                                                 @break;
                                                            @else 
                                                                 <?php
                                                                    $test++;
                                                                ?>
                                                            @endif
                                                        @endforeach
                                                        @if($test==$slgh)
                                                            <button class="btn btn-default add-to-cart " data-id_sp="{{$sanpham->sp_id}}" type="button" name="add-to-cart"><i class="fa fa-cart-plus"></i>Thêm giỏ hàng</button>
                                                        @endif
                                                    @else 
                                                        <button class="btn btn-default add-to-cart " data-id_sp="{{$sanpham->sp_id}}" type="button" name="add-to-cart"><i class="fa fa-cart-plus"></i>Thêm giỏ hàng</button>
                                                    {{-- button dua vao data-id_sp de lay id san pham chinh xac data là mặc định còn tên là id_sp --}}
                                               
                                                    @endif
                                                @else 
                                                    <p style="color:blue;margin-bottom: -6px;width: 50%;float: left;margin-left:10px;margin-top: 3%;"><b>Hết hàng</b></p>
                                               
                                                @endif

                                                
                                               {{--  <button class="btn btn-default add-to-cart " data-id_sp="{{$sanpham->sp_id}}" type="button" name="add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm giỏ hàng</button> --}}
                                                {{-- button dua vao data-id de lay id san pham chinh xac data là mặc định còn tên là id_sp --}}
                                                <button class="btn btn-default xemnhanh " data-id_sp="{{$sanpham->sp_id}}" data-toggle="modal" data-target="#xemnhanh" type="button" name="xemnhanh">Xem nhanh</button>
                                                </form>
                                            </div>
                                    </div>
                                    <div class="choose" style="float: right;">
                                        <ul class="nav nav-pills nav-justified">
                                           <li>
                                                <button class="button_wishlist" id="{{$sanpham->sp_id}}" onclick="add_wishlist(this.id);"><i class="fa fa-plus-square"></i><span> Yêu thích</span></button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        
                        
                    </div><!--features_items-->
                    <div class="modal fade" id="xemnhanh" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document" style="overflow:scroll;max-height:700px;">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">
                                {{-- <a href="{{URL::to('/chi-tiet-sp/'.$sanpham->sp_id)}}" > --}}
                                    <span id="sanpham_xn_ten"></span>
                                {{-- </a> --}}
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <div class="row">
                                <div class="col-md-5">
                                    <span id="sanpham_xn_khoanh"></span>
                                </div>
                                <div class="col-md-7">
                                    <p style="color:red;font-size: 16px;"><b>ID:</b> <span id="sanpham_xn_id"></span></p>   
                                    <p style="color:blue;font-size: 20px;">Giá: <span id="sanpham_xn_gia"></span></p>
                                   {{--  <p>
                                        <span>
                                            <label>Số Lượng</label>
                                            <input type="number" name="soluong" min="1" value="1">
                                        </span>
                                    </p><br> --}}
                                    <p>Số lượng tồn: <span id="sanpham_xn_tonkho"></span></p> 
                                    <p style="font-size: 20px;color: blue;"><b>Mô tả sản phẩm</b></p>
                                    <p><span id="sanpham_xn_mota"></span></p><br>
                                    <p style="font-size: 20px;color: blue;"><b>Cấu hình chi tiết</b></p>
                                    <p><span id="sanpham_xn_noidung"></span></p>   
                  
                                </div>          
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                            {{-- <button type="button" class="btn btn-primary" style="margin-top: 0px;">Save changes</button> --}}
                          </div>
                        </div>
                      </div>
                    </div>
<div>
    {{-- phân trang --}}
    {{-- <span>{!!$search_sanpham->render()!!}</span> --}}
</div> 
<style>
    span#sanpham_xn_khoanh img {
    width: 100%;
    }
    .col-md-7 img {
    width: 100%;
    }
    
</style>

               
@endsection

