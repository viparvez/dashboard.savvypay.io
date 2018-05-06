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

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <!-- form start -->
          <form role="form" name="RefundReq" action="{{route('refReq')}}" method="POST">
            <div class="col-md-4 col-md-offset-4">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <div class="form-group">
                      <input type="text" class="form-control" id="trxnnum" name="trxnnum" placeholder="Entern Transaction Number" required="">
                    </div>

                    <div class="form-group text-center">
                      <button class="btn btn-warning" type="submit">Submit</button>
                    </div>
            </div>
          </form>          <!-- /.box -->
        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </section>
  
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