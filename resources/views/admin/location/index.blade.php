@extends('layouts.admin')

@section('breadcrumbs')
<ol class="breadcrumb">
    <li class="breadcrumb-item">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('admin.invest') }}">Invest</a>
    </li>
    <li class="breadcrumb-item active">
        Locations
    </li>
</ol>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-3">
            <div class="card-header">
                Locations
            </div>
            <div class="card-body">
                <table class="table table-hover table-striped">
                    <tr>
                        <th>Location</th>
                        <th>Address</th>
                        <th>Lat</th>
                        <th>Lng</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                    @foreach($locations as $location)
                    <tr>
                        <td>{{ $location->location ?? '-' }}</td>
                        <td>{{ $location->address ?? '-' }}</td>
                        <td>{{ $location->lat ?? '-' }}</td>
                        <td>{{ $location->lng ?? '-' }}</td>
                        <td>{{ $location->description ?? '-' }}</td>
                        <td>
                            <a class="btn" href="{{ route('locations.edit', [$location]) }}" data-toggle="tooltip" data-placement="bottom" title="Edit">
                                <i class="far fa-edit"></i>
                            </a>
                            @if($location->orders()->count() == 0)
                                <form action="{{ route('locations.destroy', [$location]) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn" onclick="return confirm('Are you sure?')" data-toggle="tooltip" data-placement="bottom" title="Delete">
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
            <div class="card-footer">

            </div>
        </div>
    </div>
</div>
@endsection
