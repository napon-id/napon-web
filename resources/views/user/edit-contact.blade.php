@extends('layouts.user')

@section('breadcrumbs')
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="{{ route('user.dashboard') }}">Dashboard</a>
    </li>
    <li class="breadcrumb-item active">Edit</li>
</ol>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb3">
            <div class="card-header">
                {{ __('Edit informasi User') }}
            </div>

            <div class="card-body">

                <ul class="nav nav-tabs mb-4">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.edit') }}">{{ __('Informasi Data Diri') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('user.edit.contact') }}">{{ __('Informasi Kontak') }}</a>
                    </li>
                </ul>

                <form action="{{ route('user.edit.contact.update') }}" method="post">
                    @csrf
                    @method('POST')

                    <div class="form-group row">
                        <label for="phone" class="col-md-3">{{ __('Nomor telepon') }}</label>
                        <div class="col-md-4">
                            <input type="text" name="phone" class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" value="{{ old('phone') ?? $userInformation->phone }}" placeholder="08xxxxxxxxx">
                            @if($errors->has('phone'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('phone') }}</strong>
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="province" class="col-md-3">{{ __('Provinsi Tempat Tinggal') }}</label>
                        <div class="col-md-6">
                            <select name="province" id="province" class="form-control {{ $errors->has('province') ? 'is-invalid' : '' }}" onchange="changeCities(this, '#city', '{{ route('city') }}')" required>
                                <option value="">{{ __('Pilih provinsi') }}</option>
                                @foreach ($provinces as $province)
                                <option value="{{ $province->id }}" {{ $province->id == $userInformation->province ? 'selected' : '' }}>{{ $province->name }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('province'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('province') }}</strong>
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="city" class="col-md-3">{{ __('Kota Tempat Tinggal') }}</label>
                        <div class="col-md-6">
                            <select name="city" id="city" class="form-control {{ $errors->has('city') ? 'is-invalid' : '' }}" required>
                                <option value=""></option>
                                @foreach ($cities as $city)
                                <option value="{{ $city->id }}" {{ $userInformation->city == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('city'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('city') }}</strong>
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="address" class="col-md-3">{{ __('Alamat lengkap') }}</label>
                        <div class="col-md-6">
                            <textarea name="address" class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}">{{ old('address') ?? $userInformation->address }}</textarea>
                            @if($errors->has('address'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('address') }}</strong>
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="postal_code" class="col-md-3">{{ __('Kode Pos') }}</label>
                        <div class="col-md-2">
                            <input type="number" name="postal_code" class="form-control {{ $errors->has('postal_code') ? 'is-invalid' : '' }}" value="{{ old('postal_code') ?? $userInformation->postal_code }}" placeholder="{{ __('Kode Pos') }}">
                            @if($errors->has('postal_code'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('postal_code') }}</strong>
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <input type="submit" class="btn btn-success" name="" value="Perbarui">
                    </div>
                </form>
            </div>

            <div class="card-footer">
                <a href="{{ route('user.dashboard') }}" class="btn btn-info">
                    <i class="fas fa-arrow-left"></i> Dashboard
                </a>
            </div>
        </div>
    </div>
</div>
@endsection