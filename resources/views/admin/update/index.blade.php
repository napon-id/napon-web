@extends('layouts.admin')

@section('breadcrumbs')
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('admin.order.index') }}">Orders</a>
    </li>
    <li class="breadcrumb-item">
        Updates
    </li>
</ol>
@endsection


@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                Updates
                <a href="{{ route('admin.order.update.create', [$order]) }}" class="btn btn-success float-right">
                    <i class="fas fa-plus"></i> Add
                </a>
            </div>

            <div class="card-body">
                @foreach($order->updates()->latest()->get() as $update)
                <h4>
                    {{ $update->title }}
                </h4>
                <div class="btn-group">
                    <a href="{{ route('admin.order.update.edit', [$order, $update]) }}" class="btn btn-info">
                        <i class="fas fa-pencil-alt"></i>
                    </a>
                    <form action="{{ route('admin.order.update.destroy', [$order, $update]) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
                <i>{{ $update->created_at }}</i>
                <p>
                    {!! $update->description !!}
                </p>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
