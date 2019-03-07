@extends('layouts.admin')

@section('breadcrumbs')
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('admin.invest') }}">Invest</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('trees.index') }}">{{ $tree->name }}</a>
    </li>
    <li class="breadcrumb-item active">
        Products
    </li>
</ol>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-3">
            <div class="card-header">
                {{ __('Products') }}
                <a href="{{ route('products.create') }}" class="btn btn-info float-right">
                    <i class="fas fa-plus-square"></i> Add new Product
                </a>
            </div> <!-- card-header -->

            <div class="card-body">
                <table class="table table-hover table-striped">
                    <thead>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Trees</th>
                        <th>img</th>
                        <th>Percentage</th>
                        <th>Available</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        @foreach($tree->products()->get() as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->description }}</td>
                            <td>{{ $product->tree_quantity }}</td>
                            <td><a href="{{ $product->img }}" target="_blank">{{ $product->img }}</a></td>
                            <td>{{ $product->percentage }}%</td>
                            <td>{{ $product->available }}</td>
                            <td>
                                <a href="{{ route('products.edit', [$product]) }}">Edit</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div> <!-- card-body -->
        </div> <!-- card -->
    </div> <!-- col-12 -->
</div> <!-- row -->
@endsection
