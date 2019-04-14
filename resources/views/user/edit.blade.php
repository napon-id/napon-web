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
                <form action="{{ route('user.edit.update') }}" method="post">
                    @csrf
                    @method('POST')

                    <div class="form-group">
                        <label for="phone">{{ __('Nomor KTP') }}</label>
                        <input type="text" name="ktp" class="form-control {{ $errors->has('ktp') ? 'is-invalid' : '' }}" value="{{ old('ktp') ?? $userInformation->ktp }}" placeholder="16 digit nomor KTP">
                        @if($errors->has('ktp'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('ktp') }}</strong>
                        </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="phone">{{ __('Nomor telepon') }}</label>
                        <input type="text" name="phone" class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" value="{{ old('phone') ?? $userInformation->phone }}" placeholder="08xxxxxxxxx">
                        @if($errors->has('phone'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('phone') }}</strong>
                        </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="address">Alamat lengkap</label>
                        <textarea name="address" rows="4" cols="80" class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}">{{ old('address') ?? $userInformation->address }}</textarea>
                        @if($errors->has('address'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('address') }}</strong>
                        </div>
                        @endif
                    </div>

                    {{-- <div class="form-group">
                        <label for="born_place">{{ __('Tempat Lahir') }}</label>
                        <select class="form-control {{ $errors->has('born_place') ? 'is-invalid' : '' }}" name="born_place" id="born_place">
                        @foreach ($bornCities as $city)
                            <option value="{{ $city->id }}" {{ $city->id == $userInformation->born_place ? 'selected' : '' }}>{{ $city->name }}</option>
                        @endforeach
                        </select>
                        @if($errors->has('born_place'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('born_place') }}</strong>
                        </div>
                        @endif
                    </div> --}}

                    <div class="form-group">
                        <label for="born_date">{{ __('Tanggal Lahir') }}</label>
                        <input type="date" name="born_date" class="form-control {{ $errors->has('born_date') ? 'is-invalid' : '' }}" value="{{ old('born_date') ?? $userInformation->born_date }}">
                        @if($errors->has('born_date'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('born_date') }}</strong>
                        </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="gender">{{ __('Gender') }}</label>
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

                    <div class="form-group">
                        <label for="province">{{ __('Provinsi') }}</label>
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

                    <div class="form-group">
                        <label for="city">{{ __('Kota Tempat Tinggal') }}</label>
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