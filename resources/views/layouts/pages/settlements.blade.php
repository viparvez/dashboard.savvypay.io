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
        Settlements
        <small>Settlements History</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Settlements</a></li>
        <li class="active">List Settlements</li>
      </ol>
    </section>

    <div style="padding: 20px">
      <button type="button" class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#myModal">New Settlement Request</button>
    </div>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              


              <table id="example2" class="table table-bordered table-hover">
                 <thead>
                 <tr>
                   <th>Invoice No.</th>
                   <th>User</th>
                   <th>Total Amount</th>
                   <th>Total Charged</th>
                   <th>Total Creditable</th>
                   <th>Status</th>
                   <th>Action</th>
                 </tr>
                 </thead>
                 <tbody>
                 @foreach($settlements as $settlement)
                   <tr>
                     <td>INV - {{sprintf('%08d',$settlement->invCode)}}</td>
                     <td>{{$settlement->User->name}}</td>
                     <td>&#2547 {{number_format($settlement->GrandTotalAmount,2)}}</td>
                     <td>&#2547 {{number_format($settlement->TotalChargable,2)}}</td>
                     <td>&#2547 {{number_format($settlement->TotalCreditable,2)}}</td>
                     <td>
                       @if($settlement->status == 'REQUESTED')
                         <span class="btn btn-default btn-xs">{{$settlement->status}}</span>
                       @elseif($settlement->status == 'PROCESSED')
                         <span class="btn btn-success btn-xs">{{$settlement->status}}</span>
                       @else
                         <span class="btn btn-danger btn-xs">{{$settlement->status}}</span>
                       @endif
                     </td>
                     <td><a class="btn btn-primary" data-toggle="modal" data-target="#myModal{{$settlement->id}}" href="#">
                     <span class="fa fa-expand "></span></a>

                    <a class="btn btn-primary" target="_blank" href="{{route('showInvoice',$settlement->invCode)}}"><span class="fa fa-eye "></span></a>
                     </td>
                   </tr>


                   <!-- Modal -->
                   <div class="modal fade modal-lg col-lg-offset-2 col-lg-8" id="myModal{{$settlement->id}}" role="dialog">
                       <div class="modal-dialog">
                         <div class="modal-content">
                           <div class="modal-header">
                             <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">INV -  {{sprintf('%08d',$settlement->invCode)}}</h4>
                           </div>

                               <div class="modal-body">
                                 <p><b>Invoice: </b>INV - {{sprintf('%08d',$settlement->invCode)}}</p>
                                 <p><b>Merchant: </b>{{$settlement->User->name}}</p>
                                 <p><b>Total Amount: &#2547 {{number_format($settlement->GrandTotalAmount,2)}}</b></p>
                                 <p><b>Total Charged: &#2547 {{number_format($settlement->TotalChargable,2)}}</b></p>
                                 <p><b>Total Creditable: &#2547 {{number_format($settlement->TotalCreditable,2)}}</b></p>
                                 <p><b>Status: 
                                    @if($settlement->status == 'REQUESTED')
                                      <span class="btn btn-default btn-xs">{{$settlement->status}}</span>
                                    @elseif($settlement->status == 'PROCESSED')
                                      <span class="btn btn-success btn-xs">{{$settlement->status}}</span>
                                    @else
                                      <span class="btn btn-danger btn-xs">{{$settlement->status}}</span>
                                    @endif
                                 </p>
                                 <p><b>Estimated Date: </b>{{$settlement->estim_setldate}}</p>
                                 <p><b>Requested on: </b>{{$settlement->created_at}}</p>
                                 <p><b>Updated on: </b>{{$settlement->updated_at}}</p>

                                 <form method="POST" action="{{route('settle')}}" name="settlement-adjustment">
                                   <input type="hidden" name="_token" value="{{csrf_token()}}">
                                   <input type="hidden" name="settlement_id" value="{{$settlement->id}}">
                                   <input type="hidden" name="status" value="PROCESSED">
                                   <label for="Notes"> Note:</label>
                                   <textarea class="form-control"  name="note" required></textarea><br>
                                   <div class="col-md-3 col-md-offset-4 text-center">
                                     <button type="submit" class="btn btn-success pull-right" placeholder="Notes">Settle</button>
                                   </div>
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


                <div class="modal fade" id="myModal" role="dialog">
                  <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Settlement Process</h4>
                      </div>
                      <div class="modal-body">
                        <form name="settlementprocess" method="POST" action="{{route('createSettlement')}}">
                        {{csrf_field()}}
                          <div class="form-group">
                            <label for="user">User Name</label>
                            <select name="user_id" class="form-control" required="">
                              <option value=""></option>
                            @foreach($users as $user)
                              <option value="{{$user->id}}">{{$user->name}}</option>
                            @endforeach
                            </select>
                          </div>
                          <div class="form-group">
                            <label for="user">Start Date</label>
                            <input type="date" name="start_date" class="form-control" required>
                          </div>
                          <div class="form-group">
                            <label for="user">End Date</label>
                            <input type="date" name="end_date" class="form-control" required>
                          </div>
                          <button class="btn btn-sm btn-info"><span class="fa fa-gear"></span> GENERATE</button>
                        </form>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      </div>
                    </div>
                    
                  </div>
                </div>



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