<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <link rel='shortcut icon' type='image/png' href="{{ asset('images/media/icon/favicon.png') }}" />
  <title>{{ config('app.name') }} - Platform Menabung Pohon</title>
  <link rel="stylesheet" href="{{ asset('css/home.css') }}">

</head>

<body>
  @include('includes.home.header')

  @yield('content')

  @include('includes.home.footer')

  <script src="{{ asset('js/home.js') }}"></script>
</body>

</html>
