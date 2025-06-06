<div class="header">

    <!-- Logo -->
    <div class="header-left">
        @if (Auth::user()->role_id == 1)
            <a href="{{ url('/super-admin/dashboard') }}" class="logo">
                <img src="{{ url('/img') }}/logo.png" width="70" height="70" alt="">
            </a>
        @elseif (Auth::user()->role_id == 2)
            <a href="{{ url('/admin/dashboard') }}" class="logo">
                <img src="{{ url('/img') }}/logo.png" width="70" height="70" alt="">
            </a>
        @elseif (Auth::user()->role_id == 3)
            <a href="{{ url('/user/dashboard') }}" class="logo">
                <img src="{{ url('/img') }}/logo.png" width="70" height="70" alt="">
            </a>
        @endif
    </div>
    <!-- /Logo -->

    <a id="toggle_btn" href="javascript:void(0);">
        <span class="bar-icon">
            <span></span>
            <span></span>
            <span></span>
        </span>
    </a>

    <!-- Header Title -->
    <div class="page-title-box">
        <h3>DL Service</h3>
    </div>
    <!-- /Header Title -->

    <a id="mobile_btn" class="mobile_btn" href="#sidebar"><i class="fa fa-bars"></i></a>

    <!-- Header Menu -->
    <ul class="nav user-menu">
        <!-- Notifications -->
        <li class="nav-item dropdown">
            <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                <i class="fa fa-bell-o"></i> <span class="badge rounded-pill">3</span>
            </a>
            <div class="dropdown-menu notifications">
                <div class="topnav-dropdown-header">
                    <span class="notification-title">Notifications</span>
                    <a href="javascript:void(0)" class="clear-noti"> Clear All </a>
                </div>
                <div class="noti-content">
                    <ul class="notification-list">
                        <li class="notification-message">
                            <a href="activities.html">
                                <div class="media d-flex">
                                    <span class="avatar flex-shrink-0">
                                        <img alt="" src="{{ url('/assets') }}/img/profiles/avatar-02.jpg">
                                    </span>
                                    <div class="media-body flex-grow-1">
                                        <p class="noti-details"><span class="noti-title">John Doe</span> added
                                            new task <span class="noti-title">Patient appointment booking</span>
                                        </p>
                                        <p class="noti-time"><span class="notification-time">4 mins ago</span>
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="notification-message">
                            <a href="activities.html">
                                <div class="media d-flex">
                                    <span class="avatar flex-shrink-0">
                                        <img alt="" src="{{ url('/assets') }}/img/profiles/avatar-03.jpg">
                                    </span>
                                    <div class="media-body flex-grow-1">
                                        <p class="noti-details"><span class="noti-title">Tarah Shropshire</span>
                                            changed the task name <span class="noti-title">Appointment booking
                                                with payment gateway</span></p>
                                        <p class="noti-time"><span class="notification-time">6 mins ago</span>
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="notification-message">
                            <a href="activities.html">
                                <div class="media d-flex">
                                    <span class="avatar flex-shrink-0">
                                        <img alt="" src="{{ url('/assets') }}/img/profiles/avatar-06.jpg">
                                    </span>
                                    <div class="media-body flex-grow-1">
                                        <p class="noti-details"><span class="noti-title">Misty Tison</span>
                                            added <span class="noti-title">Domenic Houston</span> and <span
                                                class="noti-title">Claire Mapes</span> to project <span
                                                class="noti-title">Doctor available module</span></p>
                                        <p class="noti-time"><span class="notification-time">8 mins ago</span>
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="notification-message">
                            <a href="activities.html">
                                <div class="media d-flex">
                                    <span class="avatar flex-shrink-0">
                                        <img alt="" src="{{ url('/assets') }}/img/profiles/avatar-17.jpg">
                                    </span>
                                    <div class="media-body flex-grow-1">
                                        <p class="noti-details"><span class="noti-title">Rolland Webber</span>
                                            completed task <span class="noti-title">Patient and Doctor video
                                                conferencing</span></p>
                                        <p class="noti-time"><span class="notification-time">12 mins ago</span>
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="notification-message">
                            <a href="activities.html">
                                <div class="media d-flex">
                                    <span class="avatar flex-shrink-0">
                                        <img alt="" src="{{ url('/assets') }}/img/profiles/avatar-13.jpg">
                                    </span>
                                    <div class="media-body flex-grow-1">
                                        <p class="noti-details"><span class="noti-title">Bernardo Galaviz</span>
                                            added new task <span class="noti-title">Private chat module</span>
                                        </p>
                                        <p class="noti-time"><span class="notification-time">2 days ago</span>
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="topnav-dropdown-footer">
                    <a href="activities.html">View all Notifications</a>
                </div>
            </div>
        </li>
        <!-- /Notifications -->

        {{-- profile --}}
        <li class="nav-item dropdown has-arrow main-drop">
            <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                <span class="user-img">
                    @php
                        use Illuminate\Support\Str;

                        $user = Auth::user();
                        $image = $user->profile_image;

                        $defaultImages = [
                            1 => 'img/logo.png',
                            2 => 'img/logo.png',
                            3 => 'assets/img/profiles/avatar-01.jpg',
                        ];

                        $defaultImage = $defaultImages[$user->role_id] ?? 'assets/img/profiles/avatar-01.jpg';

                        $imageUrl = Str::startsWith($image, ['http://', 'https://'])
                            ? $image
                            : asset($image ?: $defaultImage);
                    @endphp

                    <img src="{{ $imageUrl }}" alt="">

                    <span class="status {{ Auth::user()->status == 0 ? 'offline' : 'online' }}"></span>
                </span>
                <span>{{ Auth::user()->name }}</span>
            </a>
            <div class="dropdown-menu">
                @if (Auth::user()->role_id == 1)
                    <a class="dropdown-item" href="{{ url('/super-admin/profile') }}">My Profile</a>
                @elseif (Auth::user()->role_id == 2)
                    <a class="dropdown-item" href="{{ url('/admin/profile') }}">My Profile</a>
                @elseif (Auth::user()->role_id == 3)
                    <a class="dropdown-item" href="{{ url('/user/profile') }}">My Profile</a>
                @endif
                <a class="dropdown-item" href="settings.html">Settings</a>
                <a href="{{ route('logout') }}" class="dropdown-item logoutBtn">Logout</a>
            </div>
        </li>
        {{-- profile --}}
    </ul>
    <!-- /Header Menu -->

    <!-- Mobile Menu -->
    <div class="dropdown mobile-user-menu">
        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i
                class="fa fa-ellipsis-v"></i></a>
        <div class="dropdown-menu dropdown-menu-right">
            @if (Auth::user()->role_id == 1)
                <a class="dropdown-item" href="{{ url('/super-admin/profile') }}">My Profile</a>
            @elseif (Auth::user()->role_id == 2)
                <a class="dropdown-item" href="{{ url('/admin/profile') }}">My Profile</a>
            @elseif (Auth::user()->role_id == 3)
                <a class="dropdown-item" href="{{ url('/user/profile') }}">My Profile</a>
            @endif
            <a class="dropdown-item" href="settings.html">Settings</a>
            <a class="dropdown-item logoutBtn" href="{{ url('/logout') }}">Logout</a>
        </div>
    </div>
    <!-- /Mobile Menu -->

</div>
