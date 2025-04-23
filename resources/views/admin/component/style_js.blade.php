<!-- Core JS -->
<!-- build:js{{url('/assets')}}/vendor/js/core.js -->
<script src="{{url('/assets')}}/vendor/libs/jquery/jquery.js"></script>
<script src="{{url('/assets')}}/vendor/libs/popper/popper.js"></script>
<script src="{{url('/assets')}}/vendor/js/bootstrap.js"></script>
<script src="{{url('/assets')}}/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
<script src="{{url('/assets')}}/vendor/libs/node-waves/node-waves.js"></script>

<script src="{{url('/assets')}}/vendor/libs/hammer/hammer.js"></script>
<script src="{{url('/assets')}}/vendor/libs/i18n/i18n.js"></script>
<script src="{{url('/assets')}}/vendor/libs/typeahead-js/typeahead.js"></script>

<script src="{{url('/assets')}}/vendor/js/menu.js"></script>
<!-- endbuild -->

<!-- Vendors JS -->
<script src="{{url('/assets')}}/vendor/libs/apex-charts/apexcharts.js"></script>
<script src="{{url('/assets')}}/vendor/libs/swiper/swiper.js"></script>
<script src="{{url('/assets')}}/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>

<!-- Main JS -->
<script src="{{url('/assets')}}/js/main.js"></script>

<!-- Page JS -->
<script src="{{url('/assets')}}/js/dashboards-analytics.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

@if (session('success'))
    <script>
        toastr.options.timeOut = 5000;
        toastr.options.progressBar = true;
        toastr.success("{{ session('success') }}");
        var audio = new Audio('audio.mp3');
        audio.play();
    </script>
@endif

@if (session('warning'))
    <script>
        toastr.options.timeOut = 5000;
        toastr.options.progressBar = true;
        toastr.warning("{{ session('warning') }}");
        var audio = new Audio('audio.mp3');
    </script>
@endif

@if (session('info'))
    <script>
        toastr.options.timeOut = 5000;
        toastr.options.progressBar = true;
        toastr.info("{{ session('info') }}");
        var audio = new Audio('audio.mp3');
    </script>
@endif

@if (session('error'))
    <script>
        toastr.options.timeOut = 5000;
        toastr.options.progressBar = true;
        toastr.error("{{ session('error') }}");
        var audio = new Audio('audio.mp3');
    </script>
@endif