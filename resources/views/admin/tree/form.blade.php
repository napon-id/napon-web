@extends('layouts.admin')

@section('breadcrumbs')
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('admin.invest') }}">Invest</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('trees.index') }}">Tree</a>
    </li>
    <li class="breadcrumb-item">
        {{ isset($tree) ? 'Edit' : 'Create' }}
    </li>
</ol>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-3">
            <div class="card-header">
                {{ isset($tree) ? 'Edit' : 'Create' }} Tree
            </div> <!-- card-header -->

            <div class="card-body">
                <form action="{{ isset($tree) ? route('trees.update', [$tree]) : route('trees.store') }}" method="post">
                    @csrf
                    @if(isset($tree))
                        @method('PUT')
                    @else
                        @method('POST')
                    @endif

                    <div class="form-group">
                        <label for="name">{{ __('Tree name') }}</label>
                        <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ isset($tree) ? $tree->name : old('name') }}">
                        @if($errors->has('name'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="description">{{ __('Description') }}</label>
                        <textarea name="description" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}">{{ isset($tree) ? $tree->description : old('description') }}</textarea>
                        @if($errors->has('description'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('description') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="price">{{ __('Price') }}</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp</span>
                            </div>
                            <input type="number" name="price" class="form-control{{ $errors->has('price') ? ' is-invalid' : '' }}" value="{{ isset($tree) ? $tree->price : old('price') }}">
                            @if($errors->has('price'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('price') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="custom-control custom-checkbox">
                        @php
                            $a = '';
                            if (isset($tree)) {
                                if ($tree->available == 'yes') {
                                    $a = 'checked';
                                }
                            } else {
                                if (old('available')) {
                                    $a = 'checked';
                                }
                            }
                        @endphp
                        <input type="checkbox" class="custom-control-input" name="available" id="available" {{ $a }}>
                        <label class="custom-control-label" for="available">{{ __('Available') }}</label>
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
