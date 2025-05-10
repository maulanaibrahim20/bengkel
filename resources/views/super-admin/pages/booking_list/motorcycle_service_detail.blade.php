<div class="card">
    <div class="card-body">
        <h5 class="card-title fw-bold mb-4 border-bottom pb-2">Detail Servis Motor</h5>

        <form id="formUpdateMotorcycleService">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" value="{{ $motorcycleDetail->id }}">

            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="text-muted small">Kode Booking</label>
                        <p class="fw-bold">{{ $motorcycleDetail->booking->booking_code ?? '-' }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="text-muted small">Plat Nomor</label>
                        <p class="fw-bold">{{ $motorcycleDetail->motorcycle->plate ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <h6 class="mb-3 fw-bold text-primary">Data Sebelum Servis</h6>
                    <div class="mb-3">
                        <label for="year_of_manufacture" class="form-label">Tahun Pembuatan</label>
                        <input type="number" name="year_of_manufacture" id="year_of_manufacture" class="form-control"
                            value="{{ $motorcycleDetail->year_of_manufacture }}">
                    </div>
                    <div class="mb-3">
                        <label for="kilometer_before" class="form-label">Kilometer Sebelum</label>
                        <input type="number" name="kilometer_before" id="kilometer_before" class="form-control"
                            value="{{ $motorcycleDetail->kilometer_before }}">
                    </div>
                    <div class="mb-3">
                        <label for="oil_before" class="form-label">Oli Sebelum</label>
                        <input type="text" name="oil_before" id="oil_before" class="form-control"
                            value="{{ $motorcycleDetail->oil_before }}">
                    </div>
                </div>

                <div class="col-md-6">
                    <h6 class="mb-3 fw-bold text-success">Data Sesudah Servis</h6>
                    <div class="mb-3">
                        <label for="kilometer_after" class="form-label">Kilometer Sesudah</label>
                        <input type="number" name="kilometer_after" id="kilometer_after" class="form-control"
                            value="{{ $motorcycleDetail->kilometer_after }}">
                    </div>
                    <div class="mb-3">
                        <label for="oil_after" class="form-label">Oli Sesudah</label>
                        <input type="text" name="oil_after" id="oil_after" class="form-control"
                            value="{{ $motorcycleDetail->oil_after }}">
                    </div>
                </div>
            </div>

            <div class="mt-4 text-end">
                <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-1"></i> Update Data
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    $('#formUpdateMotorcycleService').on('submit', function(e) {
        e.preventDefault();
        showLoading();
        const id = $(this).find('input[name="id"]').val();
        const formData = $(this).serialize();

        $.ajax({
            url: '/super-admin/booking-list/' + id + '/motorcycle-service-detail',
            method: 'POST',
            data: formData,
            success: function(response) {
                if (response.success) {
                    toastr.success(response.message);
                    $('#booking-tracking-table').DataTable().ajax.reload(null, false);
                    $('#generalModal').modal('hide');
                } else {
                    toastr.error('Update gagal: ' + response.message);
                }
                hideLoading();
            },
            error: function(xhr) {
                const response = xhr.responseJSON;
                if (response && response.errors) {
                    let errorMessages = '';
                    for (const key in response.errors) {
                        errorMessages += response.errors[key][0] + '<br>';
                    }
                    toastr.error(errorMessages);
                } else {
                    toastr.error('Terjadi kesalahan saat update.');
                }
                hideLoading();
            }
        });
    });
</script>
