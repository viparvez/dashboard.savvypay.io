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
        Create a Refund Request
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Refunds</a></li>
        <li class="active">Create Refund Request</li>
      </ol>
    </section>

    <div style="padding: 20px">
      <button type="button" class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#myModal">+ New</button>
    </div>
  
  </div>

  <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
      <div class="modal-dialog">
      
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Refund Request</h4>
          </div>
          <div class="modal-body">
            <div class="alert alert-danger print-error-msg" style="display:none">
              <ul></ul>
            </div>
            <form id="refund_search" method="POST" action="">
            {{csrf_field()}}
              <div class="form-group">
                <label for="name">Transaction Number:</label>
                <input type="text" name="trxnnum" class="form-control" required="" placeholder="Transaction Number">
              </div>
              <div class="form-group">
                
              </div>
              <button class='btn btn-block btn-success btn-sm' id='submit' type='submit'>SAVE</button>
              <button class='btn btn-block btn-success btn-sm' id='loading' style='display: none' disabled=''>Working...</button>
            </form>
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
  @include('layouts.resources.footer.table')
@endsection