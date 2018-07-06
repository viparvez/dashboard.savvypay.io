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

    <div style="padding: 20px">
      <button type="button" class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#myModal">New Refund Request
      </button>
    </div>

    @if (Session::has('success'))
      <br>
      <div class="alert alert-success" style="padding: 5px; text-align: center;" id="successMessage">
        <strong>Success!</strong> {{ Session::get('success') }}
      </div>
    @endif

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered table-hover" style="font-size: 13px">
                <thead>
                <tr>
                  <th>Transaction Number</th>
                  <th>Merchant</th>
                  <th>Status</th>
                  <th>Amount</th>
                  <th>Method</th>
                  <th>Updated at</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($refunds as $refund)
                  <tr>
                    <td>{{$refund->Transaction->trxnnum}}</td>
                    <td>{{$refund->Transaction->Createdby->name}}</td>
                    <td>
                      @if($refund->status == 'REQUESTED')
                        <span class="btn btn-default btn-xs">{{$refund->status}}</span>
                      @elseif($refund->status == 'REFUNDED')
                        <span class="btn btn-success btn-xs">{{$refund->status}}</span>
                      @else
                        <span class="btn btn-danger btn-xs">{{$refund->status}}</span>
                      @endif
                    </td>
                    <td>{{$refund->Transaction->Transactiondetail->Currency->code}} {{number_format($refund->Transaction->Transactiondetail->subtotal,2)}}</td>
                    <td>{{$refund->Transaction->Transactiondetail->Methodtype->name}}</td>
                    <td>{{date_format($refund->updated_at,'F d, Y')}}</td>
                    <td><a class="btn btn-xs btn-primary" onclick="show('{{route('refunds.show',$refund->id)}}')"><span class="fa fa-expand"></span></a></td>
                  </tr>
               @endforeach
                </tbody>
              </table>
              <div class="col-md-3 col-md-offset-9">{{ $refunds->links() }}</div>
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
          </div>
          <div class="modal-body">
            <div class="alert alert-danger print-error-msg" style="display:none">
              <ul></ul>
            </div>
            <form id="refund_search" method="POST" action="{{route('refunds.search')}}">
            {{csrf_field()}}
              <div class="form-group">
                <label for="name">Transaction Number:</label>
                <input type="text" name="trxnnum" class="form-control" required="" placeholder="Transaction Number">
              </div>
              <button class='btn btn-block btn-success btn-sm' id='submit_search' type='submit_search'>CHECK</button>
              <button class='btn btn-block btn-success btn-sm' id='loading' style='display: none' disabled=''>Working...</button>
            </form>

            <div id="result">

            </div>

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

<script type="text/javascript">
  /*
Function for new data insertion\
*/

$(document).ready(function() {

      $("#submit_search").click(function(e){

        e.preventDefault();

        var _url = $("#refund_search").attr("action");

        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
        });

        var _data = new FormData($('#refund_search')[0]);

          $.ajax({

              url: _url,

              type:'POST',

              dataType:"json",

              data:_data,

              processData: false,
              
              contentType: false,

              success: function(data) {
                  
                  $('#result').html("");
                  $('.print-error-msg').css("display","none");

                  if($.isEmptyObject(data.error)){
                    
                    $('#result').html("<br><br><form name='refund_request' action='' method='POST' action='http://localhost/dashboard.savvypay.io/refunds/request'><input type='hidden' name='_token' value='"+$('meta[name="csrf-token"]').attr('content')+"'><table class='table table-responsive table-bordered' style='font-size:13px'><tr><td>Transaction Number</td><td>"+data.success.trxnnum+"<input type='hidden' name='transaction_id' value='"+data.success.id+"'></td></tr><tr><td>Amount</td><td>"+data.success.code + " " +data.success.subtotal+"</td></tr><tr><td>Merchant</td><td>"+data.success.merchant+"</td></tr><tr><td>Date</td><td>"+data.success.created_at+"</td></tr><tr><td>Reference</td><td>"+data.success.reference+"</td></tr><tr><td>Status</td><td>"+data.success.status+"</td></tr></table><div class='form-group'><label>Note:</label><textarea class='form-control' name='refundnote'></textarea></div><div class='form-group'><button id='request' class='btn btn-info btn-xs btn-flat form-control'>REQUEST REFUND</button></div></form>");

                  }else{

                    printErrorMsg(data.error);

                  }

              }

          });

      }); 


      $(document).ajaxStart(function () {
          $("#loading").show();
          $("#submit_search").hide();
      }).ajaxStop(function () {
          $("#loading").hide();
          $("#submit_search").show();
      });

  });

  setTimeout(function() {
      $('#successMessage').fadeOut('fast');
  }, 2000); // <


/*
$("#myModal").on('click', '#request', function(e){

    e.preventDefault();

    var _url = $("#refund_request").attr("action");

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    var _data = new FormData($('#refund_request')[0]);

    $.ajax({

        url: _url,

        type:'POST',

        dataType:"json",

        data:_data,

        processData: false,
        
        contentType: false,

        success: function(data) {
            

            if($.isEmptyObject(data.error)){
              
               if($.isEmptyObject(data.error)){
                 swal({
                   title: "Submitted!",
                   text: "Refund request has been submitted.",
                   icon: "success",
                   button: false,
                   timer: 2000,
                   showCancelButton: false,
                   showConfirmButton: false
                 }).then(
                   function () {
                     window.location.reload(true);
                   },
                 );

            }else{

              printErrorMsg(data.error);

            }

        }

    });

});
*/
  function printErrorMsg (msg) {
    $(".print-error-msg").find("ul").html('');
    $(".print-error-msg").css('display','block');
    $.each( msg, function( key, value ) {
      $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
    });

  }

</script>
@endsection
