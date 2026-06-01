@extends('layouts.admin')

@section('title', 'Konfigurasi Homepage')

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

    /* ── Page Wrapper ── */
    .hp-wrapper {
        max-width: 100%;
        margin: 0;
        padding: 0 0 60px;
    }

    /* ── Page Header ── */
    .hp-page-header {
        background: linear-gradient(135deg, var(--navy) 0%, var(--navy-light) 100%);
        border-radius: var(--radius);
        padding: 28px 32px;
        display: flex;
        align-items: center;
        gap: 18px;
        margin-bottom: 28px;
        box-shadow: var(--shadow-md);
    }
    .hp-page-header .icon-wrap {
        width: 52px; height: 52px;
        background: rgba(255,255,255,0.12);
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.4rem; color: #fff; flex-shrink: 0;
    }
    .hp-page-header h4 { color: #fff; margin: 0; font-weight: 700; font-size: 1.2rem; }
    .hp-page-header p  { color: rgba(255,255,255,0.65); margin: 0; font-size: 0.85rem; }

    /* ── Alert ── */
    .hp-alert {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        border-left: 4px solid var(--success);
        border-radius: var(--radius-sm);
        padding: 14px 18px;
        color: #166534;
        font-size: 0.9rem;
        margin-bottom: 24px;
        display: flex; align-items: center; gap: 10px;
    }

    /* ── Section Card ── */
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
        width: 36px; height: 36px;
        border-radius: 9px;
        display: flex; align-items: center; justify-content: center;
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
    .hp-section-body { padding: 24px; }

    /* Icon colors per section */
    .icon-hero    { background: #eff6ff; color: #2563eb; }
    .icon-stats   { background: #fef3c7; color: #d97706; }
    .icon-about   { background: #f0fdf4; color: #16a34a; }
    .icon-titles  { background: #fdf4ff; color: #9333ea; }
    .icon-cta     { background: #fff1f2; color: #e11d48; }
    .icon-dest    { background: #ecfdf5; color: #059669; }

    /* ── Form Controls ── */
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
    textarea.hp-input { resize: vertical; min-height: 90px; }
    select.hp-input { cursor: pointer; }

    /* ── Grid helpers ── */
    .hp-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    .hp-grid-4 { display: grid; grid-template-columns: repeat(4,1fr); gap: 16px; }
    .hp-grid-3 { display: grid; grid-template-columns: 1fr 2fr; gap: 16px; }
    @media(max-width:768px) {
        .hp-grid-2, .hp-grid-4, .hp-grid-3 { grid-template-columns: 1fr; }
    }

    /* ── Stat card ── */
    .stat-card {
        background: var(--surface-2);
        border: 1.5px solid var(--border);
        border-radius: var(--radius-sm);
        padding: 16px;
        text-align: center;
    }
    .stat-card .stat-num {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--navy);
        line-height: 1;
        margin-bottom: 8px;
    }
    .stat-card-label { font-size: 0.75rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.06em; margin-bottom: 12px; }

    /* ── Upload Zone ── */
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
    .upload-zone:hover {
        border-color: var(--navy);
        background: #f0f6ff;
    }
    .upload-zone input[type="file"] {
        position: absolute; inset: 0;
        width: 100%; height: 100%;
        opacity: 0; cursor: pointer; z-index: 2;
    }
    .upload-zone .uz-icon {
        width: 40px; height: 40px;
        background: #e8effa;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 10px;
        font-size: 1rem; color: var(--navy);
    }
    .upload-zone .uz-label {
        font-size: 0.85rem;
        font-weight: 600;
        color: var(--text);
        margin-bottom: 3px;
    }
    .upload-zone .uz-hint {
        font-size: 0.75rem;
        color: var(--text-muted);
    }
    .upload-zone .uz-warn {
        font-size: 0.72rem;
        color: var(--danger);
        margin-top: 6px;
    }

    /* ── Current media strip ── */
    .media-strip {
        display: flex; flex-wrap: wrap; gap: 10px;
        margin-bottom: 10px;
    }
    .media-strip img, .media-strip video {
        width: 90px; height: 70px;
        object-fit: cover;
        border-radius: var(--radius-sm);
        border: 2px solid var(--border);
        box-shadow: 0 1px 4px rgba(0,0,0,0.08);
    }
    .media-strip-label {
        font-size: 0.72rem;
        font-weight: 600;
        color: var(--text-muted);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 6px;
    }

    /* ── Preview grid ── */
    .preview-grid {
        display: flex; flex-wrap: wrap; gap: 8px;
        margin-top: 10px;
        justify-content: center;
        position: relative; z-index: 3;
        pointer-events: none;
    }
    .preview-item { pointer-events: auto; }
    .preview-item img { width: 70px; height: 70px; object-fit: cover; border-radius: 6px; border: 2px solid #fff; box-shadow: 0 2px 6px rgba(0,0,0,0.12); }

    /* ── Destinasi card ── */
    .dest-card {
        border: 1.5px solid var(--border);
        border-radius: var(--radius);
        overflow: hidden;
        margin-bottom: 16px;
        background: var(--surface);
        box-shadow: var(--shadow);
    }
    .dest-card-header {
        background: linear-gradient(90deg, var(--navy) 0%, #0a4a8a 100%);
        padding: 12px 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .dest-card-header .dest-badge {
        background: rgba(255,255,255,0.18);
        color: #fff;
        font-size: 0.75rem;
        font-weight: 700;
        padding: 4px 10px;
        border-radius: 20px;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    .dest-card-header .dest-name {
        color: rgba(255,255,255,0.8);
        font-size: 0.82rem;
    }
    .dest-card-body { padding: 20px; }
    .dest-upload-col { }
    .dest-fields-col { }

    /* ── Save Button ── */
    .hp-save-bar {
        background: var(--surface);
        border-top: 1px solid var(--border);
        padding: 20px 24px;
        border-radius: 0 0 var(--radius) var(--radius);
        display: flex;
        align-items: center;
        justify-content: space-between;
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
        display: flex; align-items: center; gap: 8px;
        transition: opacity 0.2s, transform 0.1s;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }
    .hp-btn-save:hover { opacity: 0.9; transform: translateY(-1px); }
    .hp-btn-save:active { transform: translateY(0); }
    .hp-save-hint { font-size: 0.78rem; color: var(--text-muted); }

    /* section numbering pill */
    .step-pill {
        display: inline-flex; align-items: center; justify-content: center;
        width: 22px; height: 22px;
        background: var(--navy);
        color: #fff;
        font-size: 0.7rem;
        font-weight: 800;
        border-radius: 50%;
        flex-shrink: 0;
    }

    /* inline small-grid row for destinasi fields */
    .dest-fields-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }
    .dest-fields-grid .span-full { grid-column: 1 / -1; }
    @media(max-width:600px){ .dest-fields-grid { grid-template-columns: 1fr; } }
</style>

<div class="hp-wrapper">

    @if(session('success'))
    <div class="hp-alert">
        <i class="fas fa-check-circle"></i>
        {{ session('success') }}
    </div>
    @endif

    <!-- Page Header -->
    <div class="hp-page-header">
        <div class="icon-wrap"><i class="fas fa-home"></i></div>
        <div>
            <h4>Konfigurasi Homepage</h4>
            <p>Atur tampilan dan konten halaman utama website wisata</p>
        </div>
    </div>

    <form action="{{ route('admin.homepage.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- ════════ 1. HERO ════════ -->
        <div class="hp-section">
            <div class="hp-section-header">
                <div class="section-icon icon-hero"><i class="fas fa-star"></i></div>
                <div>
                    <h6>Hero / Banner Utama</h6>
                    <p>Judul, sub-judul, dan foto slideshow di bagian paling atas halaman</p>
                </div>
            </div>
            <div class="hp-section-body">
                <div class="hp-grid-2" style="margin-bottom:16px;">
                    <div>
                        <label class="hp-label">Judul Utama <span style="font-weight:400;text-transform:none;letter-spacing:0">(HTML seperti &lt;br&gt; diizinkan)</span></label>
                        <input type="text" name="hero_title" class="hp-input" value="{{ old('hero_title', $homepage->hero_title ?? 'BAKARA · TIPANG<br>BAKTIRAJA') }}">
                    </div>
                    <div>
                        <label class="hp-label">Sub-Judul</label>
                        <input type="text" name="hero_subtitle" class="hp-input" value="{{ old('hero_subtitle', $homepage->hero_subtitle ?? 'Kawasan Wisata Geopark Danau Toba') }}">
                    </div>
                </div>

                <label class="hp-label">Foto Slideshow (maks. 6 gambar)</label>

                @php $hasHeroSlides = false; @endphp
                @for($i = 1; $i <= 6; $i++)
                    @php $slideField = 'hero_slide_'.$i; @endphp
                    @if($homepage->$slideField) @php $hasHeroSlides = true; @endphp @endif
                @endfor

                @if($hasHeroSlides)
                <div class="media-strip-label">Foto saat ini</div>
                <div class="media-strip" style="margin-bottom:12px;">
                    @for($i = 1; $i <= 6; $i++)
                        @php $slideField = 'hero_slide_'.$i; @endphp
                        @if($homepage->$slideField)
                            <img src="{{ asset('storage/' . $homepage->$slideField) }}" alt="Slide {{ $i }}">
                        @endif
                    @endfor
                </div>
                @endif

                <div class="upload-zone">
                    <input type="file" name="hero_slides[]" class="hp-input image-input" accept="image/*" multiple data-preview-container="preview-hero-slides">
                    <div class="uz-icon"><i class="fas fa-images"></i></div>
                    <div class="uz-label">Klik untuk unggah hingga 6 foto sekaligus</div>
                    <div class="uz-hint">Format JPG, PNG, WEBP — disarankan rasio 16:9</div>
                    <div class="uz-warn"><i class="fas fa-exclamation-triangle me-1"></i>Mengunggah foto baru akan menggantikan seluruh kumpulan slide lama</div>
                    <div id="preview-hero-slides" class="preview-grid"></div>
                </div>
            </div>
        </div>

        <!-- ════════ 2. STATISTIK ════════ -->
        <div class="hp-section">
            <div class="hp-section-header">
                <div class="section-icon icon-stats"><i class="fas fa-chart-bar"></i></div>
                <div>
                    <h6>Statistik</h6>
                    <p>4 angka statistik yang tampil di bawah banner</p>
                </div>
            </div>
            <div class="hp-section-body">
                <div class="hp-grid-4">
                    @for($i = 1; $i <= 4; $i++)
                        @php
                            $numField   = 'stat_'.$i.'_num';
                            $labelField = 'stat_'.$i.'_label';
                            $defaultNum   = ['8', '3', '74.000', '15+'][$i-1];
                            $defaultLabel = ['DESTINASI', 'KATEGORI', 'TAHUN SEJARAH', 'WARISAN BUDAYA'][$i-1];
                        @endphp
                        <div class="stat-card">
                            <div class="stat-card-label">Statistik {{ $i }}</div>
                            <input type="text" name="{{ $numField }}" class="hp-input stat-num" style="text-align:center;font-weight:800;font-size:1.1rem;color:var(--navy);margin-bottom:8px;"
                                value="{{ old($numField, $homepage->$numField ?? $defaultNum) }}" placeholder="Angka">
                            <input type="text" name="{{ $labelField }}" class="hp-input" style="text-align:center;font-size:0.8rem;text-transform:uppercase;"
                                value="{{ old($labelField, $homepage->$labelField ?? $defaultLabel) }}" placeholder="Label">
                        </div>
                    @endfor
                </div>
            </div>
        </div>

        <!-- ════════ 3. ABOUT ════════ -->
        <div class="hp-section">
            <div class="hp-section-header">
                <div class="section-icon icon-about"><i class="fas fa-info-circle"></i></div>
                <div>
                    <h6>Tentang (About)</h6>
                    <p>Judul, deskripsi, dan video latar bagian pengenalan kawasan</p>
                </div>
            </div>
            <div class="hp-section-body">
                <div style="margin-bottom:16px;">
                    <label class="hp-label">Judul About</label>
                    <input type="text" name="about_title" class="hp-input" value="{{ old('about_title', $homepage->about_title ?? 'Bakara · Tipang · Baktiraja') }}">
                </div>
                <div class="hp-grid-2" style="margin-bottom:16px;">
                    <div>
                        <label class="hp-label">Paragraf 1</label>
                        <textarea name="about_text_1" class="hp-input" rows="4">{{ old('about_text_1', $homepage->about_text_1 ?? 'Kawasan wisata di Kabupaten Humbang Hasundutan, Sumatera Utara, yang menyimpan kekayaan alam, sejarah, dan budaya Batak yang luar biasa. Terdiri dari 8 destinasi unggulan yang tersebar di tiga desa: Bakara, Tipang, dan Baktiraja.') }}</textarea>
                    </div>
                    <div>
                        <label class="hp-label">Paragraf 2</label>
                        <textarea name="about_text_2" class="hp-input" rows="4">{{ old('about_text_2', $homepage->about_text_2 ?? 'Dari panorama Danau Toba di Panatapan Bakara, jejak perjuangan Raja Sisingamangaraja di Istana Sisingamangaraja, hingga khasiat penyembuhan Aek Sipangolu, setiap sudut kawasan ini menyimpan cerita dan keindahan yang tak terlupakan.') }}</textarea>
                    </div>
                </div>

                <label class="hp-label">Video About (MP4 / WEBM)</label>
                @if($homepage->about_video)
                <div class="media-strip-label">Video saat ini</div>
                <div class="media-strip" style="margin-bottom:10px;">
                    <video src="{{ asset('storage/' . $homepage->about_video) }}" controls style="width:200px;height:120px;"></video>
                </div>
                @endif
                <div class="upload-zone">
                    <input type="file" name="about_video" class="hp-input" accept="video/mp4,video/webm">
                    <div class="uz-icon"><i class="fas fa-video"></i></div>
                    <div class="uz-label">Klik untuk unggah video baru</div>
                    <div class="uz-hint">Biarkan kosong jika tidak ingin mengganti video</div>
                </div>
            </div>
        </div>

        <!-- ════════ 4. JUDUL SEKSI ════════ -->
        <div class="hp-section">
            <div class="hp-section-header">
                <div class="section-icon icon-titles"><i class="fas fa-heading"></i></div>
                <div>
                    <h6>Judul & Sub-judul Seksi</h6>
                    <p>Teks judul untuk bagian Destinasi dan Peta Lokasi</p>
                </div>
            </div>
            <div class="hp-section-body">
                <div class="hp-grid-2" style="margin-bottom:16px;">
                    <div>
                        <label class="hp-label">Judul Destinasi</label>
                        <input type="text" name="destinasi_title" class="hp-input" value="{{ old('destinasi_title', $homepage->destinasi_title ?? 'Destinasi Unggulan') }}">
                    </div>
                    <div>
                        <label class="hp-label">Sub-judul Destinasi</label>
                        <input type="text" name="destinasi_subtitle" class="hp-input" value="{{ old('destinasi_subtitle', $homepage->destinasi_subtitle ?? '8 destinasi wisata di kawasan Bakara · Tipang · Baktiraja') }}">
                    </div>
                </div>
                <div class="hp-grid-2">
                    <div>
                        <label class="hp-label">Judul Peta Lokasi</label>
                        <input type="text" name="maps_title" class="hp-input" value="{{ old('maps_title', $homepage->maps_title ?? 'Lokasi 3 Kawasan Wisata') }}">
                    </div>
                    <div>
                        <label class="hp-label">Sub-judul Peta Lokasi</label>
                        <input type="text" name="maps_subtitle" class="hp-input" value="{{ old('maps_subtitle', $homepage->maps_subtitle ?? 'Bakara · Tipang · Baktiraja - Kabupaten Humbang Hasundutan') }}">
                    </div>
                </div>
            </div>
        </div>

        <!-- ════════ 5. PETA LOKASI GOOGLE MAPS ════════ -->
        <div class="hp-section">
            <div class="hp-section-header">
                <div class="section-icon" style="background:#ecfdf5;color:#059669;"><i class="fas fa-map-marked-alt"></i></div>
                <div>
                    <h6>Peta Lokasi Google Maps</h6>
                    <p>Link peta yang akan ditampilkan di bagian Maps pada halaman utama website</p>
                </div>
            </div>
            <div class="hp-section-body">

                {{-- Panduan singkat cara menyalin link dari Google Maps --}}
                <div style="background:#eff6ff;border:1px solid #bfdbfe;border-left:4px solid #3b82f6;border-radius:8px;padding:14px 16px;margin-bottom:20px;font-size:0.82rem;color:#1d4ed8;">
                    <div style="font-weight:700;margin-bottom:6px;"><i class="fas fa-lightbulb" style="margin-right:6px;"></i>Cara mendapatkan link Maps:</div>
                    <ol style="margin:0;padding-left:18px;line-height:1.8;">
                        <li>Buka <strong>Google Maps</strong> di browser atau HP</li>
                        <li>Cari dan buka lokasi yang ingin ditampilkan</li>
                        <li>Klik tombol <strong>Bagikan</strong> (ikon share)</li>
                        <li>Salin link yang muncul (contoh: <code>https://maps.app.goo.gl/...</code>)</li>
                        <li>Tempel link tersebut di kolom di bawah ini, lalu klik <strong>Simpan</strong></li>
                    </ol>
                    <div style="margin-top:8px;padding-top:8px;border-top:1px solid #bfdbfe;font-size:0.78rem;color:#2563eb;">
                        <i class="fas fa-info-circle" style="margin-right:4px;"></i>
                        Sistem akan otomatis mengubah link apapun menjadi format embed yang benar. Preview peta akan muncul setelah Anda menekan Simpan.
                    </div>
                </div>

                {{-- Field input link Google Maps — menerima semua format URL --}}
                <div style="margin-bottom:16px;">
                    <label class="hp-label">Link Google Maps</label>
                    <input type="text" name="maps_link" class="hp-input"
                        value="{{ old('maps_link', $homepage->maps_link ?? '') }}"
                        placeholder="Tempel link Google Maps Anda di sini, contoh: https://maps.app.goo.gl/..."
                        style="font-size:0.84rem;"
                    >
                    @error('maps_link')
                        <div style="font-size:0.78rem;color:#ef4444;margin-top:5px;display:flex;align-items:center;gap:5px;">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </div>
                    @enderror
                    <small style="color:var(--text-muted);font-size:0.75rem;margin-top:5px;display:block;">
                        Mendukung semua format: link pendek (maps.app.goo.gl), link share panjang, atau URL embed langsung.
                    </small>
                </div>

                @if(!empty($homepage->maps_link))
                <div style="margin-top:4px;">
                    <label class="hp-label" style="margin-bottom:8px;">Preview Peta Tersimpan</label>
                    <div style="border-radius:10px;overflow:hidden;border:1.5px solid #e2e8f0;box-shadow:0 2px 12px rgba(0,0,0,0.07);">
                        <iframe
                            src="{{ $homepage->maps_link }}"
                            width="100%"
                            height="340"
                            style="border:none;display:block;"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                        ></iframe>
                    </div>
                    <small style="color:var(--text-muted);font-size:0.74rem;margin-top:6px;display:block;">
                        <i class="fas fa-check-circle" style="color:#22c55e;"></i>
                        Peta di atas sedang ditampilkan di halaman publik. Untuk menggantinya, masukkan link baru di kolom input dan simpan kembali.
                    </small>
                </div>
                @endif

                {{-- ─── CRUD TOMBOL LOKASI DI BAWAH PETA ─── --}}
                <div style="margin-top:28px;border-top:1.5px dashed #e2e8f0;padding-top:24px;">
                    <label class="hp-label" style="font-size:0.9rem;margin-bottom:4px;">
                        <i class="fas fa-map-pin" style="color:#c6a43b;margin-right:6px;"></i>
                        Tombol Lokasi di Bawah Peta
                    </label>
                    <p style="font-size:0.78rem;color:var(--text-muted);margin-bottom:14px;">
                        Tombol-tombol ini tampil di bawah peta di halaman publik dan mengarahkan pengunjung ke Google Maps. Klik <strong>+ Tambah Tombol</strong> untuk menambah tombol baru (maksimal 5).
                    </p>

                    {{-- Panduan cara mendapatkan link tombol --}}
                    <div style="background:#fefce8;border:1px solid #fde68a;border-left:4px solid #f59e0b;border-radius:8px;padding:11px 14px;margin-bottom:18px;font-size:0.78rem;color:#92400e;">
                        <i class="fas fa-lightbulb" style="margin-right:5px;"></i>
                        <strong>Cara mendapatkan link tombol:</strong> Buka Google Maps, cari lokasi, klik <strong>Bagikan</strong>, salin link pendek (contoh: <code>https://maps.app.goo.gl/...</code>), tempel di kolom Link di bawah ini.
                    </div>

                    {{-- Container daftar tombol yang bisa ditambah/hapus secara dinamis --}}
                    <div id="mapsBtnList" style="display:flex;flex-direction:column;gap:10px;margin-bottom:14px;">

                        @php
                            // Baca data tombol yang sudah tersimpan dari database untuk ditampilkan di form
                            $savedButtons = [];
                            if (!empty($homepage->maps_buttons)) {
                                $decoded = json_decode($homepage->maps_buttons, true);
                                if (is_array($decoded)) {
                                    $savedButtons = $decoded;
                                }
                            }
                            // Jika belum ada data tersimpan, tampilkan 3 baris kosong sebagai template awal
                            if (empty($savedButtons)) {
                                $savedButtons = [
                                    ['nama' => 'Bakara',    'link' => 'https://www.google.com/maps/search/?api=1&query=Bakara+Humbang+Hasundutan'],
                                    ['nama' => 'Tipang',    'link' => 'https://www.google.com/maps/search/?api=1&query=Tipang+Baktiraja'],
                                    ['nama' => 'Baktiraja', 'link' => 'https://www.google.com/maps/search/?api=1&query=Baktiraja+Humbang+Hasundutan'],
                                ];
                            }
                        @endphp

                        @foreach($savedButtons as $idx => $btn)
                        {{-- Setiap baris mewakili satu tombol dengan input Nama dan input Link --}}
                        <div class="maps-btn-row" style="display:grid;grid-template-columns:1fr 2fr auto;gap:10px;align-items:center;background:#f8fafc;border:1px solid #e2e8f0;border-radius:8px;padding:10px 12px;">
                            <div>
                                <label style="font-size:0.72rem;color:var(--text-muted);display:block;margin-bottom:4px;">Nama Tombol</label>
                                <input
                                    type="text"
                                    name="maps_buttons[{{ $idx }}][nama]"
                                    class="hp-input"
                                    value="{{ old('maps_buttons.'.$idx.'.nama', $btn['nama']) }}"
                                    placeholder="cth: Bakara"
                                    style="margin-bottom:0;"
                                >
                            </div>
                            <div>
                                <label style="font-size:0.72rem;color:var(--text-muted);display:block;margin-bottom:4px;">Link Google Maps (URL apa saja)</label>
                                <input
                                    type="text"
                                    name="maps_buttons[{{ $idx }}][link]"
                                    class="hp-input"
                                    value="{{ old('maps_buttons.'.$idx.'.link', $btn['link']) }}"
                                    placeholder="https://maps.app.goo.gl/..."
                                    style="margin-bottom:0;font-size:0.8rem;"
                                >
                            </div>
                            <div style="padding-top:18px;">
                                {{-- Tombol hapus: menghapus baris tombol dari tampilan (tidak dari DB sampai disimpan) --}}
                                <button type="button"
                                    onclick="this.closest('.maps-btn-row').remove(); reindexMapsButtons();"
                                    style="background:#fee2e2;color:#dc2626;border:none;border-radius:6px;width:34px;height:34px;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:0.85rem;"
                                    title="Hapus tombol ini">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </div>
                        @endforeach

                    </div>

                    {{-- Tombol untuk menambah baris tombol baru secara dinamis --}}
                    <button type="button" id="addMapsBtn"
                        onclick="addMapsBtnRow()"
                        style="display:inline-flex;align-items:center;gap:7px;background:#eff6ff;color:#1d4ed8;border:1.5px dashed #93c5fd;border-radius:8px;padding:9px 16px;font-size:0.8rem;font-weight:600;cursor:pointer;transition:all 0.2s;">
                        <i class="fas fa-plus"></i> Tambah Tombol Lokasi
                    </button>
                    <small style="display:block;margin-top:8px;color:var(--text-muted);font-size:0.74rem;">
                        <i class="fas fa-info-circle"></i> Maksimal 5 tombol. Nama yang kosong tidak akan disimpan.
                    </small>
                </div>

            </div>
        </div>


        <!-- ════════ 6. 8 DESTINASI ════════ -->
        <div class="hp-section">
            <div class="hp-section-header">
                <div class="section-icon icon-dest"><i class="fas fa-map-marker-alt"></i></div>
                <div>
                    <h6>8 Destinasi Unggulan</h6>
                    <p>Foto, judul, deskripsi, dan link untuk setiap destinasi yang tampil selang-seling</p>
                </div>
            </div>
            <div class="hp-section-body" style="padding-bottom:8px;">

                @foreach($homepage->destinasis as $dest)
                <div class="dest-card">
                    <div class="dest-card-header">
                        <span class="dest-badge">Destinasi {{ $loop->iteration }}</span>
                        <span class="dest-name">{{ $dest->judul ?? '—' }}</span>
                    </div>
                    <div class="dest-card-body">
                        <div style="display:grid;grid-template-columns:180px 1fr;gap:20px;align-items:start;">

                            <!-- Kolom Gambar -->
                            <div class="dest-upload-col">
                                <label class="hp-label">Foto Destinasi</label>
                                @if($dest->gambar)
                                <div class="media-strip" style="margin-bottom:8px;">
                                    <img src="{{ asset('storage/' . $dest->gambar) }}" alt="Destinasi {{ $loop->iteration }}" style="width:100%;height:110px;">
                                </div>
                                @endif
                                <div class="upload-zone" style="padding:14px 10px;">
                                    <input type="file" name="destinasi_gambar[{{ $dest->id }}]" class="hp-input image-input" accept="image/*" data-preview-container="preview-dest-{{$dest->id}}">
                                    <div class="uz-icon" style="width:32px;height:32px;font-size:0.85rem;"><i class="fas fa-image"></i></div>
                                    <div class="uz-label" style="font-size:0.78rem;">Ganti Foto</div>
                                    <div id="preview-dest-{{$dest->id}}" class="preview-grid"></div>
                                </div>
                            </div>

                            <!-- Kolom Fields -->
                            <div class="dest-fields-col">
                                <div class="dest-fields-grid">
                                    <div>
                                        <label class="hp-label">Teks Nomor</label>
                                        <input type="text" name="destinasi[{{ $dest->id }}][nomor_teks]" class="hp-input" value="{{ old('destinasi.'.$dest->id.'.nomor_teks', $dest->nomor_teks) }}" placeholder="cth: 01 — PANORAMA">
                                    </div>
                                    <div>
                                        <label class="hp-label">Judul</label>
                                        <input type="text" name="destinasi[{{ $dest->id }}][judul]" class="hp-input" value="{{ old('destinasi.'.$dest->id.'.judul', $dest->judul) }}">
                                    </div>
                                    <div class="span-full">
                                        <label class="hp-label">Lokasi (teks kecil)</label>
                                        <input type="text" name="destinasi[{{ $dest->id }}][lokasi]" class="hp-input" value="{{ old('destinasi.'.$dest->id.'.lokasi', $dest->lokasi) }}">
                                    </div>
                                    <div class="span-full">
                                        <label class="hp-label">Deskripsi Singkat</label>
                                        <textarea name="destinasi[{{ $dest->id }}][deskripsi]" class="hp-input" rows="2">{{ old('destinasi.'.$dest->id.'.deskripsi', $dest->deskripsi) }}</textarea>
                                    </div>
                                    <div>
                                        <label class="hp-label">Tags <span style="font-weight:400;text-transform:none">(pisahkan koma)</span></label>
                                        <input type="text" name="destinasi[{{ $dest->id }}][tags]" class="hp-input" value="{{ old('destinasi.'.$dest->id.'.tags', $dest->tags) }}" placeholder="cth: Alam,Sejuk">
                                    </div>
                                    <div>
                                        <label class="hp-label">Link Tombol "Jelajahi"</label>
                                        <select name="destinasi[{{ $dest->id }}][link]" class="hp-input">
                                            <option value="">Pilih halaman geosite...</option>
                                            <option value="/geosite/aek-sipangolu"         {{ old('destinasi.'.$dest->id.'.link', $dest->link) == '/geosite/aek-sipangolu'         ? 'selected' : '' }}>Aek Sipangolu</option>
                                            <option value="/geosite/aek-sitio-tio"         {{ old('destinasi.'.$dest->id.'.link', $dest->link) == '/geosite/aek-sitio-tio'         ? 'selected' : '' }}>Aek Sitio-tio</option>
                                            <option value="/geosite/air-terjun-janji"       {{ old('destinasi.'.$dest->id.'.link', $dest->link) == '/geosite/air-terjun-janji'       ? 'selected' : '' }}>Air Terjun Janji</option>
                                            <option value="/geosite/desa-wisata-tipang"     {{ old('destinasi.'.$dest->id.'.link', $dest->link) == '/geosite/desa-wisata-tipang'     ? 'selected' : '' }}>Desa Tipang</option>
                                            <option value="/geosite/gonting"                {{ old('destinasi.'.$dest->id.'.link', $dest->link) == '/geosite/gonting'                ? 'selected' : '' }}>Gonting</option>
                                            <option value="/geosite/istana-sisingamangaraja"{{ old('destinasi.'.$dest->id.'.link', $dest->link) == '/geosite/istana-sisingamangaraja'? 'selected' : '' }}>Istana Sisingamangaraja</option>
                                            <option value="/geosite/panatapan-bakara"       {{ old('destinasi.'.$dest->id.'.link', $dest->link) == '/geosite/panatapan-bakara'       ? 'selected' : '' }}>Panatapan Bakara</option>
                                            <option value="/geosite/tombak-sulu-sulu"       {{ old('destinasi.'.$dest->id.'.link', $dest->link) == '/geosite/tombak-sulu-sulu'       ? 'selected' : '' }}>Tombak Sulu-sulu</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                @endforeach

            </div>

            <!-- Save bar di bawah section terakhir -->
            <div class="hp-save-bar">
                <span class="hp-save-hint"><i class="fas fa-lock me-1"></i>Semua perubahan akan langsung diterapkan ke halaman publik</span>
                <button type="submit" class="hp-btn-save">
                    <i class="fas fa-save"></i> Simpan Konfigurasi
                </button>
            </div>
        </div>

    </form>
</div>

<script>
    document.querySelectorAll('.image-input').forEach(input => {
        input.addEventListener('change', function(e) {
            const containerId = this.getAttribute('data-preview-container');
            const container = document.getElementById(containerId);
            container.innerHTML = '';
            const files = e.target.files;
            if (files && files.length > 0) {
                Array.from(files).forEach(file => {
                    const reader = new FileReader();
                    reader.onload = function(ev) {
                        const imgContainer = document.createElement('div');
                        imgContainer.className = 'preview-item';
                        const img = document.createElement('img');
                        img.src = ev.target.result;
                        imgContainer.appendChild(img);
                        container.appendChild(imgContainer);
                    }
                    reader.readAsDataURL(file);
                });
            }
        });
    });

    /**
     * Fungsi untuk menambah baris tombol lokasi baru ke dalam form secara dinamis.
     * Baris baru dibuat dengan membuat elemen HTML secara programatik menggunakan JavaScript,
     * lalu ditambahkan ke dalam container #mapsBtnList.
     * Atribut name diatur dengan indeks yang benar menggunakan reindexMapsButtons().
     */
    function addMapsBtnRow() {
        const list  = document.getElementById('mapsBtnList');
        const count = list.querySelectorAll('.maps-btn-row').length;

        // Batasi tambah tombol jika sudah mencapai 5 agar sesuai validasi controller
        if (count >= 5) {
            alert('Maksimal 5 tombol lokasi yang dapat ditambahkan.');
            return;
        }

        // Membuat elemen div baris baru dengan struktur grid 3 kolom (nama, link, tombol hapus)
        const row = document.createElement('div');
        row.className = 'maps-btn-row';
        row.style.cssText = 'display:grid;grid-template-columns:1fr 2fr auto;gap:10px;align-items:center;background:#f8fafc;border:1px solid #e2e8f0;border-radius:8px;padding:10px 12px;';

        row.innerHTML = `
            <div>
                <label style="font-size:0.72rem;color:var(--text-muted);display:block;margin-bottom:4px;">Nama Tombol</label>
                <input type="text" name="maps_buttons[${count}][nama]" class="hp-input"
                    placeholder="cth: Bakara" style="margin-bottom:0;">
            </div>
            <div>
                <label style="font-size:0.72rem;color:var(--text-muted);display:block;margin-bottom:4px;">Link Google Maps (URL apa saja)</label>
                <input type="text" name="maps_buttons[${count}][link]" class="hp-input"
                    placeholder="https://maps.app.goo.gl/..." style="margin-bottom:0;font-size:0.8rem;">
            </div>
            <div style="padding-top:18px;">
                <button type="button"
                    onclick="this.closest('.maps-btn-row').remove(); reindexMapsButtons();"
                    style="background:#fee2e2;color:#dc2626;border:none;border-radius:6px;width:34px;height:34px;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:0.85rem;"
                    title="Hapus tombol ini">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </div>
        `;

        // Menambahkan baris baru ke paling bawah daftar
        list.appendChild(row);

        // Fokus otomatis ke input nama di baris yang baru dibuat
        row.querySelector('input[type="text"]').focus();
    }

    /**
     * Fungsi untuk memperbarui atribut name semua baris tombol agar indeksnya berurutan.
     * Ini penting karena ketika sebuah baris dihapus dari tengah, indeks array menjadi tidak
     * berurutan dan PHP akan salah membaca data form. Fungsi ini memastikan indeks selalu
     * dimulai dari 0 dan berurutan ke atas tanpa celah.
     */
    function reindexMapsButtons() {
        const rows = document.querySelectorAll('#mapsBtnList .maps-btn-row');
        rows.forEach(function(row, idx) {
            // Perbarui name untuk input nama tombol
            const namaInput = row.querySelector('input[name*="[nama]"]');
            if (namaInput) namaInput.name = `maps_buttons[${idx}][nama]`;

            // Perbarui name untuk input link tombol
            const linkInput = row.querySelector('input[name*="[link]"]');
            if (linkInput) linkInput.name = `maps_buttons[${idx}][link]`;
        });
    }

</script>

@endsection