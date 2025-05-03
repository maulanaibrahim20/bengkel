<form id="form-edit-motorcycle" action="{{ url('/user/motorcycle/' . $motorcycle->id . '/update') }}" method="POST"
    enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="form-group col-md-6">
            <label>Brand Motor</label>
            <select name="brand_id" class="form-control" required>
                <option value="">Pilih Brand</option>
                @foreach ($brands as $brand)
                    <option value="{{ $brand->id }}" {{ $brand->id == $motorcycle->brand_id ? 'selected' : '' }}>
                        {{ $brand->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group col-md-6 mt-2">
            <label>Tipe Motor</label>
            <input type="text" name="type" class="form-control" value="{{ $motorcycle->type }}" required>
        </div>

        <div class="form-group col-md-12 mt-2">
            <label>Plat Nomor</label>
            <div class="row">
                <div class="col-md-2">
                    <input type="text" name="plate_prefix" class="form-control text-uppercase" maxlength="2"
                        value="{{ $plate_prefix }}" required>
                </div>
                <div class="col-md-4">
                    <input type="text" name="plate_number" class="form-control" maxlength="6"
                        value="{{ $plate_number }}" required>
                </div>
                <div class="col-md-4">
                    <input type="text" name="plate_suffix" class="form-control text-uppercase" maxlength="3"
                        value="{{ $plate_suffix }}" required>
                </div>
            </div>
        </div>
    </div>

    <div class="submit-section d-flex justify-content-end mt-4 gap-2">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Update</button>
    </div>
</form>

<script>
    $('#form-edit-motorcycle').on('submit', function(e) {
        e.preventDefault();

        const prefix = $('input[name="plate_prefix"]').val().toUpperCase();
        const number = $('input[name="plate_number"]').val();
        const suffix = $('input[name="plate_suffix"]').val().toUpperCase();

        const plate = `${prefix} ${number} ${suffix}`;

        let formData = new FormData(this);
        formData.append('plate', plate);

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $('#add_salary-edit').modal('hide');
                $('#motorcycle-table').DataTable().ajax.reload(null, false);
                toastr.success('success', response.message);
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
