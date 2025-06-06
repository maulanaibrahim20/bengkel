@extends('landing.index')
@section('content')
    <!-- Mobile-Optimized Header Carousel -->
    <div class="container-fluid p-0 mb-4 mb-md-5">
        <div id="header-carousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img class="w-100" src="{{ url('/landing') }}/img/carousel-bg-123.png" alt="Car Repair Service"
                        style="max-height: 70vh; object-fit: cover;">
                    <div class="carousel-caption d-flex align-items-center">
                        <div class="container">
                            <div class="row align-items-center justify-content-center justify-content-lg-start">
                                <div class="col-12 col-lg-7 text-center text-lg-start">
                                    <h6 class="text-white text-uppercase mb-2 mb-md-3 animated slideInDown">Bengkel Motor
                                        Terpercaya</h6>
                                    <h1
                                        class="display-5 display-md-3 text-white mb-3 mb-md-4 pb-2 pb-md-3 animated slideInDown">
                                        Perbaikan Motor Cepat, Andal, dan Terjangkau</h1>
                                    @auth
                                        <a href="{{ url('/user/booking/create') }}"
                                            class="btn btn-primary py-2 py-md-3 px-4 px-md-5 animated slideInDown">Booking
                                            Sekarang<i class="fa fa-arrow-right ms-2 ms-md-3"></i></a>
                                    @else
                                        <a href="{{ url('/booking/register') }}"
                                            class="btn btn-primary py-2 py-md-3 px-4 px-md-5 animated slideInDown">Booking
                                            Sekarang<i class="fa fa-arrow-right ms-2 ms-md-3"></i></a>

                                    @endauth

                                </div>
                                <div class="col-lg-5 d-none d-lg-flex animated zoomIn">
                                    <img class="img-fluid" src="{{ url('/landing') }}/img/carousel-12.png" alt="Car Repair">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <img class="w-100" src="{{ url('/landing') }}/img/carousel-bg-122.png" alt="Car Wash Service"
                        style="max-height: 70vh; object-fit: cover;">
                    <div class="carousel-caption d-flex align-items-center">
                        <div class="container">
                            <div class="row align-items-center justify-content-center justify-content-lg-start">
                                <div class="col-12 col-lg-7 text-center text-lg-start">
                                    <h6 class="text-white text-uppercase mb-2 mb-md-3 animated slideInDown">Ahli Perbaikan
                                        Motor Semua Merek</h6>
                                    <h1
                                        class="display-5 display-md-3 text-white mb-3 mb-md-4 pb-2 pb-md-3 animated slideInDown">
                                        Teknisi Profesional dan Berpengalaman</h1>
                                    <a href=""
                                        class="btn btn-primary py-2 py-md-3 px-4 px-md-5 animated slideInDown">Booking
                                        Sekarang<i class="fa fa-arrow-right ms-2 ms-md-3"></i></a>
                                </div>
                                <div class="col-lg-5 d-none d-lg-flex animated zoomIn">
                                    <img class="img-fluid" src="{{ url('/landing') }}/img/carousel-22.png" alt="Car Wash">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#header-carousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#header-carousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>

    <!-- Mobile-Optimized Feature Boxes -->
    <div class="container-xxl py-4 py-md-5">
        <div class="container">
            <!-- Header Produk -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">Produk Kami</h2>
                <a href="/produk" class="btn btn-primary">Lihat Semua Produk</a>
            </div>

            <!-- Daftar Produk -->
            <div class="row g-3 g-md-4">
                @foreach ($products as $product)
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card h-100">
                            <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top"
                                alt="{{ $product->name }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-text">{{ Str::limit($product->description, 100) }}</p>
                                <p class="fw-bold text-primary">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                                <a href="{{ url('/produk/' . $product->id) }}" class="btn btn-outline-primary">Lihat
                                    Detail</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Mobile-Optimized About Section -->
    <div class="container-xxl py-4 py-md-5">
        <div class="container">
            <div class="row g-4 g-md-5">
                <div class="col-12 col-lg-6 mb-4 mb-lg-0" style="min-height: 300px;">
                    <div class="position-relative h-100 wow fadeIn" data-wow-delay="0.1s">
                        <img class="position-absolute img-fluid w-100 h-100"
                            src="{{ Storage::url($config['about_image'] ?? '') }}" style="object-fit: cover;"
                            alt="{{ $config['about_title'] ?? 'Tentang Kami' }}">
                        <div class="position-absolute top-0 end-0 mt-n4 me-n4 py-3 py-md-4 px-4 px-md-5"
                            style="background: rgba(0, 0, 0, .08);">
                            <h1 class="display-4 text-white mb-0">
                                <span class="fs-5 fs-md-4 text-lowercase">since</span>
                                <span class="fs-1 fs-md-2 fw-bold">2013</span>
                            </h1>
                            <h4 class="text-white">Experience</h4>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <h6 class="text-primary text-uppercase">{{$config['about_title']}}</h6>
                    <h1 class="mb-3 mb-md-4"><span class="text-primary">{{ config('app.name') }}</span> #Berani Beda
                    </h1>
                    <p class="mb-3 mb-md-4">{{ $config['about_content'] ?? 'Kami Adalah Tempat Perawatan Motor Terbaik' }}
                    </p>
                    <div class="row g-3 g-md-4 mb-3 pb-3">
                        <div class="col-12 wow fadeIn" data-wow-delay="0.1s">
                            <div class="d-flex">
                                <div class="bg-light d-flex flex-shrink-0 align-items-center justify-content-center mt-1"
                                    style="width: 40px; height: 40px;">
                                    <span class="fw-bold text-secondary">01</span>
                                </div>
                                <div class="ps-3">
                                    <h6>Profesional & Ahli</h6>
                                    <span>Kami memiliki tim berpengalaman dan terlatih di bidangnya.</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 wow fadeIn" data-wow-delay="0.3s">
                            <div class="d-flex">
                                <div class="bg-light d-flex flex-shrink-0 align-items-center justify-content-center mt-1"
                                    style="width: 40px; height: 40px;">
                                    <span class="fw-bold text-secondary">02</span>
                                </div>
                                <div class="ps-3">
                                    <h6>Pusat Layanan Berkualitas</h6>
                                    <span>Kami menyediakan layanan terbaik dengan standar tinggi.</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 wow fadeIn" data-wow-delay="0.5s">
                            <div class="d-flex">
                                <div class="bg-light d-flex flex-shrink-0 align-items-center justify-content-center mt-1"
                                    style="width: 40px; height: 40px;">
                                    <span class="fw-bold text-secondary">03</span>
                                </div>
                                <div class="ps-3">
                                    <h6>Teknisi Berprestasi</h6>
                                    <span>Teknisi kami telah meraih berbagai penghargaan atas dedikasinya.</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <a href="" class="btn btn-primary py-2 py-md-3 px-4 px-md-5">Read More<i
                            class="fa fa-arrow-right ms-2 ms-md-3"></i>
                    </a> --}}
                </div>
            </div>
        </div>
    </div>

    <div class="container-xxl service py-4 py-md-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="text-primary text-uppercase">Layanan Kami</h6>
                <h1 class="mb-4 mb-md-5">Jelajahi Layanan Kami</h1>
            </div>
            <div class="row g-3 g-md-4 wow fadeInUp" data-wow-delay="0.3s">
                <div class="col-12">
                    <div class="accordion" id="accordionServices">
                        @foreach ($services as $service)
                            <div class="accordion-item mb-2 mb-md-3">
                                <h2 class="accordion-header" id="heading-{{ $service->id }}">
                                    <button
                                        class="accordion-button d-flex align-items-center p-3 {{ $loop->first ? '' : 'collapsed' }}"
                                        type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{ $service->id }}"
                                        aria-expanded="{{ $loop->first ? 'true' : 'false' }}"
                                        aria-controls="collapse-{{ $service->id }}">
                                        <i class="fa {{ $service->icon ?? 'fa-cogs' }} fa-lg fa-md-2x me-3 text-primary"></i>
                                        <h5 class="m-0">{{ $service->name }}</h5>
                                    </button>
                                </h2>
                                <div id="collapse-{{ $service->id }}"
                                    class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}"
                                    aria-labelledby="heading-{{ $service->id }}" data-bs-parent="#accordionServices">
                                    <div class="accordion-body">
                                        <p><strong>Harga:</strong> Rp{{ number_format($service->price, 0, ',', '.') }}</p>
                                        <p><strong>Durasi:</strong> {{ $service->duration }}</p>

                                        @if ($service->detail->count())
                                            <ul class="list-group list-group-flush mt-3">
                                                @foreach ($service->detail as $detail)
                                                    <li class="list-group-item px-0"><i
                                                            class="fa fa-check text-success me-2"></i>{{ $detail->description }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <p class="text-muted">Tidak ada detail tambahan.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile-Optimized Booking Section -->
    <div class="container-fluid bg-secondary booking my-4 my-md-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container">
            <div class="row gx-4 gx-md-5">
                <div class="col-12 py-4 py-md-5 text-center">
                    <div class="py-3 py-md-5">
                        <h1 class="text-white mb-3 mb-md-4">Penyedia Layanan Perbaikan Motor Bersertifikat dan
                            Berpengalaman</h1>
                        <p class="text-white mb-3 mb-md-4">
                            Kami menghadirkan layanan perbaikan motor profesional dengan kualitas terbaik dan didukung
                            teknisi bersertifikat. Kepuasan Anda adalah prioritas utama kami.
                        </p>
                        @guest
                            <a href="{{ url('/booking/register') }}" class="btn btn-primary px-4 px-md-5 py-2 py-md-3">Pesan
                                Sekarang</a>
                        @else
                            <a href="{{ url('user/booking/create') }}" class="btn btn-light px-4 px-md-5 py-2 py-md-3">Pesan
                                Sekarang</a>
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile-Optimized Team Section -->
    <div class="container-xxl py-4 py-md-5">
        <div class="container">
            <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                <h6 class="text-primary text-uppercase"> Teknisi Kami</h6>
                <h1 class="mb-4 mb-md-5">Teknisi Berpengalaman Kami</h1>
            </div>
            <div class="row g-3 g-md-4">
                @php
                    $defaultImages = ['team-1.jpg', 'team-2.jpg', 'team-3.jpg', 'team-4.jpg'];
                    $i = 0;
                @endphp
                @foreach ($technician as $tech)
                    @php
                        $imagePath = $tech->photo ?? null;
                        $imageToShow = $imagePath && file_exists(public_path('storage/' . $imagePath))
                            ? asset('storage/' . $imagePath)
                            : url('/landing/img/' . $defaultImages[$i % 4]);
                        $i++;
                    @endphp
                    <div class="col-6 col-md-6 col-lg-3 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="team-item">
                            <div class="position-relative overflow-hidden">
                                <img class="img-fluid" src="{{ $imageToShow }}" alt="{{ $tech->name }}">
                            </div>
                            <div class="bg-light text-center p-3 p-md-4">
                                <h5 class="fw-bold mb-0">{{ $tech->name }}</h5>
                                <small>Teknisi</small>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="container-fluid news-section bg-dark my-4 my-md-5 py-4 py-md-5">
        <div class="container">
            <div class="text-center mb-4 mb-md-5">
                <h6 class="text-primary text-uppercase">Berita dan Info</h6>
                <h1 class="text-white">Informasi Terbaru</h1>
            </div>
            <div class="owl-carousel news-carousel position-relative">
                <div class="bg-light p-3 p-md-4 mx-2">
                    <img src="https://via.placeholder.com/400x200?text=News+1" class="img-fluid mb-3" alt="Berita 1">
                    <h5 class="mb-2">Judul Berita Pertama</h5>
                    <p class="mb-0">Ringkasan berita atau informasi singkat yang menarik perhatian pembaca.</p>
                </div>
                <div class="bg-light p-3 p-md-4 mx-2">
                    <img src="https://via.placeholder.com/400x200?text=News+2" class="img-fluid mb-3" alt="Berita 2">
                    <h5 class="mb-2">Judul Berita Kedua</h5>
                    <p class="mb-0">Penjelasan singkat tentang kegiatan atau promo terbaru dari bengkel Anda.</p>
                </div>
                <div class="bg-light p-3 p-md-4 mx-2">
                    <img src="https://via.placeholder.com/400x200?text=News+3" class="img-fluid mb-3" alt="Berita 3">
                    <h5 class="mb-2">Judul Berita Ketiga</h5>
                    <p class="mb-0">Informasi penting terkait layanan, tips perawatan motor, atau update lainnya.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile-Optimized Testimonial Section -->
    <div class="container-xxl py-4 py-md-5 wow fadeInUp" data-wow-delay="0.1s">
        <div class="container">
            <div class="text-center">
                <h6 class="text-primary text-uppercase">Testimoni</h6>
                <h1 class="mb-4 mb-md-5">Apa Kata Klien Kami!</h1>
            </div>
            <!-- Modified for touch-friendly swiping -->
            <div class="owl-carousel testimonial-carousel position-relative">
                <div class="testimonial-item text-center">
                    <img class="bg-light rounded-circle p-2 mx-auto mb-3" src="{{ url('/landing') }}/img/testimonial-1.jpg"
                        style="width: 70px; height: 70px; object-fit: cover;">
                    <h5 class="mb-3">Nama Klien</h5>
                    <div class="testimonial-text bg-light text-center p-3 p-md-4">
                        <p class="mb-0">Pelayanan yang sangat memuaskan dan profesional. Saya sangat merekomendasikan jasa
                            ini untuk siapa saja yang membutuhkan.</p>
                    </div>
                </div>
                <div class="testimonial-item text-center">
                    <img class="bg-light rounded-circle p-2 mx-auto mb-3" src="{{ url('/landing') }}/img/testimonial-2.jpg"
                        style="width: 70px; height: 70px; object-fit: cover;">
                    <h5 class="mb-3">Nama Klien</h5>
                    <div class="testimonial-text bg-light text-center p-3 p-md-4">
                        <p class="mb-0">Teknisi yang ramah dan cepat tanggap. Hasil perbaikan motor saya sangat memuaskan.
                        </p>
                    </div>
                </div>
                <div class="testimonial-item text-center">
                    <img class="bg-light rounded-circle p-2 mx-auto mb-3" src="{{ url('/landing') }}/img/testimonial-3.jpg"
                        style="width: 70px; height: 70px; object-fit: cover;">
                    <h5 class="mb-3">Nama Klien</h5>
                    <div class="testimonial-text bg-light text-center p-3 p-md-4">
                        <p class="mb-0">Layanan cepat dan harga terjangkau. Sangat puas dengan pelayanan di sini.</p>
                    </div>
                </div>
                <div class="testimonial-item text-center">
                    <img class="bg-light rounded-circle p-2 mx-auto mb-3" src="{{ url('/landing') }}/img/testimonial-4.jpg"
                        style="width: 70px; height: 70px; object-fit: cover;">
                    <h5 class="mb-3">Nama Klien</h5>
                    <div class="testimonial-text bg-light text-center p-3 p-md-4">
                        <p class="mb-0">Sangat puas dengan pelayanan ramah dan hasil kerja yang sangat rapi. Terima kasih!
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection