@extends('layouts.admin')

@section('breadcrumbs')
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    </li>
    <li class="breadcrumb-item active">
        Invest
    </li>
</ol>
@endsection

@section('content')
<div class="card mb-3">
    <div class="card-header">
        here lies the statistics
    </div>
</div>
@endsection
