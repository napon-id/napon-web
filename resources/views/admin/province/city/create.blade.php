@extends('layouts.admin')

@section('breadcrumbs')
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('admin.province.index') }}">{{ __('Provinsi') }}</a>
    </li>
    <li class="breadcumb-item">
        <a href="{{ route('admin.province.city.index', [$province]) }}">{{ __('Kota') }}</a>
    </li>
    <li class="breadcrumb-item active">
        {{ isset($city) ? __('Edit') : __('Tambah') }}
    </li>
</ol>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">{{ __('Form Kota') }}</div>
            <div class="card-body">
                <form action="{{ isset($city) ? route('admin.province.city.update', [$province, $city]) : route('admin.province.city.store', [$province]) }}" method="post">
                    @csrf
                    @if (isset($city))
                        {{ method_field('PUT') }}
                    @else
                        {{ method_field('POST') }}
                    @endif

                    <div class="form-group row">
                        <label for="name" class="col-md-3">{{ __('Nama Kota') }}</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" name="name" value="{{ isset($city) ? $city->name : old('name') }}">
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