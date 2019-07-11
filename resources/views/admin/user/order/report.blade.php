@extends('layouts.admin')

@section('breadcrumbs')
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('admin.user') }}">{{ __('User') }}</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('admin.user.order', [$user]) }}">{{ __('Tabungan') }}</a>
    </li>
    <li class="breadcrumb-item">
        {{ __('Laporan') }}
    </li>
</ol>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-3">
            <div class="card-header">
                {{ __('Laporan') }}
                <div class="float-right">
                    <a href="{{ route('admin.user.order.report.create', [$user, $order]) }}" class="btn btn-info">
                        <i class="fas fa-plus-square"></i>
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="datatable table-striped table-hover" data-url="{{ route('admin.user.order.report.table', [$user, $order]) }}">
                        <thead>
                            <tr>
                                <th data-field="report_key">{{ __('ID') }}</th>
                                <th data-field="period">{{ __('Periode') }}</th>
                                <th data-field="start_date">{{ __('Tanggal Awal') }}</th>
                                <th data-field="end_date">{{ __('Tanggal Akhir') }}</th>
                                <th data-field="tree_height">{{ __('Tinggi Pohon') }}</th>
                                <th data-field="tree_diameter">{{ __('Diameter') }}</th>
                                <th data-field="tree_state">{{ __('Kondisi') }}</th>
                                <th data-field="weather">{{ __('Cuaca') }}</th>
                                <th data-field="report_image">{{ __('Gambar') }}</th>
                                <th data-field="report_video">{{ __('Video') }}</th>
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