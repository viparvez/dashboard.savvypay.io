@extends('layouts.main')

@section('header-resources')
  @include('layouts.resources.header.transactions')
@endsection

@section('content')
<div class="wrapper">


 @include('layouts.nav.header')

 @include('layouts.nav.sidebar')

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Users
        <small>User Management</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Users</a></li>
        <li class="active">List Users</li>
      </ol>
    </section>

    <div style="padding: 20px">
      <button type="button" class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#myModal">+ Create New</button>
    </div>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Status</th>
                  <th>Registered On</th>
                  <th>Type</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                  <tr>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>
                      @if($user->active == 1)
                        <span class="btn btn-success btn-xs">Active</span>
                      @else
                        <span class="btn btn-danger btn-xs">Inactive</span>
                      @endif
                    </td>
                    <td>{{$user->created_at}}</td>
                    <td>
                      @if($user->api_user == '1')
                        <span class="btn btn-xs bg-purple btn-flat">API USER</span>
                      @else
                        <span class="btn btn-xs bg-orange btn-flat">MERCHANT USER</span>
                      @endif
                    </td>
                    <td><a class="btn btn-xs btn-primary" onclick="show('{{route('users.show',$user->id)}}')"><span class="fa fa-expand"></span></a></td>
                  </tr>
               @endforeach
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>


  <div class="modal fade" id="myModal" role="dialog">
      <div class="modal-dialog modal-lg">
      
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Add New User</h4>
          </div>
          <div class="modal-body">
            <div class="alert alert-danger print-error-msg" style="display:none">
              <ul></ul>
            </div>
            <form id="create" method="POST" action="{{route('users.store')}}" enctype="multipart/form-data">
            {{csrf_field()}}

            <div class="col-md-6 col-xs-12">
              <div class="form-group">
                <label for="name">Full Name:</label>
                <input type="text" name="name" class="form-control" required="" placeholder="Name">
              </div>

              <div class="form-group" id="email">
                <label for="email">Email:</label>
                <input type="text" name="email"  class="form-control" required="" placeholder="Email">
              </div>

              <div class="form-group" id="username">
                <label for="username">Username:</label>
                <input type="text" name="username"  class="form-control" required="" placeholder="Username">
              </div>

              <div class="form-group">
                <label>Password:</label>
                <input type="password" name="password" class="form-control" required="" placeholder="Password">
              </div>

              <div class="form-group">
                <label>Password Confirmation:</label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="Retype Password" required>
              </div>

              <div class="form-group">
                <label for="status">Status:</label>
                <select class="form-control" name="active">
                  <option value="1" selected>Active</option>
                  <option value="0">Inactive</option>
                </select>
              </div>

              <div class="form-group">
                <label for="user type">API User?</label>
                <select class="form-control" name="api_user" id="api_user">
                  <option value="1">Yes</option>
                  <option value="0" selected>No</option>
                </select>
              </div>

              <div class="form-group" id="merchantOps" hidden="">
                <label for="country">Merchant Account:</label>
                <select class="form-control" name="merchant_user_id">
                  <option value="">SELECT</option>
                  @foreach($merchants as $merchant)
                  <option value="{{$merchant->id}}">{{$merchant->name}}</option>
                  @endforeach
                </select>
              </div>
              
              <div class="form-group" id="phone">
                <label for="phone">Phone:</label>
                <input type="phone" name="phone" class="form-control" required="" placeholder="Phone">
              </div>

              <div class="form-group">
                <div id="api_user_search"></div>
                <a href="" id="addApiuser" data-toggle="modal" data-target="#secondOrderPrev">ADD API USERS</a>   
              </div>

            </div>
              
            <div class="col-md-6 col-xs-12">

              <div class="form-group">
                <label for="address">Address Line 1:</label>
                <input type="text" name="line1" class="form-control" required="" placeholder="Address Line 1">
              </div>

              <div class="form-group">
                <label for="address">Address Line 2:</label>
                <input type="text" name="line2" class="form-control" required="" placeholder="Address Line 2">
              </div>

              <div class="form-group">
                <label for="post office">Post Office:</label>
                <input type="text" name="po" class="form-control" required="" placeholder="Post Office">
              </div>

              <div class="form-group">
                <label for="postal code">Postal Code:</label>
                <input type="text" name="pocode" class="form-control" required="" placeholder="Postal Code">
              </div>

              <div class="form-group">
                <label for="area">Area:</label>
                <input type="text" name="area" class="form-control" required="" placeholder="Area">
              </div>

              <div class="form-group">
                <label for="city">City:</label>
                <input type="text" name="city" class="form-control" required="" placeholder="City">
              </div>

              <div class="form-group">
                <label for="country">Country:</label>
                <select class="form-control" name="country">
                  <option value="Bangladesh" selected>Bangladesh</option>
                </select>
              </div>


              <div class="form-group">
                <label>Image</label>
                <input type="file" name="image" id="image" >
              </div>

            </div>

            <button class='btn btn-block btn-success btn-sm' id='submit' type='submit'>SAVE</button>
            <button class='btn btn-block btn-success btn-sm' id='loading' style='display: none' disabled=''>Working...</button>
            </form>
          </div>
        </div>
        
      </div>
    </div>



  <div class="modal fade" id="preview" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">

        <div class='modal-header'>
          <button type='button' class='close' data-dismiss='modal'>&times;</button>
        </div>
        <div class='alert alert-danger print-error-msg' id='error_messages' style='display:none'>
          <ul></ul>
        </div>
        <div class="text-center">
          <img src="{{url('/')}}/public/img/spinner.gif" id="spinner">
        </div>

        <div id="showcontent">
          
        </div>

      </div>
    </div>
  </div>


    <div class="modal fade" id="secondOrderPrev" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="show">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="alert alert-danger print-error-msg" id="error_messages_2" style="display:none">
                <ul></ul>
            </div>
            <div id="showcontent_2">
              <form id="user_search" method="POST" action="{{route('users.apisearch')}}">
              {{csrf_field()}}
                <div class="form-group">
                  <label for="name">User Name</label>
                  <input type="text" name="username" class="form-control" required="" placeholder="User Name">
                </div>
                <button class='btn btn-block btn-success btn-sm' id='submit_search' type='submit_search'>Submit</button>
                <button class='btn btn-block btn-success btn-sm' id='loading' style='display: none' disabled=''>Working...</button>
              </form>
            </div>
            
          </div>
        </div>
      </div>
    </div>

  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.3.8
    </div>
    <strong>Copyright &copy; 2014-2016 <a href="http://almsaeedstudio.com">Almsaeed Studio</a>.</strong> All rights
    reserved.
  </footer>

  
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

 @endsection

