@extends('index')
@push('css')
    <style>
        :root {
            --primary-color: #d81324;
            --primary-light: #e9f4ff;
            --dark-color: #212529;
            --success-color: #198754;
            --warning-color: #ffc107;
        }

        .booking-card {
            border-radius: 12px;
            border: none;
            box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }

        .date-selector {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: thin;
            scrollbar-color: var(--primary-color) #f1f1f1;
            padding-bottom: 8px;
        }

        .date-selector::-webkit-scrollbar {
            height: 5px;
        }

        .date-selector::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .date-selector::-webkit-scrollbar-thumb {
            background: #d1d1d1;
            border-radius: 10px;
        }

        .date-selector::-webkit-scrollbar-thumb:hover {
            background: var(--primary-color);
        }

        .date-card {
            min-width: 100px;
            border-radius: 15px;
            text-align: center;
            padding: 12px 10px;
            margin-right: 10px;
            cursor: pointer;
            transition: all 0.2s ease;
            border: 1px solid #dee2e6;
        }

        .date-card.active {
            background-color: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
            transform: translateY(-3px);
            box-shadow: 0 4px 8px rgba(13, 110, 253, 0.2);
        }

        .date-card:not(.active):hover {
            background-color: var(--primary-light);
            border-color: var(--primary-color);
            transform: translateY(-2px);
        }

        .date-weekday {
            font-size: 0.85rem;
            opacity: 0.8;
        }

        .date-number {
            font-size: 1.3rem;
            font-weight: 700;
            margin: 4px 0;
        }

        .date-month {
            font-size: 0.85rem;
            text-transform: uppercase;
        }

        .time-badge {
            position: relative;
            display: inline-flex;
            margin: 8px;
        }

        .time-btn {
            border-radius: 50px;
            padding: 8px 18px;
            font-weight: 500;
            transition: all 0.2s ease;
            border: 1px solid var(--primary-color);
            color: var(--primary-color);
            background-color: white;
        }

        .time-btn:not(:disabled):hover {
            background-color: var(--primary-color);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(13, 110, 253, 0.2);
        }

        .time-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            background-color: #f8f9fa;
            border-color: #dee2e6;
            color: #6c757d;
        }

        .time-slots-container {
            border-radius: 10px;
            padding: 15px;
            background-color: #f9fbfd;
            margin-bottom: 20px;
        }

        .time-section-heading {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            color: var(--dark-color);
            font-size: 1rem;
            font-weight: 600;
        }

        .time-section-heading i {
            margin-right: 8px;
            color: var(--primary-color);
        }

        .today-badge {
            background-color: var(--warning-color);
            color: var(--dark-color);
            font-size: 0.7rem;
            padding: 3px 8px;
            border-radius: 50px;
            font-weight: 600;
            margin-top: 5px;
        }

        .info-note {
            background-color: #f8f9fa;
            border-left: 4px solid var(--primary-color);
            padding: 12px 15px;
            border-radius: 0 8px 8px 0;
            font-size: 0.9rem;
        }

        @media (max-width: 767.98px) {
            .booking-card {
                padding: 15px !important;
            }

            .date-card {
                min-width: 85px;
                padding: 10px 5px;
            }

            .date-number {
                font-size: 1.1rem;
            }

            .time-btn {
                padding: 6px 14px;
                font-size: 0.9rem;
            }

            .page-title {
                font-size: 1.5rem;
            }
        }

        /* Animation */
        .fade-in {
            animation: fadeIn 0.4s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        #bookingAdOverlay {
            animation: fadeIn 0.5s ease-in-out;
        }
    </style>
