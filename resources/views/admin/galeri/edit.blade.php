@extends('layouts.admin')

@section('title', 'Edit Galeri')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

    :root {
        --navy: #003366;
        --navy-light: #0a4080;
        --surface: #ffffff;
        --surface-2: #f8fafc;
        --border: #e2e8f0;
        --text: #1e293b;
        --text-muted: #64748b;
        --danger: #ef4444;
        --success: #22c55e;
        --radius: 14px;
        --radius-sm: 8px;
        --shadow: 0 1px 3px rgba(0,0,0,0.06), 0 4px 16px rgba(0,0,0,0.06);
        --shadow-md: 0 4px 24px rgba(0,51,102,0.10);
    }

    .hp-wrapper { max-width: 960px; margin: 0 auto; padding: 0 0 60px; font-family: 'Plus Jakarta Sans', sans-serif; }
    
    .hp-page-header {
        background: linear-gradient(135deg, var(--navy) 0%, var(--navy-light) 100%);
        border-radius: var(--radius); padding: 28px 32px; display: flex; align-items: center; gap: 18px; margin-bottom: 28px; box-shadow: var(--shadow-md);
    }
    .hp-page-header .icon-wrap {
        width: 52px; height: 52px; background: rgba(255,255,255,0.12); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; color: #fff; flex-shrink: 0;
    }
    .hp-page-header h4 { color: #fff; margin: 0; font-weight: 700; font-size: 1.2rem; }
    .hp-page-header p  { color: rgba(255,255,255,0.65); margin: 0; font-size: 0.85rem; }

    .hp-section { background: var(--surface); border-radius: var(--radius); box-shadow: var(--shadow); margin-bottom: 20px; overflow: hidden; }
    .hp-section-header { padding: 18px 24px; border-bottom: 1px solid var(--border); display: flex; align-items: center; gap: 12px; background: var(--surface-2); }
    .hp-section-header .section-icon { width: 36px; height: 36px; border-radius: 9px; display: flex; align-items: center; justify-content: center; font-size: 0.95rem; flex-shrink: 0; }
    .hp-section-header h6 { margin: 0; font-size: 0.95rem; font-weight: 700; color: var(--text); }
    .hp-section-header p { margin: 0; font-size: 0.78rem; color: var(--text-muted); }
    .hp-section-body { padding: 24px; }

    .icon-info { background: #eff6ff; color: #2563eb; }
    .icon-desc { background: #fdf4ff; color: #9333ea; }
    .icon-image { background: #ecfdf5; color: #059669; }
    .icon-status { background: #fff1f2; color: #e11d48; }

    .hp-label { font-size: 0.8rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 6px; display: block; }
    .hp-input { width: 100%; padding: 10px 14px; border: 1.5px solid var(--border); border-radius: var(--radius-sm); font-size: 0.9rem; color: var(--text); background: #fff; outline: none; font-family: 'Plus Jakarta Sans', sans-serif; transition: 0.2s; }
    .hp-input:focus { border-color: var(--navy); box-shadow: 0 0 0 3px rgba(0,51,102,0.08); }
    .hp-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px; }

    .upload-zone { border: 2px dashed var(--border); border-radius: var(--radius-sm); padding: 22px 18px; text-align: center; background: var(--surface-2); position: relative; cursor: pointer; transition: 0.2s; }
    .upload-zone:hover { border-color: var(--navy); background: #f0f6ff; }
    .upload-zone input[type="file"] { position: absolute; inset: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer; z-index: 2; }
    .upload-zone .uz-icon { width: 40px; height: 40px; background: #e8effa; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px; font-size: 1rem; color: var(--navy); }
    .upload-zone .uz-label { font-size: 0.85rem; font-weight: 600; color: var(--text); margin-bottom: 3px; }
    .upload-zone .uz-hint { font-size: 0.75rem; color: var(--text-muted); }
    
    .media-strip { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 15px; }
    .media-strip img { width: 120px; height: 100px; object-fit: cover; border-radius: var(--radius-sm); border: 2px solid var(--border); box-shadow: 0 1px 4px rgba(0,0,0,0.08); }
    .media-strip-label { font-size: 0.75rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; margin-bottom: 8px; }

    .preview-grid { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 15px; justify-content: center; position: relative; z-index: 3; pointer-events: none; }
    .preview-item { pointer-events: auto; }
    .preview-item img { width: 90px; height: 90px; object-fit: cover; border-radius: 6px; border: 2px solid #fff; box-shadow: 0 2px 6px rgba(0,0,0,0.12); }

    .hp-save-bar { background: var(--surface); border-top: 1px solid var(--border); padding: 20px 24px; border-radius: 0 0 var(--radius) var(--radius); display: flex; align-items: center; justify-content: space-between; }
    .hp-btn-save { background: linear-gradient(135deg, var(--navy) 0%, #0a4a8a 100%); color: #fff; border: none; padding: 12px 28px; border-radius: 50px; font-size: 0.9rem; font-weight: 700; cursor: pointer; display: flex; align-items: center; gap: 8px; transition: 0.2s; font-family: 'Plus Jakarta Sans', sans-serif; }
    .hp-btn-save:hover { opacity: 0.9; transform: translateY(-1px); }
    .hp-btn-back { background: #fff; color: var(--text); border: 1px solid var(--border); padding: 12px 24px; border-radius: 50px; font-size: 0.9rem; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 8px; transition: 0.2s; text-decoration: none; }
    .hp-btn-back:hover { background: var(--surface-2); color: var(--text); }

    /* Toggle Switch */
    .hp-switch { display: flex; align-items: center; gap: 12px; cursor: pointer; }
    .hp-switch input { display: none; }
    .hp-switch .slider { width: 44px; height: 24px; background: #cbd5e1; border-radius: 24px; position: relative; transition: 0.3s; }
    .hp-switch .slider::after { content: ''; position: absolute; top: 3px; left: 3px; width: 18px; height: 18px; background: #fff; border-radius: 50%; transition: 0.3s; box-shadow: 0 2px 4px rgba(0,0,0,0.2); }
    .hp-switch input:checked + .slider { background: var(--success); }
    .hp-switch input:checked + .slider::after { transform: translateX(20px); }
    .hp-switch .label-text { font-size: 0.9rem; font-weight: 600; color: var(--text); }
</style>

<div class="hp-wrapper">
    <div class="hp-page-header">
        <div class="icon-wrap"><i class="fas fa-edit"></i></div>
        <div>
            <h4>Edit Galeri</h4>
            <p>Perbarui informasi dan gambar galeri di Geosite Danau Toba</p>
        </div>
    </div>

    <form action="{{ route('admin.galeri.update', $galeri->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Bagian 1: Informasi Dasar -->
        <div class="hp-section">
            <div class="hp-section-header">
                <div class="section-icon icon-info"><i class="fas fa-info"></i></div>
                <div>
                    <h6>Informasi Dasar</h6>
                    <p>Judul, lokasi, tanggal, dan pengelompokan geosite</p>
                </div>
            </div>
            <div class="hp-section-body">
                <div class="hp-grid-2">
                    <div>
                        <label class="hp-label">Judul Foto</label>
                        <input type="text" name="judul" class="hp-input" value="{{ old('judul', $galeri->judul) }}" required>
                    </div>
                    <div>
                        <label class="hp-label">Geosite</label>
                        <select name="geosite" class="hp-input" required>
                            <option value="">-- Pilih Geosite --</option>
                            @foreach($geositeList as $slug => $label)
                                <option value="{{ $slug }}" {{ (old('geosite', $galeri->geosite) == $slug) ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="hp-label">Lokasi</label>
                        <input type="text" name="lokasi" class="hp-input" value="{{ old('lokasi', $galeri->lokasi) }}">
                    </div>
                    <div>
                        <label class="hp-label">Tanggal Foto</label>
                        <input type="date" name="tanggal_foto" class="hp-input" value="{{ old('tanggal_foto', $galeri->tanggal_foto) }}">
                    </div>
                </div>
            </div>
        </div>

        <!-- Bagian 2: Deskripsi -->
        <div class="hp-section">
            <div class="hp-section-header">
                <div class="section-icon icon-desc"><i class="fas fa-align-left"></i></div>
                <div>
                    <h6>Deskripsi</h6>
                    <p>Penjelasan detail tentang foto atau momen ini</p>
                </div>
            </div>
            <div class="hp-section-body">
                <label class="hp-label">Teks Deskripsi</label>
                <textarea name="deskripsi" class="hp-input" rows="4" required>{{ old('deskripsi', $galeri->deskripsi) }}</textarea>
            </div>
        </div>

        <!-- Bagian 3: Gambar -->
        <div class="hp-section">
            <div class="hp-section-header">
                <div class="section-icon icon-image"><i class="fas fa-images"></i></div>
                <div>
                    <h6>Gambar Galeri</h6>
                    <p>Upload gambar baru (bisa lebih dari satu) atau biarkan kosong</p>
                </div>
            </div>
            <div class="hp-section-body">
                @php
                    $images = json_decode($galeri->gambar, true);
                    if (!is_array($images)) $images = $galeri->gambar ? [$galeri->gambar] : [];
                @endphp
                
                @if(count($images) > 0)
                <div class="media-strip-label">Gambar Saat Ini</div>
                <div class="media-strip">
                    @foreach($images as $img)
                        <img src="{{ str_starts_with($img, 'data:') ? $img : asset('storage/' . $img) }}" alt="Gambar">
                    @endforeach
                </div>
                @endif

                <label class="hp-label mt-3">Upload Gambar Baru (kosongkan jika tidak diubah)</label>
                <div class="upload-zone">
                    <input type="file" name="gambar[]" class="hp-input image-input" accept="image/jpeg,image/png,image/jpg,image/webp" multiple>
                    <div class="uz-icon"><i class="fas fa-cloud-upload-alt"></i></div>
                    <div class="uz-label">Klik atau Seret Gambar ke Sini</div>
                    <div class="uz-hint">Format: JPG, PNG, WEBP | Max: 4MB per gambar | Maksimal 10 gambar</div>
                    <div class="preview-grid" id="previewGrid"></div>
                </div>
            </div>
        </div>

                
        <div class="hp-save-bar">
            <a href="{{ route('admin.galeri.index') }}" class="hp-btn-back">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <button type="submit" class="hp-btn-save">
                <i class="fas fa-save"></i> Update Galeri
            </button>
        </div>
    </form>
</div>

<script>
    document.querySelector('.image-input').addEventListener('change', function(e) {
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



