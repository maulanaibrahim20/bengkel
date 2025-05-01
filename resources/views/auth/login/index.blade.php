@extends('auth.index')
@section('content')
    <div class="account-wrapper">
        <h3 class="account-title">Login</h3>
        <p class="account-subtitle">Access to our dashboard</p>
        <form id="loginForm" action="{{ url('/login') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Email Address</label>
                <input class="form-control" type="text" name="email" value="superadmin@gmail.com" required>
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col">
                        <label>Password</label>
                    </div>
                    <div class="col-auto">
                        <a class="text-muted" href="forgot-password.html">Forgot password?</a>
                    </div>
                </div>
                <div class="position-relative">
                    <input class="form-control" type="password" name="password" value="password" id="password" required>
                    <span class="fa fa-eye-slash" id="toggle-password"
                        style="position:absolute; top:10px; right:15px; cursor:pointer;"></span>
                </div>
            </div>
            <div class="form-group text-center">
                <button class="btn btn-primary account-btn" type="submit">Login</button>
            </div>
            <div class="account-footer">
                <p>Don't have an account yet? <a href="{{ url('/register') }}">Register</a></p>
            </div>
        </form>
    </div>
@endsection

@section('script')
    <script>
        $('#toggle-password').on('click', function() {
            const passwordInput = $('#password');
            const type = passwordInput.attr('type') === 'password' ? 'text' : 'password';
            passwordInput.attr('type', type);
            $(this).toggleClass('fa-eye fa-eye-slash');
        });

        $('#loginForm').on('submit', function(e) {
            e.preventDefault();
            showLoading();

            const form = $(this);
            const url = form.attr('action');
            const formData = form.serialize();

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                success: function(response) {
                    hideLoading();
                    toastr.success(response.message);
                    setTimeout(() => {
                        window.location.href = response.redirect;
                    }, 1000);
                },
                error: function(xhr) {
                    hideLoading();
                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;
                        let message = Object.values(errors).map(err => `<li>${err[0]}</li>`).join('');
                        Swal.fire({
                            icon: 'warning',
                            title: 'Validasi Gagal',
                            html: `<ul class="text-start">${message}</ul>`
                        });
                    } else {
                        const message = xhr.responseJSON.message || 'Terjadi kesalahan saat login.';
                        Swal.fire('Gagal', message, 'error');
                    }
                }
            });
        });
    </script>
@endsection
