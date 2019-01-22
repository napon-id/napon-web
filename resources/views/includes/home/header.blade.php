<!-- navigation -->
<header>
  <!--Navbar-->
<nav class="navbar navbar-expand-lg navbar-light fixed-top" style="background-color: #fff">

  <div class="container">

    <!-- Navbar brand -->
    <a class="navbar-brand" href="{{ url('/') }}">
      <img src="https://media.napon.id/logo/logo-napon2.png" alt="{{ config('app.name') }}" style="max-height: 25px">
    </a>

    <!-- Collapse button -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarMenu"
      aria-controls="navbarMenu" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Collapsible content -->
    <div class="collapse navbar-collapse" id="navbarMenu">

      <!-- Left menu -->
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="{{ route('tentang-kami') }}">Tentang Kami</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('layanan') }}">Layanan</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="https://blog.napon.id">Blog</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('faq') }}">FAQ</a>
        </li>
      </ul>

      <!-- Right menu -->
      <ul class="navbar-nav ml-auto">
        @auth
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" id="navbarDropdownUserMenu" data-toggle="dropdown" aria-haspopup="true"
          aria-expanded="false">
            <span class="fa fa-user"></span> {{ auth()->user()->name }}
          </a>
          <div class="dropdown-menu dropdown-primary" aria-labelledby="navbarDropdownUserMenu">
            <a class="dropdown-item" href="#">Profil</a>
            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Keluar</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
          </div>
        </li>
        @else
        <li class="nav-item">
          <a class="nav-link btn btn-light-green" href="{{ url('login') }}">Masuk | Mendaftar <span class="fas fa-sign-in-alt"></span></a>
        </li>
        <!-- <li class="nav-item">
          <a class="nav-link" href="{{ url('register') }}">Register</a>
        </li> -->
        @endauth
      </ul>

    </div>
    <!-- Collapsible content -->

  </div>

</nav>
<!--/.Navbar-->
</header>