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
        Merchant Rules
        <small>Settlement Rules for Merchants</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Settlements</a></li>
        <li class="active">Merchant Settlements</li>
      </ol>
    </section>

    <div style="padding: 20px">
      <button type="button" class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#myModal">Add Merchant Rule</button>
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

              <table class="table table-bordered">
                <thead>
                  <th>ID</th>
                  <th>User</th>
                  <th>Settlement Rules</th>
                  <th>Action</th>
                </thead>
                <tbody>
                @foreach($availed_users as $indexKey => $avuser)
                  <tr>
                  <td>{{$indexKey + 1}}</td>
                    <td>{{$avuser->name}}</td>
                    <td>
                      <b>&nbsp; | &nbsp;</b>
                      @foreach($avuser->merchantrule as $rule)
                        <a href="#" data-toggle="tooltip" title="{{$rule->Settlementrule->Methodtype->name}} - {{$rule->Settlementrule->amount}}
                         @if($rule->Settlementrule->bill_policy == 'PERCENTAGE')
                          %
                         @elseif($rule->Settlementrule->bill_policy == 'AMOUNT')
                          PER TRANSACTION
                         @endif
                         ">
                          {{$rule->Settlementrule->name}}
                        </a>
                        <b>&nbsp; | &nbsp;</b>
                      @endforeach
                    </td>
                    <td>
                      <a class="btn btn-info btn-sm" data-toggle="modal" data-target="#myModal2{{$avuser->id}}" href="#">
                      <span class="fa fa-edit"> EDIT</span></a>
                    </td>
                  </tr>
                @endforeach
                </tbody>
              </table>


              <!-- Modal -->
              <div class="modal fade" id="myModal" role="dialog">
                <div class="modal-dialog">
                
                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Add Merchant Rule</h4>
                    </div>
                    <div class="modal-body">

                    <form method="POST" action="{{route('saveMerchantrule')}}">
                      {{csrf_field()}}
                      <table class="table table-responsive text-center">
                        <tbody>
                        <tr>
                          <td>Merchant</td>
                          <td>
                            <div class="form-group">
                              <select name="user_id" required="" class="form-control">
                                <option value=""></option>
                                @foreach($users as $user)
                                  <option value="{{$user->id}}">{{$user->name}}</option>
                                @endforeach
                              </select>
                            </div>
                          </td>
                        </tr>
                        @foreach($methodtypes as $indexKey => $methodtype)
                          <tr>
                            <td>{{$methodtype->name}}</td>
                            <td>
                              <div class="form-group">
                                <select name="rows[{{$indexKey}}][rule_id]" class="form-control" required="">
                                @foreach($methodtype->Settlemetrule as $methodSet)
                                  <option value="{{$methodSet->id}}">{{$methodSet->name}}</option>
                                @endforeach
                                </select>
                              </div>
                            </td>
                          </tr>
                        @endforeach

                        <tr>
                          <td colspan="2">
                            <button class="btn btn-success pull-right"> SAVE </button>
                          </td>
                        </tr>
                        </tbody>
                      </table>
                    </form>

                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                  
                </div>
              </div>

              @foreach($availed_users as $indexKey => $avuser)

              <!-- Modal -->
              <div class="modal fade" id="myModal2{{$avuser->id}}" role="dialog">
                <div class="modal-dialog">
                
                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Delete Merchant Rule</h4>
                    </div>
                    <div class="modal-body">

                    <h4 class="text-center">Are you sure, you want to delete?</h4>

                    <form method="POST" action="{{route('updateMerchantrule')}}">
                      {{csrf_field()}}
                      <input type="hidden" name="user_id" value="{{$avuser->id}}">
                      <div class="form-group text-center">
                        <button type="submit" class="btn btn-danger">YES</button>
                        <button class="btn btn-success" data-dismiss="modal">NO</button>
                      </div><br>
                    </form>

                    </div>
                  </div>
                  
                </div>
              </div>
              @endforeach

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

<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});
</script>
<!-- ./wrapper -->

 @endsection

@section('footer-resources')
  @include('layouts.resources.footer.transactions')
@endsection