@extends('index')
@section('content')
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">List Users</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/super-admin/dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">List Users</li>
                </ul>
            </div>
            <div class="col-auto float-end ms-auto">
                <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_user"><i
                        class="fa fa-plus"></i>
                    Add User</a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <div class="card mb-0">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0" id="bookingDateTable">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Jumlah Slot</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div id="slotDetailContainer" class="mt-4 d-none">
                        <h5>Detail Slot untuk <span id="detailDate"></span></h5>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Jam</th>
                                    <th>Maks Booking</th>
                                    <th>Booking Saat Ini</th>
                                </tr>
                            </thead>
                            <tbody id="slotDetailBody"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(function() {
            let table = $('#bookingDateTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ url('/super-admin/booking-slot/datatable') }}",
                order: [
                    [3, 'desc']
                ], // kolom ke-3 adalah raw_date
                columns: [{
                        data: 'date',
                        name: 'date'
                    }, // tampilkan formatted
                    {
                        data: 'total_slots',
                        name: 'total_slots'
                    },
                    {
                        data: 'action',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'raw_date',
                        visible: false
                    }, // tidak ditampilkan tapi digunakan untuk sorting
                ]
            });

            $('#bookingDateTable').on('click', '.detailBtn', function() {
                let date = $(this).data('date');
                console.log('Date:', date); // Pastikan nilai date ada

                $('#detailDate').text(date);
                $('#slotDetailContainer').removeClass('d-none');

                // Gunakan route() helper untuk membuat URL yang benar
                let url = "{{ route('booking-slot.details', ['date' => ':date']) }}";
                url = url.replace(':date', date); // Gantikan placeholder :date dengan nilai yang sesuai

                $.get(url, function(data) {
                    console.log('Data: ', data); // Log data response

                    let rows = '';
                    data.forEach(function(slot) {
                        rows += `
                <tr>
                    <td>${slot.time}</td>
                    <td>${slot.max_bookings}</td>
                    <td>${slot.current_bookings}</td>
                </tr>
            `;
                    });
                    $('#slotDetailBody').html(rows);
                });
            });

        });
    </script>
@endsection
