@extends('layouts.admin')

@section('breadcrumbs')
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('admin.user') }}">User</a>
    </li>
    <li class="breadcrumb-item">
        {{ $user['user_email'] }}
    </li>
</ol>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-3">
            <div class="card-header">
                {{ __('User Detail') }}
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <tr>
                            <td>{{ __('Nama') }}</td>
                            <td>{{ $user['user_name'] }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('Email') }}</td>
                            <td>{{ $user['user_email'] }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('Gambar Profil') }}</td>
                            <td>
                                <img src="{{ $user['user_image'] }}" class="img-thumbnail img-fluid" style="max-height: 200px">
                            </td>
                        </tr>
                        <tr>
                            <td>{{ __('Jenis Kelamin') }}</td>
                            <td>{{ $user['user_sex'] }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('No. Telepon') }}</td>
                            <td>{{ $user['user_phone'] }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('Alamat Lengkap') }}</td>
                            <td>{{ $user['user_address'] }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('Kota') }}</td>
                            <td>{{ $user['user_city'] }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('Provinsi') }}</td>
                            <td>{{ $user['user_state'] }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('Kode Pos') }}</td>
                            <td>{{ $user['user_zip_code'] }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('No. KTP') }}</td>
                            <td>{{ $user['user_id_number'] }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('Scan KTP') }}</td>
                            <td>
                                <img src="{{ $user['user_id_image'] }}" class="img-thumbnail img-fluid" style="max-height: 200px">
                            </td>
                        </tr>
                        <tr>
                            <td>{{ __('Jumlah Pohon') }}</td>
                            <td>{{ $user['user_total_tree'] }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('Tanggal Bergabung') }}</td>
                            <td>{{ $user['user_join_date'] }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('Saldo User') }}</td>
                            <td class="currency">{{ $user['user_balance'] }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('Total Menabung') }}</td>
                            <td class="currency">{{ $user['user_total_investment'] }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('Email Verifikasi') }}</td>
                            <td>
                                @if ($user['user_email_verified'])
                                    <i class="fas fa-check"></i>
                                @else
                                    <i class="fas fa-times"></i>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>{{ __('Kelengkapan Data User') }}</td>
                            <td>
                                @if ($user['user_data_filled'])
                                    <i class="fas fa-check"></i>
                                @else
                                    <i class="fas fa-times"></i>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-header">
                {{ __('Data Bank') }}
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <tr>
                            <th>{{ __('ID Bank') }}</th>
                            <th>{{ __('Nama Bank') }}</th>
                            <th>{{ __('Pemilik Akun') }}</th>
                            <th>{{ __('No. Rekening') }}</th>
                        </tr>
                        @foreach ($user['user_banks'] as $bank)
                        <tr>
                            <td>{{ $bank->user_bank_id }}</td>
                            <td>{{ $bank->user_bank_name }}</td>
                            <td>{{ $bank->user_bank_account_name }}</td>
                            <td>{{ $bank->user_bank_account_number }}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection