@extends('layouts.admin')

@section('breadcrumbs')
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('admin.invest') }}">Invest</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('locations.index') }}">Locations</a>
    </li>
    <li class="breadcrumb-item active">
        {{ isset($location) ? 'Edit' : 'Add' }}
    </li>
</ol>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-3">
            <div class="card-header">
                {{ isset($location) ? 'Edit' : 'Add' }}
            </div>

            <div class="card-body">
                <form action="{{ isset($location) ? route('locations.update', [$location]) : route('locations.store') }}" method="post">
                    @csrf
                    {{ isset($location) ? method_field('PUT') : method_field('POST') }}

                    <div class="form-group">
                        <label for="location">Location</label>
                        <input type="text" name="location" class="form-control{{ $errors->has('location') ? ' is-invalid' : '' }}" value="{{ $location->location ?? old('location') }}" placeholder="Example: Jawa Tengah">
                        @if($errors->has('location'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('location') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea name="address" class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" placeholder="Example: Lahan pepohonan km 12 ringroad Ungaran-Salatiga kecamatan Ungaran Kota Semarang">{{ $location->address ?? old('address') }}</textarea>
                        @if($errors->has('address'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('address') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" placeholder="(Optional) Example : Pada tikungan pertama km 12 ringroad utara belok kiri terdapat keterangan lahan dan terdapat police line">{{ $location->description ?? old('description') }}</textarea>
                        @if($errors->has('description'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('description') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="lat">Latitude</label>
                        <input type="text" name="lat" class="form-control{{ $errors->has('lat') ? ' is-invalid' : '' }}" value="{{ $location->lat ?? old('lat') }}" placeholder="example: 1234567890,123456">
                        @if($errors->has('lat'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('lat') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="lng">Longitude</label>
                        <input type="text" name="lng" class="form-control{{ $errors->has('lng') ? ' is-invalid' : '' }}" value="{{ $location->lng ?? old('lng') }}" placeholder="example: 1234567890,123456">
                        @if($errors->has('lng'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('lng') }}</strong>
                        </span>
                        @endif
                    </div>

                    <input type="submit" value="Submit" class="btn btn-success">
                </form>
            </div>

            <div class="card-footer">
                <a href="{{ route('locations.index') }}" class="btn btn-info">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
