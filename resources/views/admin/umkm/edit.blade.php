@extends('layouts.admin')

@section('title', 'Edit UMKM')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

    :root {
        --navy: #003366;
        --navy-light: #1a4a7a;
        --gold: #c6a43b;
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

    body, input, textarea, select, button {
        font-family: 'Plus Jakarta Sans', sans-serif !important;
    }

    .ep-wrapper {
        max-width: 100%;
        margin: 0;
        padding: 0 0 60px;
    }

    .hp-page-header {
        background: linear-gradient(135deg, var(--navy) 0%, var(--navy-light) 100%);
        border-radius: var(--radius);
        padding: 28px 32px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 18px;
        margin-bottom: 28px;
        box-shadow: var(--shadow-md);
        position: relative;
        overflow: hidden;
    }

    .hp-page-header::before {
        content: '';
        position: absolute;
        top: -40px;
        right: -40px;
        width: 160px;
        height: 160px;
        background: rgba(255,255,255,0.05);
        border-radius: 50%;
    }

    .hp-page-header::after {
        content: '';
        position: absolute;
        bottom: -30px;
        left: 120px;
        width: 100px;
        height: 100px;
        background: rgba(255,255,255,0.04);
        border-radius: 50%;
    }

    .hp-page-header-left {
        display: flex;
        align-items: center;
        gap: 18px;
        position: relative;
        z-index: 1;
    }

    .hp-page-header .icon-wrap {
        width: 52px;
        height: 52px;
        background: rgba(255,255,255,0.12);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        color: #fff;
        flex-shrink: 0;
    }

    .hp-page-header h4 {
        color: #fff;
        margin: 0;
        font-weight: 700;
        font-size: 1.2rem;
    }

    .hp-page-header p {
        color: rgba(255,255,255,0.65);
        margin: 0;
        font-size: 0.85rem;
    }

    .hp-btn-back {
        background: rgba(255,255,255,0.13);
        color: #fff;
        border: 1.5px solid rgba(255,255,255,0.25);
        padding: 9px 20px;
        border-radius: 50px;
        font-size: 0.82rem;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 7px;
        text-decoration: none;
        transition: background 0.2s;
        white-space: nowrap;
        position: relative;
        z-index: 1;
    }

    .hp-btn-back:hover {
        background: rgba(255,255,255,0.22);
        color: #fff;
    }

    .hp-section {
        background: var(--surface);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        margin-bottom: 20px;
        overflow: hidden;
    }

    .hp-section-header {
        padding: 18px 24px;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        gap: 12px;
        background: var(--surface-2);
    }

    .hp-section-header .section-icon {
        width: 36px;
        height: 36px;
        border-radius: 9px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.95rem;
        flex-shrink: 0;
    }

    .hp-section-header h6 {
        margin: 0;
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--text);
    }

    .hp-section-header p {
        margin: 0;
        font-size: 0.78rem;
        color: var(--text-muted);
    }

    .hp-section-body {
        padding: 24px;
    }

    .icon-info   { background: #eff6ff; color: #2563eb; }
    .icon-desc   { background: #f0fdf4; color: #16a34a; }
    .icon-detail { background: #fef3c7; color: #d97706; }
    .icon-media  { background: #fdf4ff; color: #9333ea; }

    .hp-label {
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 6px;
        display: block;
    }

    .hp-input {
        width: 100%;
        padding: 10px 14px;
        border: 1.5px solid var(--border);
        border-radius: var(--radius-sm);
        font-size: 0.9rem;
        color: var(--text);
        background: #fff;
        transition: border-color 0.2s, box-shadow 0.2s;
        outline: none;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .hp-input:focus {
        border-color: var(--navy);
        box-shadow: 0 0 0 3px rgba(0,51,102,0.08);
    }

    textarea.hp-input {
        resize: vertical;
        min-height: 110px;
    }

    .hp-error {
        font-size: 0.78rem;
        color: var(--danger);
        margin-top: 5px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .hp-input.is-invalid {
        border-color: var(--danger);
    }

    .hp-grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    @media(max-width: 768px) {
        .hp-grid-2 { grid-template-columns: 1fr; }
    }

    .upload-zone {
        border: 2px dashed var(--border);
        border-radius: var(--radius-sm);
        padding: 28px 18px;
        text-align: center;
        background: var(--surface-2);
        position: relative;
        cursor: pointer;
        transition: border-color 0.2s, background 0.2s;
    }

    .upload-zone:hover {
        border-color: var(--navy);
        background: #f0f6ff;
    }

    .upload-zone input[type="file"] {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
        z-index: 2;
    }

    .upload-zone .uz-icon {
        width: 48px;
        height: 48px;
        background: #e8effa;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 12px;
        font-size: 1.2rem;
        color: var(--navy);
    }

    .upload-zone .uz-label {
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--text);
        margin-bottom: 4px;
    }

    .upload-zone .uz-hint {
        font-size: 0.75rem;
        color: var(--text-muted);
    }

    .existing-preview-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 14px;
        margin-top: 12px;
        margin-bottom: 24px;
    }

    .existing-preview-grid .preview-item img {
        display: block;
        max-width: 100%;
        width: auto;
        height: auto;
        max-height: 280px;
        border-radius: 10px;
        border: 2px solid #fff;
        box-shadow: 0 4px 14px rgba(0,0,0,0.14);
    }

    .new-preview-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 16px;
        justify-content: center;
        position: relative;
        z-index: 3;
        pointer-events: none;
    }

    .new-preview-grid .preview-item {
        pointer-events: auto;
    }

    .new-preview-grid .preview-item img {
        display: block;
        width: auto;
        height: auto;
        max-width: 100%;
        max-height: 200px;
        border-radius: 8px;
        border: 2px solid #fff;
        box-shadow: 0 2px 8px rgba(0,0,0,0.12);
    }

    .hp-save-bar {
        background: var(--surface);
        border-top: 1px solid var(--border);
        padding: 20px 24px;
        border-radius: 0 0 var(--radius) var(--radius);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
    }

    .hp-save-hint {
        font-size: 0.78rem;
        color: var(--text-muted);
    }

    .hp-btn-save {
        background: linear-gradient(135deg, var(--navy) 0%, #0a4a8a 100%);
        color: #fff;
        border: none;
        padding: 12px 32px;
        border-radius: 50px;
        font-size: 0.9rem;
        font-weight: 700;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: opacity 0.2s, transform 0.1s;
        font-family: 'Plus Jakarta Sans', sans-serif;
        text-decoration: none;
    }

    .hp-btn-save:hover {
        opacity: 0.9;
        transform: translateY(-1px);
        color: #fff;
    }

    .hp-btn-cancel {
        background: var(--surface-2);
        color: var(--text-muted);
        border: 1.5px solid var(--border);
        padding: 11px 24px;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: border-color 0.2s, color 0.2s;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .hp-btn-cancel:hover {
        border-color: var(--text-muted);
        color: var(--text);
    }
</style>

<div class="ep-wrapper">

    {{-- Header halaman edit UMKM dengan tombol kembali ke daftar --}}
    <div class="hp-page-header">
        <div class="hp-page-header-left">
            <div class="icon-wrap"><i class="fas fa-store"></i></div>
            <div>
                <h4>Edit UMKM</h4>
                <p>Perbarui informasi dan data UMKM di Geosite Danau Toba</p>
            </div>
        </div>
        <a href="{{ route('admin.umkm.index') }}" class="hp-btn-back">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    {{-- Form edit UMKM: informasi dasar, deskripsi, lokasi/kontak, gambar, save bar --}}
    {{-- Menggunakan method PUT dengan enctype multipart untuk upload gambar --}}
    <form action="{{ route('admin.umkm.update', $data->id) }}" method="POST" enctype="multipart/form-data" id="formUmkm">
        @csrf
        @method('PUT')

        <div class="hp-section">
            <div class="hp-section-header">
                <div class="section-icon icon-info"><i class="fas fa-info-circle"></i></div>
                <div>
                    <h6>Informasi Dasar</h6>
                    <p>Nama UMKM dan geosite yang dituju</p>
                </div>
            </div>
            <div class="hp-section-body">
                <div class="hp-grid-2">
                    <div>
                        <label class="hp-label">Nama UMKM <span style="color:var(--danger)">*</span></label>
                        <input type="text" name="nama"
                            class="hp-input {{ $errors->has('nama') ? 'is-invalid' : '' }}"
                            value="{{ old('nama', $data->nama) }}"
                            placeholder="Masukkan nama UMKM" required>
                        @error('nama')
                            <div class="hp-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label class="hp-label">Geosite <span style="color:var(--danger)">*</span></label>
                        <select name="geosite"
                            class="hp-input {{ $errors->has('geosite') ? 'is-invalid' : '' }}" required>
                            <option value="">-- Pilih Geosite --</option>
                            @foreach($geositeList as $slug => $label)
                                <option value="{{ $slug }}" {{ old('geosite', $data->geosite) == $slug ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('geosite')
                            <div class="hp-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="hp-section">
            <div class="hp-section-header">
                <div class="section-icon icon-desc"><i class="fas fa-align-left"></i></div>
                <div>
                    <h6>Deskripsi UMKM</h6>
                    <p>Penjelasan singkat mengenai UMKM ini</p>
                </div>
            </div>
            <div class="hp-section-body">
                <div>
                    <label class="hp-label">Deskripsi <span style="color:var(--danger)">*</span></label>
                    <textarea name="deskripsi"
                        class="hp-input {{ $errors->has('deskripsi') ? 'is-invalid' : '' }}"
                        rows="4"
                        placeholder="Masukkan deskripsi UMKM" required>{{ old('deskripsi', $data->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <div class="hp-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="hp-section">
            <div class="hp-section-header">
                <div class="section-icon icon-detail"><i class="fas fa-map-marker-alt"></i></div>
                <div>
                    <h6>Lokasi dan Kontak</h6>
                    <p>Lokasi dan nomor kontak UMKM</p>
                </div>
            </div>
            <div class="hp-section-body">
                <div class="hp-grid-2">
                    <div>
                        <label class="hp-label">Lokasi</label>
                        <input type="text" name="lokasi"
                            class="hp-input {{ $errors->has('lokasi') ? 'is-invalid' : '' }}"
                            value="{{ old('lokasi', $data->lokasi) }}"
                            placeholder="cth: Desa Sibandang, Pulau Samosir">
                        @error('lokasi')
                            <div class="hp-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <label class="hp-label">Kontak</label>
                        <input type="text" name="kontak"
                            class="hp-input {{ $errors->has('kontak') ? 'is-invalid' : '' }}"
                            value="{{ old('kontak', $data->kontak) }}"
                            placeholder="cth: 0812-3456-7890">
                        @error('kontak')
                            <div class="hp-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Section gambar UMKM: tampilkan gambar tersimpan dan area upload baru --}}
        {{-- Gambar lama diambil dari JSON; gambar baru menggantikan gambar lama --}}
        <div class="hp-section">
            <div class="hp-section-header">
                <div class="section-icon icon-media"><i class="fas fa-image"></i></div>
                <div>
                    <h6>Gambar UMKM</h6>
                    <p>Unggah gambar utama untuk UMKM ini</p>
                </div>
            </div>
            <div class="hp-section-body">
                @php
                    /* Ambil dan normalisasi array gambar dari JSON */
                    $images = json_decode($data->gambar, true);
                    if (!is_array($images)) $images = $data->gambar ? [$data->gambar] : [];
                @endphp

                @if(count($images) > 0)
                <label class="hp-label">Gambar Saat Ini</label>
                <div class="existing-preview-grid">
                    @foreach($images as $img)
                        <div class="preview-item">
                            <img src="{{ str_starts_with($img, 'data:') ? $img : asset('storage/' . $img) }}" alt="Gambar">
                        </div>
                    @endforeach
                </div>
                @endif

                <label class="hp-label">Upload Gambar Baru (kosongkan jika tidak diubah)</label>
                <div class="upload-zone">
                    <input type="file" name="gambar"
                        class="{{ $errors->has('gambar') ? 'is-invalid' : '' }}"
                        accept="image/jpeg,image/png,image/jpg,image/webp"
                        id="inputGambar">
                    <div class="uz-icon"><i class="fas fa-image"></i></div>
                    <div class="uz-label">Klik atau Seret Gambar ke Sini</div>
                    <div class="uz-hint">Format: JPG, PNG, WEBP &nbsp;|&nbsp; Maks. 10MB per gambar</div>

                    <div class="new-preview-grid" id="previewGrid"></div>
                </div>
                @error('gambar')
                    <div class="hp-error" style="margin-top:8px;"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                @enderror
            </div>

            <div class="hp-save-bar">
                <span class="hp-save-hint"><i class="fas fa-lock me-1"></i> Perubahan UMKM akan langsung tersimpan ke sistem</span>
                <div style="display:flex; gap:10px; align-items:center;">
                    <a href="{{ route('admin.umkm.index') }}" class="hp-btn-cancel">
                        <i class="fas fa-times"></i> Batal
                    </a>
                    <button type="submit" class="hp-btn-save">
                        <i class="fas fa-save"></i> Update UMKM
                    </button>
                </div>
            </div>
        </div>

    </form>
</div>

{{-- Script preview gambar baru yang dipilih sebelum form disubmit --}}
<script>
    // Validasi ukuran file dan tampilkan thumbnail saat input file berubah
    document.getElementById('inputGambar').addEventListener('change', function(e) {
        const grid = document.getElementById('previewGrid');
        grid.innerHTML = '';
        const file = e.target.files[0];
        if (!file) return;
        if (file.size > 10 * 1024 * 1024) {
            alert('Gambar "' + file.name + '" melebihi batas maksimal 10MB!');
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