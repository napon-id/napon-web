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
                        <input type="number" name="ktp" class="form-control {{ $errors->has('ktp') ? 'is-invalid' : '' }}" value="{{ $userInformation->ktp }}" placeholder="16 digit nomor KTP">
                        @if($errors->has('ktp'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('ktp') }}</strong>
                        </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="phone">{{ __('Nomor telepon') }}</label>
                        <input type="number" name="phone" class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" value="{{ $userInformation->phone }}" placeholder="08xxxxxxxxx">
                        @if($errors->has('phone'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('phone') }}</strong>
                        </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="phone">Alamat lengkap</label>
                        <textarea name="address" rows="4" cols="80" class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}">{{ $userInformation->address }}</textarea>
                        @if($errors->has('address'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('address') }}</strong>
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
