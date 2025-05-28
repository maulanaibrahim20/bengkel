<form id="editForm" action="{{ url('super-admin/setting/cms/' . $section . '/update') }}" method="POST"
    enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="modal-body">
        @foreach($configs as $config)
            @php
                $fieldName = str_replace($section . '_', '', $config->key);
                $fieldLabel = ucwords(str_replace('_', ' ', $fieldName));
            @endphp

            <div class="mb-3">
                <label class="form-label">{{ $fieldLabel }}</label>

                @if($config->type === 'image')
                    <input type="file" class="form-control" name="{{ $config->key }}" accept="image/*">
                    <input type="hidden" name="{{ $config->key }}_id" value="{{ $config->id }}">
                    <small class="text-muted">Current:</small>
                    @if($config->value && Storage::disk('public')->exists($config->value))
                        <br><img src="{{ Storage::url($config->value) }}" class="img-thumbnail mt-2" style="max-height: 100px;">
                    @else
                        <span class="text-muted">No image</span>
                    @endif
                @else
                    <input type="text" class="form-control" name="{{ $config->key }}"
                        value="{{ old($config->key, $config->value ?? '') }}">
                    <input type="hidden" name="{{ $config->key }}_id" value="{{ $config->id }}">
                @endif
            </div>
        @endforeach
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save me-1"></i> Simpan Perubahan
        </button>
    </div>
</form>