@extends('index')
@section('content')
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">Tambah Layanan Servis</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('super-admin/service') }}">Layanan</a></li>
                    <li class="breadcrumb-item active">Tambah</li>
                </ul>
            </div>
        </div>
    </div>

    <form id="create-service-form" enctype="multipart/form-data">
        @csrf
        <div class="card">
            <div class="card-body">
                <div class="mb-3">
                    <label for="name">Nama Layanan</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="price">Harga</label>
                    <input type="number" name="price" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="duration">Durasi</label>
                    <input type="text" name="duration" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="icon">Icon (Optional)</label>
                    <input type="file" name="icon" class="form-control">
                </div>

                <hr>
                <h5>Deskripsi Detail Layanan</h5>
                <div id="detail-container">
                    <div class="input-group mb-2">
                        <input type="text" name="details[]" class="form-control" placeholder="Deskripsi layanan" required>
                        <button type="button" class="btn btn-danger remove-detail"><i class="fa fa-trash"></i></button>
                    </div>
                </div>

                <button type="button" id="add-detail" class="btn btn-secondary mb-3"><i class="fa fa-plus"></i> Tambah
                    Detail</button>

                <div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ url('super-admin/service') }}" class="btn btn-light">Kembali</a>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            $('#add-detail').click(function () {
                $('#detail-container').append(`
                                                                        <div class="input-group mb-2">
                                                                            <input type="text" name="details[]" class="form-control" placeholder="Deskripsi layanan" required>
                                                                            <button type="button" class="btn btn-danger remove-detail"><i class="fa fa-trash"></i></button>
                                                                        </div>
                                                                    `);
            });

            $(document).on('click', '.remove-detail', function () {
                $(this).closest('.input-group').remove();
            });

            $('#create-service-form').submit(function (e) {
                e.preventDefault();

                let formData = new FormData(this);

                $.ajax({
                    url: "{{ url('super-admin/service/create') }}",
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function () {
                        toastr.success('Layanan berhasil ditambahkan!');
                        window.location.href = "{{ url('/super-admin/service') }}";
                    },
                    error: function (xhr) {
                        const response = xhr.responseJSON;
                        toastr.error(response.message || 'Terjadi kesalahan saat menyimpan!');
                    }
                });
            });
        });
    </script>
@endsection