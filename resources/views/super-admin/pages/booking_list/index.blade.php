@extends('index')
@section('content')
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">Booking Tracking</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                    <li class="breadcrumb-item">Tracking</li>
                    <li class="breadcrumb-item active">Booking Tracking</li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-borderless table-hover align-middle" id="booking-tracking-table">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="15%">Pengguna</th>
                                    <th width="15%">Booking Code</th>
                                    <th width="15%">Jadwal</th>
                                    <th width="15%">Kendaraan</th>
                                    <th width="15%">Layanan</th>
                                    <th width="10%">Detail</th>
                                    <th width="10%">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data will be filled by DataTables -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="generalModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" id="modal-content"></div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(function() {
            $('#booking-tracking-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ url('super-admin/booking-list/datatable') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'user_name',
                        name: 'user.name'
                    },
                    {
                        data: 'booking_code',
                        name: 'booking_code'
                    },
                    {
                        data: 'schedule',
                        name: 'slot.date'
                    },
                    {
                        data: 'vehicle',
                        name: 'motorCycleDetail.motorcycle.plate',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'services',
                        name: 'bookingServices.service.name',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'detail_service',
                        name: 'motorCycleDetail.id',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'status',
                        name: 'status'
                    }
                ]
            });

            $(document).on('click', '.show-qr', function(e) {
                e.preventDefault();
                const id = $(this).data('id');
                $.get(`/super-admin/booking-list/${id}/qrcode`, function(res) {
                    $('#modal-content').html(res.html);
                    $('#generalModal').modal('show');
                });
            });

            $(document).on('click', '.show-vehicle', function(e) {
                e.preventDefault();
                const id = $(this).data('id');
                $.get(`/super-admin/booking-list/${id}/detail`, function(res) {
                    $('#modal-content').html(res.html);
                    $('#generalModal').modal('show');
                });
            });

            $(document).on('click', '.show-services', function(e) {
                e.preventDefault();
                const id = $(this).data('id');
                $.get(`/super-admin/booking-list/${id}/services`, function(res) {
                    $('#modal-content').html(res.html);
                    $('#generalModal').modal('show');
                });
            });

            $(document).on('click', '.show-detail-service', function(e) {
                e.preventDefault();
                const id = $(this).data('id');
                $.get(`/super-admin/booking-list/${id}/motorcycle-detail`, function(res) {
                    $('#modal-content').html(res.html);
                    $('#generalModal').modal('show');
                });
            });
        });
    </script>
@endsection
