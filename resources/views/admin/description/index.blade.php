@extends('layouts.admin')

@section('breadcrumbs')
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a>
    </li>
    <li class="breadcrumb-item active">
        {{ __('Deskripsi') }}
    </li>
</ol>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                {{ __('Deskripsi') }}
                <div class="float-right">
                    <a href="{{ route('admin.description.create') }}" class="btn btn-info">
                        <i class="fas fa-plus-square"></i> 
                    </a>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="datatable table table-hover table-table-striped" data-url="{{ route('admin.description.table') }}">
                        <thead>
                            <tr>
                                <th data-field="img">{{ __('Gambar') }}</th>
                                <th data-field="title">{{ __('Judul') }}</th>
                                <th data-field="text">{{ __('Teks') }}</th>
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