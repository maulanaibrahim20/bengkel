<form id="form-edit-user" action="{{ url('/super-admin/user/' . $user->id . '/update') }}" method="POST">
    @csrf
    @method('PUT')
    <div class="row">
        <div class="form-group col-md-6">
            <label>Nama</label>
            <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
        </div>

        <div class="form-group col-md-6 mt-2">
            <label>Role</label>
            <select name="role_id" class="form-control" required>
                <option value="">Pilih Role</option>
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}" {{ $role->id == $user->role_id ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group col-md-6 mt-2">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
        </div>

        <div class="form-group col-md-6 mt-2">
            <label>Password (Opsional)</label>
            <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak diubah">
        </div>

        <div class="form-group col-md-6 mt-2">
            <label>Phone</label>
            <input type="text" name="phone" class="form-control" value="{{ $user->phone }}" maxlength="15">
        </div>

        <div class="form-group col-md-6 mt-2">
            <label>Status</label>
            <select name="status" class="form-control" required>
                <option value="1" {{ $user->status == 1 ? 'selected' : '' }}>Active</option>
                <option value="0" {{ $user->status == 0 ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

    </div>

    <div class="submit-section d-flex justify-content-end mt-4 gap-2">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Update</button>
    </div>
</form>

<script>
    $('#form-edit-user').on('submit', function (e) {
        e.preventDefault();

        let formData = new FormData(this);

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                $('#edit_user_modal').modal('hide');
                $('#user-table').DataTable().ajax.reload(null, false);
                toastr.success('Success', response.message);
            },
            error: function (xhr) {
                let errMsg = 'Terjadi kesalahan.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errMsg = xhr.responseJSON.message;
                }
                toastr.error('Gagal!', errMsg, 'error');
            }
        });
    });
</script>