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
  #password_confirmation_row {
    display: none;
  }
</style>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Edit User Data</h3>
            </div>
            <form action="{{ route('users.update', ['id' => $user->id]) }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                @csrf

                <div class="box-body">
                    <div class="row">
                        <div class="col-sm-4">
                            <label class="col-sm-3 control-label"> Name <span style="color:red">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" name="name" id="name" value="{{ $user->name }}" class="form-control">
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <label class="col-sm-3 control-label"> Email <span style="color:red">*</span></label>
                            <div class="col-sm-9">
                                <input type="email" name="email" id="email" value="{{ $user->email }}" class="form-control">
                                @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <label class="col-sm-3 control-label"> Phone</label>
                            <div class="col-sm-9">
                                <input type="text" name="phone" class="form-control" id="phone" value="{{ $user->phone }}" placeholder="">
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
                                <input type="file" name="avatar" class="form-control" id="avatar" value="" placeholder="Photo">
                                @error('avatar')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                         <div class="col-sm-4">
                            <label class="col-sm-3 control-label"> Change Password</label>
                            <div class="col-sm-9">
                                <input type="password" name="password" class="form-control" id="password" value="{{ old('password') }}" placeholder="New Password">
                                @error('password')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                         <div class="col-sm-4" id="password_confirmation_row">
                            <label class="col-sm-3 control-label">Confirm Password</label>
                            <div class="col-sm-9">
                              <input type="password" name="password_confirmation" class="form-control" id="password_confirmation" value="{{ old('password_confirmation') }}" placeholder="Confirm New Password">
                                @error('password_confirmation')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                    </div>

                    <div class="box-footer ">
                      <div class="text-center" style="cursor: default;">
                      <a href="{{route('users')}}" class="btn btn-default" >Back</a>&nbsp;
                        <button type="submit" name="confirm" value="submit" class="btn btn-success" id="sub">Confirm &amp; Submit</button>
                      </div>
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
    document.addEventListener('DOMContentLoaded', (event) => {
        const passwordField = document.getElementById('password');
        const passwordConfirmationRow = document.getElementById('password_confirmation_row');
        passwordField.addEventListener('input', function() {
            const password = this.value;
            if (password) {
                passwordConfirmationRow.style.display = 'block';
            } else {
                passwordConfirmationRow.style.display = 'none';
            }
        });
    });
    
</script>
<script>
    const passwordError = "{{ $errors->has('password') || $errors->has('password_confirmation') }}";
    const passwordConfirmationRow = document.getElementById('password_confirmation_row');

    if (passwordError) {
        passwordConfirmationRow.style.display = 'block';
    }
</script>
@endpush
