@extends('layouts.admin')

@section('breadcrumbs')
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('trees.index') }}">{{ __('Pohon') }}</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('admin.tree.product.index', [$tree]) }}">{{ __('Tabungan') }}</a>
    </li>
    <li class="breadcrumb-item active">
        {{ isset($product) ? __('Edit') : __('Tambah') }}
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
                <form action="{{ isset($product) ? route('admin.tree.product.update', ['tree' => $tree, 'product' => $product]) : route('admin.tree.product.store', ['tree' => $tree]) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @if(isset($product))
                        @method('PUT')
                    @else
                        @method('POST')
                    @endif

                    <div class="form-group row">
                        <label for="name" class="col-md-3">{{ __('Nama') }}</label>
                        <div class="col-md-6">
                            <input type="text" name="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ isset($product) ? $product->name : old('name') }}">
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
                            <textarea name="description" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}">{{ isset($product) ? $product->description : old('description') }}</textarea>
                            @if($errors->has('description'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('description') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="tree_quantity" class="col-md-3">{{ __('Jumlah Pohon') }}</label>
                        <div class="col-md-6">
                            <input type="number" name="tree_quantity" class="form-control{{ $errors->has('tree_quantity') ? ' is-invalid' : '' }} col-md-4" value="{{ isset($product) ? $product->tree_quantity : old('tree_quantity') }}">
                            @if($errors->has('tree_quantity'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('tree_quantity') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label for="price" class="col-md-3">{{ __('Harga') }}</label>
                        <div class="col-md-6">
                            <input type="text" name="price" class="currency form-control{{ $errors->has('price') ? ' is-invalid' : '' }} col-md-4" value="{{ isset($product) ? $product->price : old('price') }}">
                            @if($errors->has('price'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('price') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    @if (isset($product->img_black))
                    <div class="form-group row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <img src="{{ $product->img_black }}" class="img-fluid img-thumbnail">
                        </div>
                    </div>
                    @endif
                    <div class="form-group row">
                        <label for="img_black" class="col-md-3">{{ __('Img Black') }}</label>
                        <div class="col-md-6">
                            <input type="file" name="img_black" class="form-control{{ $errors->has('img_black') ? ' is-invalid' : '' }}">
                            @if($errors->has('img_black'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('img_black') }}</strong>
                            </span>
                            @endif  
                        </div>
                    </div>

                    @if (isset($product->img_white))
                    <div class="form-group row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <img src="{{ $product->img_white }}" class="img-fluid img-thumbnail">
                        </div>
                    </div>
                    @endif
                    <div class="form-group row">
                        <label for="img_white" class="col-md-3">{{ __('Img White') }}</label>
                        <div class="col-md-6">
                            <input type="file" name="img_white" class="form-control{{ $errors->has('img_white') ? ' is-invalid' : '' }}">
                            @if($errors->has('img_white'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('img_white') }}</strong>
                            </span>
                            @endif  
                        </div>
                    </div>

                    @if (isset($product->img_background))
                    <div class="form-group row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <img src="{{ $product->img_background }}" class="img-fluid img-thumbnail">
                        </div>
                    </div>
                    @endif
                    <div class="form-group row">
                        <label for="img_background" class="col-md-3">{{ __('Img Background') }}</label>
                        <div class="col-md-6">
                            <input type="file" name="img_background" class="form-control{{ $errors->has('img_background') ? ' is-invalid' : '' }}">
                            @if($errors->has('img_background'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('img_background') }}</strong>
                            </span>
                            @endif  
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <input type="submit" class="btn btn-success" value="Submit">
                        </div>
                    </div>

                </form>
            </div> <!-- card body -->
        </div> <!--card -->
    </div> <!-- col-12 -->
</div> <!-- row -->
@endsection
