<div class="modal-header bg-primary text-white">
    <h5 class="modal-title">Detail Layanan: {{ $service->name }}</h5>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">
    <div class="mb-3">
        <h5 class="fw-bold">Informasi Umum</h5>
        <p><strong>Harga:</strong> <span class="badge bg-success">Rp
                {{ number_format($service->price, 0, ',', '.') }}</span></p>
        <p><strong>Durasi:</strong> <span class="badge bg-warning text-dark">{{ $service->duration }}</span></p>
    </div>

    <hr>

    <div>
        <h5 class="fw-bold">Rincian Layanan:</h5>
        @if($service->detail->isEmpty())
            <p class="text-muted">Belum ada rincian layanan.</p>
        @else
            <div class="list-group">
                @foreach ($service->detail as $detail)
                    <div class="list-group-item">
                        <i class="fa fa-check-circle text-success me-2"></i> {{ $detail->description }}
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
</div>