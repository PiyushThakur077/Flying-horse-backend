<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">

        <li class="{{ (Route::current()->uri() == 'admin/dashboard') ? 'active' : ''  }}"><a href="{{ url('admin/dashboard') }}"><i class="fa fa-dashboard"></i><span>Dashboard</span></a></li>
        
       
    
        <li class="{{ (Route::current()->uri() == 'admin/settings') ? 'active' : ''  }}"><a href="{{ url('admin/settings') }}"><i class="fa fa-gears"></i><span>Settings</span></a></li>


      </ul>
    </section>
    <!-- /.sidebar -->
</aside>
