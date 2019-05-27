<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin - {{ config('app.name') }}</title>

    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

  </head>

  <body id="page-top">

    <nav class="navbar navbar-expand navbar-dark bg-dark static-top">

      <a class="navbar-brand mr-1" href="{{ url('/') }}">{{ config('app.name') }}</a>

      <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
        <i class="fas fa-bars"></i>
      </button>

      <!-- Navbar -->
      <ul class="navbar-nav ml-auto mr-0">

        <li class="nav-item dropdown no-arrow">
          <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-user-circle fa-fw"></i>
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
            <a class="dropdown-item" href="#">Pengaturan</a>
            <a class="dropdown-item" href="#">Log Aktivitas</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Logout</a>
          </div>
        </li>
      </ul>

    </nav>

    <div id="wrapper">

      <!-- Sidebar -->
      <ul class="sidebar navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
          </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('admin.user') }}">
                <i class="fas fa-fw fa-user-alt"></i>
                <span>User</span>
            </a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="tabunganDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-fw fa-tree"></i>
            <span>Invest</span>
          </a>
          <div class="dropdown-menu" aria-labelledby="tabunganDropdown">
            <h6 class="dropdown-header">Admin based</h6>
            <a class="dropdown-item" href="{{ route('trees.index') }}">Trees</a>
            <a class="dropdown-item" href="{{ route('locations.index') }}">Locations</a>
            <a class="dropdown-item" href="{{ route('admin.withdraw.index') }}">Withdraws</a>
            <div class="dropdown-divider"></div>
            <h6 class="dropdown-header">User based</h6>
            <a class="dropdown-item" href="{{ route('admin.transaction') }}">Transactions</a>
            <a class="dropdown-item" href="{{ route('admin.order.index') }}">Orders</a>
          </div>
        </li>
        {{--<li class="nav-item">
          <a class="nav-link" href="charts.html">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Charts</span></a>
        </li>--}}
        <li class="nav-item">
          <a class="nav-link" href="{{ route('admin.blog.index') }}">
            <i class="fas fa-fw fa-table"></i>
            <span>Blog</span></a>
        </li>
      </ul>

      <div id="content-wrapper">

        <div class="container-fluid">

          <!-- Breadcrumbs-->
          @yield('breadcrumbs')

          <!-- session flash -->
          @if(session('status'))
          <div class="alert alert-success fade show alert-dismissible">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              {!! session('status') !!}
          </div>
          @endif

          @yield('content')

        </div>
        <!-- /.container-fluid -->

        <!-- Sticky Footer -->
        <footer class="sticky-footer">
          <div class="container my-auto">
            <div class="copyright text-center my-auto">
              <span>Copyright © Your Website 2018</span>
            </div>
          </div>
        </footer>

      </div>
      <!-- /.content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Siap untuk Logout?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">Tekan tombol "Logout di bawah jika Anda ingin melanjutkan"</div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
            <a class="btn btn-primary" href="{{ url('logout') }}">Logout</a>
          </div>
        </div>
      </div>
    </div>

    <script src="{{ asset('js/dashboard.js') }}"></script>
    @yield('script')
  </body>

</html>
