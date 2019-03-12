@extends('layouts.admin')

@section('breadcrumbs')
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    </li>
    <li class="breadcrumb-item">
        Withdraw
    </li>
</ol>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-3">
            <div class="card-header">
                Withdraw Lists
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="datatable table table-hover table-striped" data-url="{{ route('admin.withdraw.table') }}">
                        <thead>
                            <tr>
                                <th data-field="date">Date</th>
                                <th data-field="id">ID</th>
                                <th data-field="email">Email</th>
                                <th data-field="amount">Amount</th>
                                <th data-field="status">Status</th>
                                <th data-field="action">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
