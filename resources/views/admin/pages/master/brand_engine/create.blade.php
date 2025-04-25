<div id="add_salary" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data Brand Motor</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-create-brand" action="{{ url('/super-admin/master/brand-engine/create') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="form-group">
                            <label>Nama Brand Motor</label>
                            <input placeholder="Honda.." class="form-control" name="name" type="text">
                        </div>
                    </div>

                    <div class="submit-section d-flex justify-content-end mt-4 gap-2">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<script>
    $('#form-create-brand').on('submit', function (e) {
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
                $('#add_salary').modal('hide');

                form[0].reset();

                $('#brand-engine-table').DataTable().ajax.reload(null, false);
            },
            error: function (xhr) {
                let errMsg = 'Terjadi kesalahan.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errMsg = xhr.responseJSON.message;
                }
            }
        });
    });

    $('#form-create-brand').on('submit', function (e) {
    });
</script>