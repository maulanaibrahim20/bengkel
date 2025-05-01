<!-- jQuery -->
<script src="{{ url('/assets') }}/js/jquery-3.6.0.min.js"></script>

<!-- Bootstrap Core JS -->
<script src="{{ url('/assets') }}/js/bootstrap.bundle.min.js"></script>

<!-- Slimscroll JS -->
<script src="{{ url('/assets') }}/js/jquery.slimscroll.min.js"></script>

<!-- Chart JS -->
<script src="{{ url('/assets') }}/plugins/morris/morris.min.js"></script>
<script src="{{ url('/assets') }}/plugins/raphael/raphael.min.js"></script>
<script src="{{ url('/assets') }}/js/chart.js"></script>
<script src="{{ url('/assets') }}/js/greedynav.js"></script>

<!-- Theme Settings JS -->
<script src="{{ url('/assets') }}/js/layout.js"></script>
<script src="{{ url('/assets') }}/js/theme-settings.js"></script>

<!-- Custom JS -->
<script src="{{ url('/assets') }}/js/app.js"></script>

<!-- Select2 JS -->
<script src="{{ url('/assets') }}/js/select2.min.js"></script>

<!-- Datetimepicker JS -->
<script src="{{ url('/assets') }}/js/moment.min.js"></script>
<script src="{{ url('/assets') }}/js/bootstrap-datetimepicker.min.js"></script>

<!-- Datatable JS -->
<script src="{{ url('/assets') }}/js/jquery.dataTables.min.js"></script>
<script src="{{ url('/assets') }}/js/dataTables.bootstrap4.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

<div id="loadingOverlay" style="display: none;">
    <div class="spinner-border text-primary" role="status"></div>
    <p class="mt-3">Loading...</p>
</div>

<style>
    #loadingOverlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(255, 255, 255, 0.8);
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        backdrop-filter: blur(4px);
    }
</style>

<script>
    window.showLoading = function() {
        $('#loadingOverlay').fadeIn(150);
    }

    window.hideLoading = function() {
        $('#loadingOverlay').fadeOut(150);
    }
</script>

@if (session('success'))
    <script>
        toastr.options.timeOut = 5000;
        toastr.options.progressBar = true;
        toastr.success("{{ session('success') }}");
    </script>
@endif

@if (session('warning'))
    <script>
        toastr.options.timeOut = 5000;
        toastr.options.progressBar = true;
        toastr.warning("{{ session('warning') }}");
    </script>
@endif

@if (session('info'))
    <script>
        toastr.options.timeOut = 5000;
        toastr.options.progressBar = true;
        toastr.info("{{ session('info') }}");
    </script>
@endif

@if (session('error'))
    <script>
        toastr.options.timeOut = 5000;
        toastr.options.progressBar = true;
        toastr.error("{{ session('error') }}");
    </script>
@endif

<script>
    $('#logoutBtn').on('click', function(e) {
        e.preventDefault();

        let logoutUrl = $(this).attr('href');

        Swal.fire({
            title: 'Anda yakin ingin logout?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Logout!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = logoutUrl;
            }
        });
    });
</script>



<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
