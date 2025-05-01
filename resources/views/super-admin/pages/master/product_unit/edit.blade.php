<form id="form-edit-product-unit" action="{{ url('/super-admin/master/product-unit/' . $productUnit['id'] . '/update') }}"
    method="POST" enctype="multipart/form-data">
    @method('PUT')
    @csrf
    <div class="row">
        <div class="form-group mb-3">
            <label>Nama Unit</label>
            <input class="form-control" name="name" value="{{ $productUnit->name }}" type="text" required>
        </div>
        <div class="form-group mb-3">
            <label>Singkatan</label>
            <input class="form-control" name="acronym" value="{{ $productUnit->acronym }}" type="text" required>
        </div>
    </div>
    <div class="submit-section d-flex justify-content-end mt-4 gap-2">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>

<script>
    $(document).on('submit', '#form-edit-product-unit', function(e) {
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
            success: function(response) {
                $('#add_salary-edit').modal('hide');
                toastr.success('Berhasil mengupdate data!');
                $('#product-unit-table').DataTable().ajax.reload(null, false);
            },
            error: function(xhr) {
                let errMsg = 'Terjadi kesalahan.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errMsg = xhr.responseJSON.message;
                }
                toastr.error('Gagal!', errMsg, 'error');

            }
        });
    });
</script>
