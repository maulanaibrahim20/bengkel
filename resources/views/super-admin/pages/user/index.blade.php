@extends('index')
@section('content')
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">List Users</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/super-admin/dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">List Users</li>
                </ul>
            </div>
            <div class="col-auto float-end ms-auto">
                <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_user"><i class="fa fa-plus"></i>
                    Add User</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card mb-0">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0" id="user-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Status</th>
                                    <th>Role</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('super-admin.pages.user.create')

    <div id="edit_user_modal" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit User</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="modal-content-edit-user"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            $('#user-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ url('/super-admin/user/datatable') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'phone', name: 'phone' },
                    { data: 'status', name: 'status' },
                    { data: 'role', name: 'role.name' },
                    { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' }
                ]
            });
        });

        $(document).on('click', '.editBtn', function () {
            const id = $(this).data('id');

            $.ajax({
                url: '/super-admin/user/' + id + '/edit',
                type: 'GET',
                success: function (response) {
                    $('#modal-content-edit-user').html(response);
                    $('#edit_user_modal').modal('show');
                },
                error: function () {
                    Swal.fire('Gagal', 'Gagal memuat data.', 'error');
                }
            });
        });

        $('.deleteBtn').on('click', function (e) {
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

        $(document).on('click', '.deleteBtn', function (e) {
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
                    $.ajax({
                        url: '/super-admin/user/' + id + '/delete',
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}',
                        },
                        success: function (response) {
                            toastr.success('success', 'Berhasil menghapus data!');
                            $('#user-table').DataTable().ajax.reload(null,
                                false);
                        },
                        error: function (xhr) {
                            toastr.error('error', 'Gagal menghapus data!');
                        }
                    });
                }
            });
        });

        $(document).on('click', '.change-status', function (e) {
            e.preventDefault();
            const id = $(this).data('id');
            const status = $(this).data('status');

            $.ajax({
                url: '/super-admin/user/' + id + '/change-status',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    status: status
                },
                success: function (res) {
                    if (res.success) {
                        toastr.success('Berhasil mengubah status');
                        $('#user-table').DataTable().ajax.reload(null, false);
                    } else {
                        toastr.error('Gagal mengubah status');
                    }
                },
                error: function () {
                    toastr.error('Terjadi kesalahan saat mengubah status');
                }
            });
        });

    </script>
@endsection