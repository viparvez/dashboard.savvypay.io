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
        Settlement
        <small>Rules</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Settlement Rules</a></li>
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
                  <th>Name</th>
                  <th>Method Type</th>
                  <th>Billing Type</th>
                  <th>Chargable Value</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($rules as $rule)
                  <tr>
                    <td>{{$rule->name}}</td>
                    <td>{{$rule->Methodtype->name}}</td>
                    <td>{{$rule->bill_policy}}</td>
                    <td>{{$rule->amount}}</td>
                    <td><button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal{{$rule->id}}">EDIT</button></td>
                  </tr>


                  <!-- Modal -->
                    <div class="modal fade" id="myModal{{$rule->id}}" role="dialog">
                      <div class="modal-dialog">
                      
                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">{{$rule->name}}</h4>
                          </div>
                          <div class="modal-body">
                            <form name="settlementruleupdate" method="POST" action="{{route('updateSettlementrules')}}">
                            {{csrf_field()}}
                            <input type="hidden" name="id" value="{{$rule->id}}">
                              <div class="form-group">
                                <label for="name">Name:</label>
                                <input type="text" name="name" class="form-control" required="" placeholder="Name" value="{{$rule->name}}" disabled>
                              </div>
                              <div class="form-group">
                                <label for="methodtype">Method Type:</label>
                                <select name="methodtype_id" class="form-control" required="" disabled="">
                                @foreach($methodtypes as $methodtype)
                                  
                                    @if($rule->Methodtype->name == $methodtype->name)
                                      <option value="{{$methodtype->id}}" selected>{{$methodtype->name}}</option>
                                    @else
                                      <option value="{{$methodtype->id}}">{{$methodtype->name}}</option>
                                    @endif
                                  
                                @endforeach
                                </select>
                              </div>
                              <div class="form-group">
                                <label for="billing_policy">Billing Policy</label>
                                <select name="bill_policy" class="form-control" required="">
                                  @if($rule->bill_policy == 'PERCENTAGE')
                                    <option value="PERCENTAGE" SELECTED>PERCENTAGE</option>
                                    <option value="AMOUNT">FIXED AMOUNT</option>
                                  @elseif($rule->bill_policy == 'AMOUNT')
                                    <option value="PERCENTAGE">PERCENTAGE</option>
                                    <option value="AMOUNT" SELECTED>FIXED AMOUNT</option>
                                  @else
                                  @endif
                                </select>
                              </div>
                              <div class="form-group">
                                <label for="amount">Value</label>
                                <input type="text" name="amount" class="form-control" required="" placeholder="Value" value="{{$rule->amount}}">
                              </div>
                              <div class="text-center">
                                <button class="btn btn-sm btn-info">SAVE</button>
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
            <h4 class="modal-title">Create New Settlement Rule</h4>
          </div>
          <div class="modal-body">
            <form name="methodtype" method="POST" action="{{route('saveSettlementrules')}}">
            {{csrf_field()}}
              <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" name="name" class="form-control" required="" placeholder="Name">
              </div>
              <div class="form-group">
                <label for="methodtype">Method Type:</label>
                <select name="methodtype_id" class="form-control" required="">
                @foreach($methodtypes as $methodtype)
                  <option value="{{$methodtype->id}}">{{$methodtype->name}}</option>
                @endforeach
                </select>
              </div>
              <div class="form-group">
                <label for="billing_policy">Billing Policy</label>
                <select name="bill_policy" class="form-control" required="">
                  <option value="PERCENTAGE">PERCENTAGE</option>
                  <option value="AMOUNT">FIXED AMOUNT</option>
                </select>
              </div>
              <div class="form-group">
                <label for="amount">Value</label>
                <input type="text" name="amount" class="form-control" required="" placeholder="Value">
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