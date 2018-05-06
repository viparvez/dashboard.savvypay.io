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
        Gateways
        <small>Gateways</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Settings</a></li>
        <li class="active">Gateways</li>
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
                  <th>ID</th>
                  <th>Name</th>
                  <th>Status</th>
                  <th>Created</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($gateways as $indexKey => $gateway)
                  <tr>
                    <td>{{$indexKey+1}}</td>
                    <td>{{$gateway->name}}</td>
                    <td>
                      @if($gateway->active == '1')
                        <span class="btn btn-success btn-xs">Active</span>
                      @elseif($gateway->active == '0')
                        <span class="btn btn-danger btn-xs">INACTIVE</span>
                      @else
                      @endif
                    </td>
                    <td>{{$gateway->created_at}}</td>
                    <td><button type="button" class="btn btn-default btn-sm pull-right" data-toggle="modal" data-target="#myModal{{$gateway->id}}">EDIT</button></td>
                  </tr>


                  <!-- Modal -->
                    <div class="modal fade" id="myModal{{$gateway->id}}" role="dialog">
                      <div class="modal-dialog">
                      
                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal{{$gateway->id}}">&times;</button>
                            <h4 class="modal-title">EDIT: {{$gateway->name}}</h4>
                          </div>
                          <div class="modal-body">
                            <form name="gateway" method="POST" action="{{route('UpdateGateway')}}">
                            {{csrf_field()}}
                              <input type="hidden" name="id" value="{{$gateway->id}}">
                              <div class="form-group">
                                <label for="name">Name:</label>
                                <input type="text" name="name" class="form-control" required="" placeholder="Name" value="{{$gateway->name}}">
                              </div>
                              <div class="form-group">
                                <label for="name">Status:</label>
                                <select class="form-control" name="active">
                                  <option value="1">Active</option>
                                  <option value="0">Inactive</option>
                                </select>
                              </div>
                              <button class="btn btn-sm btn-info">SAVE</button>
                            </form>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                        
                      </div>
                    </div>


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


  <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
      <div class="modal-dialog">
      
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Add New Gateway</h4>
          </div>
          <div class="modal-body">
            <form name="gateway" method="POST" action="{{route('SaveGateway')}}">
            {{csrf_field()}}
              <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" name="name" class="form-control" required="" placeholder="Name">
              </div>
              <div class="form-group">
                <label for="name">Status:</label>
                <select class="form-control" name="active">
                  <option value="1">Active</option>
                  <option value="0">Inactive</option>
                </select>
              </div>
              <button class="btn btn-sm btn-info">SAVE</button>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
@endsection