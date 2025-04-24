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
                        <table class="datatable table table-stripped mb-0">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Username</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($technicians as $data)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$data->name}}</td>
                                        <td>{{$data->username}}</td>
                                        <td class="text-center">
                                            <button type="button" class="btn br-7 btn-warning" data-bs-toggle="modal"
                                                data-bs-target="#add_salary-edit" onclick="editModal('{{ $data['id'] }}')">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            <form id="deleteForm{{ $data['id'] }}"
                                                action="{{ url('/super-admin/master/technician/' . $data['id'] . '/delete') }}"
                                                style="display: inline;" method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" class="btn btn-danger deleteBtn"
                                                    data-id="{{ $data['id'] }}"><i class="fa fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('admin.pages.master.technician.create')

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
        $(document).ready(function () {
            $('#username').on('input', function () {
                $('#submit-btn').prop('disabled', true);
                $('#username').removeClass('is-invalid');
                $('#username-feedback').addClass('d-none');
            });

            $('#check-username').on('click', function () {
                var username = $('#username').val();

                if (username.trim() === '') {
                    toastr.warning("Username tidak boleh kosong");
                    return;
                }

                $.ajax({
                    url: "{{ url('/super-admin/master/technician/check-username') }}",
                    method: "GET",
                    data: { username: username },
                    success: function (response) {
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
                    error: function () {
                        toastr.error("Gagal memeriksa username");
                        $('#submit-btn').prop('disabled', true);
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
                success: function (response) {
                    $("#modal-content-edit").html(response)
                },
                error: function (error) {
                    console.log(error);
                }
            })
        }

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
    </script>
@endsection