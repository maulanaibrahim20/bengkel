@extends('index')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <form action="{{ url('super-admin/product/create') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Form Tambah Produk</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-form-label col-md-2">Nama Produk</label>
                            <div class="col-md-10">
                                <input type="text" name="name" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-md-2">Kode Produk</label>
                            <div class="col-md-10">
                                <input type="text" name="code" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-md-2">Kategori</label>
                            <div class="col-md-10">
                                <select name="category_id" class="form-control form-select" required>
                                    <option value=""> -- Pilih Kategori -- </option>
                                    @foreach ($category as $categories)
                                        <option value="{{ $categories->id }}">{{ $categories->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-md-2">Satuan</label>
                            <div class="col-md-10">
                                <select name="unit_id" class="form-control form-select2" required>
                                    <option value=""> -- Pilih Satuan -- </option>
                                    @foreach ($unit as $units)
                                        <option value="{{ $units->id }}">{{ $units->name }} ({{ $units->acronym }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-md-2">Stok</label>
                            <div class="col-md-10">
                                <input type="number" name="stock" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-md-2">Status</label>
                            <div class="col-md-10">
                                <select name="status" class="form-control form-select">
                                    <option value="active">Aktif</option>
                                    <option value="inactive">Tidak Aktif</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-md-2">Deskripsi</label>
                            <div class="col-md-10">
                                <textarea name="description" class="form-control" rows="5" placeholder="Keterangan produk (opsional)"></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-md-2">Gambar</label>
                            <div class="col-md-10">
                                <input type="file" name="image" class="form-control">
                            </div>
                        </div>

                        <div class="form-group row mt-4">
                            <div class="col-md-10 offset-md-2">
                                <button type="submit" class="btn btn-primary">Simpan Produk</button>
                            </div>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $('form').on('submit', function(e) {
            e.preventDefault();
            showLoading();

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
                    toastr.success(response.message, 'Sukses');

                    // Redirect setelah sukses (jika ingin)
                    setTimeout(() => {
                        window.location.href =
                            "{{ url('super-admin/product') }}"; // sesuaikan dengan route index-mu
                    }, 1000);
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        let message = Object.values(errors).map(err => `<li>${err[0]}</li>`).join('');
                        Swal.fire({
                            icon: 'warning',
                            title: 'Validasi Gagal',
                            html: `<ul class="text-start">${message}</ul>`
                        });
                    } else {
                        Swal.fire('Gagal', 'Terjadi kesalahan saat menyimpan.', 'error');
                    }
                }
            });
        });
    </script>
@endsection
