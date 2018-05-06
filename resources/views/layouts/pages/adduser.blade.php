@extends('layouts.main')

@section('header-resources')
  @include('layouts.resources.header.table')
@endsection

@section('content')
<div class="wrapper">

 @include('layouts.nav.header')

 @include('layouts.nav.sidebar')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Add a User to the System
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Users</a></li>
        <li class="active">Add User</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <!-- form start -->
          <form role="form" name="adduser" action="{{route('addUser')}}" method="POST" enctype="multipart/form-data">
            <div class="box box-primary">
                <div class="box-body">

                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">

                  <div class="col-md-6">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <div class="form-group">
                      <label for="name">Name</label>
                      <input type="text" class="form-control" id="name" name="name" placeholder="Entern name">
                    </div>

                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                      <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter email">
                        @if ($errors->has('email'))
                          <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                          </span>
                        @endif
                    </div>
                    </div>

                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                      <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                        @if ($errors->has('password'))
                          <span class="help-block">
                            <strong style="color: red">{{ $errors->first('password') }}</strong>
                          </span>
                        @endif
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="password-confirm">Confirm Password</label>
                      <input type="password" class="form-control" id="password-confirm" name="password_confirmation" placeholder="Re enter password">
                    </div>

                    <div class="form-group">
                      <label for="phone">Phone Number</label>
                      <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone">
                    </div>

                    <div class="form-group">
                      <label for="line1">Address Line 1</label>
                      <input type="text" class="form-control" id="line1" name="line1" placeholder="Address Line 1">
                    </div>

                    <div class="form-group">
                      <label for="line2">Address Line 2</label>
                      <input type="text" class="form-control" id="line2" name="line2" placeholder="Address Line 2">
                    </div>

                  </div>

                  <div class="col-md-6">

                    <div class="form-group">
                      <label for="postoffice">Post Office</label>
                      <input type="text" class="form-control" id="postoffice" name="po" placeholder="Post Office">
                    </div>

                    <div class="form-group">
                      <label for="postalcode">Postal Code</label>
                      <input type="text" class="form-control" id="postalcode" name="pocode" placeholder="Postal Code">
                    </div>

                    <div class="form-group">
                      <label for="area">Area</label>
                      <input type="text" class="form-control" id="area" name="area" placeholder="Area">
                    </div>

                    <div class="form-group">
                      <label for="city">City</label>
                      <input type="text" class="form-control" id="city" name="city" placeholder="City">
                    </div>

                    <div class="form-group">
                      <label for="country">Country</label>
                      <input type="text" class="form-control" id="country" name="country" placeholder="Country">
                    </div>

                    <div class="form-group">
                      <label for="logo">Upload Logo</label>
                      <input type="file" id="logo" name="logo">
                    </div>

                    <div class="checkbox">
                      <input type="radio" name="active" value="1"> ACTIVE
                      <input type="radio" name="active" value="0"> NOT ACTIVE
                    </div>
                  </div>

                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                  <button type="submit" class=" btn btn-primary">Submit</button>
                  <div class="col-md-3"></div>
                </div>
            </form>
          </div>
          <!-- /.box -->
        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
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
  @include('layouts.resources.footer.table')
@endsection