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
      <div class="row">
         <div class="col-xs-12">
            <div class="box">
               <div class="alert alert-success" id="success-message">
               </div>
               <div class="box-header">
                  <h3 class="box-title">Teams</h3>
               </div>
               <div class="box-tools pull-right">
                  <button class="btn btn-primary" data-toggle="modal" id="addTeamButton" data-target="#addTeamModal">Add Team</button>
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
                              <div class="col-xs-8">{{ $user->email }}</div>
                           </div>
                           <div class="row">
                              <div class="col-xs-4"><strong>Phone:</strong></div>
                              <div class="col-xs-8">{{ $user->phone }}</div>
                           </div>
                           @endforeach
                           <!-- <button class="btn btn-primary" onclick="openEditModal('{{ $team->id }}')">Edit</button> -->
                           <button class="btn btn-danger" onclick="deleteTeam('{{ $team->id }}')">Delete</button>
                        </div>
                     </div>
                  </div>
                  @endforeach
               </div>
            </div>
         </div>
      </div>
   </section>

   <!-------Add model--------->
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
                  <input type="text" class="form-control teamTitle"  id="teamTitle" placeholder="Enter team title" required>
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



 <!-------Edit model--------->
<div id="editTeamModal" class="modal fade" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title">Edit Team</h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="form-group">
                  <label for="teamTitle">Team Title:</label>
                  <input type="text" class="form-control teamTitle" id="teamTitlee" placeholder="Enter team title" required>
               </div>
               <div class="form-group">
                  <label for="userList">Select Users:</label>
                  <div id="datatable-container">
                     <table id="users-data1" class="display" width="100%">
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
               <button type="button" class="btn btn-primary" onclick="updateTeam()">Update Team</button>
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
       $('#users-data1').DataTable({
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
   $('#addTeamModal .user-checkbox:checked').each(function() {
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
   function updateTeam() {
   var teamTitle = $('#teamTitlee').val();
   var selectedUsers = [];
   $('#editTeamModal .user-checkbox:checked').each(function() {
       selectedUsers.push($(this).val());
   });
   if (selectedUsers.length > 2) {
       alert("You can select only up to 2 users.");
       return; 
   }
   
   $.ajax({
    url: "@isset($team){{ route('admin.teams.update', ['teamId' => $team->id]) }}@endisset",
      type: "PUT",
       data: {
           teamTitle: teamTitle,
           selectedUsers: selectedUsers
       },
       success: function(response) {
           $('#editTeamModal').modal('hide');
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
<script>
    function openEditModal(teamId) {
        $.ajax({
            url: "/admin/teams/edit/" + teamId,
            type: "GET",
            success: function(response) {
                $('.teamTitle').val(response.team.title);

                var selectedUsers = response.team.users;
                $('.user-checkbox').prop('checked', false);
                selectedUsers.forEach(function(userId) {
                    $('.user-checkbox[value="' + userId + '"]').prop('checked', true);
                });

                $('#editTeamModal').modal('show');
            },
            error: function(xhr, status, error) {
                console.error('Error retrieving team data:', error);
            }
        });
    }
</script>

<script>
    function deleteTeam(teamId) {
        if (confirm("Are you sure you want to delete this team?")) {
            $.ajax({
                url: "/admin/teams/delete/" + teamId,
                type: "DELETE",
                success: function(response) {
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.error('Error deleting team:', error);
                }
            });
        }
    }
</script>


@endpush