@section('footer-resources')
  @include('layouts.resources.footer.transactions')

  <script type="text/javascript">
  /*
Function for new data insertion\
*/

$(document).ready(function() {

      $("#submit_search").click(function(e){

        e.preventDefault();

        var _url = $("#user_search").attr("action");

        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });

        var _data = new FormData($('#user_search')[0]);

          $.ajax({

              url: _url,

              type:'POST',

              dataType:"json",

              data:_data,

              processData: false,
              
              contentType: false,

              success: function(data) {
                  
                  $('#result').html("");
                  $('.print-error-msg').css("display","none");

                  if($.isEmptyObject(data.error)){

                    if($("#"+data.success.id).length) {

                      alert('Already added.')

                    } else {

                      $('#api_user_search').append( 
                        "<div id='"+data.success.id+"'> <input type='hidden' name='api_user_id[]' value='"+data.success.id+"'><strong>"+data.success.username+"</strong> <button onclick='removeUser("+data.success.id+")' class='btn btn-xs btn-danger'>X</button></div>" 
                        );

                    }

                  }else{

                    printErrorMsg(data.error);

                  }

              }

          });

      }); 


      $(document).ajaxStart(function () {
          $("#loading").show();
          $("#submit_search").hide();
      }).ajaxStop(function () {
          $("#loading").hide();
          $("#submit_search").show();
      });

  });

  setTimeout(function() {
      $('#successMessage').fadeOut('fast');
  }, 2000); 


  function printErrorMsg_2 (msg) {
    $(".print-error-msg").find("ul").html('');
    $(".print-error-msg").css('display','block');
    $.each( msg, function( key, value ) {
      $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
    });

  }

  function removeUser(id) {
    $('#'+id).remove();
  }

</script>
@endsection