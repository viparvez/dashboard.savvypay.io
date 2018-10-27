<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  @yield('header-resources')

  <style type="text/css">
    .details-view tr td:nth-child(odd) {
      color: #3C8DBC;
      padding-right: 20px; 
    }
    .details-view tr td:nth-child(even) {
      text-align: right;
    }
    .modal {
      overflow-y:auto;
    }
  </style>

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
