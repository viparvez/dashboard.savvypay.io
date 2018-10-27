@extends('layouts.main')

@section('header-resources')
  @include('layouts.resources.header.home')
  <link rel="stylesheet" type="text/css" href="{{url('/')}}/public/css/normalize.css" />
  <link rel="stylesheet" type="text/css" href="{{url('/')}}/public/css/demo.css" />
  <link rel="stylesheet" type="text/css" href="{{url('/')}}/public/css/component.css" />
@endsection

@section('content')
<div class="wrapper">

 @include('layouts.nav.header')

 @include('layouts.nav.sidebar')

 <style type="text/css">
   .upload-btn-wrapper {
     position: relative;
     overflow: hidden;
     display: inline-block;
   }

   .bttn-up {
     border: 2px solid gray;
     color: white;
     background-color: #3C8DBC;
     padding: 8px 20px;
     border-radius: 8px;
     font-size: 16px;
     font-weight: bold;
   }

   .upload-btn-wrapper input[type=file] {
     font-size: 100px;
     position: absolute;
     left: 0;
     top: 0;
     opacity: 0;
   }

 </style>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <div id="loader-icon" style="display: none"><img src="{{url('/')}}/public/img/LoaderIcon.gif" /></div>
    <!-- Content Header (Page header) -->
    <div class="container">

      <div class="header" style="text-align: center;">
        <h3>You need to upload the below documents one by one to apply for the API ID</h3>
      </div>

      <div class="content">
        <div class="box">
          <div id="loader-icon" style="display: none"><img src="{{url('/')}}/public/img/LoaderIcon.gif" /></div>
          <form name="document" method="POST" enctype="multipart/form-data" action="{{route('documents.store')}}">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <h3>{{$file}}</h3><br>
            <div class="upload-btn-wrapper">
              <input type="hidden" name="fileType" value="{{$file}}">
              <button class="bttn-up">Select a file</button>
              <input type="file" name="file" />
              <div class="form-text">Nothing Selected</div> 
            </div>
            <br><br>
            <input class="btn btn-success" type="submit" name="submit" value="SUBMIT">
          </form>
        </div>
      </div>

    </div>
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

  <!-- Control Sidebar -->
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->
@endsection

@section('footer-resources')
  @include('layouts.resources.footer.home')

  <script type="text/javascript">
   $('input[type=file]').change(function () {
       var fileCount = this.files.length;
       $(this).next().text(fileCount + ' File Selected');
   })
 </script>
@endsection