<script src="public/js/sweetalert.js"></script>
<!-- jQuery 2.2.3 -->
<script src="{{url('/')}}/public/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="{{url('/')}}/public/bootstrap/js/bootstrap.min.js"></script>
<!-- DataTables -->
<script src="{{url('/')}}/public/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{{url('/')}}/public/plugins/datatables/dataTables.bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="{{url('/')}}/public/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="{{url('/')}}/public/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="{{url('/')}}/public/dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{url('/')}}/public/dist/js/demo.js"></script>

<script src="{{url('/')}}/public/js/savvypay.js"></script>
<!-- page script -->
<script>
  $(function () {
    $("#example1").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": false,
      "info": true,
      "autoWidth": false
    });
  });
</script>