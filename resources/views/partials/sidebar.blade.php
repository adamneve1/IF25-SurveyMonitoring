<!-- resources/views/partials/sidebar.blade.php -->
<aside class="main-sidebar sidebar-light elevation-4">
  <!-- Brand Logo -->
  <a href="{{ url('/') }}" class="brand-link">
    <img src="{{ asset('img/logo.png') }}" alt="AdminLTE Logo" class="brand-image img-elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">LKS Batam</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="{{ asset('lte/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block">Admin</a>
      </div>
    </div>

    <!-- SidebarSearch Form (Optional) -->
    <div class="form-inline">
      <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-sidebar">
            <i class="fas fa-search fa-fw"></i>
          </button>
        </div>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Dashboard -->
        <li class="nav-item">
          <a href="#" class="nav-link active">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard</p>
          </a>
        </li>

        <!-- Batamindo -->
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-map-marker-alt"></i>
            <p>
              Batamindo
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Manhour</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Manpower</p>
              </a> 
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Place 3</p>
              </a>
            </li>
          </ul>
        </li>

        <!-- Tanjung Uncang -->
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-map-marker-alt"></i>
            <p>
              Tanjung Uncang
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Manhour</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Manpower</p>
              </a> 
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Place 3</p>
              </a>
            </li>
          </ul>
        </li>

        <!-- Sekupang -->
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-map-marker-alt"></i>
            <p>
              Sekupang
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Manhour</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Manpower</p>
              </a> 
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Place 3</p>
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>
