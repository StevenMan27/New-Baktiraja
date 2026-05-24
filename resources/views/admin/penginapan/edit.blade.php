@extends('layouts.admin')

@section('title', 'Edit Penginapan')

@section('content')
<style>
    .preview-grid { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 10px; }
    .preview-item img { width: 120px; height: 120px; object-fit: cover; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
    .current-images { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 10px; }
    .current-images img { width: 120px; height: 120px; object-fit: cover; border-radius: 8px; border: 2px solid #c6a43b; }
</style>

<div class="d-flex align-items-center mb-3">
    <a href="{{ route('admin.penginapan.index') }}" class="btn btn-sm btn-secondary me-2">
        <i class="fas fa-arrow-left"></i>
    </a>
    <h5 class="mb-0">Edit Penginapan</h5>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.penginapan.update', $data->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label required">Nama Penginapan</label>
                    <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" 
                           value="{{ old('nama', $data->nama) }}" required>
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label required">Pilih Geosite</label>
                    <select name="geosite" class="form-control @error('geosite') is-invalid @enderror" required>
                        <option value="">-- Pilih Geosite --</option>
                        @foreach($geositeList as $value => $label)
                            <option value="{{ $value }}" {{ old('geosite', $data->geosite) == $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('geosite')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Urutan</label>
                    <input type="number" name="urutan" class="form-control @error('urutan') is-invalid @enderror" 
                           value="{{ old('urutan', $data->urutan) }}" required>
                    <small class="text-muted">Semakin kecil angka, semakin atas tampilannya</small>
                    @error('urutan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-12 mb-3">
                    <label class="form-label required">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" 
                              rows="4" required>{{ old('deskripsi', $data->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Harga</label>
                    <input type="text" name="harga" class="form-control @error('harga') is-invalid @enderror" 
                           value="{{ old('harga', $data->harga) }}" placeholder="Contoh: Rp 150.000 / malam">
                    @error('harga')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Kontak</label>
                    <input type="text" name="kontak" class="form-control @error('kontak') is-invalid @enderror" 
                           value="{{ old('kontak', $data->kontak) }}" placeholder="Contoh: 08123456789">
                    @error('kontak')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-12 mb-3">
                    <label class="form-label">Gambar Saat Ini</label>
                    <div class="current-images">
                        @php
                            $images = json_decode($data->gambar, true);
                            if (!is_array($images)) $images = $data->gambar ? [$data->gambar] : [];
                        @endphp
                        @forelse($images as $img)
                            <img src="{{ str_starts_with($img, 'data:') ? $img : asset('storage/' . $img) }}" alt="Gambar">
                        @empty
                            <span class="text-muted">Tidak ada gambar</span>
                        @endforelse
                    </div>
                    
                    <label class="form-label mt-3">Upload Gambar Baru (kosongkan jika tidak ingin mengubah)</label>
                    <input type="file" name="gambar[]" class="form-control @error('gambar') is-invalid @enderror @error('gambar.*') is-invalid @enderror" 
                           accept="image/jpeg,image/png,image/jpg,image/webp" id="inputGambar" multiple>
                    <small class="text-muted">Format: JPG, PNG, WEBP. Max: 4MB per gambar. Maksimal 10 gambar.</small>
                    <div class="preview-grid" id="previewGrid"></div>
                    @error('gambar')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    @error('gambar.*')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="status" value="1" 
                               id="statusCheck" {{ old('status', $data->status) ? 'checked' : '' }}>
                        <label class="form-check-label" for="statusCheck">
                            <i class="fas fa-check-circle text-success me-1"></i> Aktifkan
                        </label>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn-submit">
                    <i class="fas fa-save me-2"></i> Update
                </button>
                <a href="{{ route('admin.penginapan.index') }}" class="btn-cancel">
                    <i class="fas fa-arrow-left me-2"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('inputGambar').addEventListener('change', function(e) {
        const grid = document.getElementById('previewGrid');
        grid.innerHTML = '';
        const files = e.target.files;
        if (files.length > 10) { alert('Maksimal 10 gambar!'); this.value = ''; return; }
        Array.from(files).forEach(file => {
            if (file.size > 4 * 1024 * 1024) { alert('Gambar "' + file.name + '" melebihi 4MB!'); return; }
            const reader = new FileReader();
            reader.onload = function(ev) {
                const item = document.createElement('div');
                item.className = 'preview-item';
                item.innerHTML = '<img src="' + ev.target.result + '" alt="Preview">';
                grid.appendChild(item);
            }
            reader.readAsDataURL(file);
        });
    });
</script>
@endsection