<div class="card">
    <div class="card-body text-center">
        <h5 class="card-title fw-bold mb-4 border-bottom pb-2">QR Code Booking</h5>

        <div class="d-flex justify-content-center mb-3">
            <div class="p-2 border rounded">
                <img id="qr-code-image" src="{{ $qr ?? '#' }}" alt="QR Code" class="img-fluid" style="max-width: 250px;">
            </div>
        </div>

        <div class="mb-4">
            <h6 class="text-muted">Kode Booking</h6>
            <h3 class="fw-bold" id="booking-code">{{ $booking_code ?? '-' }}</h3>
        </div>

        <button class="btn btn-sm btn-outline-primary" onclick="downloadQrCode()">
            <i class="bi bi-download me-1"></i> Download QR Code
        </button>
    </div>
</div>
<script>
    function downloadQrCode() {
        const img = document.getElementById('qr-code-image');
        const qrUrl = img.src;

        const link = document.createElement('a');
        link.href = qrUrl;
        link.download = 'qr-booking-code.png'; // nama file saat diunduh
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    }
</script>
