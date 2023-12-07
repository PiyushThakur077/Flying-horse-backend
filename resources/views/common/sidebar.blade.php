<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">

      <li class="{{ (Route::current()->uri() == 'admin/dashboard') || (Route::current()->uri() == 'users/create') ||  Route::is('users.edit')  ? 'active' : ''  }}"><a href="{{ url('admin/dashboard') }}"><i class="fa fa-dashboard"></i><span>Users</span></a></li>
        <li class="{{ (Route::current()->uri() == 'admin/teams') ? 'active' : ''  }}"><a href="{{ url('admin/teams') }}"><i class="fa fa-users"></i><span>Teams</span></a></li>
        
       
    
        <!-- <li class="{{ (Route::current()->uri() == 'admin/users') ? 'active' : ''  }}"><a href="{{ url('admin/users') }}"><i class="fa fa-users"></i><span>Users</span></a></li> -->


      </ul>
    </section>
    <!-- /.sidebar -->
</aside>
