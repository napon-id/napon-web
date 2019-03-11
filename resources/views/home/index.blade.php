@extends('layouts.home')

@section('content')
<!-- main layout -->
<main id="mainContent">
  <!-- Hero intro -->
  <div class="container-fluid content">
      <div class="hero">
        <div id="heroIntro1" class="hero-page">
            <div class="container">

                <p class="float-right">
                    <!-- <span class="fas fa-arrow-left"></span> -->
                    <span class="fas fa-hand-paper" data-toggle="tooltip" data-placement="top" title="swipe"></span>
                    <span class="fas fa-arrow-right"></span>
                </p>
                <h2>Rajin <span class="bold">MENABUNG</span></h2>
                <h2><span class="bold">POHON</span> Pangkal</h2>
                <h2><span class="light-green">KAYA + BONUS</span></h2>
                <br>
                <h2><span class="light-green" style="font-family: 'Pacifico', cursive !important;">alam lestari</span></h2>
                <br>
                <h3>Ayo <span class="peach-gradient">#NabungPohon</span></h3>
                <img src="{{ asset('images/media/icon/napon.png') }}" alt="Napon.ID" style="max-height: 2em;">
                <div style="height: 2em;"></div>
                <br>
                <a href="#aboutUs" class="bt btn-lg btn-light-green" style="padding: 1em;">
                    CARI TAU LEBIH <span class="fas fa-arrow-right"></span>
                </a>
            </div>
        </div>
        <div id="heroIntro2" class="hero-page">
            <div class="container">
                <p class="float-right">
                    <span class="fas fa-arrow-left"></span>
                    <span class="fas fa-hand-paper" data-toggle="tooltip" data-placement="top" title="swipe"></span>
                    <span class="fas fa-arrow-right"></span>
                </p>
                <h2><span class="light-green" style="font-family: 'Pacifico', cursive !important;">setiap yang</span></h2>
                <h2>KITA <span class="bold underlined">TANAM</span> </h2>
                <h2><span class="light-green">AKAN KITA</span></h2>
                <br>
                <h2><span class="bold">TUAI</span> HASILNYA</h2>
                <br>
                <h3><span class="peach-gradient">#NabungPohon</span> Sekarang</h3>
                <img src="{{ asset('images/media/icon/napon.png') }}" alt="Napon.ID" style="max-height: 2em;">
                <div style="height: 2em;"></div>
                <br>
                <a href="#aboutUs" class="bt btn-lg btn-light-green" style="padding: 1em;">
                    CARI TAU LEBIH <span class="fas fa-arrow-right"></span>
                </a>
            </div>
        </div>
        <div id="heroIntro3" class="hero-page">
            <div class="container">
                <p class="float-right">
                    <span class="fas fa-arrow-left"></span>
                    <span class="fas fa-hand-paper" data-toggle="tooltip" data-placement="top" title="swipe"></span>
                    <!-- <span class="fas fa-arrow-right"></span> -->
                </p>
                <h2>DEMI </h2>
                <h2><span class="light-green">MASA DEPAN</span></h2>
                <h2><span class="bold">YANG</span></h2>
                <br>
                <h2><span class="light-green" style="font-family: 'Pacifico', cursive !important;">lebih cerah</span></h2>
                <br>
                <h3>Mulai <span class="peach-gradient">#NabungPohon</span></h3>
                <img src="{{ asset('images/media/icon/napon.png') }}" alt="Napon.ID" style="max-height: 2em;">
                <div style="height: 2em;"></div>
                <br>
                <a href="#aboutUs" class="bt btn-lg btn-light-green" style="padding: 1em;">
                    CARI TAU LEBIH <span class="fas fa-arrow-right"></span>
                </a>
            </div>
        </div>
      </div> <!-- Carousel -->
  </div>

  <div class="container-fluid content" id="aboutUs">
    <div class="container">
      <h2><span style="font-weight: bold;">Tentang <span class="light-green-text">{{ config('app.name') }}</span></h2>
      <hr>
      <br>
      <div class="row">
        <div class="col-md-6">
          <h4>Platform Menabung Pohon</h4>
          <p>
            Nabung Pohon ({{ config('app.name') }}) merupakan platform menabung pohon dan bercocok tanam. Portal untuk membantu Anda yang ingin berinvestasi pada pohon tanpa ribet, tanpa lahan, tanpa perawatan namun tetap bisa di pantau secara berkala. {{ config('app.name') }} juga membantu dalam proses penjualan pohon yang sudah layak panen dengan harga real-time.
          </p>
          <a href="#" class="btn btn-outline-light-green waves-effect">
            Baca lebih lanjut <span class="fas fa-leaf"></span>
          </a>
        </div>

        <div class="col-md-6">
          <!-- Opening video -->
          <div class="embed-responsive embed-responsive-16by9">
            <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/OzFaSz5lET0" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
          </div>
        </div>
      </div>

    </div>
  </div>

  <div class="container-fluid content light-green" id="whyChooseUs">
    <div class="container">
      <h2>Mengapa Menabung di {{ config('app.name') }}?</h2>
      <hr>
      <div class="row">
        <div class="col-12">
          <div class="why-choose-us" style="text-align: center;">

            <div>
              <img src="{{ asset('images/media/icon/platform-bagi-hasil-terbaik.png') }}" alt="Platform Bagi Hasil Terbaik">
              <br><br>Platform bagi hasil terbaik
            </div>

            <div>
              <img src="{{ asset('images/media/icon/mudah-terjangkau.png') }}" alt="Platform Bagi Hasil Terbaik">
              <br><br>Mudah dan Terjangkau
            </div>

            <div>
              <img src="{{ asset('images/media/icon/aman-professional.png') }}" alt="Platform Bagi Hasil Terbaik">
              <br><br>Aman dan Professional
            </div>

            <div>
              <img src="{{ asset('images/media/icon/memberikan-dampak-sosial.png') }}" alt="Platform Bagi Hasil Terbaik">
              <br><br>Memberikan Dampak Sosial
            </div>

            <div>
              <img src="{{ asset('images/media/icon/ramah-lingkungan.png') }}" alt="Platform Bagi Hasil Terbaik">
              <br><br>Ramah Lingkungan
            </div>

            <div>
              <img src="{{ asset('images/media/icon/memberdayakan-petani.png') }}" alt="Platform Bagi Hasil Terbaik">
              <br><br>Memberdayakan Petani
            </div>

          </div> <!-- Carousel -->
        </div> <!-- col-12 -->
      </div> <!-- row -->
    </div> <!-- container -->
  </div> <!-- fluid container -->

  <div class="container-fluid content" id="howWeWork">
    <div class="container">
      <h2>
          <span class="light-green-text">Bagaimana</span> <span class="bold">{{ config('app.name') }}</span> <span class="light-green-text">Bekerja?</span>
      </h2>
      <hr>

      <div class="row">
        <div class="col-sm-2" style="text-align: center;">
          <img src="{{ asset('images/media/icon/registrasi.png') }}" alt="Registrasi">
        </div>
        <div class="col-sm-10">
          <h4>Registrasi</h4>
          <p>
            Anda dapat mendaftar pada platform {{ config('app.name') }} dengan menekan tombol <a href="{{ url('/register') }}" class="btn btn-light-green peach-gradient">Registrasi</a>
          </p>
        </div>
      </div>
      <br>
      <div class="row">
        <div class="col-sm-2" style="text-align: center;">
          <img src="{{ asset('images/media/icon/danai.png') }}" alt="Danai">
        </div>
        <div class="col-sm-10">
          <h4>Menabung</h4>
          <p>
            Anda dapat memulai menabung pohon melalui platform kami setelah melakukan verifikasi alamat email.
          </p>
        </div>
      </div>
      <br>
      <div class="row">
        <div class="col-sm-2" style="text-align: center;">
          <img src="{{ asset('images/media/icon/budidaya.png') }}" alt="Budidaya">
        </div>
        <div class="col-sm-10">
          <h4>Budidaya</h4>
          <p>
            {{ config('app.name') }} bersama mitra petani menjalankan proyek budidaya dengan dana yang Anda tabung.
          </p>
        </div>
      </div>
      <br>
      <div class="row">
        <div class="col-sm-2" style="text-align: center;">
          <img src="{{ asset('images/media/icon/panen.png') }}" alt="Panen">
        </div>
        <div class="col-sm-10">
          <h4>Panen</h4>
          <p>
            {{ config('app.name') }} bersama mitra petani menjual hasil budidaya ketika musim panen telah tiba.
          </p>
        </div>
      </div>
      <br>
      <div class="row">
        <div class="col-sm-2" style="text-align: center;">
          <img src="{{ asset('images/media/icon/bagi-hasil.png') }}" alt="Bagi Hasil">
        </div>
        <div class="col-sm-10">
          <h4>Bagi hasil</h4>
          <p>
            Setelah panen selesai, Anda dapat menikmati keuntungan dari bagi hasil dengan dana yang Anda tabung.
          </p>
        </div>
      </div>

      <br>
      <h3 style="text-align: center;">
        Pelajari <a href="{{ route('layanan') }}" class="btn btn-lg btn-info waves-effect blue-gradient">layanan kami <span class="fas fa-star"></span></a> selengkapnya
      </h3>

    </div>
  </div>

</main>
<!-- main layout -->
@endsection
