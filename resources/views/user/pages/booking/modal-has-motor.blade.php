@if (!$hasMotor)
    <div class="modal fade" id="motorWarningModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
        data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content rounded-4">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title">Peringatan</h5>
                </div>
                <div class="modal-body">
                    Anda belum memiliki motor terdaftar. Silakan tambahkan motor terlebih dahulu sebelum melakukan
                    booking.
                </div>
                <div class="modal-footer">
                    <a href="{{ url('/user/motorcycle') }}" class="btn btn-primary">Tambah Motor</a>
                </div>
            </div>
        </div>
    </div>
@endif