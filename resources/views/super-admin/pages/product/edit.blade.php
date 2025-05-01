@extends('index')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <form action="{{ url('super-admin/product/' . $data['product']->id . '/update') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Form Edit Produk</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-form-label col-md-2">Nama Produk</label>
                            <div class="col-md-10">
                                <input type="text" name="name" class="form-control" required
                                    value="{{ $data['product']->name }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-md-2">Kode Produk</label>
                            <div class="col-md-10">
                                <input type="text" name="code" class="form-control" required
                                    value="{{ $data['product']->code }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-md-2">Kategori</label>
                            <div class="col-md-10">
                                <select name="category_id" class="form-control form-select" required>
                                    <option value=""> -- Pilih Kategori -- </option>
                                    @foreach ($data['category'] as $categories)
                                        <option value="{{ $categories->id }}"
                                            {{ $categories->id == $data['product']->category_id ? 'selected' : '' }}>
                                            {{ $categories->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-md-2">Satuan</label>
                            <div class="col-md-10">
                                <select name="unit_id" class="form-control form-select2" required>
                                    <option value=""> -- Pilih Satuan -- </option>
                                    @foreach ($data['unit'] as $units)
                                        <option value="{{ $units->id }}"
                                            {{ $units->id == $data['product']->unit_id ? 'selected' : '' }}>
                                            {{ $units->name }} ({{ $units->acronym }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-md-2">Stok</label>
                            <div class="col-md-10">
                                <input type="number" name="stock" class="form-control" required
                                    value="{{ $data['product']->stock }}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-md-2">Status</label>
                            <div class="col-md-10">
                                <select name="status" class="form-control form-select">
                                    <option value="active" {{ $data['product']->status === 'active' ? 'selected' : '' }}>
                                        Aktif</option>
                                    <option value="inactive"
                                        {{ $data['product']->status === 'inactive' ? 'selected' : '' }}>Tidak Aktif
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-md-2">Deskripsi</label>
                            <div class="col-md-10">
                                <textarea name="description" class="form-control" rows="5" placeholder="Keterangan produk (opsional)">{{ $data['product']->description }}</textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-md-2">Gambar</label>
                            <div class="col-md-10">
                                <input type="file" name="image" class="form-control">
                                @if ($data['product']->image)
                                    <img src="{{ asset('storage/' . $data['product']->image) }}" width="100"
                                        class="mt-2 img-thumbnail">
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mt-4">
                            <div class="col-md-10 offset-md-2">
                                <button type="submit" class="btn btn-primary">Update Produk</button>
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
                    setTimeout(() => {
                        window.location.href = "{{ url('super-admin/product') }}";
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
