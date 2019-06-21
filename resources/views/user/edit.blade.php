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
                        <a class="nav-link active" href="{{ route('user.edit') }}">{{ __('Informasi Data Diri') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.edit.contact') }}">{{ __('Informasi Kontak') }}</a>
                    </li>
                </ul>

                <form action="{{ route('user.edit.update') }}" method="post">
                    @csrf
                    @method('POST')

                    <div class="form-group row">
                        <label for="phone" class="col-md-3">{{ __('Nomor KTP') }}</label>
                        <div class="col-md-4">
                            <input type="text" name="ktp" class="form-control {{ $errors->has('ktp') ? 'is-invalid' : '' }}" value="{{ old('ktp') ?? $userInformation->ktp }}" placeholder="16 digit nomor KTP">
                            @if($errors->has('ktp'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('ktp') }}</strong>
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="born_date" class="col-md-3">{{ __('Tanggal Lahir') }}</label>
                        <div class="col-md-3">
                            <input type="text" class="datepicker form-control {{ $errors->has('born_date') ? 'is-invalid' : '' }}" name="born_date" class="form-control {{ $errors->has('born_date') ? 'is-invalid' : '' }}" value="{{ old('born_date') ?? ($userInformation->born_date ? $userInformation->born_date->format('d-m-Y') : '')  }}">
                            @if($errors->has('born_date'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('born_date') }}</strong>
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="gender" class="col-md-3">{{ __('Gender') }}</label>
                        <div class="col-md-2">
                            <select name="gender" class="form-control {{ $errors->has('gender') ? 'is-invalid' : '' }}">
                                <option value="">{{ __('Pilih') }}</option>
                                <option value="1" {{ $userInformation->gender == 1 ? 'selected' : '' }}>{{ __('Pria') }}</option>
                                <option value="2" {{ $userInformation->gender == 2 ? 'selected' : '' }}>{{ __('Wanita') }}</option>
                            </select>
                            @if($errors->has('gender'))
                            <div class="invalid-feedback">
                                <strong>{{ $errors->first('gender') }}</strong>
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