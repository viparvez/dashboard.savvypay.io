<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  @yield('header-resources')
</head>
<body class="hold-transition skin-blue sidebar-mini">
  @yield('content')

  @yield('footer-resources')

  
  @if (notify()->ready())   
     <script>
      swal({
        title: "{!! notify()->message() !!}",
        text: "{!! notify()->option('text') !!}",
        type: "{{ notify()->type() }}",
        @if (notify()->option('timer'))
            timer: {{ notify()->option('timer') }},
            showConfirmButton: false
        @endif
      });
     </script>
   @endif

</body>
</html>
