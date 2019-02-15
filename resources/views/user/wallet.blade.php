@extends('layouts.user')

@section('breadcrumbs')
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="{{ route('user.dashboard') }}">Dashboard</a>
    </li>
    <li class="breadcrumb-item active">
        Wallet
    </li>
</ol>
@endsection

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card mb3">
            <div class="card-header">
                Saldo Rekening
            </div>

            <div class="card-body text-center">
                <table class="table table-hover">
                    <h5>Saldo</h5>
                    <h2>{{ formatCurrency($balance->balance) }}</h2>
                </table>
            </div>

            <div class="card-footer">
                <a href="{{ route('user.wallet.withdraw') }}" class="btn btn-success">
                    <span class="fas fa-money-bill"></span> Cairkan saldo
                </a>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card-header">
            Rekening Bank
            <a class="btn btn-info float-right" href="{{ route('user.wallet.add') }}">Tambah rekening</a>
        </div>

        <div class="card-body">
            <table class="table table-hover">
                <tr>
                    <th>Rekening</th>
                    <th>Nama Pemilik</th>
                    <th>Nomor Rekening</th>
                    <th>Aksi</th>
                </tr>
                @foreach($accounts as $a)
                <tr>
                    <td>{{ $a->name }}</td>
                    <td>{{ $a->holder_name }}</td>
                    <td>{{ $a->number }}</td>
                    <td>
                        <form action="{{ action('User\WalletController@destroy', ['id' => $a->id]) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <span class="fas fa-trash"></span>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>

        <div class="card-footer">
            {{ $accounts->links() }}
        </div>
    </div>
</div>

<hr>


@endsection
