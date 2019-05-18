@extends('layouts.home')

@section('content')
<main id="mainContent">
    <div class="container content">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <!-- session flash -->
                @if(session('status'))
                <div class="alert alert-success fade show alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    {{ session('status') }}
                </div>
                @endif

                <div class="card">

                    <div class="card-body">
                        {{ __('Email Verification Success') }}
                    </div> <!-- card body -->
                </div> <!-- card -->
            </div> <!-- col-md-8 -->
        </div> <!-- row -->
    </div> <!-- container -->
</main>
@endsection