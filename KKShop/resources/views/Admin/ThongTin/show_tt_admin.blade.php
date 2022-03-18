
@extends('admin_layout')<!--mo rong call file layout -->
@section('admin_content')<!--tao section home -->

<div class="table-agile-info" >
  <div class="panel panel-default" style="width: 60%; margin-left: 20%;">
    <div class="panel-heading" style="background-color: #f2b10c ! important;">
      Thông Tin ADMIN {{session::get('admin_name')}}
    </div>
    <?php
      $message = Session::get('message');
      if($message){
        echo '<span class="error_login">' .$message. '</span>';
        Session::put('message',null);
      }
    ?>

    <div class="table-responsive">
      <table class="table table-striped b-t b-light">
        <tr>
          <td style="width: 20%;"><b>ID</b></td>
          <td>{{$profile->admin_id}}</td>
          <td style="width: 5%;">
             <a href="{{URL::to('/sua-profile-admin')}}" class="active styling_edit" ui-toggle-class="">
                <i class="fa fa-pencil"></i>
              </a>
          </td>
        </tr>
        <tr>
          <td><b>Họ và tên</b></td>
          <td>{{$profile->admin_name}}</td>
        </tr>
        <tr>
          <td><b>Email</b></td>
          <td>{{$profile->admin_email}}</td>
        </tr>
        <tr>
          <td><b>SĐT</b></td>
          <td>{{$profile->admin_phone}}</td>
        </tr>
        
        </tbody>
      </table>
    </div>
    </div>   
  </div>
@endsection