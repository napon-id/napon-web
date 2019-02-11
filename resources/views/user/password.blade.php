@extends('layouts.user')

@section('breadcrumbs')
<ol class="breadcrumb">
  <li class="breadcrumb-item">
    <a href="{{ route('user.dashboard') }}">Dashboard</a>
  </li>
  <li class="breadcrumb-item">
    <a href="{{ route('user.edit') }}">Edit</a>
  </li>
  <li class="breadcrumb-item active">Password</li>
</ol>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb3">
            <div class="card-header">
                Perbarui kata sandi
            </div>

            <div class="card-body">
                <form action="{{ route('user.password.update') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="old_password">Kata sandi lama</label>
                        <input type="password" name="old_password" class="form-control {{ $errors->has('old_password') ? 'is-invalid' : '' }}">
                        @if($errors->has('old_password'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('old_password') }}</strong>
                        </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="new_password">{{ __('Kata sandi baru') }}</label>

                            <input type="password" class="form-control{{ $errors->has('new_password') ? ' is-invalid' : '' }}" name="new_password">
                            @if ($errors->has('new_password'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('new_password') }}</strong>
                            </span>
                            @endif
                    </div>

                    <div class="form-group">
                        <label for="new_password-confirm">{{ __('Konfirmasi kata sandi baru') }}</label>
                            <input type="password" class="form-control" name="new_password_confirmation">
                    </div>

                    <div class="form-group">
                        <input type="submit" class="btn btn-success" value="Ganti kata sandi">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
