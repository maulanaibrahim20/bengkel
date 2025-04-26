<form id="form-edit-technician" action="{{ url('/super-admin/master/technician/' . $technician['id'] . '/update') }}"
    method="POST" enctype="multipart/form-data">
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
                <input class="form-control" value="{{ $technician->username }}" name="username" id="username-edit"
                    type="text">
                <button type="button" class="btn btn-outline-primary" id="check-username-edit">Cek</button>
            </div>
            <small id="username-feedback-edit" class="text-danger d-none">Username sudah digunakan</small>
        </div>
    </div>
    <div class="submit-section d-flex justify-content-end mt-4 gap-2">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary" id="submit-btn-edit">Simpan</button>
    </div>
</form>

<script>
    $(document).on('submit', '#form-edit-technician', function(e) {
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
                toastr.success('success', 'Berhasil mengupdate data!');
                $('#technician-table').DataTable().ajax.reload(null, false);
            },
            error: function(xhr) {
                let errMsg = 'Terjadi kesalahan.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errMsg = xhr.responseJSON.message;
                }
                Swal.fire('Gagal!', errMsg, 'error');
            }
        });
    });
    $(document).ready(function() {
        $('#username-edit').on('input', function() {
            $('#submit-btn-edit').prop('disabled', true);
            $('#username-edit').removeClass('is-invalid');
            $('#username-feedback-edit').addClass('d-none');
        });

        $('#check-username-edit').on('click', function() {
            var username = $('#username-edit').val();

            if (username.trim() === '') {
                toastr.warning("Username tidak boleh kosong");
                return;
            }

            $.ajax({
                url: "{{ url('/super-admin/master/technician/check-username') }}",
                method: "GET",
                data: {
                    username: username,
                    except_id: {{ $technician->id }}
                }, // jika kamu ingin mengabaikan username milik user itu sendiri
                success: function(response) {
                    if (response.exists) {
                        $('#username-edit').addClass('is-invalid');
                        $('#username-feedback-edit').removeClass('d-none');
                        $('#submit-btn-edit').prop('disabled', true);

                        toastr.error("Username sudah digunakan");
                    } else {
                        $('#username-edit').removeClass('is-invalid');
                        $('#username-feedback-edit').addClass('d-none');
                        $('#submit-btn-edit').prop('disabled', false);

                        toastr.success("Username tersedia");
                    }
                },
                error: function() {
                    toastr.error("Gagal memeriksa username");
                    $('#submit-btn-edit').prop('disabled', true);
                }
            });
        });
    });
</script>
