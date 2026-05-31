{{-- resources/views/admin/galeri/create.blade.php --}}
@extends('layouts.admin')

@section('title', 'Tambah Galeri')

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
        <h5 class="mb-0">
            <i class="fas fa-plus-circle me-2" style="color: #c6a43b;"></i>
            Tambah Galeri Baru
        </h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.galeri.store') }}" method="POST" enctype="multipart/form-data" id="formGaleri">
            @csrf
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label required">Judul</label>
                    <input type="text" name="judul" class="form-control @error('judul') is-invalid @enderror" 
                           value="{{ old('judul') }}" required placeholder="Masukkan judul galeri">
                    @error('judul')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label required">Geosite</label>
                    <select name="geosite" class="form-control @error('geosite') is-invalid @enderror" required>
                        <option value="">-- Pilih Geosite --</option>
                        @foreach($geositeList as $slug => $label)
                            <option value="{{ $slug }}" {{ old('geosite') == $slug ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('geosite')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-12 mb-3">
                    <label class="form-label required">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" 
                              rows="4" required placeholder="Masukkan deskripsi galeri">{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-12 mb-3">
                    <label class="form-label required">Gambar</label>
                    <div class="custom-file-upload mt-2">
    <i class="fas fa-images icon"></i>
    <p>Klik atau Seret Gambar ke Sini</p>
    <small class="d-block mt-2">Format: JPG, PNG, WEBP | Max: 4MB per gambar | Maksimal 10 gambar</small>
    <input type="file" name="gambar[]" class="form-control @error('gambar') is-invalid @enderror @error('gambar.*') is-invalid @enderror" 
                           accept="image/jpeg,image/png,image/jpg,image/webp" required id="inputGambar" multiple>
    <div class="preview-grid" id="previewGrid"></div>
</div>
                    @error('gambar')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    @error('gambar.*')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">Lokasi</label>
                    <input type="text" name="lokasi" class="form-control @error('lokasi') is-invalid @enderror" 
                           value="{{ old('lokasi') }}" placeholder="Contoh: Desa Sibandang, Pulau Samosir">
                    @error('lokasi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tanggal Foto</label>
                    <input type="date" name="tanggal_foto" class="form-control @error('tanggal_foto') is-invalid @enderror" 
                           value="{{ old('tanggal_foto') }}">
                    @error('tanggal_foto')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                

            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn-submit">
                    <i class="fas fa-save me-2"></i> Simpan
                </button>
                <a href="{{ route('admin.galeri.index') }}" class="btn-cancel">
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
        if (files.length > 10) {
            alert('Maksimal 10 gambar!');
            this.value = '';
            return;
        }
        Array.from(files).forEach((file, i) => {
            if (file.size > 4 * 1024 * 1024) {
                alert('Gambar "' + file.name + '" melebihi 4MB!');
                return;
            }
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



