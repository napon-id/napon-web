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
                <textarea name="address" class="form-control">{{ $address->value }}</textarea>
            </div>

            <div class="form-group">
                <label for="email">{{ __('Email') }}</label>
                <input type="text" name="email" value="{{ $email->value }}" class="form-control">
            </div>

            <div class="form-group">
                <label for="phone">{{ __('Phone') }}</label>
                <input type="text" name="phone" value="{{ $phone->value }}" class="form-control">
            </div>

            <div class="form-group">
                <label for="website">{{ __('Website') }}</label>
                <input type="text" name="website" value="{{ $website->value }}" class="form-control">
            </div>

            <input type="submit" name="update" value="Update" class="btn btn-info">
        </form>
    </div>
</div>
@endsection
