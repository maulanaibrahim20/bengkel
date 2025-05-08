@extends('components.index-with-bg')
@section('content')
    <div class="container min-vh-100 d-flex flex-column justify-content-between content py-4">
        <!-- Logo di bagian atas -->
        <div class="text-center text-white mt-4 pt-5">
            <img src="{{ url('/img/logo.png') }}" alt="Logo" class="img-fluid logo-large">
        </div>

        <!-- Konten utama di bagian bawah -->
        <div class="text-center text-white mb-5">
            <div class="greeting-card mb-4">
                <h5 class="greeting-name">Hallo <span
                        class="text-custom-yellow fw-bold">{{ strtoupper(Auth::user()->name) }}</span>!</h5>
                <h4 class="greeting-message fw-semibold mb-3">
                    Selamat Hari Raya <span class="text-custom-yellow">Idul Fitri 1446H</span><br>
                    <span class="text-custom-yellow">Mohon Maaf Lahir dan Batin</span>
                </h4>
            </div>

            <div class="message-card text-white rounded-4 px-4 py-4 mx-auto mb-4">
                <p class="mb-2">Kami dari seluruh tim <strong>{{ config('app.name') }}</strong> mengucapkan terima kasih
                    atas kepercayaan Anda.</p>
                <p class="mb-0">Semoga hari yang suci ini membawa kebahagiaan, keberkahan, dan kedamaian untuk Anda dan
                    keluarga.</p>
            </div>

            <p class="tagline fst-italic mb-4">#Berani Beda</p>

            <a href="{{ url('/user/dashboard') }}" class="btn btn-custom px-5 py-2 rounded-pill fw-semibold">
                🛠 Lanjut Booking
            </a>
        </div>
    </div>
@endsection
