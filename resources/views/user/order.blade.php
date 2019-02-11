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
    Order
  </li>
</ol>
@endsection

@section('content')
@if($userInformation->phone)
<div class="col-12">
  <div class="card mb3">
    <div class="card-header">
      <h4>Order produk tabungan</h4>
    </div>

    <div class="card-body">
      <form action="{{ action('User\OrderController@order') }}" id="orderProduct" method="post">
        @csrf
        <div class="form-group">
          <label for="product">Pilih produk tabungan untuk menampilkan detailnya</label>
          <select class="form-control {{ $errors->has('product') ? 'is-invalid' : '' }}" name="product" id="product">
            <option value="">Pilih</option>
            @foreach($products as $product)
            <option value="{{ $product->id }}">{{ $product->name }}</option>
            @endforeach
          </select>
          @if($errors->has('product'))
          <span class="invalid-feedback" role="alert">
            <strong>{{ $errors->first('product') }}</strong>
          </span>
          @endif

          <div class="form-group" id="description"></div>

        </div>

        <input type="submit" class="btn btn-success" value="Mulai Menabung">

      </form>
    </div>

    <div class="card-footer">
      <a href="{{ route('user.product') }}" class="btn btn-info"><i class="fas fa-arrow-left"></i> Kembali ke produk tabungan</a>
    </div>
  </div>
</div>
@else
    <h5 class="text-center">Sebelum memulai bertransaksi, Anda dimohon untuk melengkapi informasi diri.
        <br>Klik
        <a href="{{ route('user.edit') }}">lengkapi informasi diri</a>
    </h5>
@endif
@endsection

@section('script')
<script>
function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}
$(document).ready(function () {
  $('#product').on('change', function () {
    $('#description').empty();
    $('#description').append('<i>memuat</i>');
    var product_id = $('#product').val();

    if (product_id) {
      $.get("{{ route('user.product.api.order') }}?id=" + product_id, function (response, status) {
        var data = response.data;
        var price = numberWithCommas(data.tree_quantity * data.tree_price);

        $('#description').empty();
        $('#description').append('<br><hr><h4>'+data.name+'</h4>');
        $('#description').append('<p>'+data.description+'</p><br>');
        $('#description').append('<h5>Detail</h5>');
        $('#description').append('Jumlah pohon : ' + data.tree_quantity);
        $('#description').append('<br>Tabungan awal : Rp. ' + price + ',00');
        $('#description').append('<br>Lama menabung : ' + data.time);
        $('#description').append('<br>Keuntungan : ' + data.percentage + '%');
      });
    } else {
      $('#description').empty();
    }

  });
});
</script>
@endsection
