@extends('auth.index')
@section('content')
    <div class="account-wrapper">
        <h3 class="account-title">Reset Password</h3>

        <form action="{{ route('password.update') }}" method="POST">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ $email ?? old('email') }}">

            <div class="form-group">
                <label>New Password</label>
                <input class="form-control" type="password" name="password" required>
            </div>

            <div class="form-group">
                <label>Confirm Password</label>
                <input class="form-control" type="password" name="password_confirmation" required>
            </div>

            <div class="form-group text-center">
                <button class="btn btn-primary account-btn" type="submit">Reset Password</button>
            </div>
        </form>
    </div>
@endsection