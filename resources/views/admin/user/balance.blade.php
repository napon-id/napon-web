@extends('layouts.admin')

@section('breadcrumbs')
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('admin.user') }}">User</a>
    </li>
    <li class="breadcrumb-item active">
        Balance
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
                <div class="text-center">
                    <h3>{{ formatCurrency($user->balance()->first()->balance) }}</h3>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
<div class="col-12">
        <div class="card mb-3">
            <div class="card-header">
                Withdraw History
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="datatable table table-hover table-striped" data-url="{{ route('admin.user.balance.table', [$user]) }}">
                        <thead>
                            <th data-field="date">Date</th>
                            <th data-field="id">ID</th>
                            <th data-field="amount">Amount</th>
                            <th data-field="status">Status</th>
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
