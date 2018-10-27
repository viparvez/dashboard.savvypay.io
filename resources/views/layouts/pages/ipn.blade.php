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
        IPN
        <small>IPN</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Settings</a></li>
        <li class="active">IPN</li>
      </ol>
    </section>
    
    <!-- Main content -->

    <!-- Section 1-->

    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>#</th>
                  <th>API User Name</th>
                  <th>IPN URL</th>
                  <th>IPN Phone</th>
                  <th>IPN Email</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($merchantapiusers as $indexKey => $ipn)
                  <tr>
                    <td>{{$indexKey+1}}</td>
                    <td>{{$ipn->api_user}}</td>
                    <td>
                      @if(empty($ipn->ipn_url))
                        <i>NOT SET</i>
                      @else
                        {{$ipn->ipn_url}}
                      @endif
                    </td>
                    <td>
                      @if(empty($ipn->ipn_phone))
                        <i>NOT SET</i>
                      @else
                        {{$ipn->ipn_phone}}
                      @endif
                    </td>
                    <td>
                      @if(empty($ipn->ipn_email))
                        <i>NOT SET</i>
                      @else
                        {{$ipn->ipn_email}}
                      @endif
                    </td>
                    <td><a class="btn btn-xs btn-primary" onclick="show('{{route('ipn.show',$ipn->api_user_id)}}')"><span class="fa fa-expand"></span></a></td>
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