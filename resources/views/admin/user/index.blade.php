@extends('layouts.admin')

@section('breadcrumbs')
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="{{ route('admin.dashboard') }}">{{ _('Dashboard') }}</a>
        </li>
    <li class="breadcrumb-item active">
        {{ __('User') }}
    </li>
</ol>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <table class="datatable table table-display" data-url="{{ route('admin.user.table') }}" id="userTable">
            <thead>
                <tr>
                    <th data-field="user_key">{{ __('ID User') }}</th>
                    <th data-field="name">{{ __('Nama') }}</th>
                    <th data-field="email">{{ __('Email') }}</th>
                    <th data-field="created_at">{{ __('Tanggal Bergabung') }}</th>
                    <th data-field="verified">Verifikasi</th>
                    <th data-field="detail">Detail</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>
@endsection