@extends('layouts.admin')

@section('breadcrumbs')
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('admin.province.index') }}">{{ __('Provinsi') }}</a>
    </li>
    <li class="breadcrumb-item active">
        {{ __('Kota') }}
    </li>
</ol>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                {{ __('Kota') }}
                <div class="float-right">
                    <a href="{{ route('admin.province.city.create', [$province]) }}" class="btn btn-info">
                        <i class="fas fa-plus-square"></i>
                    </a>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="datatable table table-hover table-striped" data-url="{{ route('admin.province.city.table', [$province]) }}">
                        <thead>
                            <tr>
                                <th data-field="id">{{ __('ID') }}</th>
                                <th data-field="name">{{ __('Nama Kota') }}</th>
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