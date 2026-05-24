@extends('layouts.admin')

@section('title', 'Edit Galeri')

@section('content')
<style>
    .preview-grid { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 10px; }
    .preview-item { position: relative; }
    .preview-item img { width: 120px; height: 120px; object-fit: cover; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
    .current-images { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 10px; }
    .current-images img { width: 120px; height: 120px; object-fit: cover; border-radius: 8px; border: 2px solid #c6a43b; }
</style>

<div class="card">
    <div class="card-header">
        <h5><i class="fas fa-edit me-2"></i> Edit Galeri</h5>
    </div>

    <div class="card-body">
        <form action="{{ route('admin.galeri.update', $galeri->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Judul</label>
                    <input type="text" name="judul" class="form-control"
                        value="{{ old('judul', $galeri->judul) }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Geosite</label>
                    <select name="geosite" class="form-control" required>
                        <option value="">-- Pilih Geosite --</option>
                        @foreach($geositeList as $slug => $label)
                            <option value="{{ $slug }}" {{ (old('geosite', $galeri->geosite) == $slug) ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-12 mb-3">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" required>{{ $galeri->deskripsi }}</textarea>
                </div>

                <div class="col-md-12 mb-3">
                    <label>Gambar Saat Ini</label>
                    <div class="current-images">
                        @php
                            $images = json_decode($galeri->gambar, true);
                            if (!is_array($images)) $images = $galeri->gambar ? [$galeri->gambar] : [];
                        @endphp
                        @forelse($images as $img)
                            <img src="{{ str_starts_with($img, 'data:') ? $img : asset('storage/' . $img) }}" alt="Gambar">
                        @empty
                            <span class="text-muted">Tidak ada gambar</span>
                        @endforelse
                    </div>
                    <label class="mt-3">Upload Gambar Baru (kosongkan jika tidak ingin mengubah)</label>
                    <input type="file" name="gambar[]" class="form-control mt-2" id="inputGambar" multiple
                           accept="image/jpeg,image/png,image/jpg,image/webp">
                    <small class="text-muted">Format: JPG, PNG, WEBP. Max: 4MB per gambar. Maksimal 10 gambar.</small>
                    <div class="preview-grid" id="previewGrid"></div>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Lokasi</label>
                    <input type="text" name="lokasi" class="form-control"
                        value="{{ $galeri->lokasi }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Tanggal</label>
                    <input type="date" name="tanggal_foto" class="form-control"
                        value="{{ $galeri->tanggal_foto }}">
                </div>

                <div class="col-md-6 mb-3">
                    <input type="checkbox" name="status" value="1"
                        {{ $galeri->status ? 'checked' : '' }}> Aktif
                </div>
            </div>

            <div class="d-flex gap-2">
                <button class="btn-submit">
                    <i class="fas fa-save"></i> Update
                </button>
                <a href="{{ route('admin.galeri.index') }}" class="btn-cancel">
                    <i class="fas fa-arrow-left"></i> Kembali
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