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
        Transactions
        <small>Transaction History</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#active">Transactions</a></li>
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
                  <th>Amount</th>
                  <th>Method Type</th>
                  <th>Gateway</th>
                  <th>Date</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($transactions as $transaction)
                  <tr>
                    <td>{{$transaction->trxnnum}}</td>
                    <td>{{$transaction->User->name}}</td>
                    <td>{{number_format($transaction->amount,2)}}</td>
                    <td>{{$transaction->Methodtype->name}}</td>
                    <td>{{$transaction->Gateway->name}}</td>
                    <td>{{$transaction->created_at}}</td>
                    <td><a class="btn btn-primary" data-toggle="modal" data-target="#myModal{{$transaction->id}}" href="#">
                    <span class="fa fa-expand"></span></a></td>
                  </tr>


                    <!-- Modal -->
                  <div class="modal fade modal-lg col-lg-offset-2 col-lg-8" id="myModal{{$transaction->id}}" role="dialog">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                               <h4 class="modal-title">TRXN - {{$transaction->trxnnum}}</h4>
                            </div>
                              <div class="modal-body">
                                <div class="table table-bordered">
                                  <div class="col-md-6">Transaction ID:</div>
                                  <div class="col-md-6">{{$transaction->id}}</div>
                                </div>
                                <div class="table table-bordered">
                                  <div class="col-md-6">Transaction Number:</div>
                                  <div class="col-md-6">{{$transaction->trxnnum}}</div>
                                </div>
                                <div class="table table-bordered">
                                  <div class="col-md-6">Amount:</div>
                                  <div class="col-md-6">{{number_format($transaction->amount,2)}}</div>
                                </div>
                                <div class="table table-bordered">
                                  <div class="col-md-6">Gateway Type:</div>
                                  <div class="col-md-6">{{$transaction->Gateway->name}}</div>
                                </div>
                                <div class="table table-bordered">
                                  <div class="col-md-6">Method/Card Type:</div>
                                  <div class="col-md-6">{{$transaction->Methodtype->name}}</div>
                                </div>
                                <div class="table table-bordered">
                                  <div class="col-md-6">Merchant:</div>
                                  <div class="col-md-6">{{$transaction->User->name}}</div>
                                </div>
                                <div class="table table-bordered">
                                  <div class="col-md-6">IPN URL:</div>
                                  <div class="col-md-6">{{$transaction->callback_url}}</div>
                                </div>
                                <div class="table table-bordered">
                                  <div class="col-md-6">Date:</div>
                                  <div class="col-md-6">{{$transaction->created_at->format('d/m/Y g:i A')}}</div>
                                </div> 
                                <div class="table table-bordered">
                                  <div class="col-md-6">Gateway Trxn ID:</div>
                                  <div class="col-md-6">{{$transaction->gatewaytrxn_id}}</div>
                                </div>
                                <div class="table table-bordered">
                                  <div class="col-md-6">Merchant Unique ID:</div>
                                  <div class="col-md-6">{{$transaction->clientunique_id}}</div>
                                </div>
                                <div class="table table-bordered">
                                  <div class="col-md-6">Reference:</div>
                                  <div class="col-md-6">{{$transaction->reference}}</div>
                                </div>
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

</div>
<!-- ./wrapper -->

@endsection

@section('footer-resources')
  @include('layouts.resources.footer.transactions')
@endsection