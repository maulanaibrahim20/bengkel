@extends('index')
@push('css')
    <style>
        .service-card {
            transition: all 0.3s ease;
            border: 1px solid #dee2e6;
        }

        .service-card:hover {
            border-color: #0d6efd;
            box-shadow: 0 0.125rem 0.25rem rgba(13, 110, 253, 0.2);
        }

        .form-check-input:checked+.form-check-label .service-card {
            border-color: #0d6efd;
            background-color: rgba(13, 110, 253, 0.05);
        }

        .toggle-icon {
            transition: transform 0.3s ease;
        }

        [aria-expanded="true"] .toggle-icon {
            transform: rotate(180deg);
        }

        .btn-link:hover {
            color: #0d6efd !important;
        }

        @media (max-width: 767.98px) {
            .card-header h3 {
                font-size: 1.25rem;
            }

            .form-check-label h5 {
                font-size: 1rem;
            }
        }
    </style>
@endpush
@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0 fs-4">Pilih Paket Servis</h3>
        </div>
        <div class="card-body">
            <div class="mb-4">
                <div class="row">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-calendar-event me-2"></i>
                            <span><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($slot->date)->translatedFormat('l, d F Y') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-clock me-2"></i>
                            <span><strong>Jam:</strong> {{ \Carbon\Carbon::parse($slot->time)->format('H:i') }} WIB</span>
                        </div>
                    </div>
                </div>
            </div>

            <form action="{{ url('/user/booking/create') }}" method="POST">
                @csrf
                <input type="hidden" name="slot_id" value="{{ $slot->id }}">

                <div class="mb-4">
                    <h5 class="mb-3 border-bottom pb-2">Paket Tersedia</h5>

                    @foreach($services as $service)
                        <div class="card mb-3 service-card">
                            <div class="card-body">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="service_ids[]" value="{{ $service->id }}"
                                        id="service{{ $service->id }}">
                                    <label class="form-check-label w-100" for="service{{ $service->id }}">
                                        <div class="d-flex justify-content-between align-items-top">
                                            <h5 class="mb-0">{{ $service->name }}</h5>
                                            <div class="text-end">
                                                <span class="badge bg-primary rounded-pill">{{ $service->duration }}</span>
                                                <div class="fw-bold text-primary mt-1">Rp{{ number_format($service->price) }}</div>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                                <div class="mt-2">
                                    <button class="btn btn-link btn-sm text-decoration-none p-0 text-muted service-details-toggle"
                                            type="button" data-bs-toggle="collapse"
                                            data-bs-target="#serviceDetails{{ $service->id }}"
                                            aria-expanded="false" aria-controls="serviceDetails{{ $service->id }}">
                                        <i class="bi bi-info-circle me-1"></i>Lihat detail layanan
                                        <i class="bi bi-chevron-down ms-1 toggle-icon"></i>
                                    </button>

                                    <div class="collapse mt-2" id="serviceDetails{{ $service->id }}">
                                        @if(count($service->detail) > 0)
                                            <ul class="list-group list-group-flush">
                                                @foreach($service->detail as $detail)
                                                    <li class="list-group-item px-0 py-1 border-0">
                                                        <i class="bi bi-check-circle-fill text-success me-2"></i>{{ $detail->description }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <div class="text-muted small px-2 py-1">
                                                <i class="bi bi-info-circle me-1"></i>Paket layanan dasar tanpa detail tambahan.
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Konfirmasi Pilihan Layanan -->
                <div class="mb-4" id="confirmationSection" style="display: none;">
                    <h5 class="mb-3 border-bottom pb-2">Konfirmasi Pilihan Layanan</h5>
                    <ul id="selectedServicesList" class="list-group">
                        <!-- Layanan yang dipilih akan ditambahkan di sini -->
                    </ul>
                    <div class="fw-bold mt-3">Total: Rp <span id="totalPrice">0</span></div>
                </div>

                <!-- Keluhan atau Catatan Tambahan -->
                <div class="mb-4" id="complaintSection" style="display: none;">
                    <h5 class="mb-2 border-bottom pb-2">Tambahan Informasi</h5>
                    <div class="form-floating">
                        <textarea class="form-control" name="complaint" id="complaint" rows="4" style="min-height: 120px;" placeholder="Tulis keluhan jika ada..."></textarea>
                        <label for="complaint">Keluhan atau catatan tambahan</label>
                    </div>
                    <div class="form-text">Tuliskan keluhan atau informasi tambahan yang perlu kami ketahui tentang kendaraan Anda</div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary me-md-2">Kembali</a>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="la la-calendar-check me-2"></i>Lanjutkan Booking
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            function updateConfirmation() {
                const confirmationSection = $('#confirmationSection');
                const selectedServicesList = $('#selectedServicesList');
                const totalPriceElement = $('#totalPrice');
                let totalPrice = 0;
                selectedServicesList.empty();

                const selectedServices = $('.form-check-input:checked');
                if (selectedServices.length > 0) {
                    confirmationSection.show();
                    selectedServices.each(function() {
                        const serviceId = $(this).val();
                        const serviceName = $(this).closest('.form-check').find('label h5').text();
                        const servicePrice = parseInt($(this).closest('.form-check').find('.fw-bold').text().replace(/[^0-9]/g, ''));

                        selectedServicesList.append(
                            `<li class="list-group-item">${serviceName} - Rp${servicePrice.toLocaleString()}</li>`
                        );

                        totalPrice += servicePrice;
                    });

                    totalPriceElement.text(totalPrice.toLocaleString());
                    $('#complaintSection').show();
                } else {
                    confirmationSection.hide();
                    $('#complaintSection').hide();
                }
            }

            $('.form-check-input').on('change', function() {
                updateConfirmation();
            });

        });
    </script>
@endsection

