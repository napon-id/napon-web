@extends('layouts.home')

@section('content')
<!-- main layout -->
<main id="mainContent">
  <!-- Hero intro -->
  <div class="container-fluid content" id="heroIntro">
    <div class="container">
      <!-- <h1 class="bold" style="font-size: 3.5em">Napon.ID</h1> -->
      <h2>Rajin <span class="bold">MENABUNG</span></h2>
      <h2><span class="bold">POHON</span> Pangkal</h2>
      <h2><span class="light-green">KAYA + BONUS</span></h2>
      <br>
      <h2><span class="light-green" style="font-family: 'Pacifico', cursive !important;">alam lestari</span></h2>
      <br>
      <h3>Ayo <span class="peach-gradient">#NabungPohon</span></h3>
      <img src="https://media.napon.id/logo/logo-napon1.png" alt="Napon.ID" style="max-height: 2em;">
      <div style="height: 2em;"></div>
      <br>
      <a href="#aboutUs" class="bt btn-lg btn-light-green" style="padding: 1em;">
        CARI TAU LEBIH <span class="fas fa-arrow-right"></span>
      </a>
    </div>
  </div>

  <div class="container-fluid content" id="aboutUs">
    <div class="container">
      <h2 style="color: #8bc34a;">Tentang {{ config('app.name') }}</h2>
      <hr>
      <br>
      <div class="row">
        <div class="col-md-6">
          <h4>Platform Menabung Pohon</h4>
          <p>
            Nabung Pohon ({{ config('app.name') }}) merupakan platform menabung pohon dan bercocok tanam. Portal untuk membantu Anda yang ingin berinvestasi pada pohon tanpa ribet, tanpa lahan, tanpa perawatan namun tetap bisa di pantau secara berkala. {{ config('app.name') }} juga membantu dalam proses penjualan pohon yang sudah layak panen dengan harga real-time.
          </p>
          <a href="#" class="btn btn-outline-light-green waves-effect">
            Pelajari lebih lanjut <span class="fas fa-leaf"></span>
          </a>
        </div>

        <div class="col-md-6">
          <!-- Opening video -->
          <div class="embed-responsive embed-responsive-16by9">
            <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/OdIJ2x3nxzQ" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
          </div>
        </div>
      </div>

    </div>
  </div>

</main>
<!-- main layout -->
@endsection

@section('script')
<script>
$(document).ready(function(){
  // Add smooth scrolling to all links
  $("a").on('click', function(event) {

    // Make sure this.hash has a value before overriding default behavior
    if (this.hash !== "") {
      // Prevent default anchor click behavior
      event.preventDefault();

      // Store hash
      var hash = this.hash;

      // Using jQuery's animate() method to add smooth page scroll
      // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
      $('html, body').animate({
        scrollTop: $(hash).offset().top
      }, 800, function(){

        // Add hash (#) to URL when done scrolling (default click behavior)
        window.location.hash = hash;
      });
    } // End if
  });
});
</script>
@endsection
