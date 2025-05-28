@extends('index')

@push('css')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<style>
    .config-card {
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }
    .config-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    .badge-type {
        font-size: 0.7rem;
        padding: 0.25rem 0.5rem;
    }
</style>
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <!-- Page Header -->
        <div class="page-header mb-4">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title mb-0">
                        <i class="fas fa-cogs me-2"></i>Content Management System
                    </h3>
                    <p class="text-muted mb-0">Kelola konten website bengkel Anda</p>
                </div>
            </div>
        </div>

        <!-- Filter Tabs -->
        <div class="card mb-4">
            <div class="card-body">
                <ul class="nav nav-pills" id="configTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="all-tab" data-bs-toggle="pill" data-bs-target="#all" type="button" role="tab">
                            <i class="fas fa-list me-1"></i>Semua ({{ $configs->count() }})
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="hero-tab" data-bs-toggle="pill" data-bs-target="#hero" type="button" role="tab">
                            <i class="fas fa-home me-1"></i>Hero Section ({{ $configs->where('key', 'like', 'hero_%')->count() }})
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="about-tab" data-bs-toggle="pill" data-bs-target="#about" type="button" role="tab">
                            <i class="fas fa-info-circle me-1"></i>Tentang Kami ({{ $configs->where('key', 'like', 'about_%')->count() }})
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="services-tab" data-bs-toggle="pill" data-bs-target="#services" type="button" role="tab">
                            <i class="fas fa-tools me-1"></i>Layanan ({{ $configs->where('key', 'like', 'service_%')->count() }})
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="contact-tab" data-bs-toggle="pill" data-bs-target="#contact" type="button" role="tab">
                            <i class="fas fa-phone me-1"></i>Kontak ({{ $configs->where('key', 'like', 'contact_%')->count() }})
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="testimonial-tab" data-bs-toggle="pill" data-bs-target="#testimonial" type="button" role="tab">
                            <i class="fas fa-star me-1"></i>Testimoni ({{ $configs->where('key', 'like', 'testimonial_%')->count() }})
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="team-tab" data-bs-toggle="pill" data-bs-target="#team" type="button" role="tab">
                            <i class="fas fa-users me-1"></i>Tim ({{ $configs->where('key', 'like', 'team_%')->count() }})
                        </button>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Search Bar -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input type="text" class="form-control" id="searchInput" placeholder="Cari konfigurasi...">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <select class="form-select" id="typeFilter">
                            <option value="">Semua Tipe</option>
                            <option value="text">Text</option>
                            <option value="textarea">Textarea</option>
                            <option value="html">HTML</option>
                            <option value="image">Image</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Area -->
        <div class="tab-content" id="configTabsContent">
            <div class="tab-pane fade show active" id="all" role="tabpanel">
                <div class="row" id="allConfigs">
                    @php
                        $groupedConfigs = $configs->groupBy(function($item) {
                            return explode('_', $item->key)[0];
                        });
                    @endphp

                    @foreach($groupedConfigs as $section => $sectionConfigs)
                        <div class="col-md-6 col-lg-4 mb-4 rounded-2xl">
                            <div class="card h-100 shadow-sm config-card" data-section="{{ $section }}">
                                <div class="card-header
                                    @if($section == 'hero') bg-primary
                                    @elseif($section == 'about') bg-info
                                    @elseif($section == 'service') bg-success
                                    @elseif($section == 'contact') bg-warning
                                    @elseif($section == 'testimonial') bg-secondary
                                    @elseif($section == 'team') bg-dark
                                    @else bg-primary @endif text-white">
                                    <h6 class="mb-0">
                                        <i class="fas
                                            @if($section == 'hero') fa-home
                                            @elseif($section == 'about') fa-info-circle
                                            @elseif($section == 'service') fa-tools
                                            @elseif($section == 'contact') fa-phone
                                            @elseif($section == 'testimonial') fa-star
                                            @elseif($section == 'team') fa-users
                                            @else fa-cog @endif me-2"></i>
                                        {{ ucfirst($section) }} Section
                                    </h6>
                                </div>
                                <div class="card-body">
                                    @foreach($sectionConfigs->take(3) as $config)
                                        <div class="mb-3">
                                            <div class="d-flex justify-content-between align-items-start mb-1">
                                                <small class="text-muted">{{ str_replace($section.'_', '', $config->key) }}</small>
                                                <span class="badge badge-type
                                                    @if($config->type == 'text') bg-primary
                                                    @elseif($config->type == 'image') bg-info
                                                    @else bg-secondary @endif">
                                                    {{ $config->type }}
                                                </span>
                                            </div>

                                            @if($config->type == 'image')
                                                @if(Storage::disk('public')->exists($config->value))
                                                    <img src="{{ Storage::url($config->value) }}" class="img-fluid rounded" alt="{{ $config->key }}" style="max-height: 80px;">
                                                @else
                                                    <div class="bg-light rounded p-2 text-center text-muted" style="height: 80px; display: flex; align-items: center; justify-content: center;">
                                                        <i class="fas fa-image"></i> No Image
                                                    </div>
                                                @endif
                                            @else
                                                <div class="text-truncate">{{ $config->value }}</div>
                                            @endif
                                        </div>
                                    @endforeach

                                    @if($sectionConfigs->count() > 3)
                                        <small class="text-muted">+{{ $sectionConfigs->count() - 3 }} item lainnya</small>
                                    @endif
                                </div>
                                <div class="card-footer">
                                    <button class="btn btn-sm btn-outline-primary me-2 editSectionBtn" data-section="{{ $section }}">
                                        <i class="fas fa-edit me-1"></i>Edit
                                    </button>
                                    <button class="btn btn-sm btn-outline-success showSectionBtn" data-section="{{ $section }}">
                                        <i class="fas fa-list me-1"></i>Detail
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Konfigurasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div id="modal-content-edit">
                <!-- Content will be loaded here via AJAX -->
            </div>
        </div>
    </div>
