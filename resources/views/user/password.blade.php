@extends('layouts.user')

@section('breadcrumb')
<ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="{{ route('user.dashboard') }}">Dashboard</a>
  </li>
  <li class="breadcrumb-item">
    <a href="{{ route('user.edit') }}">Edit</a>
  </li>
  <li class="breadcrumb-item active">Password</li>
</ol>
@endsection
