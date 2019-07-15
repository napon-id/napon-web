@extends('layouts.admin')

@section('breadcrumbs')
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('admin.faq.index') }}">{{ __('FAQ') }}</a>
    </li>
    <li class="breadcrumb-item active">
        {{ isset($faq) ? __('Edit') : __('Tambah') }}
    </li>
</ol>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">{{ __('Form FAQ') }}</div>
            <div class="card-body">
                <form action="{{ isset($faq) ? route('admin.faq.update', [$faq]) : route('admin.faq.store') }}" method="post">
                    @csrf
                    @if (isset($faq))
                        {{ method_field('PUT') }}
                    @else
                        {{ method_field('POST') }}
                    @endif

                    <div class="form-group row">
                        <label for="question" class="col-md-3">{{ __('Pertanyaan') }}</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control {{ $errors->has('question') ? 'is-invalid' : '' }}" name="question" value="{{ isset($faq) ? $faq->question : old('question') }}">
                            @if ($errors->has('question'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('question') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="answer" class="col-md-3">{{ __('Jawaban') }}</label>
                        <div class="col-md-6">
                            <textarea name="answer" class="form-control {{ $errors->has('answer') ? 'is-invalid' : '' }}">{{ isset($faq) ? $faq->answer : old('answer') }}</textarea>
                            @if ($errors->has('answer'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('answer') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
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