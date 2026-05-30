@extends('layouts.admin')

@section('title', 'Konfigurasi Kontak')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap');

    :root {
        --navy: #003366;
        --navy-light: #0a4080;
        --gold: #c6a43b;
        --surface: #ffffff;
        --surface-2: #f8fafc;
        --border: #e2e8f0;
        --text: #1e293b;
        --text-muted: #64748b;
        --success: #22c55e;
        --radius: 14px;
        --radius-sm: 8px;
        --shadow: 0 1px 3px rgba(0,0,0,0.06), 0 4px 16px rgba(0,0,0,0.06);
        --shadow-md: 0 4px 24px rgba(0,51,102,0.10);
    }

    body, .card, .card-body, input, textarea, select {
        font-family: 'Plus Jakarta Sans', sans-serif !important;
    }

    .hp-wrapper {
        max-width: 960px;
        margin: 0 auto;
        padding: 0 0 60px;
    }

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
    .hp-section-body { padding: 24px; }

    .icon-info    { background: #eff6ff; color: #2563eb; }
    .icon-map     { background: #ecfdf5; color: #059669; }
    .icon-social  { background: #fef3c7; color: #d97706; }

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
    }
    .hp-input:focus {
        border-color: var(--navy);
        box-shadow: 0 0 0 3px rgba(0,51,102,0.08);
    }
    textarea.hp-input { resize: vertical; min-height: 90px; }

    .hp-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    @media(max-width:768px) {
        .hp-grid-2 { grid-template-columns: 1fr; }
    }
</style>

<div class="hp-wrapper">
    <div class="hp-page-header">
        <div class="icon-wrap"><i class="fas fa-address-book"></i></div>
        <div>
            <h4>Pengaturan Halaman Kontak</h4>
            <p>Kelola informasi kontak, alamat, sosial media, dan peta lokasi di halaman Kontak.</p>
        </div>
    </div>

    @if(session('success'))
    <div class="hp-alert">
        <i class="fas fa-check-circle"></i>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <form action="{{ route('admin.kontak.update') }}" method="POST">
        @csrf
        @method('PUT')

        <!-- 1. Informasi Dasar -->
        <div class="hp-section">
            <div class="hp-section-header">
                <div class="section-icon icon-info"><i class="fas fa-info-circle"></i></div>
                <div>
                    <h6>Informasi Dasar</h6>
                </div>
            </div>
            <div class="hp-section-body">
                <div class="hp-grid-2">
                    <div>
                        <label class="hp-label">Alamat</label>
                        <textarea name="alamat" class="hp-input" rows="4">{{ old('alamat', $kontak->alamat ?? '') }}</textarea>
                        <small style="color:var(--text-muted); font-size:0.75rem;">Gunakan enter (baris baru) untuk memisahkan baris.</small>
                    </div>
                    <div>
                        <label class="hp-label">Telepon</label>
                        <textarea name="telepon" class="hp-input" rows="4">{{ old('telepon', $kontak->telepon ?? '') }}</textarea>
                    </div>
                    <div>
                        <label class="hp-label">Email</label>
                        <textarea name="email" class="hp-input" rows="4">{{ old('email', $kontak->email ?? '') }}</textarea>
                    </div>
                    <div>
                        <label class="hp-label">Jam Operasional</label>
                        <textarea name="jam_operasional" class="hp-input" rows="4">{{ old('jam_operasional', $kontak->jam_operasional ?? '') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. Peta Lokasi -->
        <div class="hp-section">
            <div class="hp-section-header">
                <div class="section-icon icon-map"><i class="fas fa-map-marked-alt"></i></div>
                <div>
                    <h6>Peta & Lokasi</h6>
                </div>
            </div>
            <div class="hp-section-body">
                <div style="margin-bottom:14px;">
                    <label class="hp-label">Link Google Maps (Embed URL)</label>
                    <textarea name="map_iframe" class="hp-input" rows="3" placeholder="Contoh: https://www.google.com/maps/embed?pb=...">{{ old('map_iframe', $kontak->map_iframe ?? '') }}</textarea>
                    <small style="color:var(--text-muted); font-size:0.75rem;">Masukkan URL embed Google Maps Anda saja. Anda tidak perlu memasukkan semua kode &lt;iframe&gt;, cukup tautannya (link) saja.</small>
                </div>
                <div class="hp-grid-2">
                    <div>
                        <label class="hp-label">Teks Lokasi (Peta)</label>
                        <textarea name="map_lokasi" class="hp-input" rows="2">{{ old('map_lokasi', $kontak->map_lokasi ?? '') }}</textarea>
                    </div>
                    <div>
                        <label class="hp-label">Teks Lokasi Bawah</label>
                        <textarea name="lokasi_bawah" class="hp-input" rows="2">{{ old('lokasi_bawah', $kontak->lokasi_bawah ?? '') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3. Sosial Media -->
        <div class="hp-section">
            <div class="hp-section-header">
                <div class="section-icon icon-social"><i class="fas fa-share-alt"></i></div>
                <div>
                    <h6>Sosial Media</h6>
                </div>
            </div>
            <div class="hp-section-body hp-grid-2">
                <div>
                    <label class="hp-label">Facebook URL</label>
                    <input type="text" name="social_fb" class="hp-input" value="{{ old('social_fb', $kontak->social_fb ?? '') }}">
                </div>
                <div>
                    <label class="hp-label">Instagram URL</label>
                    <input type="text" name="social_ig" class="hp-input" value="{{ old('social_ig', $kontak->social_ig ?? '') }}">
                </div>
                <div>
                    <label class="hp-label">Twitter / X URL</label>
                    <input type="text" name="social_twitter" class="hp-input" value="{{ old('social_twitter', $kontak->social_twitter ?? '') }}">
                </div>
                <div>
                    <label class="hp-label">YouTube URL</label>
                    <input type="text" name="social_youtube" class="hp-input" value="{{ old('social_youtube', $kontak->social_youtube ?? '') }}">
                </div>
                <div>
                    <label class="hp-label">TikTok URL</label>
                    <input type="text" name="social_tiktok" class="hp-input" value="{{ old('social_tiktok', $kontak->social_tiktok ?? '') }}">
                </div>
            </div>
        </div>

        <!-- Submit -->
        <div style="text-align:right;">
            <button type="submit" class="btn btn-primary" style="background:var(--navy); border:none; padding:12px 30px; border-radius:10px; font-weight:600; font-family:'Plus Jakarta Sans',sans-serif;">
                <i class="fas fa-save me-2"></i> Simpan Perubahan
            </button>
        </div>

    </form>
</div>
@endsection
