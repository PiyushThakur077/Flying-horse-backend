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

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Users Management</h3>
              <div style="float:right;"><a class="btn btn-success" href="{{ url('admin/createUser') }}">Add User</a></div>
            </div>
            <form action="" method="POST" class="form-horizontal">
                @csrf
                <!-- /.box-header -->
                <div class="box-body">
                    
                </div>
            </form>
          </div>
        </div>
      </div>
    </section>
  </div>