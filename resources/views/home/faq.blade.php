@extends('layouts.home')

@section('content')
<main id="mainContent">
  <!-- faq hero intro -->
  <div class="container-fluid content light-green white-text text-center" id="faqHero">
    <div class="container">
      <h1>Frequently <span class="badge light-green">Asked</span> Questions</h1>
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
      <h2 class="light-green-text">FAQ</h2>
      <hr>
      @foreach($faqs as $faq)
        @if ($faq->answer)
            <button class="accordion">{{ $faq->question }}</button>
            <div class="panel">
                <p>{{ $faq->answer }}</p>
            </div>
        @endif
      @endforeach
    </div> <!-- container -->
  </div> <!-- container fluid -->
    </div> <!-- container -->
  </div> <!-- container fluid -->
</main>
@endsection
