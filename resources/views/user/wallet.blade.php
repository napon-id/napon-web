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
            </div> <!-- card-header -->

            <div class="card-body text-center">
                <table class="table table-hover">
                    <h5>Saldo</h5>
                    <h2>{{ formatCurrency($user->balance()->first()->balance) }}</h2>
                </table>
            </div> <!-- card-body -->

            <div class="card-footer">
                <a href="{{ route('user.wallet.withdraw') }}" class="btn btn-success">
                    <span class="fas fa-money-bill"></span> Cairkan saldo
                </a>
            </div> <!-- card-footer -->
        </div> <!-- card -->
    </div> <!-- col-md-4 -->

    <div class="col-md-8">
        <div class="card-header">
            Rekening Bank
            <a class="btn btn-info float-right" href="{{ route('user.wallet.add') }}">Tambah rekening</a>
        </div> <!-- col-md-8 -->

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
            </table> <!-- table -->
        </div> <!-- card body -->

        <div class="card-footer">
            {{ $accounts->links() }}
        </div> <!-- card footer -->
    </div> <!-- col-md-8 -->
</div> <!-- row -->

<hr>

<div class="row">
    <div class="col-12">
        <div class="card mb-3">
            <div class="card-header">
                {{ __('Riwayat Pencairan') }}
            </div> <!-- card-header -->

            <div class="card-body">
                <table class="table table-hover">
                    <tr>
                        <td>{{ __('Tanggal') }}</td>
                        <td>{{ __('Jumlah pencairan') }}</td>
                        <td>{{ __('Status') }}</td>
                    </tr>
                    @foreach($withdraws as $a)
                    <tr>
                        <td>{{ $a->created_at->format('d-m-Y h:i:sa') }}</td>
                        <td>{{ formatCurrency($a->amount) }}</td>
                        <td>
                            @if($a->status == 'waiting')
                                <span class="badge badge-warning">{{ __('Menunggu persetujuan') }}</span>
                            @elseif($a->status == 'approved')
                                <span class="badge badge-primary">{{ __('Sedang diproses') }}</span>
                            @elseif($a->status == 'rejected')
                                <span class="badge badge-danger">{{ __('Ditolak') }}</span>
                            @elseif($a->status == 'done')
                                <span class="badge badge-success">{{ __('Selesai') }}</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div> <!-- card-body -->

            <div class="card-footer">
                {{ $withdraws->links() }}
            </div> <!-- card-footer -->
        </div> <!-- card -->
    </div> <!-- col-12 -->
</div> <!-- row -->
@endsection
