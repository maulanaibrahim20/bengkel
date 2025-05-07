@extends('index')

@section('content')
    <div class="page-header">
        <h3 class="page-title">Tambah Slot Booking</h3>
    </div>

    <div class="card">
        <div class="card-body">
            <form id="manualBookingSlotForm">
                @csrf
                <h5>Tambah Manual Slot</h5>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="date">Tanggal</label>
                        <input type="date" class="form-control" name="date" id="manualDateInput" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="time">Jam</label>
                        <input type="time" class="form-control" name="time" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="max_bookings">Maksimal Booking</label>
                        <input type="number" class="form-control" name="max_bookings" min="1" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-success">Tambah Slot Manual</button>
            </form>

            <hr class="my-4">

            <form id="generateSlotForm">
                <h5>Generate Slot Otomatis</h5>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="generate_date">Tanggal</label>
                        <input type="date" class="form-control" name="generate_date" id="generateDateInput" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Generate Slot</button>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        // Tambah manual
        $('#manualBookingSlotForm').on('submit', function (e) {
            e.preventDefault();

            $.ajax({
                url: "{{ url('/super-admin/booking-slot/create') }}",
                method: 'POST',
                data: $(this).serialize(),
                success: function (response) {
                    toastr.success(response.message);
                    window.location.href = "{{ url('/super-admin/booking-slot') }}";
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        let message = Object.values(xhr.responseJSON.errors).join('\n');
                        alert(message);
                    } else {
                        alert('Terjadi kesalahan saat menyimpan.');
                    }
                }
            });
        });

        $('#generateSlotForm').on('submit', function (e) {
            e.preventDefault();

            $.ajax({
                url: "{{ url('super-admin/booking-slot/generate') }}",
                method: 'POST',
                data: {
                    date: $('[name=generate_date]').val(),
                    _token: "{{ csrf_token() }}"
                },
                success: function (response) {
                    toastr.success(response.message);
                    window.location.href = "{{ url('/super-admin/booking-slot') }}";
                },
                error: function (xhr) {
                    alert(xhr.responseJSON.message || 'Gagal generate slot.');
                }
            });
        });
    </script>
    <script>
        const disabledDates = @json($disabledDates);

        function disableDates(selector) {
            $(selector).on('input', function () {
                const selectedDate = $(this).val();
                if (disabledDates.includes(selectedDate)) {
                    swal.fire('Slot Booking Sudah Ada', 'Tanggal ini sudah memiliki slot booking.', 'error');
                    $(this).val('');
                }
            });
        }

        $(document).ready(function () {
            disableDates('#manualDateInput');
            disableDates('#generateDateInput');
        });
    </script>

@endsection