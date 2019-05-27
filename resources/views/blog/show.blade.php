@extends('layouts.home')

@section('content')
<!-- main layout -->
<main id="mainContent">
    <!-- hero intro -->
    <div class="container-fluid content white-text text-center" id="aboutUsHero">
        <div class="container">
            <h1>Blog <span class="badge light-green">{{ config('app.name') }}</span> </h1>
        </div> <!-- container -->
    </div> <!-- container fluid -->

    <!-- descriptive content -->
    <div class="container-fluid smaller-content" id="aboutUsDescriptive">
        <div class="container">
            <h4>
                {{ $article->title }}
            </h4>
            <span class="text-muted">{{ $article->created_at->format('d/m/Y') }}</span>
            <hr>
            By : {{ $article->author }}
        </div>

        <div class="container text-center mb-3 mt-3">
            <img class="img-fluid" src="{{ $article->img }}" style="max-height: 35em;">
        </div>

        <div class="container">
            <p>
                {!! $article->description !!}
            </p>
        </div>
    </div> <!-- container fluid -->

    <div class="container">
        <div class="row">
            @foreach ($relatedArticles as $article)
            <div class="col-sm-3 col-md-4">
                <!-- Card -->
                <div class="card">
                    <!-- Card image -->
                    <div class="view overlay" title="{{ $article->title }}">
                        <img class="card-img-top mx-auto d-block" style="max-width: 12em; max-height: 12em;" src="{{ $article->img }}" alt="Card image cap">
                        <a href="{{ route('blog.show', [$article->slug]) }}">
                            <div class="mask rgba-white-slight"></div>
                        </a>
                    </div>
                    <div class="card-body">
                        <p class="card-title" title="{{ $article->title }}">{{ str_limit($article->title, 50) }}</p>
                    </div>
                </div> <!-- Card -->
                <br>
            </div>
            @endforeach
        </div>
    </div>

    <div class="container">
        <a href="{{ route('blog.index') }}" class="btn btn-lg btn-light-green">Kembali</a>
    </div>

    @endsection