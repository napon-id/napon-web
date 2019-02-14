@extends('layouts.home')

@section('style')
<style media="screen">
  .accordion {
    background-color: #eee;
    color: #444;
    cursor: pointer;
    padding: 18px;
    width: 100%;
    border: none;
    text-align: left;
    outline: none;
    font-size: 15px;
    transition: 0.4s;
  }

  .active, .accordion:hover {
    background-color: #ccc;
  }

  .accordion:after {
    content: '\002B';
    color: #777;
    font-weight: bold;
    float: right;
    margin-left: 5px;
  }

  .active:after {
    content: "\2212";
  }

  .panel {
    padding: 0 18px;
    background-color: white;
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.2s ease-out;
  }
</style>
@endsection

@section('content')
<main id="mainContent">
  <!-- faq hero intro -->
  <div class="container-fluid content light-green white-text text-center" id="faqHero">
    <div class="container">
      <h1>Frequently Asked Questions</h1>
    </div> <!-- container -->
  </div> <!-- container fluid -->

  <!-- faq intro -->
  <div class="container-fluid smaller-content" id="faqIntro">
    <div class="container">
      <h6>Anda dapat menemukan panduan terkait {{ config('app.name') }} dan tanya-jawab yang sering disampaikan oleh pengguna. Jika ada hal yang belum dijelaskan dalam FAQ, silakan hubungi kami melalui live chat di bawah atau email ke <a href="mailto:naponindonesia@gmail.com">naponindonesia@gmail.com</a></h6>
    </div> <!-- container -->
  </div> <!-- container fluid -->

  <!-- faq about Napon -->
  <div class="container-fluid smaller-content" id="faqAbout">
    <div class="container">
      <h2 class="light-green-text">Tentang {{ config('app.name') }}</h2>
      <hr>
      @foreach($faqs_about as $faq)
        @if ($faq->answer)
            <button class="accordion">{{ $faq->question }}</button>
            <div class="panel">
                <p>{{ $faq->answer }}</p>
            </div>
        @endif
      @endforeach
    </div> <!-- container -->
  </div> <!-- container fluid -->

  <!-- faq about User -->
  <div class="container-fluid smaller-content" id="faqAbout">
    <div class="container">
      <h2 class="light-green-text">Member {{ config('app.name') }}</h2>
      <hr>
      @foreach($faqs_user as $faq)
          @if ($faq->answer)
              <button class="accordion">{{ $faq->question }}</button>
              <div class="panel">
                  <p>{{ $faq->answer }}</p>
              </div>
          @endif
      @endforeach
    </div> <!-- container -->
  </div> <!-- container fluid -->

  <!-- faq about misc -->
  <div class="container-fluid smaller-content" id="faqMisc">
    <div class="container">
      <h2 class="light-green-text">Lain-lain</h2>
      <hr>
      @foreach($faqs_misc as $faq)
          @if ($faq->answer)
              <button class="accordion">{{ $faq->question }}</button>
              <div class="panel">
                  <p>{{ $faq->answer }}</p>
              </div>
          @endif
      @endforeach
    </div> <!-- container -->
  </div> <!-- container fluid -->
</main>
@endsection

@section('script')
<script>
  var acc = document.getElementsByClassName("accordion");
  var i;

  for (i = 0; i < acc.length; i++) {
    acc[i].addEventListener("click", function() {
      this.classList.toggle("active");
      var panel = this.nextElementSibling;
      if (panel.style.maxHeight){
        panel.style.maxHeight = null;
      } else {
        panel.style.maxHeight = panel.scrollHeight + "px";
      }
    });
  }
</script>
@endsection
