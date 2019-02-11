@extends('layouts.user')

@section('breadcrumbs')
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="{{ route('user.dashboard') }}">Dashboard</a>
    </li>
    <li class="breadcrumb-item">
        Activity
    </li>
</ol>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb3">
            <div class="card-header">
                Log Aktivitas
            </div>

            <div class="card-body">
                @if(count($logs) > 0)
                    @foreach($logs as $a)
                    <h5>
                        {{-- refers to product detail --}}
                        <a href="{{ route('user.product') }}">
                            {{ $a->created_at->format('d-m-Y h:i:sa') }}
                        </a>
                    </h5>
                    <p>{{ $a->activity }}</p>
                    @endforeach
                @else
                    <p>
                        Anda belum melakukan aktivitas apapun pada platform {{ config('app.name') }}
                    </p>
                @endif
            </div>

            <div class="card-footer">
                {{ $logs->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
