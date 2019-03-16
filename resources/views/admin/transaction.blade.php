@extends('layouts.admin')

@section('breadcrumbs')
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    </li>
    <li class="breadcrumb-item active">
        Transactions
    </li>
</ol>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-3">
            <div class="card-header">
                Pending Transaction Lists
            </div>
            <div class="card-body">
                <table class="table table-responsive table-hover table-striped">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>ID</th>
                            <th>Product</th>
                            <th>User</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $transaction)
                        <tr>
                            <td>{{ $transaction->created_at }}</td>
                            <td>{{ $transaction->id }}</td>
                            <td>{{ $transaction->order()->first()->product()->first()->name }}</td>
                            <td>{{ $transaction->order()->first()->user()->first()->email }}</td>
                            <td>{{ formatCurrency($transaction->total + $transaction->id) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
