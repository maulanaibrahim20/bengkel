<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bengkel Mobil Premium</title>
    @include('super-admin.kasir.components.css')
</head>

<body>
    @include('super-admin.kasir.components.header')

    <div class="container mt-4">
        <div class="row">
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <div class="dropdown">
                                    <button
                                        class="btn dropdown-toggle w-100 d-flex justify-content-between align-items-center"
                                        type="button" id="categoryDropdown" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <span>Kategori</span>
                                        <i class="fas fa-chevron-down"></i>
                                    </button>
                                    <ul class="dropdown-menu w-100" aria-labelledby="categoryDropdown">
                                        <li><a class="dropdown-item" href="#">Semua Kategori</a></li>
                                        <li><a class="dropdown-item" href="#">Ban</a></li>
                                        <li><a class="dropdown-item" href="#">Oli</a></li>
                                        <li><a class="dropdown-item" href="#">Servis</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="input-group">
                                    <input type="text" class="form-control search-input"
                                        placeholder="Cari produk...">
                                </div>
                            </div>
                        </div>

                        <div class="category-scroll-wrapper mb-4">
                            <div class="category-btn-container">
                                <button class="btn category-btn active me-2">Semua</button>
                                @foreach ($category as $kategori)
                                    <button class="btn category-btn me-2">{{ $kategori->name }}</button>
                                @endforeach
                            </div>
                        </div>

                        <div class="row" id="product-container">
                            <!-- Akan diisi oleh AJAX -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right panel - Cart -->
            <div class="col-lg-4">
                <!-- Cart Header -->
                <div class="cart-card mb-4">
                    <div class="cart-header">
                        <h5 class="mb-0">Keranjang</h5>
                    </div>

                    <!-- Cart Items -->
                    <div class="cart-items">
                        <div class="cart-item d-flex justify-content-between">
                            <div>
                                <p class="mb-0 fw-bold">Ban Luar FDR</p>
                                <small class="text-muted">2 x 350.000</small>
                            </div>
                            <p class="mb-0 text-end fw-bold">Rp 700.000</p>
                        </div>

                        <div class="cart-item d-flex justify-content-between">
                            <div>
                                <p class="mb-0 fw-bold">Oli Yamalube</p>
                                <small class="text-muted">1 x 700.000</small>
                            </div>
                            <p class="mb-0 text-end fw-bold">Rp 700.000</p>
                        </div>

                        <div class="cart-item d-flex justify-content-between">
                            <div>
                                <p class="mb-0 fw-bold">Ban Luar FDR</p>
                                <small class="text-muted">1 x 15.000</small>
                            </div>
                            <p class="mb-0 text-end fw-bold">Rp 15.000</p>
                        </div>

                        <div class="cart-total">
                            <span>Total:</span>
                            <span class="text-end">Rp 745.000</span>
                        </div>
                    </div>
                </div>

                <!-- Notes Card -->
                <div class="cart-card mb-4">
                    <div class="cart-notes">
                        <div class="mb-3">
                            <input type="text" class="form-control mb-2" placeholder="Nama Pelanggan">
                            <input type="text" class="form-control mb-2" placeholder="Nomor Telepon">
                            <textarea class="form-control" rows="3" placeholder="Catatan"></textarea>
                        </div>
                    </div>
                </div>

                <!-- Payment Button -->
                <div class="mb-4">
                    <button class="btn btn-pay">Bayar</button>
                </div>
            </div>
        </div>
    </div>

    @include('super-admin.kasir.components.footer')
    @include('super-admin.kasir.components.js')
    <script>
        $(document).ready(function() {
            let typingTimer;
            const doneTypingInterval = 300;

            function loadProducts(search = '') {
                $('#loading').show();
                $('#product-container').hide();

                $.ajax({
                    url: "{{ url('/app/kasir/getData') }}",
                    data: {
                        search: search,
                        processing: true,
                        serverside: true,
                    },
                    success: function(response) {
                        $('#product-container').empty();
                        $('#loading').hide();
                        $('#product-container').show();

                        if (response.data.length > 0) {
                            response.data.forEach(product => {
                                $('#product-container').append(`
                        <div class="col-md-4">
                            <div class="card product-card">
                                <div class="product-image"><i class="fas fa-tire"></i></div>
                                <div class="card-body">
                                    <h6 class="product-title">${product.name}</h6>
                                    <p class="product-price">${product.price_formatted}</p>
                                    <button class="btn btn-add w-100">
                                        <i class="fas fa-plus me-2"></i>Tambah
                                    </button>
                                </div>
                            </div>
                        </div>
                    `);
                            });
                        } else {
                            $('#product-container').append(
                                '<div class="col-12 text-center">Produk tidak ditemukan.</div>');
                        }
                    },
                    error: function() {
                        $('#loading').hide();
                        $('#product-container').show().html(
                            '<div class="col-12 text-danger text-center">Gagal memuat data.</div>');
                    }
                });
            }


            // First load
            loadProducts();

            // Real-time search
            $('.search-input').on('keyup', function() {
                clearTimeout(typingTimer);
                let searchVal = $(this).val();
                typingTimer = setTimeout(() => {
                    loadProducts(searchVal);
                }, doneTypingInterval);
            });
        });
    </script>


</body>

</html>
