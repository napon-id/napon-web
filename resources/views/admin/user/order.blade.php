@extends('layouts.admin')

@section('breadcrumbs')
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('admin.user') }}">User</a>
    </li>
    <li class="breadcrumb-item">
        {{ __('Tabungan') }}
    </li>
</ol>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-3">
            <div class="card-header">
                {{ $user->email }}
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="datatable table table-hover table-striped" data-url="{{ route('admin.user.order.table', [$user]) }}">
                        <thead>
                            <th data-field="token">{{ __('ID') }}</th>
                            <th data-field="product_name">{{ __('Produk') }}</th>
                            <th data-field="buy_price">{{ __('Harga Awal') }}</th>
                            <th data-field="selling_price">{{ __('Harga Akhir') }}</th>
                            <th data-field="created_at">{{ __('Tanggal') }}</th>
                            <th data-field="location">{{ __('Lokasi') }}</th>
                            <th data-field="updated_at">{{ __('Perubahan Terakhir') }}</th>
                            <th data-field="status">{{ __('Status') }}</th>
                            <th data-field="details">{{ __('Detail') }}</th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Logout Modal-->
<div class="modal fade" id="updatesModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Updates</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
          <div id="accordion">
              some text and ant crumbs
          </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('script')
<script>
$(document).ready(function () {
    $('body').on('click', '.updates', function () {
        $('#accordion').empty();
        $.ajax({
            url: "{{ route('admin.user.order.updates') }}/?id=" + $(this).data('id'),
            dataType: "JSON",
            success: function (data) {
                var html = '';
                $.each(data.updates, function (key, val) {
                    html += '<div class="card">';
                        html += '<div class="card-header">';
                            html += '<a class="card-link" data-toggle="collapse" href="#card'+val.id+'">';
                                html += val.title;
                            html += '</a>';
                        html += '</div>';

                        html += '<div id="card'+val.id+'" class="collapse" data-parent="#accordion">';
                            html += '<div class="card-body">';
                            html += val.description;
                            html += '</div>';
                        html += '</div>';

                    html += '</div>';
                });
                $('#accordion').append(html);
            }
        })
    })
});
</script>
@endsection
