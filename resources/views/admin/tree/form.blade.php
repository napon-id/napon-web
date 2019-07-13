@extends('layouts.admin')

@section('breadcrumbs')
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('trees.index') }}">{{ __('Pohon') }}</a>
    </li>
    <li class="breadcrumb-item active">
        {{ isset($tree) ? 'Edit' : __('Tambah') }}
    </li>
</ol>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-3">
            <div class="card-header">
                {{ __('Form Pohon') }}
            </div> <!-- card-header -->

            <div class="card-body">
                <form action="{{ isset($tree) ? route('trees.update', [$tree]) : route('trees.store') }}" method="post">
                    @csrf
                    @if(isset($tree))
                        @method('PUT')
                    @else
                        @method('POST')
                    @endif

                    <div class="form-group row">
                        <label for="name" class="col-md-3">{{ __('Nama Pohon') }}</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ isset($tree) ? $tree->name : old('name') }}">
                            @if($errors->has('name'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="description" class="col-md-3">{{ __('Deskripsi') }}</label>
                        <div class="col-md-6">
                            <textarea name="description" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}">{{ isset($tree) ? $tree->description : old('description') }}</textarea>
                            @if($errors->has('description'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('description') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <hr>

                    <div class="form-group">
                        <a href="{{ route('trees.index') }}" class="btn btn-info">
                            <i class="fas fa-arrow-left"></i> {{ __('Back') }}
                        </a>
                        <input type="submit" value="{{ __('Submit') }}" class="btn btn-success">

                    </div>

                </form>
            </div>
        </div> <!-- card -->
    </div> <!-- col-12 -->
</div> <!-- row -->
@endsection
