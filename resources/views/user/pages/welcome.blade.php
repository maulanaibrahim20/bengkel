@extends('components.index-with-bg')
@section('content')
    <div class="container h-100 d-flex justify-content-center align-items-center content pb-5">
        <div class="text-center text-white">
            <!-- Logo -->
            <img src="{{ url('/img/logo.png') }}" alt="Logo" class="img-fluid mb-4 logo-large">

            <h5 class="mb-2">Hallo <span class="text-warning fw-bold">{{ strtoupper(Auth::user()->name) }}</span>!</h5>
            <h4 class="fw-semibold mb-3">
                Selamat Hari Raya <span class="text-warning">Idul Fitri 1446H</span><br>
                <span class="text-warning">Mohon Maaf Lahir dan Batin</span>
            </h4>

            <div class="text-white rounded-3 px-4 py-3 mx-auto mb-4"
                style="max-width: 500px; background-color: rgba(255, 255, 255, 0.15); backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.25);">
                <p class="mb-1">Kami dari seluruh tim <strong>{{ config('app.name') }}</strong> mengucapkan terima kasih
                    atas
                    kepercayaan Anda.</p>
                <p class="mb-0">Semoga hari yang suci ini membawa kebahagiaan, keberkahan, dan kedamaian untuk Anda dan
                    keluarga.</p>
            </div>

            <p class="fst-italic">#Berani Beda</p>

            <a href="{{ url('/user/dashboard') }}" class="btn btn-warning px-4 py-2 rounded-pill fw-semibold">
                🛠 Lanjut Booking
            </a>
        </div>
    </div>
@endsection