<!DOCTYPE html>

<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default"
    data-assets-path="../../assets/" data-template="horizontal-menu-template">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Login Basic - Pages | Vuexy - Bootstrap Admin Template</title>

    <meta name="description" content="" />

    @include('auth.component.style_css')

</head>

<body>
    <!-- Content -->

    <div class="container-xxl">
        <div style="position: absolute; top: 20px; left: 20px; z-index: 9999;">
            <a href="{{ url()->previous() }}" class="text-primary fa fa-arrow-left"
                style="font-size: 2.5rem; text-decoration: none;">
            </a>
        </div>
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner py-4">
                <!-- Login -->
                @yield('content')
            </div>
        </div>
    </div>
    @include('auth.component.style_js')
</body>

</html>