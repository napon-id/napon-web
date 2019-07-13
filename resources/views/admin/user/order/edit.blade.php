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
        <a href="{{ route('admin.user.order', [$user, $order]) }}">{{ __('Tabungan') }}</a>
    </li>
    <li class="breadcrumb-item">
        {{ __('Edit') }}
    </li>
</ol>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">{{ __('Form Tabungan') }}</div>
            <div class="card-body">
                <form action="{{ route('admin.user.order.update', [$user, $order]) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group row">
                        <label for="img_certificate" class="col-md-3">{{ __('Sertifikat') }}</label>
                        <div class="col-md-6">
                            <input type="file" class="form-control {{ $errors->has('img_certificate') ? 'is-invalid' : '' }}" name="img_certificate">
                            @if ($errors->has('img_certificate'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('img_certificate') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="status" class="col-md-3">{{ __('Status Tabungan') }}</label>
                        <div class="col-md-6">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" name="status" class="custom-control-input" id="customCheck" {{ $order->status == 4 ? 'checked' : '' }}>
                                <label class="custom-control-label" for="customCheck">{{ __('Tabungan Selesai') }}</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="selling_price" class="col-md-3">{{ __('Harga Akhir') }}</label>
                        <div class="col-md-6">
                            <input type="text" name="selling_price" class="currency form-control {{ $errors->has('selling_price') ? 'is-invalid' : '' }}" value="{{ $order->selling_price ?? 0 }}">
                            @if ($errors->has('selling_price'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('selling_price') }}</strong>
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