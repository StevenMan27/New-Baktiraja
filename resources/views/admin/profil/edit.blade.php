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

    /* ── Page Wrapper ── */
    .ep-wrapper {
        max-width: 960px;
        margin: 0 auto;
        padding: 0 0 60px;
    }

    /* ── Page Header ── */
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
    }
    .hp-page-header-left {
        display: flex;
        align-items: center;
        gap: 18px;
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
    .hp-btn-back {
        background: rgba(255,255,255,0.13);
        color: #fff;
        border: 1.5px solid rgba(255,255,255,0.25);
        padding: 9px 20px;
        border-radius: 50px;
        font-size: 0.82rem;
        font-weight: 600;
        cursor: pointer;
        display: flex; align-items: center; gap: 7px;
        text-decoration: none;
        transition: background 0.2s;
        white-space: nowrap;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }
    .hp-btn-back:hover { background: rgba(255,255,255,0.22); color: #fff; }

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
    .hp-section-body { padding: 24px; }

    /* Icon colors per section */
    .icon-hero    { background: #eff6ff; color: #2563eb; }
    .icon-desc    { background: #f0fdf4; color: #16a34a; }
    .icon-desc-img{ background: #fdf4ff; color: #9333ea; }
    .icon-info    { background: #fef3c7; color: #d97706; }

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
    .hp-input-group {
        display: flex;
        align-items: stretch;
    }
    .hp-input-group-icon {
        display: flex; align-items: center; justify-content: center;
        padding: 0 13px;
        background: var(--surface-2);
        border: 1.5px solid var(--border);
        border-right: none;
        border-radius: var(--radius-sm) 0 0 var(--radius-sm);
        color: var(--text-muted);
        font-size: 0.85rem;
        flex-shrink: 0;
    }
    .hp-input-group .hp-input {
        border-radius: 0 var(--radius-sm) var(--radius-sm) 0;
    }

    /* ── Grid helpers ── */
    .hp-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    .hp-grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px; }
    @media(max-width: 768px) {
        .hp-grid-2, .hp-grid-3 { grid-template-columns: 1fr; }
    }

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

    /* ── Current media strip ── */
    .media-strip {
        display: flex; flex-wrap: wrap; gap: 10px;
        margin-bottom: 10px;
    }
    .media-strip img {
        width: 100px; height: 75px;
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
    .preview-item img {
        width: 70px; height: 70px;
        object-fit: cover;
        border-radius: 6px;
        border: 2px solid #fff;
        box-shadow: 0 2px 6px rgba(0,0,0,0.12);
    }

    /* ── Description section numbering ── */
    .desc-section-num {
        display: inline-flex; align-items: center; justify-content: center;
        width: 22px; height: 22px;
        background: var(--navy);
        color: #fff;
        font-size: 0.7rem;
        font-weight: 800;
        border-radius: 50%;
        flex-shrink: 0;
    }

    /* ── Save Bar ── */
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
        display: inline-flex; align-items: center; gap: 6px;
        transition: border-color 0.2s, color 0.2s;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }
    .hp-btn-cancel:hover { border-color: var(--text-muted); color: var(--text); }

    /* ── Info field row (lokasi, jam, harga) ── */
    .info-divider {
        height: 1px;
        background: var(--border);
        margin: 20px 0;
    }
    .tags-hint {
        font-size: 0.75rem;
        color: var(--text-muted);
        margin-top: 5px;
        display: flex; align-items: center; gap: 5px;
    }
</style>

<div class="ep-wrapper">

    @if(session('success'))
    <div class="hp-alert">
        <i class="fas fa-check-circle"></i>
        {{ session('success') }}
    </div>
    @endif

    <!-- Page Header -->
    <div class="hp-page-header">
        <div class="hp-page-header-left">
            <div class="icon-wrap"><i class="fas fa-edit"></i></div>
            <div>
                <h4>Edit Profil Geosite</h4>
                <p>{{ $nama_geosite }}</p>
            </div>
        </div>
        <a href="{{ route('admin.profil.index') }}" class="hp-btn-back">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <form action="{{ route('admin.profil.update', $profil->geosite) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- ════════ 1. HERO ════════ -->
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

                @if($profil->bg_hero && is_array($profil->bg_hero) && count($profil->bg_hero) > 0)
                <div class="media-strip-label">Gambar saat ini</div>
                <div class="media-strip" style="margin-bottom: 12px;">
                    <img src="{{ asset('storage/' . $profil->bg_hero[0]) }}" alt="Hero background">
                </div>
                @endif

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

        <!-- ════════ 2. DESKRIPSI 1 (Tanpa Gambar) ════════ -->
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

        <!-- 3–6. DESKRIPSI 2–5 (Dengan Gambar) -->
        @for($i = 2; $i <= 5; $i++)
        @php
            $judulKey = "deskripsi_{$i}_judul";
            $teksKey  = "deskripsi_{$i}_teks";
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

                @if($profil->$gambarKey && is_array($profil->$gambarKey))
                <div class="media-strip-label">Gambar saat ini</div>
                <div class="media-strip" style="margin-bottom: 12px;">
                    @foreach($profil->$gambarKey as $img)
                        <img src="{{ asset('storage/' . $img) }}" alt="Deskripsi {{ $i }}">
                    @endforeach
                </div>
                @endif

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

        <!-- 7. INFORMASI PRAKTIS & TAGS -->
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

            <!-- Save Bar -->
            <div class="hp-save-bar">
                <span class="hp-save-hint"><i class="fas fa-lock me-1"></i>Semua perubahan akan langsung diterapkan ke halaman publik</span>
                <div style="display:flex; gap:10px; align-items:center;">
                    <a href="{{ route('admin.profil.index') }}" class="hp-btn-cancel">Batal</a>
                    <button type="submit" class="hp-btn-save">
                        <i class="fas fa-save"></i> Simpan Semua Perubahan
                    </button>
                </div>
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