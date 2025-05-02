@extends('auth.index')

@section('content')
    <div class="account-wrapper text-center">
        <h3 class="account-title">Daftar Akun</h3>
        <p class="account-subtitle">Masukkan email untuk memulai pendaftaran</p>

        <form action="{{ url('/register/email') }}" method="POST" class="mt-4">
            @csrf
            <div class="form-group mb-4 text-start">
                <label for="email" class="form-label">Alamat Email <span class="text-danger">*</span></label>
                <input id="email" name="email" type="email" class="form-control form-control-lg rounded-pill"
                    placeholder="nama@email.com" required>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-lg rounded-pill">
                    <i class="fas fa-paper-plane me-2"></i> Lanjutkan
                </button>
            </div>

            <div class="account-footer mt-4">
                <p>Sudah punya akun? <a href="{{ url('/login') }}">Login</a></p>
            </div>
        </form>
    </div>
@endsection
