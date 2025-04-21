<nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
    <a href="index.html" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
        <h2 class="m-0 text-primary"><i class="fa fa-car me-3"></i>CarServ</h2>
    </a>
    <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav ms-auto p-4 p-lg-0">
            <a href="{{ url('/') }}" class="nav-item nav-link {{ Request::is('/') ? 'active' : '' }}">Home</a>
            <a href="{{ url('/about') }}" class="nav-item nav-link {{ Request::is('about') ? 'active' : '' }}">About</a>
            <a href="{{ url('/service') }}"
                class="nav-item nav-link {{ Request::is('service') ? 'active' : '' }}">Layanan</a>
            <a href="{{ url('/booking') }}"
                class="nav-item nav-link {{ Request::is('booking') ? 'active' : '' }}">Booking</a>
            <a href="{{ url('/contact') }}"
                class="nav-item nav-link {{ Request::is('contact') ? 'active' : '' }}">Contact</a>
        </div>
        <a href="{{ url('/login') }}" class="btn btn-primary py-4 px-lg-5 d-none d-lg-block">Login<i
                class="fa fa-sign-in ms-2"></i></a>
    </div>
</nav>