@extends('auth.index')
@section('content')
    <div class="account-wrapper">
        <h3 class="account-title">Register</h3>
        <p class="account-subtitle">Access to our dashboard</p>

        <!-- Account Form -->
        <form action="admin-dashboard.html">
            <div class="form-group">
                <label>Email<span class="mandatory">*</span></label>
                <input class="form-control" type="text">
            </div>
            <div class="form-group">
                <label>Password<span class="mandatory">*</span></label>
                <input class="form-control" type="password">
            </div>
            <div class="form-group">
                <label>Repeat Password<span class="mandatory">*</span></label>
                <input class="form-control" type="password">
            </div>
            <div class="form-group text-center">
                <button class="btn btn-primary account-btn" type="submit">Register</button>
            </div>
            <div class="account-footer">
                <p>Already have an account? <a href="{{ url('/login') }}">Login</a></p>
            </div>
        </form>
    </div>
@endsection