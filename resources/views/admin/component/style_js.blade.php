<!-- jQuery -->
<script src="{{url('/assets')}}/js/jquery-3.6.0.min.js"></script>

<!-- Bootstrap Core JS -->
<script src="{{url('/assets')}}/js/bootstrap.bundle.min.js"></script>

<!-- Slimscroll JS -->
<script src="{{url('/assets')}}/js/jquery.slimscroll.min.js"></script>

<!-- Chart JS -->
<script src="{{url('/assets')}}/plugins/morris/morris.min.js"></script>
<script src="{{url('/assets')}}/plugins/raphael/raphael.min.js"></script>
<script src="{{url('/assets')}}/js/chart.js"></script>
<script src="{{url('/assets')}}/js/greedynav.js"></script>

<!-- Theme Settings JS -->
<script src="{{url('/assets')}}/js/layout.js"></script>
<script src="{{url('/assets')}}/js/theme-settings.js"></script>

<!-- Custom JS -->
<script src="{{url('/assets')}}/js/app.js"></script>

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