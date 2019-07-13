@extends('layouts.admin')

@section('breadcrumbs')
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a>
    </li>
    <li class="breadcrumb-item active">
        {{ __('Pohon') }}
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
                    <i class="fas fa-plus-square"></i>
                </a>
            </div> <!-- card-header -->

            <div class="card-body">
                <table class="table table-hover table-striped">
                    <thead>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        @foreach($trees as $tree)
                        <tr>
                            <td>{{ $tree->name }}</td>
                            <td>{{ $tree->description }}</td>
                            <td>
                                <div class="btn-group">

                                    <a href="{{ route('trees.edit', [$tree]) }}" class="btn">
                                        <i class="fas fa-edit" data-toggle="tooltip" data-placement="bottom" title="Edit"></i>
                                    </a>
                                    <form action="{{ route('trees.destroy', [$tree]) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn">
                                            <i class="fas fa-trash" data-toggle="tooltip" data-placement="bottom" title="Delete"></i>
                                        </button>
                                    </form>
                                    <a class="btn" href="{{ route('products.index', ['tree' => $tree]) }}">
                                        <i class="fas fa-list" data-toggle="tooltip" data-placement="bottom" title="{{ __('Tabungan') }}"></i>
                                    </a>
                                </div>
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