</div>

<!-- Section Details Modal -->
<div class="modal fade" id="detailModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Konfigurasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div id="modal-content-detail">
                <!-- Content will be loaded here via AJAX -->
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script>
    // Edit Section
    $(document).on('click', '.editSectionBtn', function() {
        const section = $(this).data('section');

        $.ajax({
            url: `/super-admin/setting/cms/${section}/edit`,
            type: 'GET',
            data: { section: section },
            beforeSend: function() {
                $('#modal-content-edit').html(`
                    <div class="modal-body text-center">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2">Memuat data...</p>
                    </div>
                `);
                $('#editModal').modal('show');
            },
            success: function(response) {
                $('#modal-content-edit').html(response);

                // Initialize Summernote after content is loaded
                $('.summernote').summernote({
                    height: 200,
                    toolbar: [
                        ['style', ['style']],
                        ['font', ['bold', 'underline', 'clear']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['table', ['table']],
                        ['insert', ['link', 'picture', 'video']],
                        ['view', ['fullscreen', 'codeview', 'help']]
                    ]
                });
            },
            error: function() {
                $('#modal-content-edit').html(`
                    <div class="modal-body text-center">
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle"></i>
                            Gagal memuat data. Silakan coba lagi.
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                `);
            }
        });
    });

    // Show Section Details
    $(document).on('click', '.showSectionBtn', function() {
        const section = $(this).data('section');

        $.ajax({
            url: `/super-admin/setting/cms/${section}/show`,
            type: 'GET',
            data: { section: section },
            beforeSend: function() {
                $('#modal-content-detail').html(`
                    <div class="modal-body text-center">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2">Memuat detail...</p>
                    </div>
                `);
                $('#detailModal').modal('show');
            },
            success: function(response) {
                $('#modal-content-detail').html(response);
            },
            error: function() {
                $('#modal-content-detail').html(`
                    <div class="modal-body text-center">
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle"></i>
                            Gagal memuat detail. Silakan coba lagi.
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                `);
            }
        });
    });

    // Handle form submission via AJAX
    $(document).on('submit', '#editForm', function(e) {
        e.preventDefault();

        const form = $(this);
        const formData = new FormData(this);
        const submitBtn = form.find('button[type="submit"]');
        const originalText = submitBtn.html();

        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function() {
                submitBtn.html('<i class="fas fa-spinner fa-spin me-1"></i>Menyimpan...').prop('disabled', true);
            },
            success: function(response) {
                if (response.success) {
                    $('#editModal').modal('hide');
                    Swal.fire('Berhasil', response.message, 'success').then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire('Gagal', response.message, 'error');
                }
            },
            error: function(xhr) {
                let errorMessage = 'Terjadi kesalahan saat menyimpan data.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                Swal.fire('Gagal', errorMessage, 'error');
            },
            complete: function() {
                submitBtn.html(originalText).prop('disabled', false);
            }
        });
    });

    // Search functionality
    $('#searchInput').on('input', function() {
        const query = $(this).val().toLowerCase();
        filterConfigs(query, $('#typeFilter').val());
    });

    $('#typeFilter').on('change', function() {
        const type = $(this).val();
        filterConfigs($('#searchInput').val().toLowerCase(), type);
    });

    function filterConfigs(query, type) {
        $('.config-card').each(function() {
            const card = $(this);
            const text = card.text().toLowerCase();
            const cardTypes = card.find('.badge-type').map(function() {
                return $(this).text().toLowerCase();
            }).get();

            const matchesQuery = !query || text.includes(query);
            const matchesType = !type || cardTypes.includes(type.toLowerCase());

            if (matchesQuery && matchesType) {
                card.parent().show();
            } else {
                card.parent().hide();
            }
        });
    }

    // Tab functionality
    $('#configTabs button').on('click', function() {
        const target = $(this).attr('data-bs-target');

        if (target !== '#all') {
            const section = target.replace('#', '');
            $('.config-card').each(function() {
                const card = $(this);
                const cardSection = card.attr('data-section');
                const parentCol = card.parent();

                if (section === 'all' || cardSection === section || cardSection.startsWith(section)) {
                    parentCol.show();
                } else {
                    parentCol.hide();
                }
            });
        } else {
            $('.config-card').parent().show();
        }
    });
</script>
@endsection
