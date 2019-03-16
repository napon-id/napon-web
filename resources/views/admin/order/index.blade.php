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
@endsection
