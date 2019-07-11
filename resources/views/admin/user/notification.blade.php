@extends('layouts.admin')

@section('breadcrumbs')
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('admin.user') }}">{{ __('User') }}</a>
    </li>
    <li class="breadcrumb-item active">
        {{ __('Notifikasi') }}
    </li>
</ol>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-3">
            <div class="card-header">
                {{ __('Notifikasi') }}
                <div class="float-right">
                    <a class="btn btn-info" href="{{ route('admin.user.notification.create', [$user]) }}">
                        <i class="fas fa-plus-square"></i>
                    </a>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="datatable table-hover table-striped" data-url="{{ route('admin.user.notification.table', [$user]) }}">
                        <thead>
                            <tr>
                                <th data-field="token">{{ __('ID') }}</th>
                                <th data-field="title">{{ __('Judul') }}</th>
                                <th data-field="subtitle">{{ __('Sub Judul') }}</th>
                                <th data-field="content">{{ __('Konten') }}</th>
                                <th data-field="status">{{ __('Baca') }}</th>
                                <th data-field="created_at">{{ __('Tanggal') }}</th>
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