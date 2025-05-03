@extends('index')
@section('content')
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">List Motor</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/super-admin/dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">List Motor</li>
                </ul>
            </div>
            <div class="col-auto float-end ms-auto">
                <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_salary"><i
                        class="fa fa-plus"></i> Add Motorcycle</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card mb-0">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0" id="motorcycle-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>User & Brand</th>
                                    <th>Type</th>
                                    <th>Plate</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('user.pages.motorcyle.create')

    <div id="add_salary-edit" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data Motor</h5>
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
            $('#motorcycle-table').DataTable({
                searchable: true,
                processing: true,
                serverSide: true,
                ajax: "{{ url('user/motorcycle/datatable') }}",
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
                        data: 'type',
                        name: 'type'
                    },
                    {
                        data: 'plate',
                        name: 'plate'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    }
                ]
            });
        });

        $(document).on('click', '.editBtn', function() {
            const id = $(this).data('id');

            $.ajax({
                url: '/user/motorcycle/' + id + '/edit',
                type: 'GET',
                success: function(response) {
                    $('#modal-content-edit').html(response); // Load form edit
                    $('#add_salary-edit').modal('show'); // Pastikan modal terbuka
                },
                error: function() {
                    Swal.fire('Gagal', 'Gagal memuat data.', 'error');
                }
            });
        });


        $(document).on('click', '.deleteBtn', function(e) {
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
