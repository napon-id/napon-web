@extends('layouts.home')

@section('content')
<!-- main layout -->
<main id="mainContent">
  <!-- hero intro -->
  <div class="container-fluid content white-text text-center" id="aboutUsHero">
    <div class="container">
      <h1>Tentang Kami</h1>
    </div> <!-- container -->
  </div> <!-- container fluid -->

  <!-- descriptive content -->
  <div class="container-fluid smaller-content" id="aboutUsDescriptive">
    <div class="container">
      <h2 class="light-green-text">Tentang {{ config('app.name') }}</h2>
      <hr>
      <p>
        {{ config('app.name') }} merupakan platform menabung pohon dan bercocok tanam. Portal untuk membantu Anda yang ingin berinvestasi pada pohon tanpa ribet, tanpa lahan, tanpa perawatan namun tetap bisa di pantau secara berkala. Napon.ID juga membantu dalam proses penjualan pohon yang sudah layak panen dengan harga real-time. Saat ini kami berfokus pada penanaman pohon sengon solomon.
      </p>
    </div> <!-- container -->
  </div> <!-- container fluid -->


  <div class="container-fluid smaller-content" id="aboutUsDeliver">
    <div class="container">
      <h2 class="light-green-text">{{ config('app.name') }} Hadir Untuk Anda</h2>
      <hr>
      <img class="img-fluid" src="https://media.napon.id/img/scheme.png" alt="Skema {{ config('app.name') }}">
    </div> <!-- container -->
  </div> <!-- container fluid -->
</main>
@endsection
