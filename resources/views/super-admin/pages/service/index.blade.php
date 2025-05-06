@extends('index')
@section('content')
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">Data Layanan Servis</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item active">Layanan</li>
                </ul>
            </div>
            <div class="col-auto float-end ms-auto">
                <a href="{{ url('/super-admin/service/create') }}" class="btn btn-primary">
                    <i class="fa fa-plus"></i> Tambah Layanan
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card mb-0">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="service-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Harga</th>
                                    <th>Durasi</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="detailModal" class="modal custom-modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content" id="modal-content-detail">
                <!-- Konten akan dimuat via AJAX -->
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            $('#service-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: "{{ url('super-admin/service/datatable') }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'name', name: 'name' },
                    { data: 'price', name: 'price' },
                    { data: 'duration', name: 'duration' },
                    { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' }
                ]
            });

            $(document).on('click', '.detailBtn', function () {
                const id = $(this).data('id');

                $.ajax({
                    url: '/super-admin/service/' + id + '/details',
                    type: 'GET',
                    success: function (response) {
                        $('#modal-content-detail').html(response);
                        $('#detailModal').modal('show');
                    },
                    error: function () {
                        Swal.fire('Gagal', 'Gagal memuat detail layanan.', 'error');
                    }
                });
            });


            $(document).on('click', '.editBtn', function () {
                const id = $(this).data('id');
                $.get("/super-admin/service/" + id + "/edit", function (response) {
                    $('#modal-content-edit').html(response);
                    $('#editModal').modal('show');
                });
            });

            $(document).on('click', '.deleteBtn', function (e) {
                e.preventDefault();
                const id = $(this).data('id');
                Swal.fire({
                    title: 'Yakin hapus?',
                    text: "Data akan dihapus permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/super-admin/service/' + id + '/delete',
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}',
                            },
                            success: function () {
                                toastr.success('Berhasil menghapus data!');
                                $('#service-table').DataTable().ajax.reload(null, false);
                            },
                            error: function () {
                                toastr.error('Gagal menghapus data!');
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection