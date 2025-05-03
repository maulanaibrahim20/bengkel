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
            <div class="d-flex mb-3 overflow-auto">
                @php
                    $startDate = \Carbon\Carbon::now();
                @endphp
                @for ($i = 0; $i < 7; $i++)
                    @php
                        $date = $startDate->copy()->addDays($i);
                        $isToday = $date->isToday();
                    @endphp
                    <div class="me-2">
                        <button
                            class="btn {{ $isToday ? 'btn-dark text-white' : 'btn-outline-secondary' }} rounded-4 px-4 py-2 w-100">
                            <div class="fw-bold">{{ $date->format('d M') }}</div>
                            @if ($isToday)
                                <div class="badge bg-warning text-dark mt-1">Hari Ini</div>
                            @endif
                        </button>
                    </div>
                @endfor
            </div>

            <!-- Jadwal -->
            <div class="px-2">
                <h5 class="fw-bold mb-2">Pagi</h5>
                <div class="d-flex flex-wrap mb-3">
                    @foreach (['09:00', '09:30', '10:00', '10:30', '11:00', '11:30'] as $time)
                        <div class="m-1">
                            <button class="btn btn-secondary rounded-pill px-3" disabled>{{ $time }}</button>
                        </div>
                    @endforeach
                </div>

                <h5 class="fw-bold mb-2">Sore</h5>
                <div class="d-flex flex-wrap">
                    @php
                        $afternoonTimes = [
                            '12:00',
                            '12:30',
                            '13:00',
                            '13:30',
                            '14:00',
                            '14:30',
                            '15:00',
                            '15:30',
                            '16:00',
                            '16:30',
                            '17:00',
                            '17:30',
                            '18:00',
                            '18:30',
                            '19:00',
                            '19:30',
                        ];
                        $disabledTimes = ['13:00', '17:00']; // contoh yang tidak bisa diklik
                    @endphp
                    @foreach ($afternoonTimes as $time)
                        <div class="m-1">
                            <button
                                class="btn rounded-pill px-3 {{ in_array($time, $disabledTimes) ? 'btn-secondary' : 'btn-outline-primary' }}"
                                {{ in_array($time, $disabledTimes) ? 'disabled' : '' }}>
                                {{ $time }}
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Note -->
            <div class="mt-4 text-muted small">
                * Jika jam tidak bisa di klik, artinya slot pada jam tersebut sudah penuh.
            </div>
        </div>
    </div>
@endsection