@endpush
@section('content')
    <div class="container py-4">
        <div class="row mb-4">
            <div class="col-12">
                <h3 class="page-title fw-bold">Pilih Tanggal & Jam Booking</h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/user/dashboard" class="text-decoration-none">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Booking Service</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="booking-card card p-4">
            <div class="mb-4">
                <div class="d-flex flex-wrap justify-content-between align-items-center">
                    <h5 class="fw-bold mb-3 mb-md-0">
                        <i class="bi bi-calendar-check me-2 text-primary"></i>Jadwal Tersedia
                    </h5>
                    <div class="d-flex align-items-center small">
                        <span class="d-flex align-items-center me-3">
                            <span class="badge bg-primary me-2">&nbsp;</span>Tersedia
                        </span>
                        <span class="d-flex align-items-center">
                            <span class="badge bg-secondary me-2">&nbsp;</span>Penuh
                        </span>
                    </div>
                </div>
                <p class="text-muted mb-0 small">Silahkan pilih tanggal dan jam yang sesuai untuk booking servis Anda.</p>
            </div>

            <div class="date-selector d-flex mb-4">
                @foreach ($dates as $i => $day)
                    @php
                        $isToday = $day['date']->isToday();
                        $dayName = $day['date']->translatedFormat('D');
                        $dayNumber = $day['date']->format('d');
                        $monthName = $day['date']->format('M');
                    @endphp
                    <div class="date-card {{ $i == 0 ? 'active' : '' }}" data-tab="tab-{{ $i }}">
                        <div class="date-weekday">{{ $dayName }}</div>
                        <div class="date-number">{{ $dayNumber }}</div>
                        <div class="date-month">{{ $monthName }}</div>
                        @if ($isToday)
                            <div class="today-badge">Hari Ini</div>
                        @endif
                    </div>
                @endforeach
            </div>

            @foreach ($dates as $i => $day)
                <div id="tab-{{ $i }}" class="schedule-tab fade-in"
                    style="display: {{ $i == 0 ? 'block' : 'none' }};">
                    <h5 class="fw-bold mb-3">
                        <i class="bi bi-calendar-event me-2 text-primary"></i>
                        {{ $day['date']->translatedFormat('l, d F Y') }}
                    </h5>

                    <div class="time-slots-container">
                        <div class="time-section-heading">
                            <i class="bi bi-sunrise"></i>Sesi Pagi
                        </div>
                        <div class="d-flex flex-wrap morning-slots">
                            <!-- Morning slots will be loaded here via AJAX -->
                            <div class="d-flex justify-content-center align-items-center w-100 py-3">
                                <div class="spinner-border spinner-border-sm text-primary me-2" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <span class="text-muted small">Memuat slot tersedia...</span>
                            </div>
                        </div>
                    </div>

                    <div class="time-slots-container">
                        <div class="time-section-heading">
                            <i class="bi bi-sunset"></i>Sesi Sore
                        </div>
                        <div class="d-flex flex-wrap afternoon-slots">
                            <!-- Afternoon slots will be loaded here via AJAX -->
                            <div class="d-flex justify-content-center align-items-center w-100 py-3">
                                <div class="spinner-border spinner-border-sm text-primary me-2" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                                <span class="text-muted small">Memuat slot tersedia...</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <!-- Instructions note -->
            <div class="info-note mt-3">
                <div class="d-flex align-items-start">
                    <i class="bi bi-info-circle-fill text-primary me-2 mt-1"></i>
                    <div>
                        <span class="fw-medium">Informasi:</span> Jika tombol jam berwarna abu-abu dan tidak dapat diklik,
                        artinya slot pada jam tersebut sudah penuh atau tidak tersedia.
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('user.pages.booking.modal-has-motor')
@endsection
@section('script')
    @if (!$hasMotor)
        <script>
            $(document).ready(function() {
                $('#motorWarningModal').modal('show');
                $('.date-card').addClass('disabled').css('pointer-events', 'none').css('opacity', '0.6');
            });
        </script>
    @endif
    <script>
        $(document).ready(function() {
            function renderSlotButtons(slots, containerSelector) {
                let html = '';

                if (slots.length > 0) {
                    slots.forEach(function(slot) {
                        const isDisabled = slot.isFull || slot.isPast;
                        const statusClass = isDisabled ? 'btn-secondary' : 'time-btn';
                        const statusIcon = slot.isFull ? '<i class="bi bi-x-circle me-1"></i>' :
                            '<i class="bi bi-check-circle me-1"></i>';


                        html += `
                                    <div class="time-badge">
                                       <button onclick="window.location.href='/user/booking/create?slot_id=${slot.id}'"
            class="btn ${statusClass}"
            ${isDisabled ? 'disabled' : ''}>
            ${statusIcon}${slot.time}
        </button>

                                    </div>
                                `;
                    });
                } else {
                    html = `
                                <div class="text-center w-100 py-3">
                                    <i class="bi bi-calendar-x text-muted mb-2" style="font-size: 1.5rem;"></i>
                                    <p class="text-muted mb-0">Tidak ada slot tersedia untuk sesi ini.</p>
                                </div>
                            `;
                }

                $(containerSelector).html(html);
            }

            $('.date-card').on('click', function() {
                if ($(this).hasClass('disabled')) return;

                $('.schedule-tab').hide();
                $('.date-card').removeClass('active');
                $(this).addClass('active');

                const tabId = $(this).data('tab');
                $('#' + tabId).fadeIn(300);

                // Extract the date from the clicked element
                const dayNumber = $(this).find('.date-number').text();
                const monthName = $(this).find('.date-month').text();
                const selectedDate = dayNumber + ' ' + monthName;

                // Show loading indicators
                const loadingHTML = `
                                                                                                                        <div class="d-flex justify-content-center align-items-center w-100 py-3">
                                                                                                                            <div class="spinner-border spinner-border-sm text-primary me-2" role="status">
                                                                                                                                <span class="visually-hidden">Loading...</span>
                                                                                                                            </div>
                                                                                                                            <span class="text-muted small">Memuat slot tersedia...</span>
                                                                                                                        </div>
                                                                                                                    `;

                $('#' + tabId + ' .morning-slots').html(loadingHTML);
                $('#' + tabId + ' .afternoon-slots').html(loadingHTML);

                // Fetch slots from server
                $.ajax({
                    url: '/user/booking/slot/' + selectedDate,
                    type: 'GET',
                    success: function(response) {
                        setTimeout(function() {
                            renderSlotButtons(response.morningSlots, '#' + tabId +
                                ' .morning-slots');
                            renderSlotButtons(response.afternoonSlots, '#' + tabId +
                                ' .afternoon-slots');
                        }, 300); // Small delay for better UX
                    },
                    error: function() {
                        const errorHTML =
                            `
                                                                                                                                <div class="text-center w-100 py-3">
                                                                                                                                    <i class="bi bi-exclamation-triangle text-danger mb-2" style="font-size: 1.5rem;"></i>
                                                                                                                                    <p class="text-danger mb-0">Gagal memuat data. Silakan coba lagi.</p>
                                                                                                                                </div>
                                                                                                                            `;
                        $('#' + tabId + ' .morning-slots').html(errorHTML);
                        $('#' + tabId + ' .afternoon-slots').html(errorHTML);

                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Terjadi kesalahan saat memuat jadwal',
                            confirmButtonColor: '#0d6efd'
                        });
                    }
                });
            });

            // Auto click first date
            $('.date-card').first().trigger('click');
        });
    </script>
@endsection
