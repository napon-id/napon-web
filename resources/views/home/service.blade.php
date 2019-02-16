@extends('layouts.home')

@section('content')
<main id="mainContent">
  <!-- Service hero -->
  <div class="container-fluid content light-green white-text text-center" id="serviceHero">
    <div class="container">
      <h1>Layanan Kami</h1>
    </div> <!-- container -->
  </div> <!-- container fluid -->

  <!-- trees -->
  <div class="container-fluid smaller-content" id="serviceTrees">
    <div class="container">
      <h2 class="light-green-text">Pohon yang dapat ditabung</h2>
      <hr>
      <p>
        Saat ini, Anda dapat menabung pohon Sengon Solomon pada {{ config('app.name') }}.
        <br><br>Mengapa pohon Sengon Solomon?
        <br>
        <br>
        Pohon Sengon Solomon memiliki masa panen yang lebih cepat dibandingkan pohon lainnya (antara 5-6 tahun) dengan tinggi rata-rata 10-13 meter dan diameter 25-30cm.
      </p>
    </div> <!-- container -->
  </div> <!-- container fluid -->

  <!-- products -->
  <div class="container-fluid smaller-content" id="serviceProduct">
    <div class="container">
      <h2 class="light-green-text">Paket Menabung Pohon Sengon Solomon</h2>
      <hr>
      <div class="row">
        @foreach($products as $product)
        <div class="col-sm-3 col-md-4">
          <!-- Card -->
          <div class="card">
            <!-- Card image -->
            <div class="view overlay">
              <img class="card-img-top mx-auto d-block" style="max-width: 12em; max-height: 12em;" src="{{ $product->img }}" alt="Card image cap">
              <a href="#!">
                <div class="mask rgba-white-slight"></div>
              </a>
            </div>
            <!-- Card content -->
            <div class="card-body">
              <!-- Title -->
              <h4 class="card-title">{{ $product->name }}</h4>
              <!-- Text -->
              <p class="card-text">
                Jumlah pohon : {{ $product->tree_quantity }}
                <br>
                Tabungan : Rp {{ formatCurrency($product->tree_quantity * $tree->price) }}
                <br>
                Lama menabung : {{ $product->time }}
                <br>
                Keuntungan : {{ $product->percentage }} %
                <br>
                @if($product->name != 'AKARKU')
                Sertifikat kepemilikan
                @endif
              </p>
              <!-- Button -->
              <a href="{{ route('user.product.order') }}" class="btn btn-light-green">Pesan <i class="fas fa-leaf"></i></a>
            </div>
          </div> <!-- Card -->
          <br>
        </div>
        @endforeach
      </div> <!-- row -->
    </div> <!-- container -->
  </div> <!-- container fluid -->

  <!-- simulation -->
  <div class="container-fluid smaller-content" id="serviceSimulation">
    <div class="container">
      <h2 class="light-green-text">Ilustrasi Return</h2>
      <hr>
      <!-- <p>
        Sebagai ilustrasi, pada tahun 2019 harga pohon sengon solomon dengan tinggi 10-13 meter dan diameter 25-30cm adalah <u>Rp. 750.000,00 </u>
        <br><br>
        Anda menabung dengan memilih paket HUTANKU, maka anda memiliki 100 pohon dengan nilai tabungan <u>Rp 30.000.000,00 </u> (Rp. 300.000,00 per pohon).
        <br>
        <h3>Penjualan</h3>
        Harga jual 1 pohon = <u>Rp. 750.000,00 </u>
        <br>
        Hara jual 100 pohon = <u>Rp. 75.000.000,00 </u>
        <br><br>
        <h3>Bagi Hasil</h3>
        85% dari Rp. 75.000.000,00 = <u>Rp. 63.750.000,00 </u> (Anda)
        <br>
        15% dari Rp. 75.000.000,00 = <u>Rp. 11.250.000,00 </u> (Petani)
        <br><br>
        Dalam tempo waktu 5-6 tahun Anda mendapatkan keuntungan sebesar <u>112,5%</u> dari modal Anda.
        <br><br>
        <i>Harga jual pohon sengon solomon tahun ini, saat di panen 5-6 tahun ke depan tentu akan berbeda. Terjadi kenaikan harga jual setiap tahunnya. Potensi keuntungan semakin besar yang didapatkan.</i>
      </p> -->
      <div class="view overlay">
        <img src="https://media.napon.id/img/simulate.jpg" class="img-fluid" alt="Sample image with waves effect.">
        <a href="https://media.napon.id/img/simulate.jpg">
          <div class="mask waves-effect waves-light rgba-white-slight"></div>
        </a>
      </div> <!-- view overlay -->

    </div> <!-- container -->
  </div> <!-- container fluid -->
</main>
@endsection
