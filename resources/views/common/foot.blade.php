<!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
       <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->
<script> 
var APP_URL = "{{(url('/'))}}"; 
</script>
<!-- jQuery 2.2.3 -->
<script src="/backend/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.6 -->
<script src="/backend/bootstrap/js/bootstrap.min.js"></script>

    <script type="text/javascript" src='https://maps.google.com/maps/api/js?key={{ @$map_key }}&sensor=false&libraries=places'></script>
 
  <script src="{{ url('/front/js/locationpicker.jquery.min.js') }}"></script>
  <script src="{{ url('/front/js/bootbox.min.js') }}"></script>
<!-- admin js -->
<script src="/backend/dist/js/admin.js"></script>
<!-- backend js -->
<script src="/backend/js/backend.js"></script>
<!-- CK Editor -->
<script src="https://cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>

<script src="{{ url('/front/js/wickedpicker.min.js') }}"></script>
<!--<script src="/backend/js/ckeditor.js"></script>-->
@stack('scripts')
<!-- Morris.js charts -->
@if(Route::current()->uri() == 'admin/dashboard')
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="/backend/plugins/morris/morris.min.js"></script>
<script src="{{ url('/backend/dist/js/dashboard.js') }}"></script>
<script src="{{ url('/backend/plugins/chartjs/Chart.min.js') }}"></script>-->
@endif
<!-- Sparkline -->

<script src="/backend/datatables/datatables.bundle.js"></script>

<!-- end::Datatable -->
<!-- begin::cutomjs -->
<script src="/backend/js/ys-datatables.min.js"></script>

<script src="/backend/plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="/backend/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="/backend/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="/backend/plugins/knob/jquery.knob.js"></script>
<!-- daterangepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="/backend/plugins/daterangepicker/daterangepicker.js"></script>
<script src="/backend/plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="/backend/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="/backend/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="/backend/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="/backend/dist/js/app.min.js"></script>

<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
@if(Route::current()->uri() == 'admin/dashboard')
<script src="/backend/dist/js/pages/dashboard.js"></script>
@endif
<!-- AdminLTE for demo purposes -->
<script src="/backend/dist/js/demo.js"></script>
<script src="/backend/dist/js/custom.js"></script>
<script>
  	$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
    function renderSerialNumber(data, type, row, meta){
      //return meta.row + meta.settings._iDisplayStart + 1;
      return `<i class="fa fa-angle-double-down fa-sm text-success" >&nbsp;&nbsp;&nbsp;&nbsp;</i>&nbsp;${meta.row + meta.settings._iDisplayStart + 1} `
    };
    ( function(){
      if( $("#viewtable")[0] ) {

        vtable = $("#viewtable").YSDataTable({
          removeButtons: {
            target: ["colvis","copy"]
          },
          order: [[0, "desc"]],
          responsive: true,
          lengthMenu: [
            [25, 50, 100, 200, 500, 1000, 10000, -1],
            [25, 50, 100, 200, 500, 1000, 10000, "All"]
          ],
          fixedHeader: true,
          dom:
              '<"row width100 "<"col-sm-12 col-md-7 dataTables_pager flex-start" Bl><"col-sm-12 col-md-5 align-right"f>r>t<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7 dataTables_pager align-right"p>>'
        });
      }

     
    })();
  </script>
</body>
</html>
