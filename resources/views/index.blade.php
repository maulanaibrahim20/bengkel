<!DOCTYPE html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg"
    data-sidebar-image="none">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="Smarthr - Bootstrap Admin Template">
    <meta name="keywords"
        content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
    <meta name="author" content="Dreamguys - Bootstrap Admin Template">
    <meta name="robots" content="noindex, nofollow">
    <title>{{ config('app.name') }} | {{ $pageTitle ?? 'Defaul Title' }}</title>

    @include('admin.component.style_css')
    @stack('css')

</head>

<body>
    <!-- Main Wrapper -->
    <div class="main-wrapper">

        <!-- Header -->
        @include('admin.layout.header')
        <!-- /Header -->

        <!-- Sidebar -->
        @include('admin.layout.sidebar')

        <!-- /Sidebar -->

        <!-- Page Wrapper -->
        <div class="page-wrapper">

            <!-- Page Content -->
            <div class="content container-fluid">

                <!-- Page Header -->
                {{-- <div class="page-header">
                    <div class="row">
                        <div class="col-sm-12">
                            <h3 class="page-title">Welcome Admin!</h3>
                            <ul class="breadcrumb">
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ul>
                        </div>
                    </div>
                </div> --}}
                <!-- /Page Header -->
                @yield('content')
            </div>
            <!-- /Page Content -->

        </div>
        <!-- /Page Wrapper -->


    </div>
    <!-- /Main Wrapper -->

    @include('admin.component.style_js')
    @if (session('session_expired'))
        <script type="text/javascript">
            alert("Sesi Anda telah habis, silakan login kembali.");
        </script>
    @endif


    @yield('script')

</body>

</html>
