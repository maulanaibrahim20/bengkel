@extends('index')
@section('content')
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">List Motor</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/super-admin/dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">List Motor</li>
                </ul>
            </div>
            <div class="col-auto float-end ms-auto">
                <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_salary"><i
                        class="fa fa-plus"></i> Add Motorcycle</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card mb-0">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0" id="motorcycle-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>User & Brand</th>
                                    <th>Type</th>
                                    <th>Plate</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bookings as $index => $booking)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ \Carbon\Carbon::parse($booking->slot->date)->translatedFormat('d F Y') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($booking->slot->time)->format('H:i') }} WIB</td>
                                        <td>
                                            <ul class="mb-0">
                                                @foreach ($booking->services as $service)
                                                    <li>{{ $service->name }} (Rp{{ number_format($service->price) }})</li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td class="fw-bold text-end">
                                            Rp{{ number_format($booking->services->sum('price')) }}
                                        </td>
                                        <td>
                                            <span
                                                class="badge
                                                                {{ $booking->status === 'pending' ? 'bg-warning' : ($booking->status === 'completed' ? 'bg-success' : 'bg-secondary') }}">
                                                {{ ucfirst($booking->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $booking->complaint ?? '-' }}</td>
                                        <td>{{ $booking->created_at->translatedFormat('d M Y H:i') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection