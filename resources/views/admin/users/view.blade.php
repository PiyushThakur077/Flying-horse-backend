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
    @if(session('success'))
        <div class="alert alert-success" id="success-message">
            {{ session('success') }}
        </div>
    @endif
    <!-- Main content -->
    <section class="content" style="min-height: 0px;">
      <div class="row">
        <div class="col-xs-12">
          <div class="box" style="min-height: 181px;margin-bottom:1px">
            <div class="box-header">
              <h3 class="box-title">Add User</h3>
            </div>
            <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
  
            <!-- /.box-header -->
            <div class="box-body" style="min-height:80px">

				
					<div class="row">
						<div class="col-sm-4">
							<label class="col-sm-3 control-label"> Name <span style="color:red">*</span></label>
							<div class="col-sm-9">
								<input type="text" name="name" id="name" class="form-control" >
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
							</div>
						</div>
						<div class="col-sm-4">
							<label class="col-sm-3 control-label"> Email <span style="color:red">*</span></label>
							<div class="col-sm-9">
								<input type="email" name="email" id="email" class="form-control" >
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
							</div>
						</div>
            <div class="col-sm-4">
							<label class="col-sm-3 control-label"> Phone</label>
							<div class="col-sm-9">
								<input type="number" name="phone" class="form-control " id="phone" value="" placeholder="">
                @error('phone')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
							</div>
						</div>
					</div>
          <div class="row" style="margin-top:1%;">
            <div class="col-sm-4">
							<label class="col-sm-3 control-label"> Image</label>
							<div class="col-sm-9">
								<input type="file" name="avatar" class="form-control " id="avatar" value="" placeholder="Photo">
                @error('avatar')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
							</div>
						</div>
          </div>
				


                <!-- <div class=" table-responsive">
                  <table class="table table-separate table-hover table-head-custom table-hover
                    table-checkable dataTable no-footer dtr-inline" id="viewtable"
                    data-source='{"url": "{{route("users.datatable")}}","type": "POST"}' >
                    <thead>
                    <tr>
                        <th visible=false search=false sort=false export=false data-name="created_at" > {{ __('Created At') }}</th>
                        <th data-render=renderSerialNumber search=false sort=false export=false data-name="sr_no"> {{ __('S No') }}</th>
                        <th data-name="name">Name </th>
                        <th > Email </th>
                        <th > Role </th>
                        <th > Status </th>
                        <th data-name="created_at"> {{ __('Created At') }} </th>
                    </tr>
                    </thead>
                    <tbody>
                    
                    </tbody>
                  </table>
                </div> -->
            </div>
			<div class="box-footer">
			<div class="text-center" style="cursor: default;">
				<button type="reset" id="close_btn" href="#" class="btn btn-default" value="Close">Reset</button>&nbsp;
				<button type="submit" name="confirm" value="submit" class="btn btn-success" id="sub">Confirm &amp; Submit</button>
			</div>
			</div>
			</form>
          </div>
        </div>
      </div>
    </section>
	 <!-- Main content -->
	 <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Users</h3>
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
                        <th data-name="name">Name </th>
                        <th > Email </th>
                        <th > Phone </th>
                        <th > Status </th>
                        <th data-name="created_at"> {{ __('Created At') }} </th>
                        <th > Actions </th>
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