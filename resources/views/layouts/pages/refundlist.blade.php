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
        Refunds
        <small>Refund History</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Refinds</a></li>
        <li class="active">List Refunds</li>
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
                  <th>Transaction Number</th>
                  <th>Merchant</th>
                  <th>Status</th>
                  <th>Amount</th>
                  <th>Refunded Amount</th>
                  <th>Last Updated</th>
                  <th>Gateway</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($refunds as $refund)
                  <tr>
                    <td>{{$refund->Transaction->trxnnum}}</td>
                    <td>{{$refund->Transaction->User->name}}</td>
                    <td>
                      @if($refund->status == 'REQUESTED')
                        <span class="btn btn-default btn-xs">{{$refund->status}}</span>
                      @elseif($refund->status == 'PROCESSED')
                        <span class="btn btn-success btn-xs">{{$refund->status}}</span>
                      @else
                        <span class="btn btn-danger btn-xs">{{$refund->status}}</span>
                      @endif
                    </td>
                    <td>&#2547 {{number_format($refund->Transaction->amount,2)}}</td>
                    <td>&#2547 {{number_format($refund->refd_amount,2)}}</td>
                    <td>{{$refund->updated_at}}</td>
                    <td>{{$refund->Transaction->Gateway->name}}</td>
                    <td><a class="btn btn-primary" data-toggle="modal" data-target="#myModal{{$refund->id}}" href="#">
                    <span class="fa fa-expand "></span></a></td>
                  </tr>


                  <!-- Modal -->
                  <div class="modal fade modal-lg col-lg-offset-2 col-lg-8" id="myModal{{$refund->id}}" role="dialog">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                               <h4 class="modal-title">TRXN - {{$refund->Transaction->trxnnum}}</h4>
                            </div>
                              <div class="modal-body">
                                <p><b>Transaction Number:</b>{{$refund->Transaction->trxnnum}}</p>
                                <p><b>Amount: </b>{{number_format($refund->Transaction->amount,2)}}</p>
                                <p><b>Status: </b>{{$refund->status}}</p>
                                <p><b>Merchant: </b>{{$refund->Transaction->User->name}}</p>
                                <p><b>Gateway: </b>{{$refund->Transaction->Gateway->name}}</p>
                                <p><b>Requested on: </b>{{$refund->created_at->format('d/m/Y g:i A')}}</p>
                                <p><b>Updated on: </b>{{$refund->updated_at->format('d/m/Y g:i A')}}</p>
                                <p><b>Gateway Trxn ID: </b>{{$refund->Transaction->gatewaytrxn_id}}</p>
                                <p><b>Merchant Unique ID: </b>{{$refund->Transaction->clientunique_id}}</p>
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