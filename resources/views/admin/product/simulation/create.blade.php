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
        <a href="{{ route('admin.tree.product.index', [$tree, $product]) }}">{{ __('Tabungan') }}</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('admin.tree.product.simulation.index', [$tree, $product]) }}">{{ __('Simulasi') }}</a>    
    </li>
    <li class="breadcrumb-item active">
        {{ isset($simulation) ? __('Edit') : __('Tambah') }}
    </li>
</ol>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">{{ __('Form Simulasi') }}</div>
            <div class="card-body">
                <form action="{{ isset($simulation) ? route('admin.tree.product.simulation.update', [$tree, $product, $simulation]) : route('admin.tree.product.simulation.store', [$tree, $product]) }}" method="post">
                    @csrf
                    @if (isset($simulation))
                        {{ method_field('PUT') }}
                    @else
                        {{ method_field('POST') }}
                    @endif

                    <div class="form-group row">
                        <label for="year" class="col-md-3">{{ __('Tahun') }}</label>
                        <div class="col-md-3">
                            <input type="text" class="form-control {{ $errors->has('year') ? 'is-invalid' : '' }}" name="year" value="{{ isset($simulation) ? $simulation->year : old('year') }}">
                            @if ($errors->has('year'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('year') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label for="min" class="col-md-3">{{ __('Persentase minimal (%)') }}</label>
                        <div class="col-md-2">
                            <input type="text" class="form-control {{ $errors->has('min') ? 'is-invalid' : '' }}" name="min" value="{{ isset($simulation) ? $simulation->min : old('min') }}">
                            @if ($errors->has('min'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('min') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label for="max" class="col-md-3">{{ __('Persentase maksimal (%)') }}</label>
                        <div class="col-md-2">
                            <input type="text" class="form-control {{ $errors->has('max') ? 'is-invalid' : '' }}" name="max" value="{{ isset($simulation) ? $simulation->max : old('max') }}">
                            @if ($errors->has('max'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('max') }}</strong>
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