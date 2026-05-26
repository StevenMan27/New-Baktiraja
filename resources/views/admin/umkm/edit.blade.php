@extends('layouts.admin')

@section('title', 'Edit UMKM')

@section('content')

<style>
    .custom-file-upload {
        border: 2px dashed #003366;
        border-radius: 12px;
        padding: 30px;
        text-align: center;
        background-color: #f8f9fa;
        position: relative;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .custom-file-upload:hover {
        background-color: #e9ecef;
        border-color: #c6a43b;
    }
    .custom-file-upload input[type="file"] {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
        z-index: 2;
    }
    .custom-file-upload .icon {
        font-size: 3rem;
        color: #003366;
        margin-bottom: 15px;
    }
    .custom-file-upload p {
        margin: 0;
        font-size: 1.1rem;
        font-weight: 600;
        color: #495057;
    }
    .custom-file-upload small {
        color: #6c757d;
    }
    .preview-grid { 
        display: flex; flex-wrap: wrap; gap: 15px; margin-top: 20px; justify-content: center; position: relative; z-index: 3; pointer-events: none;
    }
    .preview-item { pointer-events: auto; }
    .preview-item img { width: 120px; height: 120px; object-fit: cover; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); border: 2px solid #fff; }
</style>



<div class="card">
    <div class="card-header">
        <h5>Edit UMKM</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.umkm.update', $data->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label class="form-label">Nama UMKM</label>
                <input type="text" name="nama" class="form-control" value="{{ $data->nama }}" required>
            </div>
            <div class="mb-3">
                <label>Pilih Geosite</label>
                <select name="geosite" class="form-control" required>
                    <option value="">-- Pilih Geosite --</option>
                    @foreach($geositeList as $slug => $label)
                        <option value="{{ $slug }}" {{ $data->geosite == $slug ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="4" required>{{ $data->deskripsi }}</textarea>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Lokasi</label>
                    <input type="text" name="lokasi" class="form-control" value="{{ $data->lokasi }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Kontak</label>
                    <input type="text" name="kontak" class="form-control" value="{{ $data->kontak }}">
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Urutan</label>
                <input type="number" name="urutan" class="form-control" value="{{ $data->urutan }}" required>
            </div>
            
            <div class="mb-3">
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
                <div class="custom-file-upload mt-2">
    <i class="fas fa-cloud-upload-alt icon"></i>
    <p>Klik atau Seret Gambar ke Sini</p>
    <small class="d-block mt-2">Format: JPG, PNG, WEBP | Max: 4MB per gambar | Maksimal 10 gambar</small>
    <input type="file" name="gambar[]" class="form-control mt-2" accept="image/*" id="inputGambar" multiple>
    <div class="preview-grid" id="previewGrid"></div>
</div>
            </div>
            
            <div class="mb-3">
                <input type="checkbox" name="status" value="1" {{ $data->status ? 'checked' : '' }}> Aktifkan
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn-submit">
                    <i class="fas fa-save"></i> Update
                </button>
                <a href="{{ route('admin.umkm.index') }}" class="btn-cancel">
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