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
        {{ isset($province) ? __('Edit') : __('Tambah') }}
    </li>
</ol>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">{{ __('Form Provinsi') }}</div>
            <div class="card-body">
                <form action="{{ isset($province) ? route('admin.province.update', [$province]) : route('admin.province.store') }}" method="post">
                    @csrf
                    @if (isset($province))
                        {{ method_field('PUT') }}
                    @else
                        {{ method_field('POST') }}
                    @endif

                    <div class="form-group row">
                        <label for="name" class="col-md-3">{{ __('Nama Provinsi') }}</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" value="{{ isset($province) ? $province->name : old('name') }}">
                            @if ($errors->has('name'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('name') }}</strong>
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