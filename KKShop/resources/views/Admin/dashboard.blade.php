@extends('admin_layout')<!--mo rong call file layout -->
@section('admin_content')<!--tao section home -->
 <h3 style="color:white;">chào mừng {{Session::get('admin_name')}} đến với admin</h3>
@endsection
		