@extends('layouts.user')

@section('breadcrumbs')
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="{{ route('user.dashboard') }}">Dashboard</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('user.product') }}">Product</a>
    </li>
    <li class="breadcrumb-item active">
        Detail
    </li>
</ol>
@endsection

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card mb3">
            <div class="card-header">
                {{ __('Informasi Produk Tabungan') }}
            </div>

            <div class="card-body">
                <table class="table table-hover">
                    <tr>
                        <td>Status Tabungan</td>
                        <td>
                            @if ($order->status == 'paid')
                                <span class="badge badge-warning">Pohon sedang ditanam</span>
                            @elseif ($order->status == 'investing')
                                <span class="badge badge-info">Pohon telah ditanam</span>
                            @else
                                <span class="badge badge-success">Produk tabungan telah selesai</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Lokasi Pohon</td>
                        <td>
                            @if ($order->location_id)
                                {{ $order->location_id }}
                            @else
                                Lokasi penanaman belum ditentukan
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Harga Jual</td>
                        <td>
                            @if ($order->selling_price > 0)
                                {{ formatCurrency($order->selling_price) }}
                            @else
                                Pohon belum siap dijual
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td>Nilai Tabungan Awal</td>
                        <td>
                            {{ formatCurrency($order->transaction()->first()->total) }}
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div> <!-- col-6 -->

    <div class="col-md-6">
        <div class="card mb3">
            <div class="card-header">
                Informasi Paket Menabung
            </div>

            <div class="card-body">
                <table class="table table-hover">
                    <tr>
                        <td>Paket Menabung</td>
                        <td>{{ $order->product()->first()->name }}</td>
                    </tr>
                    <tr>
                        <td>Banyak Pohon</td>
                        <td>{{ $order->product()->first()->tree_quantity }}</td>
                    </tr>
                    <tr>
                        <td>Jenis Pohon</td>
                        <td>{{ $order->product()->first()->tree()->first()->name }}</td>
                    </tr>
                    <tr>
                        <td>Harga per pohon</td>
                        <td>{{ formatCurrency($order->product()->first()->tree()->first()->price) }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div> <!-- col-6 -->
</div> <!-- row -->

<hr>

<div class="row">
    <div class="col-12">
        <div class="card mb3">
            <div class="card-header">
                Informasi Tabungan
            </div>

            <div class="card-body">

                @foreach($order->updates()->get() as $a)
                <h5>
                    {{-- refers to product detail --}}
                    <a href="{{ route('user.product.update', ['token' => $order->token, 'id' => $a->id]) }}">
                        {{ $a->title }}
                    </a>
                </h5>
                <p>{{ $a->description }}</p>
                @endforeach

            </div>

            <div class="card-footer">

            </div>
        </div>
    </div>

</div>
@endsection
