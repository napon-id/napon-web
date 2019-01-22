<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <link rel='shortcut icon' type='image/png' href='https://media.napon.id/logo/logo1.png' />
  <link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
  <title>{{ config('app.name') }} - Platform Menabung Pohon</title>
  @include('includes.home.css')

  @yield('style')

</head>

<body>
  @include('includes.home.header')

  @yield('content')

  @include('includes.home.footer')

  @include('includes.home.js')

  @yield('script')
</body>

</html>
