<form id="form-edit-brand" action="{{ url('/super-admin/master/brand-engine/' . $brandEngine['id'] . '/update') }}"
    method="POST" enctype="multipart/form-data">
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

<script>
    $(document).on('submit', '#form-edit-brand', function (e) {
        e.preventDefault();

        let form = $(this);
        let url = form.attr('action');
        let formData = new FormData(this);

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                $('#add_salary-edit').modal('hide');
                toastr.success('success', 'Berhasil mengupdate data!');
                $('#brand-engine-table').DataTable().ajax.reload(null, false);
            },
            error: function (xhr) {
                let errMsg = 'Terjadi kesalahan.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errMsg = xhr.responseJSON.message;
                }
                Swal.fire('Gagal!', errMsg, 'error');
            }
        });
    });
</script>