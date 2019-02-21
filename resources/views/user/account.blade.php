@extends('layouts.user')

@section('breadcrumbs')
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="{{ route('user.dashboard') }}">Dashboard</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('user.wallet') }}">Wallet</a>
    </li>
    <li class="breadcrumb-item active">
        Add
    </li>
</ol>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb3">
            <div class="card-header">
                <a href="{{ route('user.wallet') }}" class="btn btn-info">
                    <span class="fas fa-arrow-left"></span> Kembali
                </a>
            </div>

            <div class="card-body">
                <form action="{{ action('User\WalletController@store') }}" method="post">
                    @csrf
                    @method('POST')

                    <div class="form-group">
                        <label>Nama Pemilik Rekening</label>
                        <input type="text" class="form-control {{ $errors->has('nama') ? 'is-invalid' : '' }}" name="nama" value="{{ old('nama') }}">
                        @if ($errors->has('nama'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('nama') }}</strong>
                        </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="rekening">Rekening</label>
                        <select class="form-control {{ $errors->has('rekening') ? 'is-invalid' : ''  }}" name="rekening">
                            <option value="">Rekening</option>
                            @foreach($banks as $code=>$name)
                            <option value="{{ $code }}" {{ (old('rekening') == $code) ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>

                        @if ($errors->has('rekening'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('rekening') }}</strong>
                        </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="nomor">Nomor Rekening</label>
                        <input type="text" class="form-control {{ $errors->has('nomor') ? 'is-invalid' : '' }}" name="nomor" value="{{ old('nomor') }}">
                        @if ($errors->has('nomor'))
                        <div class="invalid-feedback">
                            <strong>{{ $errors->first('nomor') }}</strong>
                        </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <input type="submit" class="btn btn-success" value="Simpan">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
