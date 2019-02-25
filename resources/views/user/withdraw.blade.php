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
        Withdraw
    </li>
</ol>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb3">
            <div class="card-header">
                Cairkan Saldo
            </div>

            <div class="card-body">
                <form action="{{ route('user.wallet.withdraw.store') }}" method="post">
                    @csrf
                    @method('POST')

                    <div class="form-group">
                        <label for="rekening">Rekening</label>
                        <select class="form-control {{ $errors->has('number') ? 'is-invalid' : '' }}" name="number">
                            <option value="">{{ __('Pilih rekening') }}</option>
                            @foreach($user->accounts()->get() as $a)
                            <option value="{{ $a->number }}" {{ $a->id == old('number') ? 'selected' : '' }}>{{ $a->name }} - {{ $a->number }} a/n {{ $a->holder_name }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('number'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('number') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="amount">{{ __('Jumlah pencairan') }}</label>
                        <input type="text" class="form-control {{ $errors->has('amount') ? 'is-invalid' : '' }}" name="amount" value="{{ old('amount') }}">
                        @if($errors->has('amount'))
                        <span class="invalid-feedback">
                            <strong>{{ $errors->first('amount') }}</strong>
                        </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <input type="submit" class="btn btn-success" name="" value="Cairkan">
                    </div>
                </form>
            </div>

            <div class="card-footer">
                <a href="{{ route('user.wallet') }}" class="btn btn-info">
                    <span class="fas fa-arrow-left"></span> Kembali
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
