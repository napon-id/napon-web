<!DOCTYPE html>
<html lang="en">

  <head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Dashboard - {{ config('app.name') }}</title>

    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

  </head>

  <body id="page-top">

    <nav class="navbar navbar-expand navbar-dark bg-dark static-top" style="background-color: #8bc34a!important">

      <a class="navbar-brand mr-1" href="{{ url('/') }}">{{ config('app.name') }}</a>

      <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
        <i class="fas fa-bars"></i>
      </button>

      <!-- Navbar -->
      <ul class="navbar-nav ml-auto mr-0">

        <li class="nav-item dropdown no-arrow">
          <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-user-circle fa-fw"></i> {{ auth()->user()->name }}
          </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
            <a class="dropdown-item" href="{{ route('user.edit') }}">Pengaturan</a>
            <a class="dropdown-item" href="{{ route('user.password') }}">Ganti kata sandi</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Logout</a>
          </div>
        </li>
      </ul>

    </nav>

    <div id="wrapper">

      <!-- Sidebar -->
      <ul class="sidebar navbar-nav">
        <li class="nav-item active">
          <a class="nav-link" href="{{ url('user') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
          </a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="productDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-fw fa-folder"></i>
            <span>Tabungan</span>
          </a>
          <div class="dropdown-menu" aria-labelledby="productDropdown">
            <a class="dropdown-item" href="{{ url('/user/product') }}">Produk Tabungan</a>
            <a class="dropdown-item" href="{{ url('/user/product/order') }}"><i class="fas fa-plus"></i> Order</a>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('user.wallet') }}">
            <i class="fas fa-fw fa-credit-card"></i>
            <span>Dompet</span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('user.activity') }}">
            <i class="fas fa-fw fa-info"></i>
            <span>Log Aktivitas</span></a>
        </li>
      </ul>

      <div id="content-wrapper">

        <div class="container-fluid">

          <!-- breadcrumbs -->
          @yield('breadcrumbs')

          <!-- session flash -->
          @if(session('status'))
          <div class="alert alert-success fade show alert-dismissible">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              {!! session('status') !!}
          </div>
          @endif

          <!-- content -->
          @yield('content')

        </div>
        <!-- /.container-fluid -->

        <!-- Sticky Footer -->
        <footer class="sticky-footer">
          <div class="container my-auto">
            <div class="copyright text-center my-auto">
              <span>Copyright © {{ config('app.name') . ' ' . date('Y') }} </span>
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
