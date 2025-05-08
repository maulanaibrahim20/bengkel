@extends('index')

@section('content')
    <div class="container text-center">
        <h2 class="mb-4">QR Code Booking</h2>

        <p>Kode Booking: <strong>{{ $booking->booking_code }}</strong></p>

        <img src="{{ $qrBase64 }}" alt="QR Code Booking" class="mb-3" style="max-width: 300px;">

        <div class="d-flex justify-content-center gap-3">
            <a href="{{ url('/user/booking-history') }}" class="btn btn-secondary">Lihat Detail</a>
            <a href="{{ $qrBase64 }}" download="booking-{{ $booking->booking_code }}.png" class="btn btn-warning">
                Download QR Code
            </a>
        </div>
    </div>
@endsection