@extends('index')
@push('css')
    <style>
        .table th {
            font-weight: 600;
        }

        .card {
            border-radius: 0.5rem;
            border: none;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }

        .card-header {
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        .badge-slot {
            font-size: 0.9rem;
            padding: 0.5rem 0.75rem;
        }

        .thead-light th {
            background-color: #f8f9fa;
            color: #495057;
        }
    </style>
@endpush
@section('content')
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">Manajemen Booking Slot</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/super-admin/dashboard') }}"><i class="fa fa-home"></i>
                            Dashboard</a></li>
                    <li class="breadcrumb-item active">Booking Slot</li>
                </ul>
            </div>
            <div class="col-auto float-end ms-auto">
                <a href="{{ url('/super-admin/booking-slot/create') }}" class="btn btn-primary mb-3">
                    <i class="fa fa-plus-circle"></i> Tambah Slot Booking
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card mb-4">
                <div class="card-header bg-white py-3">
                    <h5 class="card-title mb-0"><i class="fa fa-calendar-alt me-2"></i>Daftar Slot Booking</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped mb-0" id="bookingDateTable">
                            <thead class="thead-light">
                                <tr>
                                    <th><i class="fa fa-calendar me-2"></i>Tanggal</th>
                                    <th><i class="fa fa-users me-2"></i>Jumlah Slot</th>
                                    <th class="text-center"><i class="fa fa-cog me-2"></i>Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>

            <div id="slotDetailContainer" class="card mb-4 d-none">
                <div class="card-header bg-white py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0"><i class="fa fa-clock me-2"></i>Detail Slot untuk <span id="detailDate"
                                class="text-primary"></span></h5>
                        <button type="button" id="closeDetailBtn" class="btn btn-sm btn-light">
                            <i class="fa fa-times"></i> Tutup
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th width="30%"><i class="fa fa-clock me-2"></i>Jam</th>
                                    <th width="35%"><i class="fa fa-users me-2"></i>Maks Booking</th>
                                    <th width="35%"><i class="fa fa-check-circle me-2"></i>Booking Saat Ini</th>
                                </tr>
                            </thead>
                            <tbody id="slotDetailBody">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(function () {
            let table = $('#bookingDateTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ url('/super-admin/booking-slot/datatable') }}",
                order: [
                    [3, 'desc']
                ],
                columns: [
                    {
                        data: 'date',
                        name: 'date',
                        render: function (data, type, row) {
                            return `<span class="fw-medium">${data}</span>`;
                        }
                    },
                    {
                        data: 'total_slots',
                        name: 'total_slots',
                        className: 'text-center',
                        render: function (data, type, row) {
                            return `<span class="badge bg-info badge-slot">${data} slot</span>`;
                        }
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                    {
                        data: 'raw_date',
                        visible: false
                    }
                ],
                language: {
                    search: "<i class='fa fa-search'></i>",
                    searchPlaceholder: "Cari tanggal...",
                    lengthMenu: "Tampilkan _MENU_ entri",
                    info: "Menampilkan _START_ hingga _END_ dari _TOTAL_ entri",
                    infoEmpty: "Tidak ada data yang tersedia",
                    paginate: {
                        next: "<i class='fa fa-angle-right'></i>",
                        previous: "<i class='fa fa-angle-left'></i>"
                    }
                },
                pageLength: 10,
                lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "Semua"]]
            });

            $('#bookingDateTable').on('click', '.detailBtn', function () {
                let date = $(this).data('date');
                $('#detailDate').text(date);
                $('#slotDetailContainer').removeClass('d-none');

                let url = "{{ url('super-admin/booking-slot/details-booking', ['date' => ':date']) }}";
                url = url.replace(':date', date);

                $.get(url, function (data) {
                    let rows = '';
                    if (data.length === 0) {
                        rows = `
                                                                        <tr>
                                                                            <td colspan="3" class="text-center py-3">
                                                                                <i class="fa fa-info-circle text-muted me-1"></i> Tidak ada data slot tersedia
                                                                            </td>
                                                                        </tr>
                                                                    `;
                    } else {
                        data.forEach(function (slot) {
                            // Menentukan status booking
                            let badgeClass = 'bg-success';
                            if (slot.current_bookings >= slot.max_bookings) {
                                badgeClass = 'bg-danger';
                            } else if (slot.current_bookings >= (slot.max_bookings * 0.7)) {
                                badgeClass = 'bg-warning text-dark';
                            }

                            rows += `
                                                                            <tr>
                                                                                <td class="fw-medium">${slot.time}</td>
                                                                                <td>${slot.max_bookings}</td>
                                                                                <td>
                                                                                    <span class="badge ${badgeClass}">${slot.current_bookings}/${slot.max_bookings}</span>
                                                                                </td>
                                                                            </tr>
                                                                        `;
                        });
                    }
                    $('#slotDetailBody').html(rows);
                });
            });

            $('#closeDetailBtn').on('click', function () {
                $('#slotDetailContainer').addClass('d-none');
            });
        });
    </script>
@endsection