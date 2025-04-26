@extends('index')
@section('content')
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">Technician</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="admin-dashboard.html">Dashboard</a></li>
                    <li class="breadcrumb-item text-2xl">Master</li>
                    <li class="breadcrumb-item active">Technician</li>
                </ul>
            </div>
            <div class="col-auto float-end ms-auto">
                <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_salary"><i
                        class="fa fa-plus"></i> Add Technician</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card mb-0">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0" id="technician-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Username</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('super-admin.pages.master.technician.create')

    <div id="add_salary-edit" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Teknisi</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="modal-content-edit">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('#technician-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ url('/super-admin/master/technician/datatable') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'username',
                        name: 'username'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                ]
            });

            $('#username').on('input', function() {
                $('#submit-btn').prop('disabled', true);
                $('#username').removeClass('is-invalid');
                $('#username-feedback').addClass('d-none');
            });

            $('#check-username').on('click', function() {
                var username = $('#username').val();

                if (username.trim() === '') {
                    toastr.warning("Username tidak boleh kosong");
                    return;
                }

                $.ajax({
                    url: "{{ url('/super-admin/master/technician/check-username') }}",
                    method: "GET",
                    data: {
                        username: username
                    },
                    success: function(response) {
                        if (response.exists) {
                            $('#username').addClass('is-invalid');
                            $('#username-feedback').removeClass('d-none');
                            $('#submit-btn').prop('disabled', true);

                            toastr.error("Username sudah digunakan");
                        } else {
                            $('#username').removeClass('is-invalid');
                            $('#username-feedback').addClass('d-none');
                            $('#submit-btn').prop('disabled', false);

                            toastr.success("Username tersedia");
                        }
                    },
                    error: function() {
                        toastr.error("Gagal memeriksa username");
                        $('#submit-btn').prop('disabled', true);
                    }
                });
            });
        });

        $('#technician-table').on('draw.dt', function() {
            $('.editBtn').on('click', function() {
                const id = $(this).data('id');
                editModal(id);
            });

            $('.deleteBtn').on('click', function(e) {
                e.preventDefault();
                const id = $(this).data('id');
                const deleteForm = $('#deleteForm' + id);
                Swal.fire({
                    title: 'Anda yakin?',
                    text: "Data akan dihapus secara permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        deleteForm.submit();
                    }
                });
            });
        });


        function editModal(id) {
            $.ajax({
                url: '/super-admin/master/technician/' + id + '/edit',
                type: 'GET',
                data: {
                    id: id
                },
                success: function(response) {
                    $("#modal-content-edit").html(response)
                },
                error: function(error) {
                    console.log(error);
                }
            })
        }

        $('.deleteBtn').on('click', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            var deleteForm = $('#deleteForm' + id);
            Swal.fire({
                title: 'Anda yakin?',
                text: "Data akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteForm.submit();
                }
            });
        });

        $(document).on('click', '.deleteBtn', function(e) {
            e.preventDefault();
            const id = $(this).data('id');

            Swal.fire({
                title: 'Anda yakin?',
                text: "Data akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Kirimkan request delete ke server
                    $.ajax({
                        url: '/super-admin/master/technician/' + id + '/delete',
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}', // Kirimkan CSRF token untuk validasi
                        },
                        success: function(response) {
                            // Swal.fire('Berhasil!', response.success, 'success');
                            toastr.success('success', 'Berhasil menghapus data!');
                            $('#technician-table').DataTable().ajax.reload(null,
                                false); // Reload tabel tanpa refresh
                        },
                        error: function(xhr) {
                            toastr.error('error', 'Gagal menghapus data!');
                            // Swal.fire('Gagal!', xhr.responseJSON.error || 'Terjadi kesalahan', 'error');
                        }
                    });
                }
            });
        });
    </script>
@endsection
