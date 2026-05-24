@extends('layouts.admin')

@section('title', 'Tambah Fasilitas')

@section('content')
<style>
    .preview-grid { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 10px; }
    .preview-item img { width: 120px; height: 120px; object-fit: cover; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
</style>

<div class="card">
    <div class="card-header">
        <h5>Tambah Fasilitas</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.fasilitas.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="mb-3">
                <label>Nama Fasilitas</label>
                <input type="text" name="nama" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Pilih Geosite</label>
                <select name="geosite" class="form-control" required>
                    <option value="">-- Pilih Geosite --</option>
                    @foreach($geositeList as $slug => $label)
                        <option value="{{ $slug }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="mb-3">
                <label>Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="4" required></textarea>
            </div>
            
            <div class="mb-3">
                <label>Harga</label>
                <input type="text" name="harga" class="form-control" placeholder="Contoh: Gratis / Rp 50.000">
            </div>
            
            <div class="mb-3">
                <label>Urutan</label>
                <input type="number" name="urutan" class="form-control" required>
            </div>
            
            <div class="mb-3">
                <label>Gambar</label>
                <input type="file" name="gambar[]" class="form-control" accept="image/*" id="inputGambar" multiple>
                <small class="text-muted">Format: JPG, PNG, WEBP. Max: 4MB per gambar. Maksimal 10 gambar.</small>
                <div class="preview-grid" id="previewGrid"></div>
            </div>
            
            <div class="mb-3">
                <input type="checkbox" name="status" value="1" checked> Aktifkan
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn-submit">
                    <i class="fas fa-save"></i> Simpan
                </button>
                <a href="{{ route('admin.fasilitas.index') }}" class="btn-cancel">
                    <i class="fas fa-arrow-left"></i> Batal
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