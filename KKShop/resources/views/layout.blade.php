<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"> 
    <title>Home | K&K-SHOP</title>
    <link href="{{asset('public/frontend/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('public/frontend/css/main.css')}}" rel="stylesheet">
    <link href="{{asset('public/frontend/css/responsive.css')}}" rel="stylesheet">
    <link href="{{asset('public/frontend/css/font-awesome.min.css')}}" rel="stylesheet">
    {{-- nút dưới góc --}}
    <link href="{{asset('public/frontend/css/animate.css')}}" rel="stylesheet">
    
    {{-- thông báo của ajax  --}}
    <link href="{{asset('public/frontend/css/sweetalert.css')}}" rel="stylesheet">

    {{-- cho ảnh của chi tiết sản phẩm --}}
    <link href="{{asset('public/frontend/css/lightslider.css')}}" rel="stylesheet">
    <link href="{{asset('public/frontend/css/prettify.css')}}" rel="stylesheet">
    <link href="{{asset('public/frontend/css/lightgallery.min.css')}}" rel="stylesheet">
    
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" type="text/css" media="all" /> --}}
    {{-- Lọc theo giá thanh kéo giá --}}
    <link href="{{asset('public/frontend/css/jquery-ui.min.css')}}" rel="stylesheet">
    {{-- <link href="{{asset('public/frontend/css/price-range.css')}}" rel="stylesheet"> --}}
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css"> --}}

</head><!--/head-->
    
<body>  
    <header id="header"><!--header-->
        <div class="header_top"><!--header_top-->
            <div class="container">
                <div class="row">
                    <div class="col-sm-9">
                        {{-- <a href="{{URL::to('/')}}"><img style="width: 100px;height: 100px;" src="{{asset('public/frontend/images/logo.png')}}" alt="" /></a> --}}
                    </div>
                    <div class="col-sm-3">
                        <div class="contactinfo">
                            <ul class="nav nav-pills">
                                <li><a href="#"><i class="fa fa-phone"></i> 0358670161</a></li>
                                <li><a href="mailto://trankhanh@gmail.com" target="_blank"><i class="fa fa-envelope fa-style"></i> trankhanh@gmail.com</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--/header_top-->
    </header><!--/header-->

    <div class="header-menu" style="height: 80px;"><!--header-menu-->
        <div class="container">
            <div class="row" >
                <div class="col-sm-2">
                    <a href="{{URL::to('/')}}"><img style="width: 175px;height: 120px;border-radius: 5px;position: absolute;" src="{{asset('public/frontend/images/logo3.png')}}" alt="" /></a>
                </div>
                <div class="col-sm-10" style="padding: 10px;background-color: #CCC;border-radius: 5px;border-top: 1px solid blue;">
        
                    <div class="mainmenu pull-left">
                        
                        <ul class="nav navbar-nav collapse navbar-collapse ">
                            <li><a href="{{URL::to('trang-chu')}}" class="active"><i class="fa fa-home"></i><b> Trang chủ</b></a></li>
                            <li class="dropdown"><a href="#"><i class="fa fa-cube"></i><b> Loại sản phẩm</b><i class="fa fa-angle-down"></i></a>
                                <ul role="menu" class="sub-menu">
                                    @foreach($loai_sp as $key => $loai)
                                        <li><a href="{{URL::to('loai-sp/'.$loai->l_id)}}">{{$loai->Ten}}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                            <li class="dropdown"><a href="#"><i class="fa fa-diamond"></i><b> Thương Hiêu</b><i class="fa fa-angle-down"></i></a>
                                <ul  role="menu" class="sub-menu" >
                                    @foreach($thuonghieu_sp as $key => $thuonghieu)
                                        <li><a href="{{URL::to('thuonghieu-sp/'.$thuonghieu->th_id)}}">{{$thuonghieu->th_Ten}}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                            <li><a href="{{URL::to('checkout')}}"><i class="fa fa-crosshairs"></i><b> Thanh toán</b></a></li>
                            <li class="cart-hover"><a href="{{URL::to('gio-hang')}}"><i class="fa fa-shopping-cart"></i><b> Giỏ hàng
                                <span id="show_cart"></span>
                                <div class="clearfix"></div>
                                <span id="hover-ht-gh" >
                                    
                                </span>
                               
                            </b></a></li>
                            @if(Session::get('kh_id'))
                                <li><a href="{{URL::to('don-hang')}}"><i class="fa fa-cart-arrow-down"></i><b> Đơn hàng </b></a></li>
                            @endif
                            @if(Session::get('kh_id'))
                                <li class="dropdown"><a href="#"><i class="fa fa-user-o"></i><b> Tài khoản</b><i class="fa fa-angle-down"></i></a>
                                <ul role="menu" class="sub-menu">
                                    <li><a href="{{URL::to('profile-customer')}}"><i class="fa fa-user"></i> Hồ sơ</a></li>
                                   <li><a onclick="return confirm('Bạn có chắc muốn đăng xuất?')" href="{{URL::to('logout-customer')}}"><i class="fa fa-sign-out"></i> Đăng xuất</a></li>
                                   <li><a href="{{URL::to('sua-pass')}}"><i class="fa fa-lock"></i>  Đổi mật khẩu</a></li>
                                </ul>
                                </li>
                            @else
                               <li><a href="{{URL::to('login-checkout')}}"><i class="fa fa-sign-in"></i><b> Đăng nhập</b></a></li> 
                            @endif
                            
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div><!--/header-menu-->

    <section id="slider"><!--slider-->
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div id="slider-carousel" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                        <?php
                          $i=0;  
                        ?>
                            @foreach($slider as $key => $val)
                            <?php
                                $i++;
                              
                            ?>   
                            <li data-target="#slider-carousel" data-slide-to="{{$i}}" class="{{$i==1 ? 'active' : ''}}"></li>
                            {{-- <li data-target="#slider-carousel" data-slide-to="1"></li> --}}
                            {{-- <li data-target="#slider-carousel" data-slide-to="2"></li> --}}
                        @endforeach 
                        </ol>
                        
                        <div class="carousel-inner">
                        {{-- carousel-inner chạy nền slider bootstrap.min.css --}}
                        <?php
                          $i=0;  
                        ?>
                            @foreach($slider as $key => $val)
                            <?php
                                $i++;
                              
                            ?>
                            <div class="item {{$i==1 ? 'active' : ''}}">
                                <div class="col-sm-3">
                                     <a href="{{URL::to('/')}}">
                                        <h1><span style="color: blue;">K<small style="color: blue;">&amp;</small>K</span>-SHOP</h1>
                                        <h3 style="color: #aaa;">The best or nothing</h3>
                                    </a>
                                </div>
                                <div class="col-sm-9">
                                   
                                    <img src="{{asset('public/uploads/slider/'.$val->slider_hinhanh)}}" alt="" height="120" width="100%" class="img img-responsive" />
                                </div>
                            </div>
                            
                           @endforeach 
                        </div>
                        
                        <a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
                            <i class="fa fa-angle-left"></i>
                        </a>
                        <a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </div>
                    
                </div>
            </div>
        </div>
    </section><!--/slider-->
    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-6"></div>
                <div class="col-sm-6 padding-right">
                    <form action="{{URL::to('search-sp')}}"  autocomplete="off" method="post">
                        @csrf 
                        <div class="search_box pull-right"style="margin-right: 10px;width: 100%">
                            <input style="width: 70%;border: 1px solid blue;border-radius: 5px;margin-right:20px;margin-top:5px;height:40px;font-size: 13px;float: left;" id ="keywords" type="text" name="keywords_submit"  placeholder="Tìm kiếm sản phẩm"/>
                            <div id="search-ajax"></div>
                            <input type="submit" style="margin-top: 0;color:white;width: 80px;height:30px;margin-top: 10px;border-radius:5px;" name="search_items" class="btn btn-primary btn-sm" value="Tìm kiếm">
                           
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section><br>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <div class="left-sidebar">
                        {{-- <h2>Danh mục</h2> --}}
                        {{-- <div class="panel-group category-products" id="accordian"> --}}
                            <!--category-productsr-->
                           
                           {{-- @foreach($loai_sp as $key => $loai)
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title"><a href="{{URL::to('loai-sp/'.$loai->l_id)}}">{{$loai->Ten}}</a></h4>
                                </div>
                            </div>
                           @endforeach
                        </div> --}}
                        <!--/category-products-->
                    
                        {{-- <div class="brands_products" style="text-align:center; "> --}}
                            <!--brands_products-->
                            {{-- <h2>Thương hiệu</h2>
                            @foreach($thuonghieu_sp as $key => $thuonghieu)
                            <div class="brands-name">
                                <ul class="nav nav-pills nav-stacked">
                                    <li><a href="{{URL::to('thuonghieu-sp/'.$thuonghieu->th_id)}}"> <b>{{$thuonghieu->th_Ten}}</b></a></li>
                                    
                                </ul>
                            </div>
                            @endforeach
                        </div> --}}
                        <!--/brands_products-->
                        <div class="brands_products" style="text-align:center; ">
                            <h2>Yêu thích</h2>
                            {{-- <div class="brands-name"> --}}
                                <div id="row_wishlist" class="row"></div>
                            {{-- </div> --}}
                        </div>
                    </div>
                </div>
                
                <div class="col-sm-9 padding-right">
                    @yield('content') <!--call section home -->
             
                </div>
            </div>
        </div>
    </section>
    
    <footer id="footer" style="background-color: #ccc;"><!--Footer-->
        <div class="footer-top">
            <div class="container">
                <div class="row">

                    <div class="col-sm-2">
                        <div class="companyinfo">
                            <a href="{{URL::to('/')}}">
                                <h2><span>K<small style="color: blue;">&amp;</small>K</span>-SHOP</h2>
                            </a>
                            <p><a href="#"><i class="fa fa-phone"></i> 0358670161</a></p>
                            <p><a href="mailto://trankhanh@gmail.com" target="_blank"><i class="fa fa-envelope fa-style"></i> trankhanh@gmail.com</a></p>
                        
                            <p style="color: blue;">The best or nothing</p>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="address">
                            <img src="{{asset('public/frontend/images/map.png')}}" alt="" />
                            <p></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </footer><!--/Footer-->
    
  {{-- chạy cục bộ --}}
    <script src="{{asset('public/frontend/js/jquery.js')}}"></script>
    <script src="{{asset('public/frontend/js/bootstrap.min.js')}}"></script>
    
    {{-- cho nút phía dưới đưa lên top --}}
    <script src="{{asset('public/frontend/js/jquery.scrollUp.min.js')}}"></script>
    <script src="{{asset('public/frontend/js/price-range.js')}}"></script>
    <script src="{{asset('public/frontend/js/main.js')}}"></script>
   
    {{-- dùng cho ajax của giỏ hàng --}}
    <script src="{{asset('public/frontend/js/sweetalert.min.js')}}"></script>

    {{-- chạy cho ảnh của chi tiết sản phẩm --}}
    <script src="{{asset('public/frontend/js/lightslider.js')}}"></script>
    <script src="{{asset('public/frontend/js/prettify.js')}}"></script>
    <script src="{{asset('public/frontend/js/lightgallery-all.min.js')}}"></script>
    {{-- Lọc theo giá thanh kéo giá --}}
    <script src="{{asset('public/frontend/js/jquery-ui.min.js')}}"></script>
    {{-- format cho mức tiền --}}
    <script src="{{asset('public/frontend/js/simple.money.format.js')}}"></script>
    <script src="{{asset('public/frontend/js/boxicons.js')}}"></script>
    {{-- <script src="https://unpkg.com/boxicons@2.0.9/dist/boxicons.js"></script> --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" type="text/javascript"async defer></script> --}}
    {{--ajax lấy class --}}
    {{-- xem nhanh --}}
    <script type="text/javascript">
        $(document).ready(function(){
            $('.xemnhanh').click(function(){
                var id = $(this).data('id_sp'); 
                var _token = $('input[name="_token"]').val();
                var vitri = window.location.pathname;
                $.ajax({
                    url: '{{url('/xemnhanh')}}',
                    method: 'POST',
                    dataType: 'JSON', //kiểu dữ liệu trả về 
                    data:{id:id,_token:_token,vitri:vitri},
                    success:function(data){
                        $('#sanpham_xn_id').html(data.sp_id);
                        $('#sanpham_xn_ten').html(data.sp_Ten);
                        $('#sanpham_xn_tonkho').html(data.sp_soluong); 
                        $('#sanpham_xn_mota').html(data.sp_mota);
                        $('#sanpham_xn_noidung').html(data.sp_noidung);
                        $('#sanpham_xn_gia').html(data.sp_gia);
                        $('#sanpham_xn_khoanh').html(data.sp_khoanh);
                    }

                });

            });
        });
    </script>   
    {{-- thêm giỏ hàng --}}
    <script  type="text/javascript" >
        $(document).ready(function(){
            show_cart();
            show_gh_hover();
            // show gh hover
            function show_gh_hover(){
                $.ajax({
                        url:'{{url('/show-gh-hover')}}',
                        method: 'GET',
                        success:function(data){
                            $('#hover-ht-gh').html(data);
                        }
                    });
            }
            {{-- show cart --}}
            function show_cart() {
                 $.ajax({
                        url:'{{url('/show-sl-gh')}}',
                        method: 'GET',
                        success:function(data){
                            $('#show_cart').html(data);
                        }
                    });
            };
            $('.add-to-cart').click(function(){ //lấy class add-to-cart 
                var id = $(this).data('id_sp'); //để biết lấy sản phẩm nào đưa vào giỏ hàng 
                // data là mặc định còn tên là id_sp (lấy từ data-id_sp)
                //data không cần chấm
                var gh_sp_id = $('.gh_sp_id_'+ id).val(); //gh_sp_id_ phải ghi đúng phải chấm và chấm val()
                var gh_sp_ten = $('.gh_sp_ten_'+ id).val();
                var gh_sp_hinhanh = $('.gh_sp_hinhanh_'+ id).val();
                var gh_sp_gia = $('.gh_sp_gia_'+ id).val();
                var gh_sp_soluong = $('.gh_sp_soluong_'+ id).val();
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url: '{{url('/them-gh-ajax')}}',
                    method: 'POST',
                    data:{gh_sp_id:gh_sp_id,gh_sp_ten:gh_sp_ten,gh_sp_hinhanh:gh_sp_hinhanh,gh_sp_gia:gh_sp_gia,gh_sp_soluong:gh_sp_soluong,_token:_token},
                    success:function(){
                        //swal("Giỏ Hàng", "Thêm thành công", "success");
                        swal({
                                title: "Đã thêm sản phẩm vào giỏ hàng",
                                text: "Bạn có thể mua hàng tiếp hoặc tới giỏ hàng để tiến hành thanh toán",
                                showCancelButton: true,
                                cancelButtonText: "Xem tiếp",
                                confirmButtonClass: "btn-success",
                                confirmButtonText: "Đi đến giỏ hàng",
                                closeOnConfirm: false
                                
                            },
                            function() {
                                // window.location.assign("http://localhost/shopbanhang/gio-hang") //trả về trang mới 
                                window.location.href = "gio-hang" //trả về trang hiện tại /gio-hang
                            });
                        show_cart();
                        show_gh_hover();
                        // location.reload();
                    }
                });
            });

        });

