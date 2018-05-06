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
                  <th>Phone</th>
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
                        <span class="btn btn-success btn-small">Active</span>
                      @else
                        <span class="btn btn-danger btn-small">Inactive</span>
                      @endif
                    </td>
                    <td>{{$user->created_at}}</td>
                    <td>{{$user->phone}}</td>
                    <td><a class="btn btn-default" data-toggle="modal" data-target="#myModal{{$user->id}}" href="#">
                    <span class="fa fa-edit"> EDIT</span></a></td>
                  </tr>

                    <!-- Modal -->
                      <div class="row modal fade modal-lg col-lg-offset-2 col-lg-8" id="myModal{{$user->id}}" role="dialog">
                        <!-- left column -->
                        <div class="col-md-12">

                          <div class="col-md-6 col-md-offset-3">
                            <img src="{{$user->logo_url}}" class="img-thumbnail" alt="Cinque Terre" width="200px" height="200px">
                          </div>
                          <!-- general form elements -->
                          <form role="form" name="updateuser" action="{{route('updateUser',['id'=>$user->id])}}" method="POST" enctype="multipart/form-data">
                            <div class="box box-primary">
                                <div class="box-body">
                                  <div class="col-md-6">
                                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                                    <input type="hidden" name="id" value="{{$user->id}}">
                                    <div class="form-group">
                                      <label for="name">Name</label>
                                      <input type="text" class="form-control" id="name" name="name" value="{{$user->name}}" readonly="">
                                    </div>


                                      <div class="form-group">
                                        <label for="email">Email address</label>
                                        <input type="email" class="form-control" id="email" name="email" value="{{$user->email}}" readonly="">
                                    </div>

                                    <div class="form-group">
                                      <label for="phone">Phone Number</label>
                                      <input type="text" class="form-control" id="phone" name="phone" value="{{$user->phone}}">
                                    </div>

                                    <div class="form-group">
                                      <label for="line1">Address Line 1</label>
                                      <input type="text" class="form-control" id="line1" name="line1" value="{{$user->line1}}" required="">
                                    </div>

                                    <div class="form-group">
                                      <label for="line2">Address Line 2</label>
                                      <input type="text" class="form-control" id="line2" name="line2" value="{{$user->line2}}">
                                    </div>

                                  </div>

                                  <div class="col-md-6">

                                    <div class="form-group">
                                      <label for="postoffice">Post Office</label>
                                      <input type="text" class="form-control" id="postoffice" name="po" value="{{$user->po}}" required="">
                                    </div>

                                    <div class="form-group">
                                      <label for="postalcode">Postal Code</label>
                                      <input type="text" class="form-control" id="postalcode" name="pocode" value="{{$user->pocode}}" required="">
                                    </div>

                                    <div class="form-group">
                                      <label for="area">Area</label>
                                      <input type="text" class="form-control" id="area" name="area" value="{{$user->area}}" required="">
                                    </div>

                                    <div class="form-group">
                                      <label for="city">City</label>
                                      <input type="text" class="form-control" id="city" name="city" value="{{$user->city}}" required="">
                                    </div>

                                    <div class="form-group">
                                      <label for="country">Country</label>
                                      <input type="text" class="form-control" id="country" name="country" value="{{$user->country}}" required="">
                                    </div>

                                    <div class="checkbox">
                                    @if($user->active == 1)
                                      <input type="radio" name="active" value="1" checked> ACTIVE
                                      <input type="radio" name="active" value="0"> NOT ACTIVE
                                    @else
                                      <input type="radio" name="active" value="1"> ACTIVE
                                      <input type="radio" name="active" value="0" checked=""> NOT ACTIVE
                                    @endif
                                    </div>
                                  </div>

                                </div>
                                <!-- /.box-body -->

                                <div class="box-footer">
                                  <button type="submit" class=" btn btn-primary">UPDATE</button>
                                  <div class="col-md-10"></div>
                                </div>
                            </form>
                          </div>
                          <!-- /.box -->
                        </div>
                        <!--/.col (right) -->
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                      </div>
                      <!-- /.row -->

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
@endsection