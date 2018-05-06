<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Login</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="http://{{$_SERVER['HTTP_HOST']}}/public/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="http://{{$_SERVER['HTTP_HOST']}}/public/dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="http://{{$_SERVER['HTTP_HOST']}}/public/plugins/iCheck/square/blue.css">
</head>

<body class="hold-transition login-page">
 <div class="login-box">
  <div class="login-logo">
    <a href="#"><b>SAVVYPAY.IO</b></a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Sign in to start your session</p>

    <form action="{{route('login')}}" method="post">

      {{ csrf_field() }}

      <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}"> 

      <div class="form-group has-feedback">
        <input type="email" class="form-control" type="email" placeholder="Email" name="email" value="{{ old('email') }}" required autofocus>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>

        @if ($errors->has('email'))
          <span class="help-block">
            <strong>{{ $errors->first('email') }}</strong>
          </span>
        @endif

      </div>

      <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">

      <div class="form-group has-feedback">
        <input type="password" class="form-control" name="password" required placeholder="Password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>

        @if ($errors->has('password'))
          <span class="help-block">
            <strong>{{ $errors->first('password') }}</strong>
          </span>
        @endif


      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox"> Remember Me
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
    </form>

    <a href="#">I forgot my password</a><br>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 2.2.3 -->
<script src="http://{{$_SERVER['HTTP_HOST']}}/public/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="http://{{$_SERVER['HTTP_HOST']}}/public/bootstrap/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="http://{{$_SERVER['HTTP_HOST']}}/public/plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>

</body>
</html>