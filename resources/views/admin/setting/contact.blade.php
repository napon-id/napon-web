@extends('layouts.admin')

@section('breadcrumbs')
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    </li>
    <li class="breadcrumb-item active">
        {{ __('Contact') }}
    </li>
</ol>
@endsection

@section('content')
<div class="card mb-3">
    <div class="card-header">
        {{ __('Contact') }}
    </div>

    <div class="card-body">
        <form action="{{ route('admin.contact.update') }}" method="post">
            @csrf
            <div class="form-group">
                <label for="address">{{ __('Address') }}</label>
                <textarea name="address" class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}">{{ $address->value }}</textarea>
                @if ($errors->has('address'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('address') }}</strong>
                </span>
                @endif
            </div>

            <div class="form-group">
                <label for="email">{{ __('Email') }}</label>
                <input type="text" name="email" value="{{ $email->value }}" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}">
                @if ($errors->has('email'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
                @endif
            </div>

            <div class="form-group">
                <label for="phone">{{ __('Phone') }}</label>
                <input type="text" name="phone" value="{{ $phone->value }}" class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}">
                @if ($errors->has('phone'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('phone') }}</strong>
                </span>
                @endif
            </div>

            <div class="form-group">
                <label for="website">{{ __('Website') }}</label>
                <input type="text" name="website" value="{{ $website->value }}" class="form-control {{ $errors->has('website') ? 'is-invalid' : '' }}">
                @if ($errors->has('website'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('website') }}</strong>
                </span>
                @endif
            </div>

            <input type="submit" name="update" value="Update" class="btn btn-info">
        </form>
    </div>
</div>
@endsection
