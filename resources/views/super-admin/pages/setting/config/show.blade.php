<div class="modal-body">
    @if($section === 'hero')
        @php
            $heroTitle = $configs->where('key', 'hero_title')->first()?->value ?? '';
            $heroSubtitle = $configs->where('key', 'hero_subtitle')->first()?->value ?? '';
            $heroImage = $configs->where('key', 'hero_image')->first()?->value ?? '';
        @endphp

        <div class="text-center bg-primary text-white p-5 rounded">
            <h1 class="display-4 mb-3">{{ $heroTitle }}</h1>
            <p class="lead">{{ $heroSubtitle }}</p>
            @if($heroImage && Storage::disk('public')->exists($heroImage))
                <img src="{{ Storage::url($heroImage) }}" class="img-fluid rounded mt-3" alt="Hero Image"
                    style="max-height: 300px;">
            @else
                <div class="bg-secondary rounded p-4 mt-3">No Image</div>
            @endif
        </div>

    @elseif($section === 'about')
        @php
            $aboutTitle = $configs->where('key', 'about_title')->first()?->value ?? '';
            $aboutContent = $configs->where('key', 'about_content')->first()?->value ?? '';
            $aboutImage = $configs->where('key', 'about_image')->first()?->value ?? '';
        @endphp

        <div class="row align-items-center">
            <div class="col-md-6">
                <h2>{{ $aboutTitle }}</h2>
                <div>{!! $aboutContent !!}</div>
            </div>
            <div class="col-md-6">
                @if($aboutImage && Storage::disk('public')->exists($aboutImage))
                    <img src="{{ Storage::url($aboutImage) }}" class="img-fluid rounded" alt="About Image">
                @else
                    <div class="bg-light rounded p-4">No Image</div>
                @endif
            </div>
        </div>

    @elseif($section === 'contact')
        @php
            $contactAddress = $configs->where('key', 'contact_address')->first()?->value ?? '';
            $contactPhone = $configs->where('key', 'contact_phone')->first()?->value ?? '';
            $contactEmail = $configs->where('key', 'contact_email')->first()?->value ?? '';
            $contactOpenHours = $configs->where('key', 'contact_open_hours')->first()?->value ?? '';
        @endphp

        <ul class="list-group">
            <li class="list-group-item"><strong>Alamat:</strong> {{ $contactAddress }}</li>
            <li class="list-group-item"><strong>Telepon:</strong> {{ $contactPhone }}</li>
            <li class="list-group-item"><strong>Email:</strong> {{ $contactEmail }}</li>
            <li class="list-group-item"><strong>Jam Operasional:</strong> {{ $contactOpenHours }}</li>
        </ul>

    @else
        <p class="text-muted">Tidak ada konten untuk bagian ini.</p>
    @endif
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
</div>