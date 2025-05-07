<div class="modal fade" id="editSlotModal" tabindex="-1" aria-labelledby="editSlotModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSlotModalLabel">Edit Slot Booking</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editSlotForm">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" id="editSlotId" name="slot_id">

                    <div class="mb-3">
                        <label for="editTime" class="form-label">Jam</label>
                        <input type="time" class="form-control" id="editTime" name="time" required>
                    </div>

                    <div class="mb-3">
                        <label for="editMaxBookings" class="form-label">Maks Booking</label>
                        <input type="number" class="form-control" id="editMaxBookings" name="max_bookings" min="1"
                            required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>