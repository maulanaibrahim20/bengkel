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
                        <li><a class="{{ Request::segment(2) == 'dashboard' ? 'active' : '' }}"
                                href="{{ url('/super-admin/dashboard') }}">Admin Dashboard</a></li>
                    </ul>
                </li>
                <li class="menu-title">
                    <span>Employees</span>
                </li>
                <li>
                    <a href="clients.html"><i class="la la-users"></i> <span>Clients</span></a>
                </li>
                <li class="menu-title">
                    <span>Master</span>
                </li>
                <li class="submenu">
                    <a href="#"><i class="la la-dashboard"></i> <span> Master</span> <span
                            class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a class="{{ Request::segment(3) == 'brand-engine' ? 'active' : '' }}"
                                href="{{ url('/super-admin/master/brand-engine') }}">Brand Engine</a></li>
                        <li><a class="{{ Request::segment(3) == 'technician' ? 'active' : '' }}"
                                href="{{ url('/super-admin/master/technician') }}">Technician</a></li>
                        <li><a class="{{ Request::segment(3) == 'product-category' ? 'active' : '' }}"
                                href="{{ url('/super-admin/master/product-category') }}">Product Category</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
