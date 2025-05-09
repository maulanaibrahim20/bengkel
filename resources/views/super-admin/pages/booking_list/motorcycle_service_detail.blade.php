<div>
    <h5>Detail Servis Motor</h5>
    <p><strong>Kode Booking:</strong> {{ $motorcycleDetail->booking->booking_code ?? '-' }}</p>
    <p><strong>Plat Nomor:</strong> {{ $motorcycleDetail->motorcycle->plate ?? '-' }}</p>
    <p><strong>Tahun Pembuatan:</strong> {{ $motorcycleDetail->year_of_manufacture ?? '-' }}</p>
    <p><strong>Kilometer Sebelum:</strong> {{ $motorcycleDetail->kilometer_before ?? '-' }} km</p>
    <p><strong>Oli Sebelum:</strong> {{ $motorcycleDetail->oil_before ?? '-' }}</p>
    <p><strong>Kilometer Sesudah:</strong> {{ $motorcycleDetail->kilometer_after ?? '-' }} km</p>
    <p><strong>Oli Sesudah:</strong> {{ $motorcycleDetail->oil_after ?? '-' }}</p>
</div>