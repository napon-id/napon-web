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
        @foreach ($articles as $article)
        <div class="container">
            <h2 class="light-green-text">
                <a href="{{ route('blog.show', [str_slug($article->title)]) }}">
                    {{ $article->title }}
                </a>
            </h2>
            <hr>
            <span class="text-muted">{{ $article->created_at ? $article->created_at->format('d/m/Y') : '' }}</span>
            <p>
                {{ $article->description }}
            </p>
        </div> <!-- container -->
        @endforeach
    </div> <!-- container fluid -->

    <div class="container text-center">
        {{ $articles->links('vendor.pagination.mdb') }}
    </div>
@endsection