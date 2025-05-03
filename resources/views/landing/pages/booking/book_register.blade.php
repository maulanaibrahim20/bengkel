@extends('components.index-with-bg')
@section('content')
    <div class="container h-100 d-flex justify-content-center align-items-center content">
        <div class="text-center text-white">
            <h2 class="fw-bold">Buat akun dengan dua langkah mudah</h2>
            <p class="mb-4">Untuk menggunakan layanan kami, kita harus terhubung terlebih dahulu</p>
            <a href="{{ url('/register') }}" class="btn btn-yellow px-4 py-2 rounded-pill">
                OK, Buat akun saya sekarang
            </a>
        </div>
    </div>
@endsection
