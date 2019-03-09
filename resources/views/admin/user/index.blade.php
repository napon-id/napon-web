@extends('layouts.admin')

@section('breadcrumbs')
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    </li>
    <li class="breadcrumb-item active">
        User
    </li>
</ol>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <table class="datatable table table-display" data-url="{{ route('admin.user.table') }}" id="userTable">
            <thead>
                <tr>
                    <th data-field="id">ID</th>
                    <th data-field="name">Name</th>
                    <th data-field="email">Email</th>
                    <th data-field="created_at">Register date</th>
                    <th data-field="verified">Verified</th>
                    <th data-field="detail">Detail</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>


<div class="modal fade" id="userDetail" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">
            Detail
        </h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <table class="table table-hover">
              <tr>
                  <td>KTP</td>
                  <td><span class="detail-ktp"></span></td>
              </tr>
              <tr>
                  <td>Phone</td>
                  <td><span class="detail-phone"></span></td>
              </tr>
              <tr>
                  <td>Address</td>
                  <td><span class="detail-address"></span></td>
              </tr>
          </table>
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
  $('#userTable').on('click', '.detail', function ()  {
      var id = $(this).data('id');
      $.ajax({
          url: "{{ route('admin.user.detail') }}?id=" + id,
          dataType: "JSON",
          success: function (data) {
              console.log(data.ktp);
              $('.detail-ktp').html(data.ktp);
              $('.detail-phone').html(data.phone);
              $('.detail-address').html(data.address);
          }
      })
  });

});
</script>
@endsection
