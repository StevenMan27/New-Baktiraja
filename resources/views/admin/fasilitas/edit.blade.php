@extends('layouts.admin')

@section('title', 'Edit Fasilitas')

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
        <h5>Edit Fasilitas</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.fasilitas.update', $data->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label>Nama Fasilitas</label>
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
                <label>Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="4" required>{{ $data->deskripsi }}</textarea>
            </div>
            
            <div class="mb-3">
                <label>Harga</label>
                <input type="text" name="harga" class="form-control" value="{{ $data->harga }}">
            </div>
            
            <div class="mb-3">
                <label>Urutan</label>
                <input type="number" name="urutan" class="form-control" value="{{ $data->urutan }}" required>
            </div>
            
            <div class="mb-3">
                <label>Gambar Saat Ini</label>
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
                <label class="mt-3">Upload Gambar Baru (kosongkan jika tidak ingin mengubah)</label>
                <div class="custom-file-upload mt-2">
    <i class="fas fa-cloud-upload-alt icon"></i>
    <p>Klik atau Seret Gambar ke Sini</p>
    <small class="d-block mt-2">Format: JPG, PNG, WEBP | Maks. 4MB</small>
    <input type="file" name="gambar" class="form-control mt-2" accept="image/*" id="inputGambar" >
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
        const file = e.target.files[0];
        if (!file) return;
        if (file.size > 4 * 1024 * 1024) {
            alert('Gambar "' + file.name + '" melebihi batas maksimal 4MB!');
            this.value = '';
            return;
        }
        const reader = new FileReader();
        reader.onload = function(ev) {
            const item = document.createElement('div');
            item.className = 'preview-item';
            item.innerHTML = '<img src="' + ev.target.result + '" alt="Preview">';
            grid.appendChild(item);
        };
        reader.readAsDataURL(file);
    });
</script>

@endsection