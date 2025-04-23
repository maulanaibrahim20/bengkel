<!-- JavaScript Libraries -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{url('/landing')}}/lib/wow/wow.min.js"></script>
<script src="{{url('/landing')}}/lib/easing/easing.min.js"></script>
<script src="{{url('/landing')}}/lib/waypoints/waypoints.min.js"></script>
<script src="{{url('/landing')}}/lib/counterup/counterup.min.js"></script>
<script src="{{url('/landing')}}/lib/owlcarousel/owl.carousel.min.js"></script>
<script src="{{url('/landing')}}/lib/tempusdominus/js/moment.min.js"></script>
<script src="{{url('/landing')}}/lib/tempusdominus/js/moment-timezone.min.js"></script>
<script src="{{url('/landing')}}/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

<!-- Template Javascript -->
<script src="{{url('/landing')}}/js/main.js"></script>

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