@extends('layouts.admin') @section('main')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <!-- <section class="content-header"><h1>
        Users
      </h1>
      @include('common.breadcrumb')
    </section> -->
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
         <!--  <div class="box-header">
            <h3 class="box-title">Add User</h3>
          </div> -->
          <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data"> @csrf
            <!-- /.box-header -->
            <div class="box-body add-user-div" style="min-height:80px">




           
              <div class="row">
                <div class="col-sm-12">
                  <h3 class="box-title" style="color:#ffffff; margin-top:0px;">Add User</h3>
                  <hr>
                </div>
                <div class="col-sm-12">
                  
                  <label class=" control-label"> Name <span style="color:red">*</span>
                  </label>
                  <div class="">
                    <input type="text" name="name" id="name" class="form-control"> @error('name') <div class="text-danger">{{ $message }}</div> @enderror
                  </div>
                </div>
                <div class="col-sm-12">
                  <label class=" control-label pd-top-zr"> Email <span style="color:red">*</span>
                  </label>
                  <div class="">
                    <input type="email" name="email" id="email" class="form-control"> @error('email') <div class="text-danger">{{ $message }}</div> @enderror
                  </div>
                </div>
                <div class="col-sm-12">
                  <label class=" control-label pd-top-zr"> Phone <span style="font-weight: normal;">(Opitonal)</span></label>
                  <div class="">
                    <input type="text" name="phone" class="form-control " id="phone" value="" placeholder=""> @error('phone') <div class="text-danger">{{ $message }}</div> @enderror
                  </div>
                </div>
              </div>
              <div class="row" style="margin-top:1%;">
                <!-- <div class="col-sm-4"><label class="col-sm-3 control-label"> Image</label><div class="col-sm-9"><input type="file" name="avatar" class="form-control " id="avatar" value="" placeholder="Photo">
                      @error('avatar')
                          <div class="text-danger">{{ $message }}</div>
                      @enderror
                    </div></div> -->
                <div class="col-sm-12 pd-top-zr">
                  <div class="">
                    <input type="checkbox" checked="checked" id="showPasswordCheckbox" onchange="togglePasswordField()">
                    <label class="control-label" for="showPasswordCheckbox">Generate Random password</label><br>
                    <span>You can uncheck this to create your own custom password for this user</span>







                  </div>
                </div>
                <div class="col-sm-12" id="password_div">
                  <label class=" control-label pd-top-zr">Password</label>
                  <div class="">
                    <!-- <input type="password" name="password" class="form-control" id="password" value="" placeholder="New Password"> -->
                    <div class="password-container">
                      <input type="password" name="password" class="form-control" id="password" value="" placeholder="New Password">
                      <span class="toggle-password" onclick="togglePassword()" style="color:#000000;">
                        <i class="fa fa-eye-slash" aria-hidden="true"></i>
                      </span>
                    </div> @error('password') <div class="text-danger">{{ $message }}</div> @enderror
                  </div>
                </div>

                <div class="col-sm-12">
                   <div class="box-footer" style="background-color: transparent;border-top: 1px solid #ffffff;">
              <div class="text-right" style="cursor: default;">
                <a href="{{route('users')}}" class="btn btn-default">Back</a>&nbsp; <button type="submit" name="confirm" value="submit" class="btn btn-success" id="sub">Confirm &amp; Submit</button>
              </div>
            </div>
                </div>
              </div>
            </div>
           
          </form>
        </div>
      </div>
    </div>
  </section>
</div> @endsection @push('scripts') <script>



        function togglePasswordField() {
            var passwordInput = document.getElementById('password');
            var showPasswordCheckbox = document.getElementById('showPasswordCheckbox');
            var passwordDiv = document.getElementById('password_div');

            if (showPasswordCheckbox.checked) {
                passwordInput.type = 'text';
                passwordDiv.style.display = 'none';
            } else {
                passwordInput.type = 'password';
                passwordDiv.style.display = 'block';
            }
        }

        function togglePassword() {
            var passwordInput = document.getElementById('password');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
            } else {
                passwordInput.type = 'password';
            }
        }
 
  const passwordError = "{{ $errors->has('password') }}";
  const passwordErrorDisplay = document.getElementById('password_div');
  if (passwordError) {
    passwordErrorDisplay.style.display = 'block';
    var showPasswordCheckbox = document.getElementById('showPasswordCheckbox');
    showPasswordCheckbox.checked = false;
  }
  setInterval(function() {
    const check = document.getElementById('showPasswordCheckbox');
    const pass = document.getElementById('password');
    if (check.checked) {
      pass.value = '';
    }
  }, 1000);
</script>
<script>
  function togglePassword() {
    var passwordInput = document.getElementById('password');
    var toggleIcon = document.querySelector('.toggle-password');
    if (passwordInput.type === 'password') {
      passwordInput.type = 'text';
      toggleIcon.innerHTML = ' < i class = "fa fa-eye" aria - hidden = "true" > < /i>';
    } else {
      passwordInput.type = 'password';
      toggleIcon.innerHTML = ' < i class = "fa fa-eye-slash" aria - hidden = "true" > < /i>';
    }
  }
</script> @endpush