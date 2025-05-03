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
