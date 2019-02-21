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
    <a href="{{ route('user.product.order') }}">Order</a>
  </li>
  <li class="breadcrumb-item active">Checkout</li>
</ol>
@endsection

@section('content')
<div class="row">
  <div class="col-sm-6 col-md-6">
    <div class="card mb3">
      <div class="card-header">
        <h5>Terima Kasih</h5>
      </div> <!-- card header -->

      <div class="card-body">
        <p>
          Pesanan Anda sudah kami terima.
          <br>Untuk melanjutkan proses menabung, silakan lakukan transfer untuk Order anda.
        </p>
      </div> <!-- card body -->

      <div class="card-footer">
        Jumlah Transfer : Rp. {{ number_format($order->transaction()->first()->total, 2, ',', '.') }}
        <br>Kode unik : {{ $order->transaction()->first()->id }}
        <br>Total : Rp. {{ number_format($order->transaction()->first()->total + $order->transaction()->first()->id, 2, ',', '.') }}
      </div> <!-- card footer -->
    </div> <!-- card -->
  </div> <!-- col -->

  <div class="col-sm-6 col-md-6">
    <div class="card mb3">
      <div class="card-header">
        <h5>Informasi Transfer</h5>
      </div> <!-- card header -->


      <div class="card-body">
        List ATM ada disini
      </div> <!-- card body -->

      <div class="card-footer">
        Untuk mempercepat konfirmasi pembayaran
        <br>Pada kolom komentar tuliskan : NPID{{ auth()->user()->id }}TR{{ $order->transaction()->first()->id }}
      </div>

    </div>
  </div> <!-- col -->
</div> <!-- row -->

<hr>
<a href="{{ route('user.product') }}" class="btn btn-info">
  <i class="fas fa-arrow-left"></i> Kembali ke produk
</a>
<hr>
@endsection
