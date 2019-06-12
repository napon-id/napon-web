@extends('layouts.admin')

@section('breadcrumbs')
<ul class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('admin.blog.index') }}">{{ __('Blog') }}</a>
    </li>
    <li class="breadcrumb-item active">
        {{ isset($blog) ? __('Edit') : __('Create') }}
    </li>
</ul>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-3">
            <div class="card-header">
                {{ isset($blog) ? __('Edit Blog Post') : __('Add Blog Post') }}
            </div>
            <div class="card-body">
                <form action="{{ isset($blog) ? route('admin.blog.update', [$blog]) : route('admin.blog.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if (isset($blog))
                        {{ method_field('PUT') }}
                    @else
                        {{ method_field('POST') }}
                    @endif

                    <div class="form-group">
                        <div class="col-md-3">
                            <label for="title">{{ __('Title') }}</label>
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="title" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" value="{{ isset($blog) ? $blog->title : old('title') }}">
                            @if ($errors->has('title'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('title') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-3">
                            <label for="description">{{ __('Description') }}</label>
                        </div>
                        <textarea name="description" id="editor" class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}">{{ isset($blog) ? $blog->description : old('description') }}</textarea>
                        @if ($errors->has('description'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('description') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <div class="col-md-3">
                            <label for="img">{{ __('Image') }}</label>
                        </div>
                        <div class="col-md-6">
                            <input type="file" name="img" class="form-control {{ $errors->has('img') ? 'is-invalid' : '' }}">
                            @if ($errors->has('img'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('img') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    @if (isset($blog->img))
                    <div class="form-group">
                        <div class="img-fluid">
                            <img src="{{ $blog->img }}" alt="">
                        </div>
                    </div>
                    @endif

                    <button type="submit" class="btn btn-info">
                        {{ __('Submit') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
