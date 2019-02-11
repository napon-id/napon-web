@extends('layouts.user')

@section('breadcrumbs')
<ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="{{ route('user.dashboard') }}">Dashboard</a>
  </li>
  <li class="breadcrumb-item active">
    Product
  </li>
</ol>
@endsection

@section('content')
@if($userInformation->phone)
<div class="row">
    <div class="col-12">

        <div class="table-responsive">
          <table class="table" id="productTable">
            <select class="form-control" id="statusFilter" style="max-width: 20%">
              <option value="">Semua status</option>
              @foreach($status_select as $indexKey=>$a)
              <option value="{{ $indexKey }}" {{ request()->query('status') == $indexKey ? 'selected' : '' }}>{{ $a }}</option>
              @endforeach
            </select>
            <thead>
              <tr>
                <th>Order ID</th>
                <th>Tanggal</th>
                <th>Produk Tabungan</th>
                <th>Nilai Tabungan</th>
                <th>Nilai Akhir</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <!-- Ajax Load -->
            </tbody>
          </table>
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
function reloadStatus() {
  var status = $('#selectStatus').val();
  url = $(location).attr('href');

  console.log(url);

  if(url.indexOf('?') != -1) {
    var url = url + "&status=" + status;
  } else {
    var url = url + "?status=" + status;
  }

  $(location).attr('href', url);
  }

  $(document).ready(function () {
    // Datatable
    var productTable = $('#productTable').DataTable({
      processing: true,
      serverSide: true,
      ajax: "{{ route('user.product.api') }}",
      columns: [
        { data: 'id' },
        { data: 'created_at' },
        { data: 'product_name' },
        { data: 'price' },
        { data: 'selling_price' },
        { data: 'status' },
        { data: 'action', searchable: false }
      ],
      language: {
        'lengthMenu'  : 'Menampilkan _MENU_ transaksi per halaman',
        'zeroRecords' : 'Belum terdapat data transaksi',
        'info'        : 'Menampilkan halaman _PAGE_ dari _PAGES_',
        'infoEmpty'   : 'Tidak terdapat data',
        'infoFiltered': '(disaring dari _MAX_ data transaksi)',
        'search'      : 'Cari:'
      }
    });

    $('#statusFilter').on('change', function(){
      var filter_value = $(this).val();
      var new_url = "{{ route('user.product.api') }}/" + filter_value;
      productTable.ajax.url(new_url).load();
    });

  });
</script>
@endsection
