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
        <a href="{{ route('trees.index') }}">{{ $tree->name }}</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('products.index', [$tree]) }}">Products</a>
    </li>
    <li class="breadcrumb-item">
        {{ isset($product) ? 'Edit' : 'Create' }}
    </li>
</ol>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-3">
            <div class="card-header">
                {{ isset($product) ? 'Edit' : 'Create' }} Product
            </div> <!-- card header -->

            <div class="card-body">
                <form action="{{ isset($product) ? route('products.update', [$product, 'tree' => $tree]) : route('products.store', ['tree' => $tree]) }}" method="post">
                    @csrf
                    @if(isset($product))
                        @method('PUT')
                    @else
                        @method('POST')
                    @endif

                    <div class="form-group">
                        <label for="name">{{ __('Name') }}</label>
                        <input type="text" name="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ isset($product) ? $product->name : old('name') }}">
                        @if($errors->has('name'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="description">{{ __('Description') }}</label>
                        <textarea name="description" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}">{{ isset($product) ? $product->description : old('description') }}</textarea>
                        @if($errors->has('description'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('description') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="tree_quantity">{{ __('Tree Quantity') }}</label>
                        <input type="number" name="tree_quantity" class="form-control{{ $errors->has('tree_quantity') ? ' is-invalid' : '' }} col-md-4" value="{{ isset($product) ? $product->tree_quantity : old('tree_quantity') }}">
                        @if($errors->has('tree_quantity'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('tree_quantity') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="img">{{ __('Image') }}</label>
                        <input type="text" name="img" class="form-control{{ $errors->has('img') ? ' is-invalid' : '' }}" value="{{ isset($product) ? $product->img : old('img') }}">
                        @if($errors->has('img'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('img') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="percentage">{{ __('Percentage') }}</label>
                        <div class="input-group">
                            <input type="number" name="percentage" class="form-control{{ $errors->has('percentage') ? ' is-invalid' : '' }} col-md-1" value="{{ isset($product) ? $product->percentage : old('percentage') }}">
                            <div class="input-group-append">
                                <span class="input-group-text">%</span>
                            </div>
                            @if($errors->has('percentage'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('percentage') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="time">{{ __('Invest Time') }}</label>
                        <input type="text" name="time" class="form-control{{ $errors->has('time') ? ' is-invalid' : '' }}" value="{{ isset($product) ? $product->time : old('time') }}" placeholder="? tahun ? bulan ? hari">
                        @if($errors->has('time'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('time') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="custom-control custom-checkbox">
                        @php
                            $a = '';
                            if (isset($product)) {
                                if ($product->available == 'yes') {
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

                    <div class="custom-control custom-checkbox">
                        @php
                            $a = '';
                            if (isset($product)) {
                                if ($product->has_certificate == true) {
                                    $a = 'checked';
                                }
                            } else {
                                if (old('has_certificate')) {
                                    $a = 'checked';
                                }
                            }
                        @endphp
                        <input type="checkbox" class="custom-control-input" name="has_certificate" id="has_certificate" {{ $a }}>
                        <label class="custom-control-label" for="has_certificate">{{ __('Certificate') }}</label>
                    </div>

                    <hr>

                    <div class="form-group">
                        <a href="{{ route('products.index', [$tree]) }}" class="btn btn-info">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                        <input type="submit" class="btn btn-success" value="Submit">
                    </div>
                </form>
            </div> <!-- card body -->
        </div> <!--card -->
    </div> <!-- col-12 -->
</div> <!-- row -->
@endsection
