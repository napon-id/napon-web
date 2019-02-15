@extends('layouts.user')

@section('breadcrumbs')
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="{{ route('user.dashboard') }}">Dashboard</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('user.product') }}">Product</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('user.product.detail', ['token' => $order->token]) }}">Detail</a>
    </li>
    <li class="breadcrumb-item active">
        Update
    </li>
</ol>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb3">
            <div class="card-header">
                <a href="{{ route('user.product.detail', ['token' => $order->token]) }}" class="btn btn-info">
                    <span class="fas fa-arrow-left"></span> Kembali
                </a>
            </div>

            <div class="card-body">
                <h5>
                    {{ $orderUpdate->title }}
                </h5>

                <i>
                    {{ $orderUpdate->created_at->format('d-m-Y h:i:sa') }}
                </i>

                <hr>
                <p>
                    {!! $orderUpdate->description !!}
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
