@extends('auth.index')
@section('content')
    <div class="account-wrapper">
        <h3 class="account-title">Forgot Password?</h3>
        <p class="account-subtitle">Enter your email to get a password reset link</p>

        <form id="forgotPasswordForm" action="{{ url('/forgot-password') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Email Address</label>
                <input class="form-control" name="email" type="text">
            </div>
            <div class="form-group text-center">
                <button class="btn btn-primary account-btn" type="submit">Reset Password</button>
            </div>
            <div class="account-footer">
                <p>Remember your password? <a href="{{ url('/login') }}">Login</a></p>
            </div>
        </form>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            $('#forgotPasswordForm').on('submit', function (e) {
                showLoading();
                e.preventDefault();

                const form = $(this);
                const url = form.attr('action');
                const data = form.serialize();


                $.post(url, data)
                    .done(function (res) {
                        setTimeout(() => {
                            location.reload();
                        }, 500)
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