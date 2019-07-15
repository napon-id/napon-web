@extends('layouts.admin')

@section('breadcrumbs')
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('trees.index') }}">{{ __('Pohon') }}</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('admin.tree.product.index', [$tree, $product]) }}">{{ __('Tabungan') }}</a>
    </li>
    <li class="breadcrumb-item active">
        {{ __('Simulasi') }}
    </li>
</ol>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                {{ __('Simulasi') }}
                <div class="float-right">
                    <a href="{{ route('admin.tree.product.simulation.create', [$tree, $product]) }}" class="btn btn-info">
                        <i class="fas fa-plus-square"></i>
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="datatable table table-hover table-striped" data-url="{{ route('admin.tree.product.simulation.table', [$tree, $product]) }}">
                        <thead>
                            <tr>
                                <th data-field="year">{{ __('Tahun') }}</th>
                                <th data-field="min">{{ __('Persentase minimal (%)') }}</th>
                                <th data-field="max">{{ __('Persentase maksimal (%)') }}</th>
                                <th data-field="action">{{ __('Aksi') }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection