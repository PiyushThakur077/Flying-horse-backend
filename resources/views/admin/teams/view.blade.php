@extends('layouts.admin')
@section('main')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <section class="content-header">
      <h1>
         Users
         <small>Control panel</small>
      </h1>
      @include('common.breadcrumb')
   </section>
   <style>
      #success-message {
      display:none;
      }
   </style>
   <!-- Main content -->
   <section class="content">
      <div class="row box">
         <div class="col-xs-12">
         <div class="d-flex cstm_head">
                  <h3 class="">Teams</h3>
                  <div class="box-tools pull-right">
                  <button class="btn btn-primary cstm_mrgn" data-toggle="modal" id="addTeamButton" data-target="#addTeamModal">Add Team</button>
               </div>
               </div>
               
            <div class="">
               <div class="alert alert-success" id="success-message">
               </div>
               
               <div class="row">
                  @foreach($teams as $team)
                  <div class="col-md-4">
                     <div class="panel panel-default"> 
                        <div class="panel-heading">{{ $team->title }}</div>
                        <div class="panel-body">
                           @foreach($team->users as $user)
                           <div class="row">
                              <div class="col-xs-4"><strong>Name:</strong></div>
                              <div class="col-xs-8">{{ $user->name }}</div>
                           </div>
                           <div class="row">
                              <div class="col-xs-4"><strong>Email:</strong></div>
                              <div class="col-xs-8 cstm_div">{{ $user->email }}</div>
                           </div>
                           <div class="row">
                              <div class="col-xs-4"><strong>Phone:</strong></div>
                              <div class="col-xs-8">{{ $user->phone }}</div>
                           </div>
                           @endforeach
                        </div>
                     </div>
                  </div>
                  @endforeach
               </div>
            </div>
         </div>
      </div>
   </section>
   <div id="addTeamModal" class="modal fade" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title">Add Team</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="form-group">
                  <label for="teamTitle">Team Title:</label>
                  <input type="text" class="form-control" id="teamTitle" placeholder="Enter team title" required>
               </div>
               <div class="form-group">
                  <label for="userList">Select Users:</label>
                  <div id="datatable-container">
                     <table id="users-data" class="display" width="100%">
                        <thead>
                           <tr>
                              <th>Name</th>
                              <th>Email</th>
                              <th>Phone</th>
                           </tr>
                        </thead>
                     </table>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
               <button type="button" class="btn btn-primary" onclick="createTeam()">Create Team</button>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
@push('scripts')
<script>
   $(document).ready(function() {
       $('#users-data').DataTable({
           processing: true,
           serverSide: true,
           ajax: {
               url: "{{ route('users.data') }}",
               type: "POST"
           },
           columns: [
               { data: 'name', name: 'name' },
               { data: 'email', name: 'email' },
               { data: 'phone', name: 'phone' },
           ]
       });
   });
</script>
<script>
   function createTeam() {
   var teamTitle = $('#teamTitle').val();
   var selectedUsers = [];
   $('.user-checkbox:checked').each(function() {
       selectedUsers.push($(this).val());
   });
   if (selectedUsers.length > 2) {
       alert("You can select only up to 2 users.");
       return; 
   }
   
   $.ajax({
       url: "{{ route('admin.teams.create') }}",
       type: "POST",
       data: {
           teamTitle: teamTitle,
           selectedUsers: selectedUsers
       },
       success: function(response) {
           $('#addTeamModal').modal('hide');
           $('#success-message').text(response.message);
           $('#success-message').show();
           window.location.href = "{{ route('admin.teams') }}";
       },
       error: function(xhr, status, error) {
           console.error('Error creating team:', error);
       }
   });
   }
</script>
@endpush
