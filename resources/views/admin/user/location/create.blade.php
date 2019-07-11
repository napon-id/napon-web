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
    <li class="breadcrumb-item active">
        @if (isset($location))
        {{ __('Perbarui Lokasi') }}
        @else
        {{ __('Tambah Lokasi') }}
        @endif
    </li>
</ol>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">{{ __('Form Lokasi') }}</div>
            <div class="card-body">
                <form action="{{ isset($location) ? route('admin.user.order.location.update', [$user, $order, $location]) : route('admin.user.order.location.store', [$user, $order]) }}" method="post">
                    @csrf
                    @if (isset($location))
                        {{ method_field('PUT') }}
                    @else
                        {{ method_field('POST') }}
                    @endif

                    <div class="form-group row">
                        <label for="location" class="col-md-3">{{ __('Lokasi') }}</label>
                        <div class="col-md-4">
                            <input type="text" name="location" class="form-control{{ $errors->has('location') ? ' is-invalid' : '' }}" value="{{ $location->location ?? old('location') }}">
                            @if($errors->has('location'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('location') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="address" class="col-md-3">{{ __('Alamat') }}</label>
                        <div class="col-md-6">
                            <textarea name="address" class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}">{{ $location->address ?? old('address') }}</textarea>
                            @if($errors->has('address'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('address') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="description" class="col-md-3">{{ __('Deskripsi') }}</label>
                        <div class="col-md-6">
                            <textarea name="description" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}">{{ $location->description ?? old('description') }}</textarea>
                            @if($errors->has('description'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('description') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="lat" class="col-md-3">{{ __('Latitude') }}</label>
                        <div class="col-md-4">
                            <input type="text" name="lat" class="form-control{{ $errors->has('lat') ? ' is-invalid' : '' }}" value="{{ $location->lat ?? old('lat') }}">
                            @if($errors->has('lat'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('lat') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="lng" class="col-md-3">{{ __('Longitude') }}</label>
                        <div class="col-md-4">
                            <input type="text" name="lng" class="form-control{{ $errors->has('lng') ? ' is-invalid' : '' }}" value="{{ $location->lng ?? old('lng') }}">
                            @if($errors->has('lng'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('lng') }}</strong>
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