@extends('layouts.admin')

@section('breadcrumbs')
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('admin.description.index') }}">{{ __('Deskripsi') }}</a>
    </li>
    <li class="breadcrumb-item active">
        {{ isset($description) ? __('Edit') : __('Tambah') }}
    </li>
</ol>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                {{ __('Form Deskripsi') }}
            </div>
            <div class="card-body">
                <form action="{{ isset($description) ? route('admin.description.update', [$description]) : route('admin.description.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @if (isset($description))
                        {{ method_field('PUT') }}
                    @else
                        {{ method_field('POST') }}
                    @endif

                    @if (isset($description->img))
                    <div class="form-group row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <img src="{{ $description->img }}" class="img-fluid img-thumbnail">
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
                        <label for="title" class="col-md-3">{{ __('Judul') }}</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" name="title" value="{{ isset($description) ? $description->title : old('title') }}">
                            @if ($errors->has('title'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('title') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="text" class="col-md-3">{{ __('Teks') }}</label>
                        <div class="col-md-6">
                            <textarea name="text" class="form-control {{ $errors->has('text') ? 'is-invalid' : '' }}">{{ isset($description) ? $description->text : old('text') }}</textarea>
                            @if ($errors->has('text'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('text') }}</strong>
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