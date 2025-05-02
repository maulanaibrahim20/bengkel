<div class="navbar">
    <div class="container d-flex justify-content-between align-items-center">
        <div class="navbar-brand text-white fw-bold">
            <i class="fas fa-car-mechanic me-2"></i>
            Bengkel Mobil Premium
        </div>
        <div class="dropdown">
            <button class="btn text-white border-0 d-flex align-items-center" type="button" id="adminDropdown"
                data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-user-circle me-2"></i>
                <span>{{ Auth::user()->name }}</span>
                <i class="fas fa-chevron-down ms-2 small"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="adminDropdown">
                <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Profile</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item text-danger" href="{{ url('/logout') }}"><i
                            class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
            </ul>
        </div>
    </div>
</div>
