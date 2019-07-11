@extends('layouts.admin')

@section('breadcrumbs')
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('admin.banner.index') }}">{{ __('Banner') }}</a>
    </li>
    <li class="breadcrumb-item">
        {{ isset($banner) ? __('Edit') : __('Tambah') }}
    </li>
</ol>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">{{ __('Form Banner') }}</div>
            <div class="card-body">
                <form action="{{ isset($banner) ? route('admin.banner.edit', [$banner]) : route('admin.banner.create') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @if (isset($banner))
                    {{ method_field('PUT') }}
                    @else
                    {{ method_field('POST') }}
                    @endif

                    @if (isset($banner->img))
                    <div class="form-group row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <img src="{{ $banner->img }}" class="img-fluid img-thumbnail">
                        </div>
                    </div>
                    @endif

                    <div class="form-group row">
                        <label for="img" class="col-md-3">{{ __('Gambar') }}</label>
                        <div class="col-md-6">
                            <input type="file" class="form-control {{ $errors->has('img') ? 'is-invalid' : '' }}" name="img">
                            @if ($errors->has('img'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('img') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="description" class="col-md-3">{{ __('Deskripsi') }}</label>
                        <div class="col-md-6">
                            <textarea name="description" class="form-control editor {{ $errors->has('description') ? 'is-invalid' : '' }}">{{ $banner->description ?? old('description') }}</textarea>
                            @if ($errors->has('description'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('description') }}</strong>
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