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
                <div class="col-auto">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addConfigModal">
                        <i class="fas fa-plus me-1"></i>Tambah Konfigurasi
                    </button>
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
                                                    @elseif($config->type == 'textarea') bg-success
                                                    @elseif($config->type == 'html') bg-warning
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
                                            @elseif($config->type == 'html')
                                                <div class="text-truncate">{{ strip_tags($config->value) }}</div>
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
                                    <button class="btn btn-sm btn-outline-primary me-2" onclick="editSection('{{ $section }}')">
                                        <i class="fas fa-edit me-1"></i>Edit
                                    </button>
                                    <button class="btn btn-sm btn-outline-info me-2" onclick="previewSection('{{ $section }}')">
                                        <i class="fas fa-eye me-1"></i>Preview
                                    </button>
                                    <button class="btn btn-sm btn-outline-success" onclick="showSectionDetails('{{ $section }}')">
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
            <form id="editForm" action="{{ url('admin.config.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div id="editFormFields">
                        <!-- Dynamic form fields will be inserted here -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Preview Modal -->
<div class="modal fade" id="previewModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Preview Konten</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="previewContent">
                <!-- Preview content will be inserted here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Add Config Modal -->
<div class="modal fade" id="addConfigModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Konfigurasi Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ url('admin.config.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Key</label>
                        <input type="text" class="form-control" name="key" required>
                        <small class="text-muted">Format: section_field (contoh: hero_title)</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Type</label>
                        <select class="form-select" name="type" required>
                            <option value="">Pilih Tipe</option>
                            <option value="text">Text</option>
                            <option value="textarea">Textarea</option>
                            <option value="html">HTML</option>
                            <option value="image">Image</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Value</label>
                        <textarea class="form-control" name="value" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i>Tambah
                    </button>
                </div>
            </form>
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
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="detailTable">
                        <thead>
                            <tr>
                                <th>Key</th>
                                <th>Type</th>
                                <th>Value</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="detailTableBody">
                            <!-- Table content will be inserted here -->
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script>
    // Laravel data
    const configs = @json($configs);

    // Edit functions
    function editSection(section) {
        console.log(section);

        const sectionConfigs = configs.filter(config => config.key.startsWith(section + '_'));
        let formFields = '';

        sectionConfigs.forEach(config => {
            const fieldName = config.key.replace(section + '_', '');

            if (config.type === 'image') {
                formFields += `
                    <div class="mb-3">
                        <label class="form-label">${fieldName.charAt(0).toUpperCase() + fieldName.slice(1)}</label>
                        <input type="file" class="form-control" name="${config.key}" accept="image/*">
                        <input type="hidden" name="${config.key}_id" value="${config.id}">
                        <small class="text-muted">Current: ${config.value || 'No image'}</small>
                        ${config.value ? `<br><img src="/storage/${config.value}" class="img-thumbnail mt-2" style="max-height: 100px;">` : ''}
                    </div>
                `;
            } else if (config.type === 'html') {
                formFields += `
                    <div class="mb-3">
                        <label class="form-label">${fieldName.charAt(0).toUpperCase() + fieldName.slice(1)}</label>
                        <textarea class="form-control summernote" name="${config.key}">${config.value || ''}</textarea>
                        <input type="hidden" name="${config.key}_id" value="${config.id}">
                    </div>
                `;
            } else if (config.type === 'textarea') {
                formFields += `
                    <div class="mb-3">
                        <label class="form-label">${fieldName.charAt(0).toUpperCase() + fieldName.slice(1)}</label>
                        <textarea class="form-control" name="${config.key}" rows="3">${config.value || ''}</textarea>
                        <input type="hidden" name="${config.key}_id" value="${config.id}">
                    </div>
                `;
            } else {
                formFields += `
                    <div class="mb-3">
                        <label class="form-label">${fieldName.charAt(0).toUpperCase() + fieldName.slice(1)}</label>
                        <input type="text" class="form-control" name="${config.key}" value="${config.value || ''}">
                        <input type="hidden" name="${config.key}_id" value="${config.id}">
                    </div>
                `;
            }
        });

        document.querySelector('#editModal .modal-title').textContent = `Edit ${section.charAt(0).toUpperCase() + section.slice(1)} Section`;
        document.getElementById('editFormFields').innerHTML = formFields;

        // Initialize Summernote for HTML content
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

        new bootstrap.Modal(document.getElementById('editModal')).show();
    }

    function previewSection(section) {
        const sectionConfigs = configs.filter(config => config.key.startsWith(section + '_'));
        let previewContent = '';
        let title = `Preview ${section.charAt(0).toUpperCase() + section.slice(1)} Section`;

        // Generate preview based on section type
        if (section === 'hero') {
            const heroTitle = sectionConfigs.find(c => c.key === 'hero_title')?.value || '';
            const heroSubtitle = sectionConfigs.find(c => c.key === 'hero_subtitle')?.value || '';
            const heroImage = sectionConfigs.find(c => c.key === 'hero_image')?.value || '';

            previewContent = `
                <div class="text-center bg-primary text-white p-5 rounded">
                    <h1 class="display-4 mb-3">${heroTitle}</h1>
                    <p class="lead">${heroSubtitle}</p>
                    ${heroImage ? `<img src="/storage/${heroImage}" class="img-fluid rounded mt-3" alt="Hero Image" style="max-height: 300px;">` : '<div class="bg-secondary rounded p-4 mt-3">No Image</div>'}
                </div>
            `;
        } else if (section === 'about') {
            const aboutTitle = sectionConfigs.find(c => c.key === 'about_title')?.value || '';
            const aboutContent = sectionConfigs.find(c => c.key === 'about_content')?.value || '';
            const aboutImage = sectionConfigs.find(c => c.key === 'about_image')?.value || '';

            previewContent = `
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h2>${aboutTitle}</h2>
                        <div>${aboutContent}</div>
                    </div>
                    <div class="col-md-6">
                        ${aboutImage ? `<img src="/storage/${aboutImage}" class="img-fluid rounded" alt="About Image">` : '<div class="bg-light rounded p-4">No Image</div>'}
                    </div>
                </div>
            `;
        } else if (section === 'contact') {
            const contactAddress = sectionConfigs.find(c => c.key === 'contact_address')?.value || '';
            const contactPhone = sectionConfigs.find(c => c.key === 'contact_phone')?.value || '';
            const contactEmail = sectionConfigs.find(c => c.key === 'contact_email')?.value || '';
            const contactHours = sectionConfigs.find(c => c.key === 'contact_open_hours')?.value || '';

            previewContent = `
                <div class="row">
                    <div class="col-md-6">
                        <h3>Informasi Kontak</h3>
                        <div class="mb-3">
                            <i class="fas fa-map-marker-alt text-primary me-2"></i>
                            <strong>Alamat:</strong> ${contactAddress}
                        </div>
                        <div class="mb-3">
                            <i class="fas fa-phone text-primary me-2"></i>
                            <strong>Telepon:</strong> ${contactPhone}
                        </div>
                        <div class="mb-3">
                            <i class="fas fa-envelope text-primary me-2"></i>
                            <strong>Email:</strong> ${contactEmail}
                        </div>
                        <div class="mb-3">
                            <i class="fas fa-clock text-primary me-2"></i>
                            <strong>Jam Buka:</strong> ${contactHours}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="bg-light p-4 rounded">
                            <h5>Lokasi Kami</h5>
                            <div class="bg-secondary rounded" style="height: 200px; display: flex; align-items: center; justify-content: center;">
                                <span class="text-white">Map Placeholder</span>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        } else if (section.startsWith('service')) {
            const serviceTitle = sectionConfigs.find(c => c.key.includes('_title'))?.value || '';
            const serviceDescription = sectionConfigs.find(c => c.key.includes('_description'))?.value || '';
            const serviceImage = sectionConfigs.find(c => c.key.includes('_image'))?.value || '';

            previewContent = `
                <div class="card">
                    ${serviceImage ? `<img src="/storage/${serviceImage}" class="card-img-top" alt="${serviceTitle}">` : '<div class="bg-light p-4 text-center">No Image</div>'}
                    <div class="card-body text-center">
                        <h4 class="card-title">${serviceTitle}</h4>
                        <p class="card-text">${serviceDescription}</p>
                        <button class="btn btn-primary">Pelajari Lebih Lanjut</button>
                    </div>
                </div>
            `;
        } else if (section.startsWith('testimonial')) {
            const testimonialName = sectionConfigs.find(c => c.key.includes('_name'))?.value || '';
            const testimonialPosition = sectionConfigs.find(c => c.key.includes('_position'))?.value || '';
            const testimonialComment = sectionConfigs.find(c => c.key.includes('_comment'))?.value || '';
            const testimonialImage = sectionConfigs.find(c => c.key.includes('_image'))?.value || '';

            previewContent = `
                <div class="card">
                    <div class="card-body text-center">
                        ${testimonialImage ? `<img src="/storage/${testimonialImage}" class="rounded-circle mb-3" alt="${testimonialName}" style="width: 100px; height: 100px; object-fit: cover;">` : '<div class="bg-light rounded-circle mx-auto mb-3" style="width: 100px; height: 100px;"></div>'}
                        <blockquote class="blockquote">
                            <p class="mb-3">"${testimonialComment}"</p>
                        </blockquote>
                        <footer class="blockquote-footer">
                            <strong>${testimonialName}</strong>
                            <cite title="Source Title">${testimonialPosition}</cite>
                        </footer>
                        <div class="mt-3">
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                            <i class="fas fa-star text-warning"></i>
                        </div>
                    </div>
                </div>
            `;
        } else if (section.startsWith('team')) {
            const teamName = sectionConfigs.find(c => c.key.includes('_name'))?.value || '';
            const teamPosition = sectionConfigs.find(c => c.key.includes('_position'))?.value || '';
            const teamDescription = sectionConfigs.find(c => c.key.includes('_description'))?.value || '';
            const teamImage = sectionConfigs.find(c => c.key.includes('_image'))?.value || '';

            previewContent = `
                <div class="card">
                    <div class="card-body text-center">
                        ${teamImage ? `<img src="/storage/${teamImage}" class="rounded-circle mb-3" alt="${teamName}" style="width: 150px; height: 150px; object-fit: cover;">` : '<div class="bg-light rounded-circle mx-auto mb-3" style="width: 150px; height: 150px;"></div>'}
                        <h4 class="card-title">${teamName}</h4>
                        <h6 class="card-subtitle mb-2 text-muted">${teamPosition}</h6>
                        <p class="card-text">${teamDescription}</p>
                        <div class="mt-3">
                            <a href="#" class="btn btn-sm btn-outline-primary me-2">
                                <i class="fab fa-linkedin"></i>
                            </a>
                            <a href="#" class="btn btn-sm btn-outline-info">
                                <i class="fab fa-twitter"></i>
                            </a>
                        </div>
                    </div>
                </div>
            `;
        } else {
            previewContent = '<p>Preview tidak tersedia untuk section ini.</p>';
        }

        document.querySelector('#previewModal .modal-title').textContent = title;
        document.getElementById('previewContent').innerHTML = previewContent;
        new bootstrap.Modal(document.getElementById('previewModal')).show();
    }

    function showSectionDetails(section) {
        const sectionConfigs = configs.filter(config => config.key.startsWith(section + '_'));
        let tableContent = '';

        sectionConfigs.forEach(config => {
            let valueDisplay = config.value || '';

            if (config.type === 'image') {
                valueDisplay = config.value ?
                    `<img src="/storage/${config.value}" class="img-thumbnail" style="max-height: 50px;"> <br><small>${config.value}</small>` :
                    '<span class="text-muted">No image</span>';
            } else if (config.type === 'html') {
                valueDisplay = `<div class="text-truncate" style="max-width: 200px;">${valueDisplay.replace(/<[^>]*>/g, '')}</div>`;
            } else if (valueDisplay.length > 50) {
                valueDisplay = valueDisplay.substring(0, 50) + '...';
            }

            tableContent += `
                <tr>
                    <td><code>${config.key}</code></td>
                    <td><span class="badge bg-primary">${config.type}</span></td>
                    <td>${valueDisplay}</td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary" onclick="editSingleConfig(${config.id})">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-outline-danger" onclick="deleteSingleConfig(${config.id})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
        });

        document.querySelector('#detailModal .modal-title').textContent = `Detail ${section.charAt(0).toUpperCase() + section.slice(1)} Section`;
        document.getElementById('detailTableBody').innerHTML = tableContent;
        new bootstrap.Modal(document.getElementById('detailModal')).show();
    }

    function editSingleConfig(configId) {
        const config = configs.find(c => c.id === configId);
        if (!config) return;

        let formField = '';
        const fieldName = config.key.split('_').slice(1).join(' ');

        if (config.type === 'image') {
            formField = `
                <div class="mb-3">
                    <label class="form-label">${fieldName.charAt(0).toUpperCase() + fieldName.slice(1)}</label>
                    <input type="file" class="form-control" name="${config.key}" accept="image/*">
                    <input type="hidden" name="${config.key}_id" value="${config.id}">
                    <small class="text-muted">Current: ${config.value || 'No image'}</small>
                    ${config.value ? `<br><img src="/storage/${config.value}" class="img-thumbnail mt-2" style="max-height: 100px;">` : ''}
                </div>
            `;
        } else if (config.type === 'html') {
            formField = `
                <div class="mb-3">
                    <label class="form-label">${fieldName.charAt(0).toUpperCase() + fieldName.slice(1)}</label>
                    <textarea class="form-control summernote" name="${config.key}">${config.value || ''}</textarea>
                    <input type="hidden" name="${config.key}_id" value="${config.id}">
                </div>
            `;
        } else if (config.type === 'textarea') {
            formField = `
                <div class="mb-3">
                    <label class="form-label">${fieldName.charAt(0).toUpperCase() + fieldName.slice(1)}</label>
                    <textarea class="form-control" name="${config.key}" rows="3">${config.value || ''}</textarea>
                    <input type="hidden" name="${config.key}_id" value="${config.id}">
                </div>
            `;
        } else {
            formField = `
                <div class="mb-3">
                    <label class="form-label">${fieldName.charAt(0).toUpperCase() + fieldName.slice(1)}</label>
                    <input type="text" class="form-control" name="${config.key}" value="${config.value || ''}">
                    <input type="hidden" name="${config.key}_id" value="${config.id}">
                </div>
            `;
        }

        document.querySelector('#editModal .modal-title').textContent = `Edit ${config.key}`;
        document.getElementById('editFormFields').innerHTML = formField;

        // Initialize Summernote for HTML content
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

        // Hide detail modal and show edit modal
        bootstrap.Modal.getInstance(document.getElementById('detailModal')).hide();
        new bootstrap.Modal(document.getElementById('editModal')).show();
    }

    function deleteSingleConfig(configId) {
        const config = configs.find(c => c.id === configId);
        if (!config) return;

        if (confirm(`Apakah Anda yakin ingin menghapus konfigurasi "${config.key}"?`)) {
            // Create form and submit
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `{{ url('admin.config.destroy', '') }}/${configId}`;

            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';

            const methodField = document.createElement('input');
            methodField.type = 'hidden';
            methodField.name = '_method';
            methodField.value = 'DELETE';

            form.appendChild(csrfToken);
            form.appendChild(methodField);
            document.body.appendChild(form);
            form.submit();
        }
    }

    // Search functionality
    document.getElementById('searchInput').addEventListener('input', function() {
        const query = this.value.toLowerCase();
        filterConfigs(query, document.getElementById('typeFilter').value);
    });

    document.getElementById('typeFilter').addEventListener('change', function() {
        const type = this.value;
        filterConfigs(document.getElementById('searchInput').value.toLowerCase(), type);
    });

    function filterConfigs(query, type) {
        const cards = document.querySelectorAll('.config-card');
        cards.forEach(card => {
            const text = card.textContent.toLowerCase();
            const cardTypes = Array.from(card.querySelectorAll('.badge-type')).map(badge => badge.textContent.toLowerCase());

            const matchesQuery = !query || text.includes(query);
            const matchesType = !type || cardTypes.includes(type.toLowerCase());

            if (matchesQuery && matchesType) {
                card.parentElement.style.display = 'block';
            } else {
                card.parentElement.style.display = 'none';
            }
        });
    }

    // Form submission with loading state
    document.getElementById('editForm').addEventListener('submit', function(e) {
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;

        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Menyimpan...';
        submitBtn.disabled = true;

        // Allow form to submit normally
        setTimeout(() => {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }, 2000);
    });

    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Tab functionality
    document.querySelectorAll('#configTabs button').forEach(tab => {
        tab.addEventListener('click', function() {
            const target = this.getAttribute('data-bs-target');

            if (target !== '#all') {
                const section = target.replace('#', '');
                const cards = document.querySelectorAll('.config-card');

                cards.forEach(card => {
                    const cardSection = card.getAttribute('data-section');
                    const parentCol = card.parentElement;

                    if (section === 'all' || cardSection === section || cardSection.startsWith(section)) {
                        parentCol.style.display = 'block';
                    } else {
                        parentCol.style.display = 'none';
                    }
                });
            } else {
                // Show all cards
                document.querySelectorAll('.config-card').forEach(card => {
                    card.parentElement.style.display = 'block';
                });
            }
        });
    });
</script>
@endsection
