@extends('layouts.admin')

@section('breadcrumbs')
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    </li>
    <li class="breadcrumb-item active">
        Order
    </li>
</ol>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-3">
            <div class="card-header">
                Order Lists
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped datatable" data-url="{{ route('admin.order.table') }}">
                        <thead>
                            <th data-field="date">Date</th>
                            <th data-field="id">ID</th>
                            <th data-field="product">Product</th>
                            <th data-field="email">Email</th>
                            <th data-field="status">Status</th>
                            <th data-field="action">Action</th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Logout Modal-->
<div class="modal fade" id="orderUpdateModal" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Order Update</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <form method="post" id="orderUpdateForm">
              <input type="hidden" id="orderUpdateURL" name="url" value="">
              <div class="form-group">
                  <label for="status">Status (leave unchanged if don't wanna change order status)</label>
                  <select class="form-control" id="status" name="status">
                      <option value="">-</option>
                      <option value="waiting">Waiting</option>
                      <option value="paid">Paid</option>
                      <option value="investing">Investing</option>
                      <option value="done">Done</option>
                  </select>
              </div>

              <div class="form-group">
                  <label for="selling_price">Selling Price</label>
                  <input id="sellingPrice" type="number" name="selling_price" class="form-control">
              </div>
              <button type="submit" class="btn btn-info">
                  <i class="fas fa-pencil-alt"></i> Update
              </button>
          </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('script')
<script>
$('document').ready(function () {
    $('body').on('click', '.order-update-modal', function () {
        $('#sellingPrice').val("");
        $('#status').prop('selectedIndex', 0);
        var url = $(this).data('url');
        var orderUpdateURL = $(this).data('post');
        console.log(orderUpdateURL);
        $.get(url, function (response, status) {
            $('#sellingPrice').val(response.selling_price);
            $('#orderUpdateURL').val(orderUpdateURL);
        });
    });

    $('body').on('submit', '#orderUpdateForm', function () {
        event.preventDefault();
        console.log($('#orderUpdateURL').val());
        $.ajax({
            url: $('#orderUpdateURL').val(),
            type: "POST",
            dataType: "JSON",
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                method: '_UPDATE',
                selling_price: $('#sellingPrice').val(),
                status: $('#status').val(),
            },
            success: function (data) {
                $('#orderUpdateModal').modal('hide');
                if (data.order) {
                    console.log(data.order);
                    $('.datatable').DataTable().draw(false);
                }
            }
        })
    });
})


</script>
@endsection
