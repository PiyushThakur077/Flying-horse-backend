<footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 1.0.0
    </div>
    <strong>Copyright &copy; 2016-{{date('Y')}} <a href="#">{{config('app.name')}}</a>.</strong> All rights
    reserved.
</footer>

<!-- Modal -->
<div class="modal fade" id="delete-warning-modal" role="dialog" style="z-index:1060;">
    <div class="modal-dialog" >
      <!-- Modal content-->
      <div class="modal-content" style="width:100%;height:100%">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Confirm Delete</h4>
        </div>
        <div class="modal-body">
          <p>You are about to delete one record, this procedure is irreversible.</p>
          <p>Do you want to proceed?</p>
        </div>
        <div class="modal-footer">
        	<a class="btn btn-danger" id="delete-modal-yes" href="javascript:void(0)">Yes</a>
          	<button type="button" class="btn btn-default" data-dismiss="modal">No</button>
        </div>
      </div>
    </div>
</div>
<div class="modal fade" id="refund-warning-modal" role="dialog" style="z-index:1060;">
    <div class="modal-dialog" >
      <!-- Modal content-->
      <div class="modal-content" style="width:100%;height:100%">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Confirm Security fee refund</h4>
        </div>
        <div class="modal-body">
          <p>You are about to make a refund for the security fee to the renter. Please make sure the item is returned to the Lister, before sharing the security refund.</p>
          <p>Do you want to proceed?</p>
        </div>
        <div class="modal-footer">
        	<a class="btn btn-danger" id="refund-modal-yes" href="javascript:void(0)">Yes</a>
          	<button type="button" class="btn btn-default" data-dismiss="modal">No</button>
        </div>
      </div>
    </div>
</div>
@push('scripts')
<script type="text/javascript">
  $(document).on('click', '.delete-warning', function(e){
    e.preventDefault();
    var url = $(this).attr('href');
    $('#delete-modal-yes').attr('href', url)
    $('#delete-warning-modal').modal('show');
  });  
  $(document).on('click', '#editUserByAdmin', function(e){
    e.preventDefault();
    $('#admin-password-modal').modal('show');  
  });
  $('#adminPasswordForm').submit(function(e){
    e.preventDefault();
   let password = $('#adminPasswordForm #popup_admin_password').val();
   let url = "<?php echo env('APP_URL') ?>";
   $.ajax({
        type:'POST',
        url: url+'admin/isLoginUser',
        dataType:"JSON",
        data:'_token = <?php echo csrf_token() ?>&&admin_password='+password+'',
        success:function(data) { 
          if(data['ResponseCode'] == 1){
            $('#admin-password-modal').modal("hide");
            $('#updateUserDetail').submit();
          }else{
            $('#aj-admin_password').html(data['ResponseText'] )
          }              
         
        }
    });
  });
  
</script>
@endpush