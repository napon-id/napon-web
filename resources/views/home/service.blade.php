@extends('layouts.home')

@section('content')
<main id="mainContent">
  <!-- Service hero -->
  <div class="container-fluid content light-green white-text text-center" id="serviceHero">
    <div class="container">
      <h1>Layanan <span class="badge light-green">{{ config('app.name') }}</span> </h1>
    </div> <!-- container -->
  </div> <!-- container fluid -->

  <!-- trees -->
  <div class="container-fluid smaller-content" id="serviceTrees">
    <div class="container">
      <h2>Pohon <span class="light-green-text">yang dapat ditabung</span></h2>
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
      <h2><span class="light-green-text">Paket Menabung Pohon</span> Sengon Solomon</h2>
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
              <div class="card-text">
                <h5>
                    Jumlah pohon : {{ $product->tree_quantity }}
                </h5>
                <h5>
                    Tabungan : Rp {{ formatCurrency($product->tree_quantity * $tree->price) }}
                </h5>
                <h5>
                    Lama menabung : {{ $product->time }}
                </h5>
                <h5>
                    Keuntungan : {{ $product->percentage }} %
                </h5>
                <h5>
                    @if($product->has_certificate == true)
                        <span class="badge light-green">Sertifikat kepemilikan</span>
                    @else
                        <span class="badge badge-danger">Tanpa Sertifikat</span>
                    @endif
                </h5>
            </div>
              <!-- Button -->
              <div class="text-center">

                  <a href="{{ route('user.product.order') }}" class="btn btn-light-green">Pesan <i class="fas fa-leaf"></i></a>
              </div>
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
      <!-- <h2 class="light-green-text">Ilustrasi Return</h2> -->
      <!-- <hr> -->
      <div class="view overlay">
        <img src="{{ asset('images/media/img/simulate.jpg') }}" class="img-fluid" alt="Sample image with waves effect.">
        <a href="#!">
          <div class="mask waves-effect waves-light rgba-white-slight"></div>
        </a>
      </div> <!-- view overlay -->

    </div> <!-- container -->
  </div> <!-- container fluid -->
</main>
@endsection
