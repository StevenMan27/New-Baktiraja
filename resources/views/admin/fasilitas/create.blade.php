@extends('layouts.admin')

@section('title', 'Tambah Fasilitas')

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

    /* Font global halaman menggunakan Plus Jakarta Sans */
    body, input, textarea, select, button {
        font-family: 'Plus Jakarta Sans', sans-serif !important;
    }

    /* Wrapper utama halaman tanpa batas tengah agar konten melebar penuh */
    .ep-wrapper {
        max-width: 100%;
        margin: 0;
        padding: 0 0 60px;
    }

    /* Banner header halaman dengan gradient biru gelap */
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

    /* Dekorasi lingkaran besar transparan di pojok kanan header */
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

    /* Dekorasi lingkaran kecil transparan di pojok kiri bawah header */
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

    /* Wrapper sisi kiri header yang menampung ikon dan teks judul */
    .hp-page-header-left {
        display: flex;
        align-items: center;
        gap: 18px;
        position: relative;
        z-index: 1;
    }

    /* Kotak ikon di sisi kiri header */
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

    /* Judul halaman di dalam header */
    .hp-page-header h4 {
        color: #fff;
        margin: 0;
        font-weight: 700;
        font-size: 1.2rem;
    }

    /* Subjudul kecil di bawah judul header */
    .hp-page-header p {
        color: rgba(255,255,255,0.65);
        margin: 0;
        font-size: 0.85rem;
    }

    /* Tombol kembali di sisi kanan header */
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

    /* Efek hover tombol kembali memperterang latar */
    .hp-btn-back:hover {
        background: rgba(255,255,255,0.22);
        color: #fff;
    }

    /* Card section pembungkus kelompok input */
    .hp-section {
        background: var(--surface);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        margin-bottom: 20px;
        overflow: hidden;
    }

    /* Header bagian atas setiap section card */
    .hp-section-header {
        padding: 18px 24px;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        gap: 12px;
        background: var(--surface-2);
    }

    /* Kotak ikon kecil di kiri header section */
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

    /* Judul section card */
    .hp-section-header h6 {
        margin: 0;
        font-size: 0.95rem;
        font-weight: 700;
        color: var(--text);
    }

    /* Deskripsi kecil di bawah judul section */
    .hp-section-header p {
        margin: 0;
        font-size: 0.78rem;
        color: var(--text-muted);
    }

    /* Padding konten di dalam body section */
    .hp-section-body {
        padding: 24px;
    }

    /* Warna ikon section informasi dasar biru */
    .icon-info { background: #eff6ff; color: #2563eb; }

    /* Warna ikon section gambar ungu */
    .icon-media { background: #fdf4ff; color: #9333ea; }

    /* Warna ikon section harga hijau toska */
    .icon-price { background: #f0fdfa; color: #0d9488; }

    /* Label di atas setiap input field */
    .hp-label {
        font-size: 0.8rem;
        font-weight: 600;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 6px;
        display: block;
    }

    /* Input teks, textarea, dan select standar */
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

    /* Efek fokus input menampilkan border biru dan shadow tipis */
    .hp-input:focus {
        border-color: var(--navy);
        box-shadow: 0 0 0 3px rgba(0,51,102,0.08);
    }

    /* Textarea dengan tinggi minimum yang bisa diubah secara vertikal */
    textarea.hp-input {
        resize: vertical;
        min-height: 100px;
    }

    /* Teks error validasi di bawah input */
    .hp-error {
        font-size: 0.78rem;
        color: var(--danger);
        margin-top: 5px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    /* Border merah pada input yang gagal validasi */
    .hp-input.is-invalid {
        border-color: var(--danger);
    }

    /* Grid dua kolom untuk input berdampingan */
    .hp-grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    /* Grid menjadi satu kolom di layar kecil */
    @media(max-width: 768px) {
        .hp-grid-2 { grid-template-columns: 1fr; }
    }

    /* Area upload gambar dengan border dashed */
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

    /* Efek hover area upload menampilkan border biru */
    .upload-zone:hover {
        border-color: var(--navy);
        background: #f0f6ff;
    }

    /* Input file tersembunyi di atas upload zone */
    .upload-zone input[type="file"] {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
        z-index: 2;
    }

    /* Ikon besar di tengah upload zone */
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

    /* Teks label utama upload zone */
    .upload-zone .uz-label {
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--text);
        margin-bottom: 4px;
    }

    /* Teks petunjuk format gambar di bawah label */
    .upload-zone .uz-hint {
        font-size: 0.75rem;
        color: var(--text-muted);
    }

    /* Grid preview gambar yang baru dipilih sebelum disimpan */
    .preview-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 16px;
        justify-content: center;
        position: relative;
        z-index: 3;
        pointer-events: none;
    }

    /* Item preview individual dalam grid */
    .preview-item {
        pointer-events: auto;
    }

    /* Gambar thumbnail di dalam item preview */
    .preview-item img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 8px;
        border: 2px solid #fff;
        box-shadow: 0 2px 8px rgba(0,0,0,0.12);
    }

    /* Bar simpan di bagian bawah form */
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

    /* Teks petunjuk kecil di sisi kiri save bar */
    .hp-save-hint {
        font-size: 0.78rem;
        color: var(--text-muted);
    }

    /* Tombol simpan berwarna biru gradient */
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

    /* Efek hover tombol simpan sedikit terangkat */
    .hp-btn-save:hover {
        opacity: 0.9;
        transform: translateY(-1px);
        color: #fff;
    }

    /* Tombol batal berwarna abu di samping tombol simpan */
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

    /* Efek hover tombol batal mempergelap border */
    .hp-btn-cancel:hover {
        border-color: var(--text-muted);
        color: var(--text);
    }
</style>

<div class="ep-wrapper">

    {{-- Banner header halaman dengan tombol kembali --}}
    <div class="hp-page-header">
        <div class="hp-page-header-left">
            <div class="icon-wrap"><i class="fas fa-concierge-bell"></i></div>
            <div>
                <h4>Tambah Fasilitas Baru</h4>
                <p>Isi nama, geosite, deskripsi, dan detail fasilitas</p>
            </div>
        </div>
        {{-- Tombol kembali ke halaman daftar fasilitas --}}
        <a href="{{ route('admin.fasilitas.index') }}" class="hp-btn-back">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    {{-- Form utama pengiriman data fasilitas baru --}}
    <form action="{{ route('admin.fasilitas.store') }}" method="POST" enctype="multipart/form-data" id="formFasilitas">
        @csrf

        {{-- Section informasi dasar nama, geosite, dan deskripsi --}}
        <div class="hp-section">
            <div class="hp-section-header">
                <div class="section-icon icon-info"><i class="fas fa-info-circle"></i></div>
                <div>
                    <h6>Informasi Dasar</h6>
                    <p>Nama, geosite, dan deskripsi fasilitas</p>
                </div>
            </div>
            <div class="hp-section-body">
                <div class="hp-grid-2" style="margin-bottom: 16px;">
                    <div>
                        <label class="hp-label">Nama Fasilitas <span style="color:var(--danger)">*</span></label>
                        <input type="text" name="nama"
                            class="hp-input {{ $errors->has('nama') ? 'is-invalid' : '' }}"
                            value="{{ old('nama') }}"
                            placeholder="Masukkan nama fasilitas" required>
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
                                <option value="{{ $slug }}" {{ old('geosite') == $slug ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('geosite')
                            <div class="hp-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="hp-label">Deskripsi <span style="color:var(--danger)">*</span></label>
                    <textarea name="deskripsi"
                        class="hp-input {{ $errors->has('deskripsi') ? 'is-invalid' : '' }}"
                        rows="4"
                        placeholder="Masukkan deskripsi fasilitas" required>{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <div class="hp-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Section upload gambar fasilitas --}}
        <div class="hp-section">
            <div class="hp-section-header">
                <div class="section-icon icon-media"><i class="fas fa-image"></i></div>
                <div>
                    <h6>Gambar</h6>
                    <p>Unggah gambar pendukung fasilitas</p>
                </div>
            </div>
            <div class="hp-section-body">
                {{-- Area upload dengan input file tersembunyi dan preview --}}
                <div class="upload-zone">
                    <input type="file" name="gambar"
                        class="{{ $errors->has('gambar') ? 'is-invalid' : '' }}"
                        accept="image/jpeg,image/png,image/jpg,image/webp"
                        id="inputGambar">
                    <div class="uz-icon"><i class="fas fa-image"></i></div>
                    <div class="uz-label">Klik atau Seret Gambar ke Sini</div>
                    <div class="uz-hint">Format: JPG, PNG, WEBP &nbsp;|&nbsp; Maks. 10MB</div>
                    <div class="preview-grid" id="previewGrid"></div>
                </div>
                @error('gambar')
                    <div class="hp-error" style="margin-top:8px;"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                @enderror
            </div>
        </div>

        {{-- Section harga fasilitas --}}
        <div class="hp-section">
            <div class="hp-section-header">
                <div class="section-icon icon-price"><i class="fas fa-tag"></i></div>
                <div>
                    <h6>Harga</h6>
                    <p>Informasi harga fasilitas yang tersedia</p>
                </div>
            </div>
            <div class="hp-section-body">
                <label class="hp-label">Harga</label>
                <input type="text" name="harga"
                    class="hp-input {{ $errors->has('harga') ? 'is-invalid' : '' }}"
                    value="{{ old('harga') }}"
                    placeholder="Contoh: Gratis / Rp 50.000">
                @error('harga')
                    <div class="hp-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                @enderror
            </div>

            {{-- Bar simpan di bagian bawah form --}}
            <div class="hp-save-bar">
                <span class="hp-save-hint"><i class="fas fa-lock me-1"></i> Data fasilitas akan langsung tersimpan ke sistem</span>
                <div style="display:flex; gap:10px; align-items:center;">
                    {{-- Tombol batal kembali ke halaman daftar fasilitas --}}
                    <a href="{{ route('admin.fasilitas.index') }}" class="hp-btn-cancel">
                        <i class="fas fa-times"></i> Batal
                    </a>
                    {{-- Tombol submit menyimpan data fasilitas baru --}}
                    <button type="submit" class="hp-btn-save">
                        <i class="fas fa-save"></i> Simpan Fasilitas
                    </button>
                </div>
            </div>
        </div>

    </form>
</div>

{{-- Script preview gambar sebelum diupload, berjalan saat file dipilih --}}
<script>
    document.getElementById('inputGambar').addEventListener('change', function(e) {
        const grid = document.getElementById('previewGrid');
        grid.innerHTML = '';
        const file = e.target.files[0];

        /* Hentikan proses jika tidak ada file yang dipilih */
        if (!file) return;

        /* Validasi ukuran file tidak melebihi 10MB */
        if (file.size > 10 * 1024 * 1024) {
            alert('Gambar "' + file.name + '" melebihi batas maksimal 10MB!');
            this.value = '';
            return;
        }

        /* Baca file sebagai URL data lalu tampilkan sebagai thumbnail preview */
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