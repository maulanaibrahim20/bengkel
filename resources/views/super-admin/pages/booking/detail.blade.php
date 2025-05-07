@extends('index')
@push('css')
    <style>
        .card {
            border-radius: 0.5rem;
            border: none;
        }

        .card-header {
            border-radius: 0.5rem 0.5rem 0 0 !important;
        }

        .table th {
            font-weight: 600;
        }

        .badge {
            font-weight: 500;
            padding: 0.35em 0.65em;
        }

        .btn {
            border-radius: 0.25rem;
            padding: 0.375rem 1rem;
        }

        .form-control:focus,
        .input-group-text {
            box-shadow: none;
            border-color: #ced4da;
        }

        .breadcrumb-item+.breadcrumb-item::before {
            content: "›";
        }
    </style>
@endpush
@section('content')
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ url('/super-admin/dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ url('/super-admin/booking-slot') }}">Booking
                                    Slot</a></li>
                            <li class="breadcrumb-item active">Detail</li>
                        </ol>
                    </nav>
                    <h3 class="mt-2 text-primary">Detail Slot Booking</h3>
                    <h3 class="text-muted">{{ \Carbon\Carbon::parse($date)->translatedFormat('l, d F Y') }}</h3>
                </div>
                <a href="{{ url('/super-admin/booking-slot') }}" class="btn btn-outline-secondary">
                    <i class="la la-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Form Tambah Slot -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-plus-circle"></i> Tambah Slot Manual
                    </h5>
                </div>
                <div class="card-body">
                    <form id="addSlotForm">
                        @csrf
                        <input type="hidden" name="date" value="{{ $date }}">

                        <div class="mb-3">
                            <label for="time" class="form-label">Jam</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-clock"></i>
                                </span>
                                <input type="time" class="form-control" name="time" id="time" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="max_bookings" class="form-label">Maks Booking</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bi bi-people"></i>
                                </span>
                                <input type="number" class="form-control" name="max_bookings" id="max_bookings" min="1"
                                    value="1" required>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="la la-save"></i> Tambah Slot
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Tabel Slot -->
        <div class="col-md-8 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-calendar-check"></i> Daftar Slot
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped" id="slotsTable">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Jam</th>
                                    <th class="text-center">Maks Booking</th>
                                    <th class="text-center">Current Booking</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Slot -->
    @include('super-admin.pages.booking.edit-slot-modal')

    <!-- Alert Container -->
    <div id="alertContainer"></div>
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            $('#slotsTable').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: "{{ url('/super-admin/booking-slot/details-booking/' . $date) }}",
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'time', name: 'time' },
                    { data: 'max_bookings', name: 'max_bookings' },
                    { data: 'current_bookings', name: 'current_bookings' },
                    { data: 'status', name: 'status', orderable: false, searchable: false },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            });

            $(document).on('click', '.edit-slot-btn', function () {
                const slotId = $(this).data('id');
                const time = $(this).data('time');
                const maxBookings = $(this).data('max-bookings');

                $('#editSlotId').val(slotId);
                $('#editTime').val(time);
                $('#editMaxBookings').val(maxBookings);

                $('#editSlotModal').modal('show');
            });

            $('#editSlotForm').on('submit', function (e) {
                e.preventDefault();

                const submitBtn = $(this).find('button[type="submit"]');
                submitBtn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processing...');
                submitBtn.prop('disabled', true);

                $.ajax({
                    url: `/super-admin/booking-slot/${$('#editSlotId').val()}/update`,
                    type: 'PUT',
                    data: $(this).serialize(),
                    success: function (res) {
                        showAlert('success', '<i class="bi bi-check-circle-fill"></i> Slot berhasil diperbarui');
                        $('#editSlotModal').modal('hide');
                        $('#slotsTable').DataTable().ajax.reload();
                    },
                    error: function (xhr) {
                        let msg = 'Terjadi kesalahan saat memperbarui slot.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            msg = xhr.responseJSON.message;
                        }
                        showAlert('danger', '<i class="bi bi-exclamation-triangle-fill"></i> ' + msg);

                        submitBtn.html('<i class="bi bi-save"></i> Simpan Perubahan');
                        submitBtn.prop('disabled', false);
                    }
                });
            });

            function showAlert(type, message) {
                const alertElement = `
                                                            <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                                                                ${message}
                                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                            </div>
                                                        `;
                $('#alertContainer').html(alertElement);

                // Auto hide alert after 5 seconds
                setTimeout(() => {
                    $('.alert').fadeOut('slow', function () {
                        $(this).remove();
                    });
                }, 5000);
            }
        });
    </script>
@endsection