</script>
<script type="text/javascript">
    $(document).ready(function(){
        $('.choose').change(function(){
        var action = $(this).attr('id'); 
        // attr lấy thuộc tính id của class choose 
        var ma_id = $(this).val();
        var _token = $('input[name="_token"]').val();
        var result = '';

        if(action=='city'){
            result = 'province';
        }
        if(action=='province'){
            result = 'wards';
        }
        $.ajax({
            url : '{{url('/select-shippingfee-home')}}',
            method: 'POST',
            data:{action:action,ma_id:ma_id,_token:_token},
            // gửi dữ liệu qua controller
            success:function(data){
               $('#'+result).html(data); 
                   //'#+id' 
            }
            });
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $('.save_shipping').click(function(){
            var hoten = $('.shipping_ten').val();
            var sdt = $('.shipping_sdt').val();
            var matp = $('.city').val();
            var maqh = $('.province').val();
            var xaid = $('.wards').val();
            var diachi = $('.shipping_diachi').val();
            var note = $('.shipping_note').val();
            var _token = $('input[name="_token"]').val();
            if(xaid == '' || matp==''|| maqh==''){
                alert('Làm ơn chọn để tính phí vận chuyển')
            }else{
               $.ajax({
                url : '{{url('/save-shipping')}}',
                method: 'POST',
                data:{hoten:hoten,sdt:sdt,matp:matp,maqh:maqh,xaid:xaid,diachi:diachi,note:note,_token:_token},
                // gửi dữ liệu qua controller
                success:function(data){
                  window.location.href = "checkout" //trả về trang hiện tại /gio-hang
                }
                });
            }
        });

    });
</script>
{{-- dùng cho hình ảnh của chi tiết sản phẩm --}}
<script>
    $(document).ready(function() {
        $('#imageGallery').lightSlider({
            // chạy nhiều ảnh
            gallery:true,
            // click vào chạy một ảnh
            item:1,
            // vòng lặp
            loop:true,
            // số lượng hình ảnh hiểu thị bên dưới
            thumbItem:3,
            
            slideMargin:0,
            enableDrag: false,
            currentPagerPosition:'left',
            onSliderLoad: function(el) {
                el.lightGallery({
                    selector: '#imageGallery .lslide'
                });
            }   
        });  
  });
</script>  
{{-- search sản phẩm --}}
<script type="text/javascript" >
    $('#keywords').keyup(function(){
        var kq = $(this).val();
        if(kq != ''){
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url:"{{url('/autocomplete-ajax')}}",
                method: "POST",
                data: {kq:kq,_token:_token},
                success:function(data){
                    $('#search-ajax').fadeIn();
                    // hieu ung mo
                    $('#search-ajax').html(data);
                }
            });
        }else{
            $('#search-ajax').fadeOut();
        }
    });
    $(document).on('click','li',function(){
        $('#keywords').val($(this).text());
        $('#search-ajax').fadeOut();
    });
