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

              <form method="POST" action="">
                {{csrf_field()}}
                <div class="col-md-3">
                  <label>Transaction Number:</label>
                  <input type="text" name="trxnnum" class="form-control">
                </div>

                <div class="col-md-3">
                  <label>Gateway:</label>
                  <select name="gateway_id" class="form-control">
                    <option value="">SELECT</option>
                    @foreach($gateways as $gateway)
                    <option value="{{$gateway->id}}">{{$gateway->name}}</option>
                    @endforeach
                  </select>
                </div>

                <div class="col-md-3">
                  <label>Method:</label>
                  <select name="methodtype_id" class="form-control">
                    <option value="">SELECT</option>
                    @foreach($methods as $method)
                    <option value="{{$method->id}}">{{$method->name}}</option>
                    @endforeach
                  </select>
                </div>

                <div class="col-md-3">
                  <label>Merchant:</label>
                  <select name="user_id" class="form-control">
                    <option value="">SELECT</option>
                    @foreach($merchants as $mer)
                    <option value="{{$mer->id}}">{{$mer->name}}</option>
                    @endforeach
                  </select>
                </div>

                <div class="col-md-3">
                  <label>Status:</label>
                  <select name="status" class="form-control">
                    <option value="">SELECT</option>
                    <option value="SUCCESSFUL">SUCCESSFUL</option>
                    <option value="FAILED">FAILED</option>
                    <option value="CANCELED">CANCELED</option>
                    <option value="INITIATED">INITIATED</option>
                  </select>
                </div>

                <div class="col-md-3">
                  <label for="user">Start Date</label>
                  <input type="date" name="start_date" class="form-control">
                </div>

                <div class="col-md-3">
                  <label for="user">End Date</label>
                  <input type="date" name="end_date" class="form-control">
                </div>

                <div class="col-md-3 text-center">
                  <br><br>
                  <button type="submit" class="btn bg-purple btn-flat">SEARCH</button>
                  <br><br>
                </div>

              </form>


              <table id="" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>Transaction Number</th>
                  <th>Merchant</th>
                  <th>Amount</th>
                  <th>Method Type</th>
                  <th>Gateway</th>
                  <th>Date</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($transactions as $transaction)
                  <tr>
                    <td>{{$transaction->trxnnum}}</td>
                    <td>{{$transaction->User->name}}</td>
                    <td>{{$transaction->Transactiondetail->Currency->code}} {{number_format($transaction->Transactiondetail->subtotal,2)}}</td>
                    <td>{{$transaction->Transactiondetail->Methodtype->name}}</td>
                    <td>{{$transaction->Transactiondetail->Gateway->name}}</td>
                    <td>{{$transaction->created_at->format('d F Y g:i A')}}</td>
                    <td>
                      @if($transaction->status == 'SUCCESSFUL')
                        <button class="btn btn-xs btn-success">{{$transaction->status}}</button>
                      @elseif($transaction->status == 'FAILED')
                        <button class="btn btn-xs btn-warning">{{$transaction->status}}</button>
                      @elseif($transaction->status == 'REJECTED')
                        <button class="btn btn-xs btn-danger">{{$transaction->status}}</button>
                      @else
                        <button class="btn btn-xs btn-default">{{$transaction->status}}</button>
                      @endif
                    </td>
                    <td><a class="btn btn-xs btn-primary" onclick="show({{$transaction->id}}, 'transactions')"><span class="fa fa-expand"></span></a></td>
                  </tr>      
                @endforeach
                </tbody>
              </table>
              <div class="col-md-3 col-md-offset-9">{{ $transactions->links() }}</div>
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

</div>
<!-- ./wrapper -->

@endsection

@section('footer-resources')
  @include('layouts.resources.footer.transactions')
@endsection