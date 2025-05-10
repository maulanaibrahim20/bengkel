<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul class="sidebar-vertical">
                <li class="menu-title">
                    <span>Main</span>
                </li>
                <li class="submenu {{ Request::segment(2) == 'dashboard' ? 'active menu-open' : '' }}">
                    <a href="#"><i class="la la-dashboard"></i> <span> Dashboard</span> <span
                            class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li>
                            @auth
                                @if (Auth::user()->role_id == 1)
                                    <a class="{{ Request::segment(2) == 'dashboard' ? 'active' : '' }}"
                                        href="{{ url('/super-admin/dashboard') }}">Dashboard
                                    </a>
                                @elseif (Auth::user()->role_id == 2)
                                    <a class="{{ Request::segment(2) == 'dashboard' ? 'active' : '' }}"
                                        href="{{ url('/admin/dashboard') }}">Dashboard
                                    </a>
                                @elseif (Auth::user()->role_id == 3)
                                    <a class="{{ Request::segment(2) == 'dashboard' ? 'active' : '' }}"
                                        href="{{ url('/user/dashboard') }}">Dashboard
                                    </a>
                                @endif
                            @endauth
                        </li>
                    </ul>
                </li>
                @can('super-admin')
                    {{-- TRANSAKSI --}}
                    <li class="menu-title"><span>Transaksi</span></li>
                    <li class="{{ Request::segment(2) == 'kasir' ? 'active' : '' }}">
                        <a href="{{ url('/app/kasir') }}"><i class="la la-cash-register"></i>
                            <span>Kasir (Prototype)</span></a>
                    </li>
                    <li class="{{ Request::segment(2) == 'booking-list' ? 'active' : '' }}">
                        <a href="{{ url('/super-admin/booking-list') }}"><i class="la la-book"></i>
                            <span>Daftar Booking</span></a>
                    </li>

                    {{-- PRODUK & LAYANAN --}}
                    <li class="menu-title"><span>Produk & Layanan</span></li>
                    <li class="{{ Request::segment(2) == 'product' ? 'active' : '' }}">
                        <a href="{{ url('/super-admin/product') }}"><i class="la la-box"></i> <span>Produk</span></a>
                    </li>
                    <li class="{{ Request::segment(2) == 'motorcycle' ? 'active' : '' }}">
                        <a href="{{ url('/super-admin/motorcycle') }}"><i class="la la-motorcycle"></i>
                            <span>Kendaraan</span></a>
                    </li>
                    <li class="{{ Request::segment(2) == 'service' ? 'active' : '' }}">
                        <a href="{{ url('/super-admin/service') }}"><i class="la la-tools"></i>
                            <span>Layanan Servis</span></a>
                    </li>
                    <li class="{{ Request::segment(2) == 'booking-slot' ? 'active' : '' }}">
                        <a href="{{ url('/super-admin/booking-slot') }}"><i class="la la-calendar"></i>
                            <span>Slot Booking</span></a>
                    </li>

                    {{-- MASTER DATA --}}
                    <li class="menu-title"><span>Master Data</span></li>

                    @php
                        $activeMasterProduk = in_array(Request::segment(3), ['product-category', 'product-unit']);
                        $activeMasterUmum = in_array(Request::segment(3), ['brand-engine', 'technician']);
                    @endphp

                    {{-- Master Produk --}}
                    <li class="submenu {{ $activeMasterProduk ? 'active menu-open' : '' }}">
                        <a href="#"><i class="la la-archive"></i> <span>Master Produk</span> <span
                                class="menu-arrow"></span></a>
                        <ul style="{{ $activeMasterProduk ? 'display: block;' : 'display: none;' }}">
                            <li><a class="{{ Request::segment(3) == 'product-category' ? 'active' : '' }}"
                                    href="{{ url('/super-admin/master/product-category') }}">Kategori Produk</a></li>
                            <li><a class="{{ Request::segment(3) == 'product-unit' ? 'active' : '' }}"
                                    href="{{ url('/super-admin/master/product-unit') }}">Satuan Produk</a></li>
                        </ul>
                    </li>

                    {{-- Master Umum --}}
                    <li class="submenu {{ $activeMasterUmum ? 'active menu-open' : '' }}">
                        <a href="#"><i class="la la-cogs"></i> <span>Master Umum</span> <span
                                class="menu-arrow"></span></a>
                        <ul style="{{ $activeMasterUmum ? 'display: block;' : 'display: none;' }}">
                            <li><a class="{{ Request::segment(3) == 'brand-engine' ? 'active' : '' }}"
                                    href="{{ url('/super-admin/master/brand-engine') }}">Merek Mesin</a></li>
                            <li><a class="{{ Request::segment(3) == 'technician' ? 'active' : '' }}"
                                    href="{{ url('/super-admin/master/technician') }}">Teknisi</a></li>
                        </ul>
                    </li>

                    {{-- MANAJEMEN SISTEM --}}
                    <li class="menu-title"><span>Manajemen Sistem</span></li>
                    <li class="{{ Request::segment(2) == 'user' ? 'active' : '' }}">
                        <a href="{{ url('/super-admin/user') }}"><i class="la la-user"></i> <span>Pengguna</span></a>
                    </li>
                @endcan
                @can('admin')
                @endcan
                @can('user')
                    <li class="menu-title"><span>Layanan</span></li>

                    {{-- Booking --}}
                    <li class="{{ Request::segment(2) == 'booking' ? 'active' : '' }}">
                        <a href="{{ url('/user/booking') }}"><i class="la la-calendar-plus-o"></i> <span>Buat
                                Booking</span></a>
                    </li>

                    {{-- Riwayat Booking --}}
                    <li class="{{ Request::segment(2) == 'booking-history' ? 'active' : '' }}">
                        <a href="{{ url('/user/booking-history') }}"><i class="la la-history"></i> <span>Riwayat
                                Booking</span></a>
                    </li>

                    {{-- Motor --}}
                    <li class="menu-title"><span>Kendaraan</span></li>
                    <li class="{{ Request::segment(2) == 'motorcycle' ? 'active' : '' }}">
                        <a href="{{ url('/user/motorcycle') }}"><i class="la la-motorcycle"></i> <span>Motor
                                Saya</span></a>
                    </li>
                @endcan
                {{-- PENGATURAN --}}
                <li class="menu-title"><span>Pengaturan</span></li>
                <li class="{{ Request::segment(2) == 'profile' ? 'active' : '' }}">
                    @if (Auth::user()->role_id == 1)
                        <a href="{{ url('/super-admin/profile') }}"><i class="la la-user"></i> <span>Profil</span></a>
                    @elseif (Auth::user()->role_id == 2)
                        <a href="{{ url('/admin/profile') }}"><i class="la la-user"></i> <span>Profil</span></a>
                    @elseif (Auth::user()->role_id == 3)
                        <a href="{{ url('/user/profile') }}"><i class="la la-user"></i> <span>Profil</span></a>
                    @endif
                </li>
                <li>
                    <a href="{{ route('logout') }}" class="logoutBtn"><i class="fa fa-sign-out"></i>
                        <span>Logout</span></a>
                </li>
            </ul>
        </div>
    </div>
</div>
