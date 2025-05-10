<!-- Daftar Layanan Yang Dipesan - Versi Profesional -->
<div class="card shadow-sm border-0">
    <div class="card-body">
        <h5 class="card-title fw-bold mb-4 border-bottom pb-2">
            <i class="bi bi-list-check me-2"></i>
            Daftar Layanan yang Dipesan
        </h5>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th width="8%">No</th>
                        <th>Nama Layanan</th>
                        <th width="20%" class="text-end">Harga</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @forelse($booking->bookingServices as $index => $item)
                        @php
                            $service = $item->service;
                            $price = $service->price ?? 0;
                            $total += $price;
                            $collapseId = 'collapseServiceDetail' . $index;
                        @endphp
                        <tr class="service-row" data-collapse-target="#{{ $collapseId }}">
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    {{ $service->name ?? '-' }}
                                    @if ($service->detail->count())
                                        <i class="bi bi-chevron-down ms-2 toggle-icon"></i>
                                    @endif
                                </div>
                            </td>
                            <td class="text-end">Rp{{ number_format($price) }}</td>
                        </tr>
                        @if ($service->detail->count())
                            <tr class="collapse-content" id="{{ $collapseId }}">
                                <td colspan="3" class="border-0 p-0">
                                    <div class="p-3 bg-light">
                                        <ul class="mb-0 ps-3 small">
                                            @foreach ($service->detail as $detail)
                                                <li class="mb-1">{{ $detail->description }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-3">
                                <span class="text-muted">Tidak ada layanan yang dipesan</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot class="table-light">
                    <tr>
                        <th colspan="2" class="text-end">Total</th>
                        <th class="text-end">Rp{{ number_format($total) }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
{{--  --}}
<script>
    $(document).ready(function() {
        // Sembunyikan semua konten yang dapat di-collapse saat halaman dimuat
        $('.collapse-content').hide();

        // Tambahkan cursor pointer dan event click untuk baris dengan detail
        $('.service-row').each(function() {
            const target = $(this).data('collapse-target');
            if (target) {
                $(this).css('cursor', 'pointer');

                $(this).on('click', function() {
                    const $target = $(target);
                    const $icon = $(this).find('.toggle-icon');

                    // Toggle collapse dengan animasi
                    $target.slideToggle(200);

                    // Toggle ikon rotasi
                    $icon.toggleClass('rotate');

                    // Tambahkan/hapus highlight pada baris yang diklik
                    $(this).toggleClass('table-active');
                });
            }
        });
    });
</script>
