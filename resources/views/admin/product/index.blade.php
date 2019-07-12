@extends('layouts.admin')

@section('breadcrumbs')
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('trees.index') }}">{{ __('Pohon') }}</a>
    </li>
    <li class="breadcrumb-item active">
        {{ __('Tabungan') }}
    </li>
</ol>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-3">
            <div class="card-header">
                {{ __('Tabungan') }}
                <a href="{{ route('products.create', ['tree' => $tree]) }}" class="btn btn-info float-right">
                    <i class="fas fa-plus-square"></i>
                </a>
            </div> <!-- card-header -->

            <div class="card-body">
                <div class="table-responsive">
                    <table class="datatable table table-striped table-hover" data-url="{{ route('products.table') }}">
                        <thead>
                            <tr>
                                <th data-field="id">{{ __('ID') }}</th>
                                <th data-field="name">{{ __('Nama') }}</th>
                                <th data-field="tree_quantity">{{ __('Jumlah Pohon') }}</th>
                                <th data-field="description">{{ __('Deskripsi') }}</th>
                                <th data-field="price">{{ __('Harga') }}</th>
                                <th data-field="img_black">{{ __('Img Black') }}</th>
                                <th data-field="img_white">{{ __('Img White') }}</th>
                                <th data-field="img_background">{{ __('Img Background') }}</th>
                                <th data-field="action">{{ __('Aksi') }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div> <!-- card-body -->
        </div> <!-- card -->
    </div> <!-- col-12 -->
</div> <!-- row -->
@endsection
