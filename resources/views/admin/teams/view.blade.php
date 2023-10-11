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
      /* Apply styles when hovering over a row with a disabled checkbox */
      #users-data tbody tr.disabled-checkbox {
         background-color: #f0f0f0; /* Change this to the desired hover background color */
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
                  <div class="">
                  <h3 class="box-title">Teams</h3>
                  </div>
                  <div class="box-tools pull-right">
                  <button class="btn btn-primary" data-toggle="modal" id="addTeamButton" data-target="#addTeamModal">Add Team</button>
                  </div>
               </div>

               <div class="row">
                  @foreach($teams as $team)
                  <div class="col-md-4">
                     <div class="panel panel-default">
                        <div class="panel-heading">{{ $team->title }}</div>
                        <div class="panel-body">
                           @foreach($team->users as $user)
                           <div class="row" style="margin:0px;">
                              <div class="col-12">{{ $user->name }}</div>
                              <div class="col-12">{{ $user->email }}</div>
                              <div class="col-12">{{ $user->phone }}</div>
                           </div>
                           <hr />
                           @endforeach
                           <button class="btn btn-primary" onclick="openEditModal('{{ $team->id }}')">Edit</button>
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
                  <input type="hidden" class="form-control teamId-edit/" id="teamId">
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
   var table1;
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
       table1 = $('#users-data1').DataTable({
           processing: true,
           serverSide: true,
           ajax: {
               url: "{{ route('users.data.edit') }}",
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
          $("#editTeamModal").on("hidden.bs.modal", function () {
         table1.ajax.reload()
});
   function createTeam() {
   var teamTitle = $('#teamTitle').val();
   var selectedUsers = [];
   $('#addTeamModal .user-checkbox:checked').each(function() {
      if (!$(this).is(':disabled')) {
         selectedUsers.push($(this).val());
      }
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
   function updateTeam(teamId) {
      var teamTitle = $('#teamTitlee').val();
      var tmId = $('#teamId').val();
      var selectedUsers = [];
      $('#editTeamModal .user-checkbox:checked').each(function() {
          if (!$(this).is(':disabled')) {
         selectedUsers.push($(this).val());
      }
      });
      if (selectedUsers.length > 2) {
         alert("You can select only up to 2 users.");
         return; 
      }
      
      $.ajax({
      url: "@isset($team){{ route('admin.teams.update', ['teamId' => $team->id]) }}@endisset",
         type: "PUT",
         data: {
            tmId:tmId,
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
            async:false,
            success: function(response) {
                $('.teamTitle').val(response.team.title);
                $('#teamId').val(teamId);
                var selectedUsers = response.team.users;
                selectedUsers.forEach(function(userId) {
                    $('.user-checkbox[value="' + userId + '"]').prop('checked', true)
                    .attr('disabled',false);
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