</script>
                 {{-- Lọc sản phẩm --}}
<script type="text/javascript">
    $(document).ready(function(){
        $('#sort').change(function(){
        var _token = $('input[name="_token"]').val();
        var url = $(this).val();
        if(url){
            window.location = url;
        }
        return false;
        });
    });
</script>
{{-- Lọc theo giá thanh kéo --}}
<script type="text/javascript">
    $(document).ready(function(){
        $( "#slider-range" ).slider({
            orientation: "horizontal",
            range: true, //hai cục kéo thả có khoảng cách
            min: {{$min_td}},
            max: {{$max_td}},
            values: [ {{$min}}, {{$max}}], //giá từ 
            step:100000,
            slide: function( event, ui ) {
                //lấy số khi kéo thả
                $( "#amount_start" ).val( ui.values[ 0 ] + "vnđ" ).simpleMoneyFormat(); 
                $( "#amount_end" ).val( ui.values[ 1 ] + "vnđ" ).simpleMoneyFormat(); 
                $( "#start_price" ).val( ui.values[ 0 ]);
                $( "#end_price" ).val(ui.values[ 1 ]);
            }
        });
        $( "#amount_start" ).val( $( "#slider-range" ).slider( "values", 0 ) + "vnđ" ).simpleMoneyFormat(); //hiển thị giá trị 
        $( "#amount_end" ).val( $( "#slider-range" ).slider( "values", 1 ) + "vnđ" ).simpleMoneyFormat(); //hiển thị giá trị 
    });
