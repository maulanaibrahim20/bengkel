<div id="add_salary" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data Motor</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-create-motorcycle" action="{{ url('/user/motorcycle/create') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Brand Motor</label>
                            <select name="brand_id" class="form-control" required>
                                <option value="">Pilih Brand</option>
                                @foreach ($brands as $brand)
                                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-6 mt-2">
                            <label>Tipe Motor</label>
                            <input type="text" name="type" class="form-control" placeholder="Contoh: Vario 125"
                                required>
                        </div>

                        <div class="form-group col-md-12 mt-2">
                            <label>Plat Nomor</label>
                            <div class="row">
                                <div class="col-md-2">
                                    <input type="text" name="plate_prefix" class="form-control text-uppercase"
                                        maxlength="2" placeholder="D" required maxlength="3">
                                </div>
                                <div class="col-md-4">
                                    <input type="text" name="plate_number" class="form-control" maxlength="6"
                                        placeholder="1234" required>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" name="plate_suffix" class="form-control text-uppercase"
                                        maxlength="3" placeholder="PAD" required maxlength="4">
                                </div>
                            </div>
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
    $('#form-create-motorcycle').on('submit', function(e) {
        e.preventDefault();

        const prefix = $('input[name="plate_prefix"]').val().toUpperCase();
        const number = $('input[name="plate_number"]').val();
        const suffix = $('input[name="plate_suffix"]').val().toUpperCase();

        const plate = `${prefix} ${number} ${suffix}`;

        // Tambahkan ke formData
        let formData = new FormData(this);
        formData.append('plate', plate);

        let url = $(this).attr('action');

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $('#add_salary').modal('hide');
                $('#form-create-motorcycle')[0].reset();
                $('#motorcycle-table').DataTable().ajax.reload(null, false);
            },
            error: function(xhr) {
                let errMsg = 'Terjadi kesalahan.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errMsg = xhr.responseJSON.message;
                }
                alert(errMsg);
            }
        });
    });
</script>
