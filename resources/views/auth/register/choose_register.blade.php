@extends('auth.index')
@section('content')
    <div class="account-wrapper text-center">
        <h3 class="account-title">Daftar Akun</h3>
        <p class="account-subtitle">Pilih metode pendaftaran yang paling nyaman untukmu</p>

        <div class="d-grid gap-3 mt-4">
            <a href="{{ url('register', ['type' => 'google']) }}" class="btn btn-primary btn-lg rounded-pill">
                <i class="fab fa-google me-2"></i> Daftar Menggunakan Google
            </a>
            <a href="{{ url('register', ['type' => 'phone']) }}" class="btn btn-outline-primary btn-lg rounded-pill">
                <i class="fas fa-phone me-2"></i> Daftar Menggunakan Nomor Telepon
            </a>
        </div>

        <div class="account-footer mt-4">
            <p>Sudah punya akun? <a href="{{ url('/login') }}">Login</a></p>
        </div>
    </div>
@endsection
