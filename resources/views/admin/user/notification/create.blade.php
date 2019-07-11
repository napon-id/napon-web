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
        <a href="{{ route('admin.user.notification', [$user]) }}">{{ __('Notifikasi') }}</a>
    </li>
    <li class="breadcrumb-item active">
        {{ __('Tambah Notifikasi') }}
    </li>
</ol>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-3">
            <div class="card-header">{{ __('Notifikasi') }}</div>
            <div class="card-body">
                <form action="{{ route('admin.user.notification.store', [$user]) }}" method="post">
                    @csrf
                    @method('POST')
                    <div class="form-group row">
                        <label for="title" class="col-md-3">{{ __('Judul') }}</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" name="title" value="{{ old('title') }}">
                            @if ($errors->has('title'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('title') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="subtitle" class="col-md-3">{{ __('Sub Judul') }}</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control {{ $errors->has('subtitle') ? 'is-invalid' : '' }}" name="subtitle" value="{{ old('subtitle') }}">
                            @if ($errors->has('subtitle'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('subtitle') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="content" class="col-md-3">{{ __('Konten') }}</label>
                        <div class="col-md-6">
                            <textarea name="content" class="form-control {{ $errors->has('content') ? 'is-invalid' : '' }}">{{ old('content') }}</textarea>
                            @if ($errors->has('content'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('content') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <input type="submit" class="btn btn-info" value="{{ __('Simpan') }}">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection