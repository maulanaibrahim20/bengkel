@extends('index')
@section('content')
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">Edit Layanan Servis</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ url('super-admin/service') }}">Layanan</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ul>
            </div>
        </div>
    </div>

    <form id="edit-service-form" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card">
            <div class="card-body">
                <div class="mb-3">
                    <label>Nama Layanan</label>
                    <input type="text" name="name" class="form-control" value="{{ $service->name }}" required>
                </div>

                <div class="mb-3">
                    <label>Harga</label>
                    <input type="number" name="price" class="form-control" value="{{ $service->price }}" required>
                </div>

                <div class="mb-3">
                    <label>Durasi</label>
                    <input type="text" name="duration" class="form-control" value="{{ $service->duration }}" required>
                </div>

                <div class="mb-3">
                    <label>Icon (Biarkan kosong jika tidak ingin mengubah)</label>
                    <input type="file" name="icon" class="form-control">
                    @if($service->icon)
                        <small class="text-muted">Icon saat ini: <a href="{{ asset('storage/' . $service->icon) }}"
                                target="_blank">Lihat</a></small>
                    @endif
                </div>

                <hr>
                <h5>Deskripsi Detail Layanan</h5>
                <div id="detail-container">
                    @foreach ($service->detail as $detail)
                        <div class="input-group mb-2">
                            <input type="text" name="details[]" class="form-control" value="{{ $detail->description }}"
                                required>
                            <button type="button" class="btn btn-danger remove-detail"><i class="fa fa-trash"></i></button>
                        </div>
                    @endforeach
                </div>

                <button type="button" id="add-detail" class="btn btn-secondary mb-3"><i class="fa fa-plus"></i> Tambah
                    Detail</button>

                <div>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <a href="{{ url('service.index') }}" class="btn btn-light">Kembali</a>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            // Tambah input detail
            $('#add-detail').click(function () {
                $('#detail-container').append(`
                                                    <div class="input-group mb-2">
                                                        <input type="text" name="details[]" class="form-control" placeholder="Deskripsi layanan" required>
                                                        <button type="button" class="btn btn-danger remove-detail"><i class="fa fa-trash"></i></button>
                                                    </div>
                                                `);
            });

            // Hapus input detail
            $(document).on('click', '.remove-detail', function () {
                $(this).closest('.input-group').remove();
            });

            // Submit form via AJAX
            $('#edit-service-form').submit(function (e) {
                e.preventDefault();

                let formData = new FormData(this);

                $.ajax({
                    url: "{{ url('/super-admin/service/' . $service->id . '/update') }}",
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function () {
                        toastr.success('Layanan berhasil diperbarui!');
                        window.location.href = "{{ url('super-admin/service') }}";
                    },
                    error: function (xhr) {
                        const response = xhr.responseJSON;
                        toastr.error(response.message || 'Gagal memperbarui layanan!');
                    }
                });
            });
        });
    </script>
@endsection