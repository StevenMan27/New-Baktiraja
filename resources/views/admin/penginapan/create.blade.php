@extends('layouts.admin')

@section('title', 'Tambah Penginapan')

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



<div class="d-flex align-items-center mb-3">
    <a href="{{ route('admin.penginapan.index') }}" class="btn btn-sm btn-secondary me-2">
        <i class="fas fa-arrow-left"></i>
    </a>
    <h5 class="mb-0">Tambah Penginapan</h5>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.penginapan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label required">Nama Penginapan</label>
                    <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" 
                           value="{{ old('nama') }}" required>
                    @error('nama')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label required">Pilih Geosite</label>
                    <select name="geosite" class="form-control @error('geosite') is-invalid @enderror" required>
                        <option value="">-- Pilih Geosite --</option>
                        @foreach($geositeList as $value => $label)
                            <option value="{{ $value }}" {{ old('geosite') == $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('geosite')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Urutan</label>
                    <input type="number" name="urutan" class="form-control @error('urutan') is-invalid @enderror" 
                           value="{{ old('urutan') }}" required>
                    <small class="text-muted">Semakin kecil angka, semakin atas tampilannya</small>
                    @error('urutan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-12 mb-3">
                    <label class="form-label required">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" 
                              rows="4" required>{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Harga</label>
                    <input type="text" name="harga" class="form-control @error('harga') is-invalid @enderror" 
                           value="{{ old('harga') }}" placeholder="Contoh: Rp 150.000 / malam">
                    @error('harga')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Kontak</label>
                    <input type="text" name="kontak" class="form-control @error('kontak') is-invalid @enderror" 
                           value="{{ old('kontak') }}" placeholder="Contoh: 08123456789">
                    @error('kontak')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-12 mb-3">
                    <label class="form-label">Gambar</label>
                    <div class="custom-file-upload mt-2">
    <i class="fas fa-cloud-upload-alt icon"></i>
    <p>Klik atau Seret Gambar ke Sini</p>
    <small class="d-block mt-2">Format: JPG, PNG, WEBP | Maks. 4MB</small>
    <input type="file" name="gambar" class="form-control @error('gambar') is-invalid @enderror @error('gambar.*') is-invalid @enderror" accept="image/jpeg,image/png,image/jpg,image/webp" id="inputGambar" >
    <div class="preview-grid" id="previewGrid"></div>
</div>
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
                               id="statusCheck" {{ old('status') ? 'checked' : 'checked' }}>
                        <label class="form-check-label" for="statusCheck">
                            <i class="fas fa-check-circle text-success me-1"></i> Aktifkan
                        </label>
                        <br>
                        <small class="text-muted">Jika diaktifkan, akan ditampilkan di halaman publik</small>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn-submit">
                    <i class="fas fa-save me-2"></i> Simpan
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
        const file = files[0];
if (file) {
        {
            if (file.size > 4 * 1024 * 1024) { alert('Gambar "' + file.name + '" melebihi 4MB!'); return; }
            const reader = new FileReader();
            reader.onload = function(ev) {
                const item = document.createElement('div');
                item.className = 'preview-item';
                item.innerHTML = '<img src="' + ev.target.result + '" alt="Preview">';
                grid.appendChild(item);
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection