<div id="add_salary" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Teknisi</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ url('/super-admin/master/technician/create') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="form-group">
                            <label>Nama Teknisi</label>
                            <input placeholder="Asep.." class="form-control" name="name" type="text">
                        </div>
                        <div class="form-group">
                            <label>Username</label>
                            <div class="d-flex gap-2">
                                <input placeholder="Honda.." class="form-control" name="username" id="username"
                                    type="text">
                                <button type="button" class="btn btn-outline-primary" id="check-username">Cek</button>
                            </div>
                            <small id="username-feedback" class="text-danger d-none">Username sudah digunakan</small>
                        </div>
                    </div>
                    <div class="submit-section d-flex justify-content-end mt-4 gap-2">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary" id="submit-btn" disabled>Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>