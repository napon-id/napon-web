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
                    <th data-field="user_key">ID</th>
                    <th data-field="name">Name</th>
                    <th data-field="email">Email</th>
                    <th data-field="created_at">Register date</th>
                    <th data-field="verified">Verified</th>
                    <th data-field="detail">Detail</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>
@endsection