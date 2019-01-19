<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>{{ config('app.name') }} - Platform Menabung Pohon</title>
  @include('includes.css')

  @yield('style')

</head>

<body>

  @yield('content')

  @include('includes.js')

  @yield('script')
</body>

</html>
