<nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
    <a href="index.html" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
        <h2 class="m-0 text-primary"><i class="fa fa-car me-3"></i>CarServ</h2>
    </a>
    <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav ms-auto p-4 p-lg-0">
            <a href="{{ url('/') }}" class="nav-item nav-link {{ Request::is('/') ? 'active' : '' }}">
                <i class="fa fa-home me-2"></i>Home
            </a>
            <a href="{{ url('/about') }}" class="nav-item nav-link {{ Request::is('about') ? 'active' : '' }}">
                <i class="fa fa-info-circle me-2"></i>About
            </a>
            <a href="{{ url('/service') }}" class="nav-item nav-link {{ Request::is('service') ? 'active' : '' }}">
                <i class="fa fa-tools me-2"></i>Service
            </a>
            <a href="{{ url('/booking') }}" class="nav-item nav-link {{ Request::is('booking') ? 'active' : '' }}">
                <i class="fa fa-calendar-check me-2"></i>Booking
            </a>
            <a href="{{ url('/contact') }}" class="nav-item nav-link {{ Request::is('contact') ? 'active' : '' }}">
                <i class="fa fa-envelope me-2"></i>Contact
            </a>
        </div>

        <!-- Tombol Login -->
        <a href="{{ url('/login') }}" class="btn btn-primary py-3 px-5 d-none d-lg-block"
            style="transition: background-color 0.3s ease;">
            Login <i class="fa fa-sign-in-alt ms-2"></i>
        </a>

        <!-- Tombol Login untuk Tampilan Mobile -->
        <a href="{{ url('/login') }}" class="btn btn-primary py-3 w-100 w-lg-auto d-block d-lg-none"
            style="transition: background-color 0.3s ease;">
            Login <i class="fa fa-sign-in-alt ms-2"></i>
        </a>
    </div>
</nav>