<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SavvyPAY.io | Invoice</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="../public/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../public/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="../public/dist/css/skins/_all-skins.min.css">
<body class="hold-transition skin-blue sidebar-mini">
    <!-- Main content -->
    <section class="invoice">
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <i class="fa fa-globe"></i> SavvyPAY.io
            <small class="pull-right">Date: {{$settlementdetails[0]->created_at}}</small>
          </h2>
        </div>
        <!-- /.col -->
      </div>

      <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
          From
          <address>
            <strong>SavvyPAY</strong><br>
            House# 249/250<br>
            Road# 03, Block# Dho<br>
            Mirpur# 12, Dhaka - 1216<br>
            Bangladesh<br>
            Email: info@almasaeedstudio.com
          </address>
        </div>
        
      </div>

      <!-- Table row -->
      <div class="row">
        <div class="col-xs-12">
          <table class="table table-bo">
            <thead>
            <tr>
              <th>#SL</th>
              <th>Payment Method</th>
              <th>Amount</th>
              <th>Charge</th>
              <th>Creditable</th>
            </tr>
            </thead>
            <tbody>
            @foreach($settlementdetails as $indexKey => $setl)
              <tr>
                <td>{{$indexKey+1}}</td>
                <td>{{$setl->Methodtype->name}}</td>
                <td>{{$setl->TotalAmount}} &#2547</td>
                <td>{{$setl->Charge}} &#2547</td>
                <td>{{$setl->CreditableAmount}} &#2547</td>
              </tr>
            @endforeach
              <tr>
            <tr style="font-weight: bold">
              <td colspan="2" style="text-align: center;">Total</td>
              <td>
                &#2547
              </td>
              <td>
                &#2547
              </td>
              <td>
                &#2547
              </td>
            </tr>
            </tbody>
          </table>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <!-- /.row -->

      <!-- this row will not appear when printing -->
      <div class="row no-print">
        <div class="col-xs-12">
          <button type="button" class="btn btn-success pull-right"><i class="fa fa-print"></i> Print
          </button>
          <a class="btn btn-primary pull-right" style="margin-right: 5px;" href="{{route('downLoadPDF',$settlementdetails[0]->invCode)}}">
            <i class="fa fa-download"></i> Generate PDF
          </a>
        </div>
      </div>
    </section>
    <!-- /.content -->
<!-- jQuery 2.2.3 -->
<script src="../public/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="../public/bootstrap/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="../public/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../public/dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../public/dist/js/demo.js"></script>
</body>
</html>