@extends('layouts.admin')
@section('main')
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Users
      </h1>
      @include('common.breadcrumb')
    </section>
<style>
#password_div {
  display: none;
}
</style>
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
                  <div class="col-sm-4">
                    <label class="col-sm-3 control-label">Generate Random password</label>
                    <div class="col-sm-9">
                      <input type="checkbox" checked="checked" id="showPasswordCheckbox" onchange="togglePasswordField()">
                    </div>
                  </div>
                  <div class="col-sm-4" id="password_div">
                    <label class="col-sm-3 control-label">Password</label>
                    <div class="col-sm-9">
                        <input type="password" name="password" class="form-control" id="password" value="" placeholder="New Password">
                        @error('password')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                </div>
              </div>
              <div class="box-footer">
                <div class="text-center" style="cursor: default;">
                  <a href="{{route('users')}}" class="btn btn-default" >Back</a>&nbsp;
                  <button type="submit" name="confirm" value="submit" class="btn btn-success" id="sub">Confirm &amp; Submit</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
  </div>
@endsection

@push('scripts')
<script>
  
  function togglePasswordField() {
    const passwordField = document.getElementById('password_div');
    const showPasswordCheckbox = document.getElementById('showPasswordCheckbox');

    if (showPasswordCheckbox.checked) {
      passwordField.style.display = 'none';
    } else {
      passwordField.style.display = 'block';
    }
  }
  
</script>
@endpush
