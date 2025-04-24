<form action="{{ url('/super-admin/master/brand-engine/' . $brandEngine['id'] . '/update') }}" method="POST"
    enctype="multipart/form-data">
    @method('PUT')
    @csrf
    <div class="row">
        <div class="form-group">
            <label>Nama Brand Motor</label>
            <input class="form-control" name="name" value="{{ $brandEngine->name }}" type="text">
        </div>
    </div>
    <div class="submit-section d-flex justify-content-end mt-4 gap-2">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>