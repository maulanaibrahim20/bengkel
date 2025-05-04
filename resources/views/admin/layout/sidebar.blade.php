<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul class="sidebar-vertical">
                <li class="menu-title">
                    <span>Main</span>
                </li>
                <li class="submenu">
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
                    <li class="menu-title">
                        <span>Kasir</span>
                    </li>
                    <li class="{{ Request::segment(2) == 'product' ? 'active' : '' }}">
                        <a href="{{ url('/app/kasir') }}"><i class="la la-box"></i> <span>Kasir</span></a>
                    </li>
                    <li class="menu-title">
                        <span>Product</span>
                    </li>
                    <li class="{{ Request::segment(2) == 'product' ? 'active' : '' }}">
                        <a href="{{ url('/super-admin/product') }}"><i class="la la-box"></i> <span>Produk</span></a>
                    </li>
                    <li class="menu-title">
                        <span>Master</span>
                    </li>
                    <li class="submenu">
                        <a href="#"><i class="la la-dashboard"></i> <span> Master</span> <span
                                class="menu-arrow"></span></a>
                        <ul style="display: none;">
                            <li><a class="{{ Request::segment(3) == 'brand-engine' ? 'active' : '' }}"
                                    href="{{ url('/super-admin/master/brand-engine') }}">Brand Engine</a>
                            </li>
                            <li><a class="{{ Request::segment(3) == 'technician' ? 'active' : '' }}"
                                    href="{{ url('/super-admin/master/technician') }}">Technician</a>
                            </li>
                            <li><a class="{{ Request::segment(3) == 'product-category' ? 'active' : '' }}"
                                    href="{{ url('/super-admin/master/product-category') }}">Product Category</a>
                            </li>
                            <li><a class="{{ Request::segment(3) == 'product-unit' ? 'active' : '' }}"
                                    href="{{ url('/super-admin/master/product-unit') }}">Product Unit</a>
                            </li>
                        </ul>
                    </li>
                @endcan
                @can('admin')
                @endcan
                @can('user')
                    <li class="menu-title">
                        <span>Booking</span>
                    </li>
                    <li class="{{ Request::segment(2) == 'booking' ? 'active' : '' }}">
                        <a href="{{ url('/user/booking') }}"><i class="fa fa-book"></i> <span>Booking</span></a>
                    </li>
                    <li class="menu-title">
                        <span>List Motor</span>
                    </li>
                    <li class="{{ Request::segment(2) == 'motorcycle' ? 'active' : '' }}">
                        <a href="{{ url('/user/motorcycle') }}"><i class="fa fa-motorcycle"></i> <span>Motor</span></a>
                    </li>
                @endcan
                <li class="menu-title">
                    <span>Setting</span>
                </li>
                <li class="{{ Request::segment(2) == 'profile' ? 'active' : '' }}">
                    @if (Auth::user()->role_id == 1)
                        <a href="{{ url('/super-admin/profile') }}"><i class="fa fa-user"></i> <span>Profile</span></a>
                    @elseif (Auth::user()->role_id == 2)
                        <a href="{{ url('/admin/profile') }}"><i class="fa fa-user"></i> <span>Profile</span></a>
                    @elseif (Auth::user()->role_id == 3)
                        <a href="{{ url('/user/profile') }}"><i class="fa fa-user"></i> <span>Profile</span></a>
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
