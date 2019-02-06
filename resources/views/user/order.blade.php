@extends('layouts.user')

@section('breadcrumbs')
<ol class="breadcrumb">
  <ul class="breadcrumb-item">
    <a href="{{ url('/user') }}">Dashboard</a>
  </ul>
  <ul class="breadcrumb-item">
    <a href="{{ url('/user/product') }}">Product</a>
  </ul>
  <ul class="breadcrumb-item active">
    Order
  </ul>
</ol>
@endsection

@section('content')

@endsection
