@extends('layouts.admin')
@section('main')

 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!-- <section class="content-header">
      <h1>
        Users
      </h1>
      @include('common.breadcrumb')
    </section>  -->
    @if(session('success'))
        <div class="alert alert-success" id="success-message">
            {{ session('success') }}
        </div>
    @endif
	 <!-- Main content -->
	 <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
          @include('common.breadcrumb')
            <div class="box-header">
              <h3 class="box-title">Users</h3>
             
              <div style="float:right;"><a class="btn btn-success" href="{{ route('users.create') }}">Add New User</a></div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class=" table-responsive">
                  <table class="table table-separate table-hover table-head-custom table-hover
                    table-checkable dataTable no-footer dtr-inline" id="viewtable"
                    data-source='{"url": "{{route("users.datatable")}}","type": "POST"}' >
                    <thead>
                    <tr>
                        <th visible=false search=false sort=false export=false data-name="created_at" > {{ __('Created At') }}</th>
                        <th data-render=renderSerialNumber search=false sort=false export=false data-name="sr_no"> {{ __('S No') }}</th>
                        <th sort=false data-name="name">Name </th>
                        <th sort=false > Email </th>
                        <th sort=false> Phone </th>
                        <th sort=false> Status </th>
                        <th sort=false> Timer </th>
                        <th sort=false data-name="created_at"> {{ __('Created At') }} </th>
                        <th sort=false > Actions </th>
                    </tr>
                    </thead>
                    <tbody>
                    
                    </tbody>
                  </table>
                </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
@endsection

@push('scripts')
  <script>
      setTimeout(function() {
          $('#success-message').fadeOut('fast');
      }, 3000);
  </script> 
@endpush