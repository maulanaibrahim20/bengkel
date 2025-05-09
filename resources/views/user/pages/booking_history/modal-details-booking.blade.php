<div class="modal fade" id="bookingDetailModal" tabindex="-1" aria-labelledby="bookingDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header bg-primary text-white rounded-top-4">
                <h5 class="modal-title" id="bookingDetailModalLabel">
                    <i class="fa fa-info-circle me-2"></i>Detail Booking
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">

                <!-- QR Code Section with Caption and Download Button -->
                <div class="text-center mb-4">
                    <img src="" id="booking-qrcode" alt="QR Code" class="img-fluid"
                        style="max-width: 150px; height: auto;">
                    <p class="mt-2 text-muted" id="qr-caption">Scan QR code hanya dilakukan oleh admin</p>
                    <a href="" id="download-qrcode" class="btn btn-outline-primary btn-sm mt-3" download>
                        <i class="fa fa-download me-1"></i> Download QR Code
                    </a>
                </div>

                <div class="mb-3">
                    <label class="fw-bold text-muted">Kode Booking</label>
                    <div class="badge bg-primary text-white fs-6" id="modal-booking-code">-</div>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="fw-bold text-muted">Status</label>
                        <div id="modal-status" class="badge bg-secondary text-uppercase">-</div>
                    </div>
                    <div class="col-md-6">
                        <label class="fw-bold text-muted">Keluhan</label>
                        <div id="modal-complaint" class="border rounded p-2 bg-light">-</div>
                    </div>
                    <div class="col-md-6">
                        <label class="fw-bold text-muted">Tanggal Booking</label>
                        <div id="modal-slot-date" class="form-control-plaintext">-</div>
                    </div>
                    <div class="col-md-6">
                        <label class="fw-bold text-muted">Waktu Booking</label>
                        <div id="modal-slot-time" class="form-control-plaintext">-</div>
                    </div>
                </div>

                <hr class="my-4">

                <h6 class="text-primary fw-bold mb-3"><i class="fa fa-cogs me-2"></i>Layanan yang Dipilih</h6>
                <ul id="modal-services-list" class="list-group list-group-flush mb-0">
                    <li class="list-group-item">-</li>
                </ul>
            </div>
            <div class="modal-footer justify-content-between">
                <div class="w-100 d-none" id="cancel-reason-container">
                    <label class="form-label fw-semibold">Alasan Pembatalan</label>
                    <textarea class="form-control" id="cancel-reason" rows="2" placeholder="Masukkan alasan..."></textarea>
                </div>
                <div class="d-flex justify-content-end w-100 gap-2">
                    <button type="button" class="btn btn-danger" id="cancel-booking-btn">
                        <i class="fa fa-times-circle me-1"></i> Batalkan Booking
                    </button>
                    <a href="#" id="wa-confirm-btn" class="btn btn-success">
                        <i class="fa fa-whatsapp me-1"></i> Konfirmasi via WhatsApp
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>
