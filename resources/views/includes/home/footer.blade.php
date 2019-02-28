<!-- Footer -->
<footer class="page-footer font-small unique-color-dark">

  <!-- Social buttons -->
  <div class="light-green">
    <div class="container">
      <!--Grid row-->
      <div class="row py-4 d-flex align-items-center">

        <!--Grid column-->
        <div class="col-md-6 col-lg-5 text-center text-md-left mb-4 mb-md-0">
          <h6 class="mb-0 white-text">Terhubung dengan kami di sosial media</h6>
        </div>
        <!--Grid column-->

        <!--Grid column-->
        <div class="col-md-6 col-lg-7 text-center text-md-right">
          <!-- Facebook-->
          <a class="fb-ic ml-0" href="">
            <i class="fab fa-facebook white-text mr-4"> </i>
          </a>
          <!--Twitter-->
          <!-- <a class="tw-ic">
            <i class="fab fa-twitter white-text mr-4"> </i>
          </a> -->
          <!--Linkedin-->
          <!-- <a class="li-ic">
            <i class="fab fa-linkedin white-text mr-4"> </i>
          </a> -->
          <!--Instagram-->
          <a class="ins-ic" href="https://instagram.com/napon.id" target="_blank">
            <i class="fab fa-instagram white-text mr-lg-4"> </i>
          </a>
        </div>
        <!--Grid column-->

      </div>
      <!--Grid row-->
    </div>
  </div>
  <!-- Social buttons -->

  <!--Footer Links-->
  <div class="container mt-5 mb-4 text-center text-md-left">
    <div class="row mt-3">

      <!--First column-->
      <div class="col-md-3 col-lg-4 col-xl-3 mb-4">
        <h6 class="text-uppercase font-weight-bold">
          <strong>{{ config('app.name') }}</strong>
        </h6>
        <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
        <p>Platform yang membantu Anda menabung pohon tanpa ribet, tanpa memikirkan lahan, tanpa memikiran perawatan namun selalu bisa dipantau secara berkala.</p>
      </div>
      <!--/.First column-->

      <!--Second column-->
      <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
        <h6 class="text-uppercase font-weight-bold">
          <strong>Informasi</strong>
        </h6>
        <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
        <p>
          <a href="{{ route('tentang-kami') }}">Tentang Kami</a>
        </p>
        <p>
          <a href="{{ route('layanan') }}">Layanan</a>
        </p>
        <!-- <p>
          <a href="#!">Jenis Pohon</a>
        </p> -->
        <p>
          <a href="{{ route('faq') }}">FAQ</a>
        </p>
      </div>
      <!--/.Second column-->

      <!--Third column-->
      <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
        <h6 class="text-uppercase font-weight-bold">
          <strong>Navigasi</strong>
        </h6>
        <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
        <p>
          <a href="{{ route('login') }}">Masuk</a>
        </p>
        <p>
          <a href="{{ route('register') }}">Pendaftaran</a>
        </p>
        <p>
          <a href="{{ url('https://blog.napon.id') }}" target="_blank">Blog <span class="fas fa-window"></span></a>
        </p>
        <p>
          <a href="{{ route('layanan') }}#serviceSimulation">Simulasi Menabung</a>
        </p>
      </div>
      <!--/.Third column-->

      <!--Fourth column-->
      <div class="col-md-4 col-lg-3 col-xl-3">
        <h6 class="text-uppercase font-weight-bold">
          <strong>Hubungi Kami</strong>
        </h6>
        <hr class="deep-purple accent-2 mb-4 mt-0 d-inline-block mx-auto" style="width: 60px;">
        <p>
          <i class="fa fa-home mr-3"></i> Jl. Pattimura Raya, kompleks ruko Masjid Baitut Taqwa, Mapangan - Ungaran</p>
        <p>
          <i class="fa fa-envelope mr-3"></i> naponindonesia@gmail.com</p>
        <p>
          <i class="fa fa-phone mr-3"></i> (024) 7590 1139</p>
      </div>
      <!--/.Fourth column-->

    </div>
  </div>
  <!--/.Footer Links-->

  <!-- Copyright -->
  <div class="footer-copyright text-center py-3">© {{ date('Y') }} Copyright:
    <a href="{{ route('home') }}"> {{ config('app.name') }}</a>
  </div>
  <!-- Copyright -->

</footer>
<!-- Footer -->