</script>
{{-- Lọc thương hiệu và loại --}}
<script type="text/javascript">
    $('.brand-filter').click(function(){
        var brand = [];
        var temArray = [];
        $.each( $("[data-filters='brand']:checked" ), function(){
            temArray.push($(this).val());
        });
        temArray.reverse(); //đưa id sản phẩm click sau lên đầu
        if(temArray.length !== 0){
            brand+='?brand='+temArray.toString();
        }
        window.location.href = brand
    });
    $('.category-filter').click(function(){
        var category = [];
        var temArray = [];
        $.each( $("[data-filters='category']:checked" ), function(){
            temArray.push($(this).val());
        });
        temArray.reverse(); //đưa id sản phẩm click sau lên đầu
        if(temArray.length !== 0){
            category+='?category='+temArray.toString();
        }
        window.location.href = category
    });
</script>

{{-- Thêm yêu thích --}}
<script type="text/javascript">
    function view(){
        if(localStorage.getItem('data') != null){
            var data = JSON.parse(localStorage.getItem('data'));//ép kiểu dl hiển thị kiểu JSON
            data.reverse(); //chuyển dl mới thêm lên đầu
            document.getElementById('row_wishlist').style.overflow = 'scroll';
            document.getElementById('row_wishlist').style.height = '500px';
            document.getElementById('row_wishlist').style.background = '#f6f4f4';
            for(i=0;i<data.length;i++){
                var ten = data[i].ten;
                var gia = data[i].gia;
                var hinhanh = data[i].hinhanh;
                var url = data[i].url;
                var id = data[i].id;
                $("#row_wishlist").append('<div class="row" style="margin:10px 0;text-align:left;"><a href="'+url+'" style="color:blue;"><div class="col-md-4"><img width ="100%" src="'+hinhanh+'"></a></div><div class="col-md-8 info_wishlist"><a href="'+url+'" style="color:blue;"><p><i>'+ten+'</i></p><p style="color:red;">'+gia+'</p></a><button style="color:blue;" class="button_wishlist" id="'+id+'" onclick="del_wishlist(this.id);">Xóa</button></div></div>');
                    // <a href="'+url+'" style="color:blue;">Xem chi tiết</a>   
            }
            $("#row_wishlist").append('<br><div class="row" style="margin:10px 0;text-align:left;"><div class="col-md-7"></div><div class="col-md-5 info_wishlist"><button type="button" name="del_all" class="btn btn-info del_all">Xóa tất cả</button></div></div>');
        }
    }
    view();
    function add_wishlist(clicked_id){
        // gán + id để biết đường lấy sản phẩm nào
        var id = clicked_id;
        var ten = document.getElementById('wishlist_sp_ten'+id).value; 
        var gia = document.getElementById('wishlist_sp_gia'+id).value; 
        var hinhanh = document.getElementById('wishlist_sp_hinhanh'+id).src;
        var url = document.getElementById('wishlist_sp_url'+id).href;
        var newItem = {
            'url':url,
            'id':id,
            'ten':ten,
            'gia':gia,
            'hinhanh':hinhanh
        }
        if(localStorage.getItem('data')==null){
            localStorage.setItem('data','[]');
        }
        var old_data = JSON.parse(localStorage.getItem('data'));
        // kiểm tra xem sản phẩm này thêm vào localStorage chưa
        var matches = $.grep(old_data,function(obj){
            return obj.id == id;
        })
        if(matches.length){
            alert('Sản phẩm đã thêm vào yêu thích!');
        }else{
            old_data.push(newItem);

        }
        localStorage.setItem('data',JSON.stringify(old_data))
        location.reload();
    }
    function del_wishlist(clicked_id){
        var id_sp = clicked_id;
        var array = JSON.parse(localStorage.getItem('data'));
        for(i=0;i<array.length;i++){
            if(array[i].id == id_sp){
                array.splice(i,1);
                }
            }
        localStorage.setItem('data',JSON.stringify(array))
        //JSON.stringify() chuyển dữ liệu thành chuỗi để đưa vào localSortage
        location.reload();

    }
</script>
<script type="text/javascript">
    $(document).ready(function(){
            $('.del_all').click(function(){
                localStorage.clear();
                location.reload();

            });
        });
</script>
</body>
</html>