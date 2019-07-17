@extends('layouts.admin')

@section('breadcrumbs')
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('admin.user') }}">{{ __('User') }}</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('admin.user.order', [$user]) }}">{{ __('Tabungan') }}</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('admin.user.order.report', [$user, $order]) }}">{{ __('Laporan') }}</a>
    </li>
    <li class="breadcrumb-item active">
        {{ isset($report) ? __('Edit') : __('Tambah') }}
    </li>
</ol>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-3">
            <div class="card-header">{{ __('Form Laporan') }}</div>
            <div class="card-body">
                <form action="{{ !isset($report) ? route('admin.user.order.report.store', [$user, $order]) : route('admin.user.order.report.update', [$user, $order, $report]) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @if (isset($report))
                        {{ method_field('PUT') }}
                    @else
                        {{ method_field('POST') }}
                    @endif
                    <div class="form-group row">
                        <label for="period" class="col-md-3">{{ __('Periode') }}</label>
                        <div class="col-md-3">
                            <input type="text" name="period" class="form-control {{ $errors->has('period') ? 'is-invalid' : '' }}" value="{{ $report->period ?? old('period') }}">
                            @if ($errors->has('period'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('period') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="start_date" class="col-md-3">{{ __('Tanggal Awal') }}</label>
                        <div class="col-md-3">
                            <input type="text" class="no-rule-datepicker form-control {{ $errors->has('start_date') ? 'is-invalid' : '' }}" name="start_date" value="{{ $startDate ?? old('start_date') }}">
                            @if ($errors->has('start_date'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('start_date') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="end_date" class="col-md-3">{{ __('Tanggal Akhir') }}</label>
                        <div class="col-md-3">
                            <input type="text" class="no-rule-datepicker form-control {{ $errors->has('end_date') ? 'is-invalid' : '' }}" name="end_date" value="{{ $endDate ?? old('end_date') }}">
                            @if ($errors->has('end_date'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('end_date') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="tree_height" class="col-md-3">{{ __('Tinggi Pohon (meter)') }}</label>
                        <div class="col-md-1">
                            <input type="text" class="form-control currency {{ $errors->has('tree_height') ? 'is-invalid' : '' }}" name="tree_height" value="{{ $report->tree_height ?? old('tree_height') }}">
                            @if ($errors->has('tree_height'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('tree_height') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="tree_diameter" class="col-md-3">{{ __('Diameter Pohon (meter)') }}</label>
                        <div class="col-md-1">
                            <input type="text" class="form-control currency {{ $errors->has('tree_diameter') ? 'is-invalid' : '' }}" name="tree_diameter" value="{{ $report->tree_diameter ?? old('tree_diameter') }}">
                            @if ($errors->has('tree_diameter'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('tree_diameter') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="tree_state" class="col-md-3">{{ __('Kondisi') }}</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control {{ $errors->has('tree_state') ? 'is-invalid' : '' }}" name="tree_state" value="{{ $report->tree_state ?? old('tree_state') }}">
                            @if ($errors->has('tree_state'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('tree_state') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="weather" class="col-md-3">{{ __('Cuaca') }}</label>
                        <div class="col-md-4">
                            <input type="text" class="form-control {{ $errors->has('weather') ? 'is-invalid' : '' }}" name="weather" value="{{ $report->weather ?? old('weather') }}">
                            @if ($errors->has('weather'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('weather') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    @if (isset($report->report_image))
                    <div class="form-group row">
                        <label class="col-md-3"></label>
                        <div class="col-md-6">
                            <img src="{{ $report->report_image }}" class="img-fluid img-thumbnail">
                        </div>
                    </div>
                    @endif

                    <div class="form-group row">
                        <label for="report_image" class="col-md-3">{{ __('Gambar') }}</label>
                        <div class="col-md-6">
                            <input type="file" class="form-control {{ $errors->has('report_image') ? 'is-invalid' : '' }}" name="report_image">
                            @if ($errors->has('report_image'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('report_image') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    @if (isset($report->report_video))
                    <div class="form-group row">
                        <label class="col-md-3"></label>
                        <div class="col-md-6">
                            <video width="320" height="240" controls>
                                <source src="{{ $report->report_video }}" type="video/mp4">
                            </video>
                        </div>
                    </div>
                    @endif

                    <div class="form-group row">
                        <label for="report_video" class="col-md-3">{{ __('Video') }}</label>
                        <div class="col-md-6">
                            <input type="file" class="form-control {{ $errors->has('report_video') ? 'is-invalid' : '' }}" name="report_video">
                            @if ($errors->has('report_video'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('report_video') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3"></label>
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