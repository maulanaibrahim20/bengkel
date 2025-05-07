@extends('index')
@section('content')
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">List Motor</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/super-admin/dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">List Motor</li>
                </ul>
            </div>
            <div class="col-auto float-end ms-auto">
                <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_salary"><i
                        class="fa fa-plus"></i> Add Motorcycle</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card mb-0">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0" id="motorcycle-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal dan Jam Booking</th>
                                    <th>Kode Booking</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('user.pages.booking_history.modal-details-booking')
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            let currentBookingId = null;

            // Initialize DataTable
            let table = $('#motorcycle-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ url('/user/booking-history/datatable') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'booking_code',
                        name: 'booking_code'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            // Klik tombol detail (modal)
            $('#motorcycle-table').on('click', '.editBtn', function() {
                const bookingId = $(this).data('id');
                currentBookingId = bookingId;

                // Reset form dan tampilan modal
                $('#cancel-reason-container').addClass('d-none');
                $('#cancel-reason').val('');

                $.ajax({
                    url: `/user/booking-history/${bookingId}/details`,
                    method: 'GET',
                    success: function(response) {
                        // Isi data ke modal
                        $('#modal-booking-code').text(response.booking.booking_code);
                        $('#modal-slot-date').text(response.slot.date);
                        $('#modal-slot-time').text(response.slot.time);
                        $('#modal-complaint').text(response.booking.complaint || '-');

                        // Isi layanan
                        let servicesHtml = '';
                        if (response.services.length > 0) {
                            response.services.forEach(service => {
                                servicesHtml += `<li class="list-group-item d-flex justify-content-between align-items-center">
                            ${service.name}
                            <span class="badge bg-primary">Rp${Number(service.price).toLocaleString()}</span>
                        </li>`;
                            });
                        } else {
                            servicesHtml = `<li class="list-group-item">-</li>`;
                        }
                        $('#modal-services-list').html(servicesHtml);

                        // Atur warna badge status
                        let statusBadge = $('#modal-status');
                        statusBadge.removeClass().addClass('badge');
                        if (response.booking.status === 'pending') {
                            statusBadge.addClass('bg-warning text-dark').text('Pending');
                        } else if (response.booking.status === 'confirmed') {
                            statusBadge.addClass('bg-success').text('Confirmed');
                        } else {
                            statusBadge.addClass('bg-secondary').text('Cancelled');
                        }

                        // Tampilkan tombol hanya jika status pending
                        if (response.booking.status === 'pending') {
                            $('#confirm-booking-btn').show();
                            $('#cancel-booking-btn').show();
                        } else {
                            $('#confirm-booking-btn').hide();
                            $('#cancel-booking-btn').hide();
                        }

                        // Tampilkan modal
                        $('#bookingDetailModal').modal('show');
                    },
                    error: function() {
                        alert('Gagal memuat detail booking.');
                    }
                });
            });

            // Tombol konfirmasi kedatangan
            $('#confirm-booking-btn').on('click', function() {
                updateBookingStatus('confirmed');
            });

            // Tombol batalkan booking
            $('#cancel-booking-btn').on('click', function() {
                const reasonContainer = $('#cancel-reason-container');
                if (reasonContainer.hasClass('d-none')) {
                    reasonContainer.removeClass('d-none');
                    $('#cancel-reason').focus();
                    return;
                }

                const reason = $('#cancel-reason').val().trim();
                if (!reason) {
                    alert('Alasan pembatalan harus diisi.');
                    return;
                }

                updateBookingStatus('cancelled', reason);
            });

            // Fungsi untuk mengirim request ubah status
            function updateBookingStatus(status, reason = null) {
                $.ajax({
                    url: `/user/booking-history/${currentBookingId}/status`,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        status: status,
                        reason: reason
                    },
                    beforeSend: function() {
                        $('#confirm-booking-btn, #cancel-booking-btn').prop('disabled', true).text(
                            'Memproses...');
                    },
                    success: function(response) {
                        alert('Status booking berhasil diperbarui!');
                        $('#bookingDetailModal').modal('hide');
                        table.ajax.reload(); // Reload DataTable untuk menampilkan data terbaru
                    },
                    error: function(xhr) {
                        alert('Gagal memperbarui status. Silakan coba lagi.');
                    },
                    complete: function() {
                        $('#confirm-booking-btn').prop('disabled', false).html(
                            '<i class="fa fa-check-circle me-1"></i> Konfirmasi Kedatangan');
                        $('#cancel-booking-btn').prop('disabled', false).html(
                            '<i class="fa fa-times-circle me-1"></i> Batalkan Booking');
                    }
                });
            }
        });
    </script>
@endsection
