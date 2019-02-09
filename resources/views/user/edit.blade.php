@extends('layouts.user')

@section('breadcrumbs')
<ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="{{ route('user.dashboard') }}">Dashboard</a>
  </li>
  <li class="breadcrumb-item active">Edit</li>
</ol>
@endsection

@section('content')
<div class="col-12">
  <div class="card mb3">

  </div>
</div>
@endsection
