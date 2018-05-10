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
                    <td><a class="btn btn-xs btn-primary" onclick="show('{{route('gateways.show',$gateway->id)}}')"><span class="fa fa-expand"></span></a></td>
                  </tr>
                @endforeach
                </tbody>
              </table>
              <div class="col-md-3 col-md-offset-9">{{ $gateways->links() }}</div>
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
            <div class="alert alert-danger print-error-msg" style="display:none">
              <ul></ul>
            </div>
            <form id="create" method="POST" action="{{route('gateways.store')}}">
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

  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 1.9.0
    </div>
    <strong>Copyright &copy; {{date('Y')}} <a target="_blank" href="http://www.savvypay.io">Savvypay</a>.</strong> All rights
    reserved.
  </footer>

  
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

 @endsection

@section('footer-resources')
  @include('layouts.resources.footer.transactions')
@endsection