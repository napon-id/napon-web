@extends('layouts.admin')

@section('breadcrumbs')
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('admin.invest') }}">Invest</a>
    </li>
    <li class="breadcrumb-item active">
        Tree
    </li>
</ol>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-3">
            <div class="card-header">
                {{ __('Trees') }}
                <a href="{{ route('trees.create') }}" class="btn btn-info float-right">
                    <i class="fas fa-plus-square"></i> Add new Tree
                </a>
            </div> <!-- card-header -->

            <div class="card-body">
                <table class="table table-hover table-striped">
                    <thead>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Availability</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        @foreach($trees as $tree)
                        <tr>
                            <td>{{ $tree->name }}</td>
                            <td>{{ $tree->description }}</td>
                            <td>{{ formatCurrency($tree->price) }}</td>
                            <td>{{ $tree->available }}</td>
                            <td>
                                <a href="{{ route('trees.edit', [$tree]) }}" class="btn btn-link">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('trees.destroy', [$tree]) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-link" onclick="return confirm('Are you sure to delete this?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                                <a class="btn btn-dark" href="{{ route('products.index', ['tree' => $tree]) }}">
                                    <i class="fas fa-list"></i> Products
                                </a>
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
