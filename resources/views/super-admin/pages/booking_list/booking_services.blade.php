<div>
    <h5>Daftar Layanan yang Dipesan</h5>
    <ul>
        @foreach($booking->bookingServices as $item)
            <li>{{ $item->service->name ?? '-' }} - Rp{{ number_format($item->service->price ?? 0) }}</li>
        @endforeach
    </ul>
</div>