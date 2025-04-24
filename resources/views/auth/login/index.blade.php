@extends('auth.index')
@section('content')
    <div class="account-wrapper">
        <h3 class="account-title">Login</h3>
        <p class="account-subtitle">Access to our dashboard</p>
        <form action="{{ url('/login') }}" method="POST">
            @csrf
            <div class="form-group">
                <label>Email Address</label>
                <input class="form-control" type="text" name="email" value="superadmin@gmail.com">
            </div>
            <div class="form-group">
                <div class="row">
                    <div class="col">
                        <label>Password</label>
                    </div>
                    <div class="col-auto">
                        <a class="text-muted" href="forgot-password.html">
                            Forgot password?
                        </a>
                    </div>
                </div>
                <div class="position-relative">
                    <input class="form-control" type="password" name="password" value="password" id="password">
                    <span class="fa fa-eye-slash" id="toggle-password"></span>
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