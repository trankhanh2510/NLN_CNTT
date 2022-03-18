<!DOCTYPE html>
<head>
<title>Admin</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
{{-- <script type="application/x-javascript">
    addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); 
    function hideURLbar(){ window.scrollTo(0,1); } 
</script> --}}
<!-- bootstrap-css --  -->
<link rel="stylesheet" href="{{asset('public/backend/css/bootstrap.min.css')}}" >
<!-- Custom CSS -->
<link href="{{asset('public/backend/css/style.css')}}" rel='stylesheet' type='text/css' />
<link href="{{asset('public/backend/css/style-responsive.css')}}" rel="stylesheet"/>
<!-- font CSS -->
<link href='//fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
<!-- font-awesome icons -->
<link rel="stylesheet" href="{{asset('public/backend/css/font.css')}}" type="text/css"/>
<link rel="stylesheet" href="{{asset('public/backend/css/font-awesome.css')}}" > 
<link rel="stylesheet" href="{{asset('public/backend/css/morris.css')}}" type="text/css"/>
{{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" type="text/css" media="all" /> --}}
<!-- //font-awesome icons -->

{{-- tìm kiếm dữ liệu bằng datatables --}}
<link rel="stylesheet" href="{{asset('public/backend/css/datatables.css')}}">

<script src="{{asset('public/backend/js/jquery2.0.3.min.js')}}"></script>
<script src="{{asset('public/backend/js/raphael-min.js')}}"></script>
<script src="{{asset('public/backend/js/morris.js')}}"></script>
<script src="{{asset('public/backend/js/boxicons.js')}}"></script>
{{-- <script src="https://unpkg.com/boxicons@2.0.9/dist/boxicons.js"></script> --}}
</head>
<body class="admin_bg">
<section id="container">
<!--header start-->
<header class="header fixed-top clearfix">
<!--logo start-->
<div class="brand">
    <a href="dashboard" class="logo">
        K&K-Shop
    </a>
    <div class="sidebar-toggle-box">
        <div class="fa fa-bars"></div>
    </div>
</div>

<div class="top-nav clearfix">
    <!--search & user info start-->
    <ul class="nav pull-right top-menu">
        <!-- user login dropdown start-->
        <li class="dropdown">
            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                <img alt="" src="{{asset('public/backend/images/avtadmin.jpg')}}">
                <span class="username">
                	<?php
                		$name_admin = Session::get('admin_name');
                		if($name_admin){
                			echo $name_admin;
                		}
                	?>
                </span>
                <b class="caret"></b>
            </a>
            <ul class="dropdown-menu extended logout">
                <li><a href="{{URL::to('profile-admin')}}"><i class=" fa fa-suitcase"></i>Hồ sơ</a></li>
                <li><a href="{{URL::to('password-admin')}}"><i class="fa fa-cog"></i> Đổi mật khẩu</a></li>
                <li><a onclick="return confirm('Bạn có chắc muốn đăng xuất?')" href="{{URL::to('logout')}}"><i class="fa fa-key"></i> Đăng xuất</a></li>
            </ul>
        </li>
        <!-- user login dropdown end -->
       
    </ul>
    <!--search & user info end-->
</div>
</header>
<!--header end-->
<!--sidebar start-->
<aside>
    <div id="sidebar" class="nav-collapse">
        <!-- sidebar menu start-->
        <div class="leftside-navigation">
            <ul class="sidebar-menu" id="nav-accordion">
                <li>
                    <a class="active" href="{{URL::to('dashboard')}}">
                        <i class="fa fa-home"></i>
                        <span>Trang chủ</span>
                    </a>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-calendar-check-o"></i>
                        <span>Đơn hàng</span>
                    </a>
                    <ul class="sub">
                        <li><a href="{{URL::to('quanly-donhang')}}">Danh sách đơn hàng</a></li>
                        <li><a href="{{URL::to('danhsach-shipping')}}">Danh sách thông tin gửi hàng</a></li>
                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="{{URL::to('them-shippingfee')}}">
                        <i class="fa fa-truck"></i>
                        <span>Phí vận chuyển</span>
                    </a>
                </li>                      
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-cube"></i>
                        <span>Loại sản phẩm</span>
                    </a>
                    <ul class="sub">
						<li><a href="{{URL::to('them-loai-sp')}}">Thêm loại sản phẩm</a></li>
						<li><a href="{{URL::to('danhsach-loai-sp')}}">Danh sách loại sản phẩm</a></li>
                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-diamond"></i>
                        <span>Thương hiệu sản phẩm</span>
                    </a>
                    <ul class="sub">
						<li><a href="{{URL::to('them-th-sp')}}">Thêm Thương hiệu sản phẩm</a></li>
						<li><a href="{{URL::to('danhsach-th-sp')}}">Danh sách thương hiệu sản phẩm</a></li>
                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-cubes"></i>
                        <span>Sản phẩm</span>
                    </a>
                    <ul class="sub">
						<li><a href="{{URL::to('them-sp')}}">Thêm sản phẩm</a></li>
						<li><a href="{{URL::to('danhsach-sp')}}">Danh sách sản phẩm</a></li>
                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="{{URL::to('danhsach-kh')}}">
                        <i class="fa fa-users"></i>
                        <span>Khách hàng</span>
                    </a>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Slider</span>
                    </a>
                    <ul class="sub">
                        <li><a href="{{URL::to('them-slider')}}">Thêm slider</a></li>
                        <li><a href="{{URL::to('danhsach-slider')}}">Danh sách slider</a></li>
                    </ul>
                </li>   
                
            </ul>            </div>
        <!-- sidebar menu end-->
    </div>
</aside>
<!--sidebar end-->
<!--main content start-->
<section id="main-content">
	<section class="wrapper">
       @yield('admin_content') 
       <!-- goi conten admin-->
     </section>
</section>
<!--main content end-->
</section>
<script src="{{asset('public/backend/js/bootstrap.js')}}"></script>
<script src="{{asset('public/backend/js/jquery.dcjqaccordion.2.7.js')}}"></script>
<script src="{{asset('public/backend/js/scripts.js')}}"></script>
<script src="{{asset('public/backend/js/jquery.slimscroll.js')}}"></script>
<script src="{{asset('public/backend/js/jquery.nicescroll.js')}}"></script>
<script src="{{asset('public/backend/js/jquery.scrollTo.js')}}"></script>

{{-- tìm kiếm data bằng datatables --}}
<script src="{{asset('public/backend/js/datatables.js')}}"></script>

<script src="{{asset('public/backend/ckeditor/ckeditor.js')}}"></script> 
{{-- tạo editor trình soạn thảo văn bản --}}
{{-- gọi ckeditor chỉ cần thêm vào class ckeditor--}}

{{-- datatables tạo thanh tìm kiếm và phân trang--}}
<script type="text/javascript">

    $(document).ready( function () {
        $('#myTable').DataTable();
   } );

</script>
{{-- Phí vận chuyển --}}
<script type="text/javascript">
    $(document).ready(function(){

        fetch_shippingfee()

        function fetch_shippingfee(){
            var _token = $('input[name="_token"]').val();
            $.ajax({
            url : '{{url('/xem-shippingfee')}}',
            method: 'POST',
            data:{_token:_token},
            success:function(data){
               $('#load_shippingfee').html(data);  
                }
            });
        }

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
            url : '{{url('/select-shippingfee')}}',
            method: 'POST',
            data:{action:action,ma_id:ma_id,_token:_token},
            // gửi dữ liệu qua controller
            success:function(data){
               $('#'+result).html(data); 
                   //'#+id' 
            }
            });
        });
        $('.them_shippingfee').click(function(){
            var city = $('.city').val();
            var province = $('.province').val();
            var wards = $('.wards').val();
            var fee = $('.fee').val();
            var _token = $('input[name="_token"]').val();
            $.ajax({
            url : '{{url('/luu-shippingfee')}}',
            method: 'POST',
            data:{city:city,province:province,wards:wards,fee:fee,_token:_token},
            success:function(data){  
               fetch_shippingfee();
               $('#thongbao').html(data); 
               // alert('Thêm phí vận chuyển thành công!');
                }
            });
        });
        // blur chọn vào thoát ra là gọi blur
        $(document).on('blur','.edit_fee',function(){
            var sf_id = $(this).data('sf_id');
            var fee = $(this).text();
            var _token = $('input[name="_token"]').val();
            $.ajax({
            url : '{{url('/luu-fee')}}',
            method: 'POST',
            data:{sf_id:sf_id,fee:fee,_token:_token},
            success:function(data){  
               fetch_shippingfee();
               $('#thongbao').html(data); 
                }
            });
        
        });

});
</script>
{{-- Ảnh sản phẩm --}}
<script type="text/javascript">
    $(document).ready(function(){
        xem_asp();
        function xem_asp(){
            var id_sp = $('.id_sp').val();
            var _token = $('input[name="_token"]').val();
            $.ajax({
                //post qua select-anhsanpham 
                url:'{{url('select-anhsanpham')}}',
                method:"POST",
                data:{id_sp:id_sp,_token:_token},
                success:function(data){
                    //hiển thị function select_anhsanpham qua id load_anh
                    $('#load_anh').html(data);
                }
            });
        }  
    $('#file').change(function(){
        var error = '';
        var files = $('#file')[0].files;
        if(files.length==0){
            error+='<p>Bạn không được bỏ trống<p>';
        }else if(files.length>5){
            error+='<p>Bạn chỉ được chọn tối đa 5 ảnh</p>'; 
        }else if(files.size>2000000){
            // lớn hơn 2MB
            error+='<p>Ảnh không lớn hơn 2MB</p>';
        }
        if(error==''){

        }else{
            $('#file').val('');
            $('#error_anh').html('<span class="text-danger">'+error+'</span>');
            return false;
        }
        }); 
    $(document).on('blur','.edit_asp',function(){
            var asp_id = $(this).data('asp_id');
            var ten = $(this).text();
            var _token = $('input[name="_token"]').val();
            if(ten){
                $.ajax({
                url : '{{url('/capnhat-ten-asp')}}',
                method: 'POST',
                data:{asp_id:asp_id,ten:ten,_token:_token},
                success:function(data){  
                   xem_asp();
                   $('#error_anh').html('<span class="text-danger">Cập nhật tên hình ảnh thành công</span>');
                    }
                });
            }else{
                xem_asp();
                alert('ảnh sản phẩm không thể trống!');
            }
        });
    $(document).on('click','.delete-anh',function(){
            var asp_id = $(this).data('asp_id');
            var _token = $('input[name="_token"]').val();
            if(confirm('Bạn có chắc muốn xóa ảnh này không?')){
            $.ajax({
                url : '{{url('xoa-anhsanpham')}}',
                method: 'POST',
                data:{asp_id:asp_id,_token:_token},
                success:function(data){  
                   xem_asp();
                   $('#error_anh').html('<span class="text-danger">Xóa hình ảnh thành công</span>');
                }
            });
            }
        });
    });
</script>       
</body>
</html>
