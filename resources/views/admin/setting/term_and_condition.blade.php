@extends('layouts.admin')

@section('breadcrumbs')
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    </li>
    <li class="breadcrumb-item active">
        Term And Condition
    </li>
</ol>
@endsection

@section('content')
<div class="card mb-3">
    <div class="card-header">
        Term And Condition
    </div>

    <div class="card-body">
        <form action="{{ route('admin.term_and_condition.update') }}" method="post">
            @csrf
            <div class="form-group">
                <label for="term_and_condition">{{ __('Term And Condition') }}</label>
                <textarea name="term_and_condition" id="editor">{{ $data->value }}</textarea>
            </div>

            <input class="btn btn-info" type="submit" name="update" value="{{ __('Update') }}">
        </form>
    </div>
</div>
@endsection
