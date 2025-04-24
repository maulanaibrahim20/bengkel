<form action="{{ url('/super-admin/master/technician/' . $technician['id'] . '/update') }}" method="POST"
    enctype="multipart/form-data">
    @method('PUT')
    @csrf
    <div class="row">
        <div class="form-group">
            <label>Nama Teknisi</label>
            <input class="form-control" name="name" value="{{ $technician->name }}" type="text">
        </div>
        <div class="form-group">
            <label>Username</label>
            <div class="d-flex gap-2">
                <input class="form-control" value="{{ $technician->username }}" name="username" id="username"
                    type="text">
                <button type="button" class="btn btn-outline-primary" id="check-username">Cek</button>
            </div>
            <small id="username-feedback" class="text-danger d-none">Username sudah digunakan</small>
        </div>
    </div>
    <div class="submit-section d-flex justify-content-end mt-4 gap-2">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>