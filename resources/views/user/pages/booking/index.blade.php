@extends('index')
@push('css')
    <style>
        .btn-outline-primary:hover:not(:disabled) {
            background-color: #e9f4ff;
        }

        .btn[disabled] {
            opacity: 0.6;
        }
    </style>
@endpush
@section('content')
    <div class="page-header">
        <div class="row">
            <div class="col-sm-12">
                <h3 class="page-title">Pilih Tanggal Dan Jam Booking</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item active">Dashboard</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container my-5">
        <div class="card p-4 shadow-sm rounded-4">
            <!-- Header tanggal -->
            <div class="d-flex mb-4 overflow-auto">
                @foreach ($dates as $i => $day)
                    @php
                        $isToday = $day['date']->isToday();
                    @endphp
                    <div class="me-2">
                        <button
                            class="btn date-tab-btn {{ $isToday ? 'btn-dark text-white' : 'btn-outline-secondary' }} rounded-4 px-4 py-2 w-100"
                            data-tab="tab-{{ $i }}">
                            <div class="fw-bold">{{ $day['date']->format('d M') }}</div>
                            @if ($isToday)
                                <div class="badge bg-warning text-dark mt-1">Hari Ini</div>
                            @endif
                        </button>
                    </div>
                @endforeach
            </div>

            <!-- Slot jadwal per tanggal -->
            @foreach ($dates as $i => $day)
                <div id="tab-{{ $i }}" class="schedule-tab mb-4" style="display: none;">
                    <h5 class="fw-bold mb-3">{{ $day['date']->translatedFormat('l, d F Y') }}</h5>

                    <h6 class="fw-bold">Pagi</h6>
                    <div class="d-flex flex-wrap mb-3 morning-slots">
                        <!-- Slot pagi akan dimuat di sini melalui AJAX -->
                    </div>

                    <h6 class="fw-bold">Sore</h6>
                    <div class="d-flex flex-wrap afternoon-slots">
                        <!-- Slot sore akan dimuat di sini melalui AJAX -->
                    </div>
                </div>
            @endforeach


            <!-- Note -->
            <div class="mt-4 text-muted small">
                * Jika jam tidak bisa di klik, artinya slot pada jam tersebut sudah penuh.
            </div>
        </div>
    </div>

    @if (!$hasMotor)
        <div class="modal fade" id="motorWarningModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static"
            data-bs-keyboard="false">
            <div class="modal-dialog">
                <div class="modal-content rounded-4">
                    <div class="modal-header bg-warning">
                        <h5 class="modal-title">Peringatan</h5>
                    </div>
                    <div class="modal-body">
                        Anda belum memiliki motor terdaftar. Silakan tambahkan motor terlebih dahulu sebelum melakukan
                        booking.
                    </div>
                    <div class="modal-footer">
                        <a href="{{ url('/user/motorcycle') }}" class="btn btn-primary">Tambah Motor</a>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@section('script')
    @if (!$hasMotor)
        <script>
            $(document).ready(function() {
                $('#motorWarningModal').modal('show');

                // Matikan semua tombol agar tidak bisa booking
                $('button').not('.btn-primary').prop('disabled', true);
            });
        </script>
    @endif
    <script>
        $(document).ready(function() {
            // Ketika tombol tanggal diklik
            $('.date-tab-btn').on('click', function() {
                $('.schedule-tab').hide(); // Sembunyikan semua tab jadwal

                $('.date-tab-btn').removeClass('btn-dark text-white').addClass(
                    'btn-outline-secondary'); // Reset tombol

                $(this).removeClass('btn-outline-secondary').addClass(
                    'btn-dark text-white'); // Aktifkan tombol yg dipilih

                const tabId = $(this).data('tab'); // ID tab yg dipilih
                $('#' + tabId).show(); // Tampilkan tab yang sesuai

                const selectedDate = $(this).find('.fw-bold').text(); // Ambil tanggal

                // AJAX untuk ambil data slot berdasarkan tanggal
                $.ajax({
                    url: '/user/booking/slot/' + selectedDate,
                    type: 'GET',
                    success: function(response) {

                        // --- SLOT PAGI ---
                        let morningHtml = '';
                        if (response.morningSlots.length > 0) {

                            response.morningSlots.forEach(function(slot) {
                                const isFull = slot.current_bookings >= slot
                                    .max_bookings;
                                morningHtml += `
                                        <div class="m-1">
                                            <button class="btn rounded-pill px-3 ${isFull ? 'btn-secondary' : 'btn-outline-primary'}" ${isFull ? 'disabled' : ''}>
                                                ${slot.time}
                                            </button>
                                        </div>
                                    `;
                            });
                        } else {
                            morningHtml = '<div class="text-muted">Tidak ada slot pagi.</div>';
                        }
                        $('#' + tabId + ' .morning-slots').html(morningHtml);

                        // --- SLOT SORE ---
                        let afternoonHtml = '';

                        const afternoonSlots = Object.values(response.afternoonSlots);

                        if (afternoonSlots.length > 0) {
                            afternoonSlots.forEach(function(slot) {
                                const isFull = slot.current_bookings >= slot
                                    .max_bookings;

                                afternoonHtml += `
                <div class="m-1">
                    <button class="btn rounded-pill px-3 ${isFull ? 'btn-secondary' : 'btn-outline-primary'}" ${isFull ? 'disabled' : ''}>
                        ${slot.time}
                    </button>
                </div>
            `;
                            });
                        } else {
                            afternoonHtml =
                                '<div class="text-muted">Tidak ada slot sore.</div>';
                        }


                        $('#' + tabId + ' .afternoon-slots').html(afternoonHtml);
                    }
                });
            });

            // Klik tanggal pertama saat halaman dibuka
            $('.date-tab-btn').first().click();
        });
    </script>
@endsection
