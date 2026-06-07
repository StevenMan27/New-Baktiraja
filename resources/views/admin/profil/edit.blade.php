@extends('layouts.admin')

@section('title', 'Edit Profil Geosite')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');
    
    :root {
        --navy: #003366;
        --navy-light: #0a4080;
        --gold: #c6a43b;
        --gold-light: #f0d98a;
        --bg: #f0f4f8;
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

    body, .card, .card-body, input, textarea, select {
        font-family: 'Plus Jakarta Sans', sans-serif !important;
    }

    /* Wrapper halaman yang mengikuti lebar konten penuh tanpa batas tengah */
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

    /* Subjudul nama geosite di bawah judul header */
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
        font-family: 'Plus Jakarta Sans', sans-serif;
        position: relative;
        z-index: 1;
    }

    /* Efek hover tombol kembali */
    .hp-btn-back:hover {
        background: rgba(255,255,255,0.22);
        color: #fff;
    }

    /* Alert notifikasi sukses di bawah header */
    .hp-alert {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        border-left: 4px solid var(--success);
        border-radius: var(--radius-sm);
        padding: 14px 18px;
        color: #166534;
        font-size: 0.9rem;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* Card section pembungkus setiap kelompok input */
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

    /* Badge opsional di sisi kanan header section */
    .hp-section-header .badge-optional {
        margin-left: auto;
        background: #f1f5f9;
        color: var(--text-muted);
        border: 1px solid var(--border);
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
        padding: 3px 10px;
        letter-spacing: 0.03em;
    }

    /* Padding konten di dalam section card */
    .hp-section-body {
        padding: 24px;
    }

    /* Warna ikon section hero biru */
    .icon-hero     { background: #eff6ff; color: #2563eb; }

    /* Warna ikon section deskripsi tanpa gambar hijau */
    .icon-desc     { background: #f0fdf4; color: #16a34a; }

    /* Warna ikon section deskripsi dengan gambar ungu */
    .icon-desc-img { background: #fdf4ff; color: #9333ea; }

    /* Warna ikon section informasi praktis kuning */
    .icon-info     { background: #fef3c7; color: #d97706; }

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

    /* Input teks dan textarea standar */
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

    /* Textarea dengan tinggi minimum yang bisa diubah */
    textarea.hp-input {
        resize: vertical;
        min-height: 90px;
    }

    /* Wrapper input dengan ikon prefix di sisi kiri */
    .hp-input-group {
        display: flex;
        align-items: stretch;
    }

    /* Kotak ikon prefix di sisi kiri input group */
    .hp-input-group-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 13px;
        background: var(--surface-2);
        border: 1.5px solid var(--border);
        border-right: none;
        border-radius: var(--radius-sm) 0 0 var(--radius-sm);
        color: var(--text-muted);
        font-size: 0.85rem;
        flex-shrink: 0;
    }

    /* Input di dalam grup yang menyesuaikan border kiri */
    .hp-input-group .hp-input {
        border-radius: 0 var(--radius-sm) var(--radius-sm) 0;
    }

    /* Grid dua kolom untuk input berdampingan */
    .hp-grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    /* Grid tiga kolom untuk input berdampingan */
    .hp-grid-3 {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 16px;
    }

    /* Grid menjadi satu kolom di layar kecil */
    @media(max-width: 768px) {
        .hp-grid-2, .hp-grid-3 { grid-template-columns: 1fr; }
    }

    /* Area upload gambar dengan border dashed */
    .upload-zone {
        border: 2px dashed var(--border);
        border-radius: var(--radius-sm);
        padding: 22px 18px;
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

    /* Ikon di tengah upload zone */
    .upload-zone .uz-icon {
        width: 40px;
        height: 40px;
        background: #e8effa;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 10px;
        font-size: 1rem;
        color: var(--navy);
    }

    /* Teks label utama upload zone */
    .upload-zone .uz-label {
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--text);
        margin-bottom: 3px;
    }

    /* Teks petunjuk format gambar di upload zone */
    .upload-zone .uz-hint {
        font-size: 0.75rem;
        color: var(--text-muted);
    }

    /* Strip gambar yang sudah tersimpan sebelumnya */
    .media-strip {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 10px;
    }

    /* Setiap gambar di dalam media strip */
    .media-strip img {
        width: 100px;
        height: 75px;
        object-fit: cover;
        border-radius: var(--radius-sm);
        border: 2px solid var(--border);
        box-shadow: 0 1px 4px rgba(0,0,0,0.08);
    }

    /* Label kecil di atas media strip */
    .media-strip-label {
        font-size: 0.72rem;
        font-weight: 600;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 6px;
    }

    /* Grid preview gambar yang baru dipilih sebelum disimpan */
    .preview-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 10px;
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
        width: 70px;
        height: 70px;
        object-fit: cover;
        border-radius: 6px;
        border: 2px solid #fff;
        box-shadow: 0 2px 6px rgba(0,0,0,0.12);
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

    /* Tombol simpan semua perubahan berwarna biru */
    .hp-btn-save {
        background: linear-gradient(135deg, var(--navy) 0%, #0a4a8a 100%);
        color: #fff;
        border: none;
        padding: 12px 32px;
        border-radius: 50px;
        font-size: 0.9rem;
        font-weight: 700;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: opacity 0.2s, transform 0.1s;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    /* Efek hover tombol simpan sedikit terangkat */
    .hp-btn-save:hover {
        opacity: 0.9;
        transform: translateY(-1px);
    }

    /* Efek klik tombol simpan kembali ke posisi semula */
    .hp-btn-save:active {
        transform: translateY(0);
    }

    /* Teks petunjuk kecil di sisi kiri save bar */
    .hp-save-hint {
        font-size: 0.78rem;
        color: var(--text-muted);
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

    /* Garis pemisah antar kelompok input di section informasi */
    .info-divider {
        height: 1px;
        background: var(--border);
        margin: 20px 0;
    }

    /* Teks petunjuk kecil di bawah input tags */
    .tags-hint {
        font-size: 0.75rem;
        color: var(--text-muted);
        margin-top: 5px;
        display: flex;
        align-items: center;
        gap: 5px;
    }
</style>

<div class="ep-wrapper">

    {{-- Alert notifikasi setelah data berhasil disimpan --}}
    @if(session('success'))
    <div class="hp-alert">
        <i class="fas fa-check-circle"></i>
        {{ session('success') }}
    </div>
    @endif

    {{-- Banner header halaman dengan nama geosite dan tombol kembali --}}
    <div class="hp-page-header">
        <div class="hp-page-header-left">
            <div class="icon-wrap"><i class="fas fa-edit"></i></div>
            <div>
                <h4>Edit Profil Geosite</h4>
                <p>{{ $nama_geosite }}</p>
            </div>
        </div>
        {{-- Tombol kembali ke halaman daftar profil geosite --}}
        <a href="{{ route('admin.profil.index') }}" class="hp-btn-back">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    {{-- Form utama yang mengirimkan semua data profil geosite --}}
    <form action="{{ route('admin.profil.update', $profil->geosite) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Section 1: Bagian Hero dengan judul dan gambar latar --}}
        <div class="hp-section">
            <div class="hp-section-header">
                <div class="section-icon icon-hero"><i class="fas fa-star"></i></div>
                <div>
                    <h6>Bagian Utama (Hero)</h6>
                    <p>Judul, sub-judul, dan gambar latar belakang halaman geosite</p>
                </div>
            </div>
            <div class="hp-section-body">
                <div class="hp-grid-2" style="margin-bottom: 20px;">
                    <div>
                        <label class="hp-label">Judul Utama</label>
                        <input type="text" name="judul_utama" class="hp-input"
                            value="{{ old('judul_utama', $profil->judul_utama) }}"
                            placeholder="cth: PANATAPAN BAKARA">
                    </div>
                    <div>
                        <label class="hp-label">Sub Judul</label>
                        <input type="text" name="sub_judul" class="hp-input"
                            value="{{ old('sub_judul', $profil->sub_judul) }}"
                            placeholder="cth: Desa Bakara · Kec. Baktiraja">
                    </div>
                </div>

                <label class="hp-label">Gambar Latar Belakang (Hero)</label>

                {{-- Tampilkan gambar hero yang sudah tersimpan bila ada --}}
                @if($profil->bg_hero && is_array($profil->bg_hero) && count($profil->bg_hero) > 0)
                <div class="media-strip-label">Gambar saat ini</div>
                <div class="media-strip" style="margin-bottom: 12px;">
                    <img src="{{ asset('storage/' . $profil->bg_hero[0]) }}" alt="Hero background">
                </div>
                @endif

                {{-- Area upload gambar hero baru --}}
                <div class="upload-zone">
                    <input type="file" name="bg_hero" class="image-input" accept="image/*"
                        data-preview-container="preview-hero">
                    <div class="uz-icon"><i class="fas fa-image"></i></div>
                    <div class="uz-label">Klik atau seret gambar ke sini</div>
                    <div class="uz-hint">Format: JPG, PNG, WEBP — disarankan rasio 16:9 atau lebar</div>
                    <div id="preview-hero" class="preview-grid"></div>
                </div>
            </div>
        </div>

        {{-- Section 2: Deskripsi pertama tanpa gambar --}}
        <div class="hp-section">
            <div class="hp-section-header">
                <div class="section-icon icon-desc"><i class="fas fa-align-left"></i></div>
                <div>
                    <h6>Deskripsi 1</h6>
                    <p>Bagian teks pengenalan tanpa gambar</p>
                </div>
            </div>
            <div class="hp-section-body">
                <div style="margin-bottom: 16px;">
                    <label class="hp-label">Judul Deskripsi 1</label>
                    <input type="text" name="deskripsi_1_judul" class="hp-input"
                        value="{{ old('deskripsi_1_judul', $profil->deskripsi_1_judul) }}"
                        placeholder="cth: Panorama Spektakuler Danau Toba">
                </div>
                <div>
                    <label class="hp-label">Teks Deskripsi 1</label>
                    <textarea name="deskripsi_1_teks" class="hp-input" rows="5"
                        placeholder="Tuliskan teks deskripsi utama di sini...">{{ old('deskripsi_1_teks', $profil->deskripsi_1_teks) }}</textarea>
                </div>
            </div>
        </div>

        {{-- Section 3-6: Deskripsi 2 hingga 5 dengan gambar, diulang menggunakan loop --}}
        @for($i = 2; $i <= 5; $i++)
        @php
            $judulKey  = "deskripsi_{$i}_judul";
            $teksKey   = "deskripsi_{$i}_teks";
            $gambarKey = "deskripsi_{$i}_gambar";
        @endphp
        <div class="hp-section">
            <div class="hp-section-header">
                <div class="section-icon icon-desc-img"><i class="fas fa-images"></i></div>
                <div>
                    <h6>Deskripsi {{ $i }}</h6>
                    <p>Bagian dengan judul, teks, dan galeri gambar</p>
                </div>
                <span class="badge-optional">Opsional</span>
            </div>
            <div class="hp-section-body">
                <div style="margin-bottom: 16px;">
                    <label class="hp-label">Judul Deskripsi {{ $i }}</label>
                    <input type="text" name="{{ $judulKey }}" class="hp-input"
                        value="{{ old($judulKey, $profil->$judulKey) }}"
                        placeholder="Judul untuk bagian ini">
                </div>
                <div style="margin-bottom: 20px;">
                    <label class="hp-label">Teks Deskripsi {{ $i }}</label>
                    <textarea name="{{ $teksKey }}" class="hp-input" rows="4"
                        placeholder="Tuliskan penjelasan untuk bagian ini...">{{ old($teksKey, $profil->$teksKey) }}</textarea>
                </div>

                <label class="hp-label">Gambar Deskripsi {{ $i }}</label>

                {{-- Tampilkan gambar yang sudah tersimpan untuk deskripsi ini bila ada --}}
                @if($profil->$gambarKey && is_array($profil->$gambarKey))
                <div class="media-strip-label">Gambar saat ini</div>
                <div class="media-strip" style="margin-bottom: 12px;">
                    @foreach($profil->$gambarKey as $img)
                        <img src="{{ asset('storage/' . $img) }}" alt="Deskripsi {{ $i }}">
                    @endforeach
                </div>
                @endif

                {{-- Area upload gambar baru untuk deskripsi ini, mendukung multiple file --}}
                <div class="upload-zone">
                    <input type="file" name="{{ $gambarKey }}[]" class="image-input" accept="image/*" multiple
                        data-preview-container="preview-deskripsi-{{ $i }}">
                    <div class="uz-icon"><i class="fas fa-images"></i></div>
                    <div class="uz-label">Klik untuk unggah gambar (bisa lebih dari satu)</div>
                    <div class="uz-hint">Format: JPG, PNG, WEBP — maks. 4MB per gambar</div>
                    <div id="preview-deskripsi-{{ $i }}" class="preview-grid"></div>
                </div>
            </div>
        </div>
        @endfor

        {{-- Section terakhir: Informasi praktis dan tags pencarian --}}
        <div class="hp-section">
            <div class="hp-section-header">
                <div class="section-icon icon-info"><i class="fas fa-info-circle"></i></div>
                <div>
                    <h6>Informasi Praktis &amp; Tags</h6>
                    <p>Lokasi, jam operasional, harga tiket, dan kata kunci pencarian</p>
                </div>
            </div>
            <div class="hp-section-body">
                <div class="hp-grid-3" style="margin-bottom: 20px;">
                    <div>
                        <label class="hp-label">Lokasi</label>
                        <div class="hp-input-group">
                            <span class="hp-input-group-icon"><i class="fas fa-map-marker-alt"></i></span>
                            <input type="text" name="info_lokasi" class="hp-input"
                                value="{{ old('info_lokasi', $profil->info_lokasi) }}"
                                placeholder="cth: Desa Bakara">
                        </div>
                    </div>
                    <div>
                        <label class="hp-label">Jam Operasional</label>
                        <div class="hp-input-group">
                            <span class="hp-input-group-icon"><i class="fas fa-clock"></i></span>
                            <input type="text" name="info_jam" class="hp-input"
                                value="{{ old('info_jam', $profil->info_jam) }}"
                                placeholder="cth: 06:00 – 18:00 WIB">
                        </div>
                    </div>
                    <div>
                        <label class="hp-label">Harga Tiket</label>
                        <div class="hp-input-group">
                            <span class="hp-input-group-icon"><i class="fas fa-ticket-alt"></i></span>
                            <input type="text" name="info_harga" class="hp-input"
                                value="{{ old('info_harga', $profil->info_harga) }}"
                                placeholder="cth: Rp 5.000">
                        </div>
                    </div>
                </div>

                <div class="info-divider"></div>

                {{-- Field input link Google Maps — menerima semua format URL dari Google Maps --}}
                <div style="margin-bottom:20px;">
                    <label class="hp-label">Link Google Maps</label>

                    {{-- Panduan singkat cara menyalin link dari Google Maps --}}
                    <div style="background:#eff6ff;border:1px solid #bfdbfe;border-left:4px solid #3b82f6;border-radius:8px;padding:12px 14px;margin-bottom:12px;font-size:0.78rem;color:#1d4ed8;">
                        <div style="font-weight:700;margin-bottom:5px;"><i class="fas fa-lightbulb" style="margin-right:5px;"></i>Cara mendapatkan link Maps:</div>
                        <ol style="margin:0;padding-left:18px;line-height:1.8;">
                            <li>Buka <strong>Google Maps</strong>, cari lokasi geosite ini</li>
                            <li>Klik tombol <strong>Bagikan</strong> (ikon share)</li>
                            <li>Salin link yang muncul (contoh: <code>https://maps.app.goo.gl/...</code>)</li>
                            <li>Tempel link di kolom bawah, lalu klik <strong>Simpan Semua Perubahan</strong></li>
                        </ol>
                        <div style="margin-top:7px;padding-top:7px;border-top:1px solid #bfdbfe;font-size:0.75rem;">
                            <i class="fas fa-info-circle" style="margin-right:3px;"></i>
                            Sistem otomatis mengubah link apapun ke format embed. Preview muncul setelah Anda menyimpan.
                        </div>
                    </div>

                    <input type="text" name="maps_link" class="hp-input"
                        value="{{ old('maps_link', $profil->maps_link ?? '') }}"
                        placeholder="Tempel link Google Maps di sini, contoh: https://maps.app.goo.gl/..."
                        style="font-size:0.84rem;"
                    >

                    @error('maps_link')
                        <div style="font-size:0.78rem;color:#ef4444;margin-top:5px;display:flex;align-items:center;gap:5px;">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </div>
                    @enderror

                    <small style="color:var(--text-muted);font-size:0.75rem;margin-top:4px;display:block;">
                        Mendukung semua format: link pendek (maps.app.goo.gl), link share panjang, atau URL embed langsung.
                    </small>

                    
                    @if(!empty($profil->maps_link))
                    <div style="margin-top:12px;">
                        <label class="hp-label" style="margin-bottom:6px;">Preview Peta Tersimpan</label>
                        <div style="border-radius:10px;overflow:hidden;border:1.5px solid #e2e8f0;box-shadow:0 2px 12px rgba(0,0,0,0.07);">
                            <iframe
                                src="{{ $profil->maps_link }}"
                                width="100%"
                                height="300"
                                style="border:none;display:block;"
                                allowfullscreen=""
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"
                            ></iframe>
                        </div>
                        <small style="color:var(--text-muted);font-size:0.74rem;margin-top:6px;display:block;">
                            <i class="fas fa-check-circle" style="color:#22c55e;"></i>
                            Peta ini sedang ditampilkan di halaman publik geosite. Masukkan link baru dan simpan untuk menggantinya.
                        </small>
                    </div>
                    @endif
                </div>

                <div class="info-divider"></div>

                <div>
                    <label class="hp-label">Tags Pencarian</label>
                    <input type="text" name="tags" class="hp-input"
                        value="{{ is_array($profil->tags) ? implode(', ', $profil->tags) : old('tags') }}"
                        placeholder="cth: Panorama Danau, Sunrise, Sunset, Alam">
                    <p class="tags-hint">
                        <i class="fas fa-info-circle"></i>
                        Pisahkan setiap kata kunci menggunakan tanda koma (,)
                    </p>
                </div>
            </div>

            {{-- Save bar berisi tombol batal dan simpan di bagian bawah form --}}
            <div class="hp-save-bar">
                <span class="hp-save-hint"><i class="fas fa-lock me-1"></i>Semua perubahan akan langsung diterapkan ke halaman publik</span>
                <div style="display:flex; gap:10px; align-items:center;">
                    {{-- Tombol batal kembali ke halaman daftar profil --}}
                    <a href="{{ route('admin.profil.index') }}" class="hp-btn-cancel">Batal</a>
                    {{-- Tombol submit untuk menyimpan seluruh perubahan --}}
                    <button type="submit" class="hp-btn-save">
                        <i class="fas fa-save"></i> Simpan Semua Perubahan
                    </button>
                </div>
            </div>
        </div>

    </form>
</div>

{{-- Script preview gambar sebelum diupload, berjalan saat file dipilih --}}
<script>
document.querySelectorAll('.image-input').forEach(input => {
    input.addEventListener('change', function(e) {
        const containerId = this.getAttribute('data-preview-container');
        const container = document.getElementById(containerId);
        container.innerHTML = '';
        const files = e.target.files;
        if (files && files.length > 0) {
            Array.from(files).forEach(file => {
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(ev) {
                        const item = document.createElement('div');
                        item.className = 'preview-item';
                        const img = document.createElement('img');
                        img.src = ev.target.result;
                        item.appendChild(img);
                        container.appendChild(item);
                    };
                    reader.readAsDataURL(file);
                }
            });
        }
    });
});

</script>

@endsection