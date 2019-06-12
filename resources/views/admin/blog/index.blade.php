@extends('layouts.admin')

@section('breadcrumbs')
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    </li>
    <li class="breadcrumb-item active">
        Blog
    </li>
</ol>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-3">
            <div class="card-header">
                {{ __('Blog') }}
                <div class="float-right">
                    <a href="{{ route('admin.blog.create') }}" class="btn btn-info">
                        {{ __('Create') }}
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="datatable table-hover table-striped" data-url="{{ route('admin.blog.table') }}">
                        <thead>
                            <tr>
                                <th data-field="title">{{ __('Title') }}</th>
                                <th data-field="img">{{ __('Image') }}</th>
                                <th data-field="action">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
