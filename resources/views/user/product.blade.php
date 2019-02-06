@extends('layouts.user')

@section('breadcrumbs')
<ol class="breadcrumb">
  <ul class="breadcrumb-item">
    <a href="{{ url('user') }}">Dashboard</a>
  </ul>
  <ul class="breadcrumb-item active">
    Product
  </ul>
</ol>
@endsection

@section('content')
<div class="card mb3">
  <div class="row">
    <div class="col-12">
      <div class="table-responsive">
        <table class="table table-hover" id="userProductTable">
          <tr>
            <th>Order ID</th>
            <th>Produk Tabungan</th>
            <th>Nilai Tabungan</th>
            <th>Nilai Akhir</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
          @foreach($orders as $a)
          <tr>
            <td>{{ $a->id }}</td>
            <td>{{ $a->product_name }}</td>
            <td>Rp. {{ number_format($a->tree_price * $a->product_tree_quantity, 2, ',', '.') }}</td>
            <td>
              @if($a->selling_price < 1)
              Produk tabungan belum selesai
              @else
              {{ number_format($a->selling_price, 2, ',', '.') }}
              @endif
            </td>
            <td>
              @if($a->status == 'waiting')
                <p class="badge badge-dark">Menunggu top-up pembayaran</p>
              @elseif($a->status == 'paid')
                <p class="badge badge-warning">Pohon sedang ditanam</p>
              @elseif($a->status == 'investing')
                <p class="badge badge-info">Pohon telah ditanam</p>
              @elseif($a->status == 'done')
                <p class="badge badge-success">Produk tabungan telah selesai</p>
              @endif
            </td>
            <td>
              <a href="{{ url('/user/product/detail/' . $a->id) }}" class="btn btn-info">
                <span class="fas fa-eye"></span> {{ $a->status == 'done' ? ' Lihat Detail' : ' Pantau' }}
              </a>
            </td>
          </tr>
          @endforeach
        </table>
      </div>
    </div>
  </div>
</div>
@endsection
