<div id="add_user" class="modal custom-modal fade" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data User</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="form-create-user" action="{{ url('/super-admin/user/create') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Nama</label>
                            <input type="text" name="name" class="form-control" placeholder="Nama Lengkap" required>
                        </div>

                        <div class="form-group col-md-6 mt-2">
                            <label>Role</label>
                            <select name="role_id" class="form-control" required>
                                <option value="">Pilih Role</option>
                                @foreach ($role as $roles)
                                    <option value="{{ $roles->id }}">{{ $roles->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-6 mt-2">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Email" required>
                        </div>

                        <div class="form-group col-md-6 mt-2">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Password" required>
                        </div>

                        <div class="form-group col-md-6 mt-2">
                            <label>Phone</label>
                            <input type="text" name="phone" class="form-control" placeholder="Phone" maxlength="15">
                        </div>

                        <div class="form-group col-md-6 mt-2">
                            <label>Status</label>
                            <select name="status" class="form-control" required>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
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
    // Handle submit form user
    $('#form-create-user').on('submit', function (e) {
        e.preventDefault();

        let formData = new FormData(this);
        let url = $(this).attr('action');

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                $('#add_user').modal('hide');
                $('#form-create-user')[0].reset();
                $('#user-table').DataTable().ajax.reload(null, false); // Reload table
            },
            error: function (xhr) {
                let errMsg = 'Terjadi kesalahan.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errMsg = xhr.responseJSON.message;
                }
                alert(errMsg);
            }
        });
    });
</script>