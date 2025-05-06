@extends('auth.index')
@section('content')
    <div class="account-wrapper">
        <h3 class="account-title">Daftar Akun</h3>
        <p class="account-subtitle">Pilih metode pendaftaran yang paling nyaman untukmu</p>
        <form id="registerForm" action="{{ url('/register') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Name<span class="mandatory">*</span></label>
                <input class="form-control" name="name" type="text">
            </div>
            <div class="form-group">
                <label>Email<span class="mandatory">*</span></label>
                <input class="form-control" name="email" type="text">
            </div>
            <div class="form-group">
                <label>Password<span class="mandatory">*</span></label>
                <input class="form-control" name="password" type="password">
            </div>
            <div class="form-group">
                <label>Repeat Password<span class="mandatory">*</span></label>
                <input class="form-control" name="password_confirmation" type="password">
            </div>
            <div class="form-group text-center">
                <button class="btn btn-primary account-btn" type="submit">Register</button>
            </div>
            <div class="account-footer mt-4">
                <p>Sudah punya akun? <a href="{{ url('/login') }}">Login</a></p>
            </div>
            <div class="form-group text-center">
                <p>Atau daftar dengan</p>
                <a href="{{ url('/auth/google/redirect') }}" class="btn btn-outline-light"
                    style="border-radius: 50%; padding: 12px 15px; border: 1px solid #ccc;">
                    <i class="fab fa-google" style="font-size: 20px; color: #db4437;"></i>
                </a>
            </div>
        </form>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            $('#registerForm').on('submit', function (e) {
                showLoading(); // fungsi loader milikmu
                e.preventDefault();

                const form = $(this);
                const url = form.attr('action');
                const data = form.serialize();

                $.post(url, data)
                    .done(function (res) {
                        setTimeout(() => {
                            window.location.href = '/login';
                        }, 800);
                        toastr.success(res.message);
                    })
                    .success(function (res) {
                        hideLoading();
                        toastr.success(res.message);
                    })
                    .fail(function (xhr) {
                        hideLoading();

                        let msg = 'Terjadi kesalahan. Coba lagi.';
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            msg = Object.values(errors).map(err => `<li>${err[0]}</li>`).join('');
                            msg = `<ul class="text-danger">${msg}</ul>`;
                        } else if (xhr.responseJSON && xhr.responseJSON.message) {
                            msg = `<p class="text-danger">${xhr.responseJSON.message}</p>`;
                        }

                        $('#flash-message').html(msg);
                    });
            });
        });
    </script>
@endsection