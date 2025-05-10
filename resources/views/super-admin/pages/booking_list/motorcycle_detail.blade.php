<div class="card">
    <div class="card-body">
        <h5 class="card-title fw-bold mb-4 border-bottom pb-2">Detail Kendaraan</h5>
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="text-muted small">Nama Pemilik</label>
                    <p class="fw-medium">{{ $motorcycle->user->name ?? '-' }}</p>
                </div>
                <div class="mb-3">
                    <label class="text-muted small">Plat Nomor</label>
                    <p class="fw-bold">{{ $motorcycle->plate }}</p>
                </div>
                <div class="mb-3">
                    <label class="text-muted small">Tipe</label>
                    <p class="fw-medium">{{ $motorcycle->type }}</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label class="text-muted small">Merk</label>
                    <p class="fw-medium">{{ $motorcycle->brandEngine->name ?? '-' }}</p>
                </div>
                <div class="mb-3">
                    <label class="text-muted small">Tahun</label>
                    <p class="fw-medium">{{ $motorcycle->latestMotorCycleDetail->year_of_manufacture ?? '-' }}</p>
                </div>
                <div class="mb-3">
                    <label class="text-muted small">Warna</label>
                    <p class="fw-medium">{{ $motorcycle->color ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
