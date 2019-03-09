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
    <div class="card mb-3">
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
          <h4>
              Jumlah Transfer :
              <span class="badge badge-info">
                  Rp. {{ number_format($order->transaction()->first()->total, 2, ',', '.') }}
              </span>
          </h4>
          <h4>
              Kode unik :
              <span class="badge badge-info">
                  {{ $order->transaction()->first()->id }}
              </span>
          </h4>
          <h4>
              Total :
              <br>
              <span id="totalPrice" class="badge badge-success">
                  Rp. {{ number_format($order->transaction()->first()->total + $order->transaction()->first()->id, 2, ',', '.') }}
              </span>
              <button onclick="copyToClipboard('totalPrice')" class="btn btn-xs btn-dark" data-toggle="popover" data-placement="right" data-content="copied">
                  <i class="far fa-copy"></i>
              </button>
          </h4>
      </div> <!-- card footer -->
    </div> <!-- card -->
  </div> <!-- col -->

  <div class="col-sm-6 col-md-6">
    <div class="card mb-3">
      <div class="card-header">
        <h5>Informasi Transfer</h5>
      </div> <!-- card header -->


      <div class="card-body">
        List ATM ada disini
      </div> <!-- card body -->

      <div class="card-footer">
        Untuk mempercepat konfirmasi pembayaran
        <br>Pada kolom berita tuliskan :
        <br>
        <h4>
            <span id="information" class="badge badge-success">
                NPID{{ auth()->user()->id }}TR{{ $order->transaction()->first()->id }}
            </span>
            <button type="button" onclick="copyToClipboard('information')" class="btn btn-dark" data-toggle="popover" data-placement="right" data-content="copied">
                <i class="far fa-copy"></i>
            </button>
        </h4>
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
