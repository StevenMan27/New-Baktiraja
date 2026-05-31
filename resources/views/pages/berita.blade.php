@extends('layouts.app')

@section('title', 'Berita Terkini - Geosite Danau Toba')

@section('content')

<style>
    /* ========== VARIABEL WARNA DAN FONT GLOBAL ========== */
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap');

    :root {
        --primary: #003366;
        --primary-light: #1a4a7a;
        --primary-dark: #001f3f;
        --gold: #c6a43b;
        --gold-light: #f1d26b;
        --gold-dark: #967a28;
        --text-dark: #0f172a;
        --text-gray: #334155;
        --text-light: #64748b;
        --white: #ffffff;
        --bg-light: #f8fafc;
        --bg-gray: #f1f5f9;

        /* Bayangan bertingkat */
        --shadow-sm: 0 2px 8px rgba(0,0,0,0.04);
        --shadow-md: 0 10px 30px rgba(0,0,0,0.06);
        --shadow-xl: 0 25px 50px -12px rgba(15, 23, 42, 0.15);

        --radius-lg: 20px;
        --radius-md: 14px;
        --radius-sm: 8px;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Inter', sans-serif;
        color: var(--text-dark);
        background-color: var(--bg-light);
        -webkit-font-smoothing: antialiased;
    }

    /* ========== HERO SECTION ========== */
    .news-hero {
        background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary-light) 100%);
        padding: 80px 0 50px;
        margin-top: 70px;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    /* Efek lingkaran cahaya berputar di latar belakang hero */
    .news-hero::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 70%);
        animation: slowRotate 20s linear infinite;
    }

    @keyframes slowRotate {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    .news-hero-content {
        position: relative;
        z-index: 2;
    }

    /* Badge kecil di atas judul hero */
    .hero-badge {
        display: inline-block;
        background: rgba(198, 164, 59, 0.12);
        border: 1px solid rgba(198, 164, 59, 0.3);
        color: var(--gold-light);
        padding: 6px 20px;
        border-radius: 50px;
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 2px;
        text-transform: uppercase;
        margin-bottom: 20px;
    }

    .news-hero h1 {
        font-size: 2.8rem;
        font-weight: 700;
        font-family: 'Playfair Display', serif;
        color: white;
        margin-bottom: 10px;
        letter-spacing: 2px;
    }

    .news-hero p {
        font-size: 0.85rem;
        letter-spacing: 3px;
        text-transform: uppercase;
        color: rgba(255,255,255,0.8);
    }

    /* Garis emas kecil di bawah subjudul */
    .hero-divider {
        width: 50px;
        height: 3px;
        background: var(--gold);
        margin: 20px auto 0;
        border-radius: 4px;
    }

    /* ========== SECTION DAFTAR BERITA ========== */
    .news-section {
        padding: 60px 0 100px;
        background: linear-gradient(135deg, #f8fafc 0%, #eef2f8 100%);
        min-height: 100vh;
    }

    .container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 24px;
    }

    /* ========== SLIP CARD STYLE (KARTU BERITA TUMPUKAN) ========== */
    .stack-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 0;
        padding: 40px 0;
        position: relative;
    }

    /* Kartu berita yang saling tumpang tindih seperti slip/struk */
    .slip-card {
        position: relative;
        width: 280px;
        background: white;
        border-radius: 16px;
        overflow: hidden;
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.2, 0.9, 0.4, 1.1);
        box-shadow: 0 10px 20px -5px rgba(0,0,0,0.1), 0 0 0 1px rgba(0,0,0,0.02);
        margin-left: -60px;
    }

    .slip-card:first-child {
        margin-left: 0;
    }

    /* Saat hover, kartu naik ke atas dan membesar sedikit */
    .slip-card:hover {
        transform: translateY(-20px) scale(1.02);
        z-index: 100;
        box-shadow: 0 25px 40px -10px rgba(0,0,0,0.25);
    }

    /* Kartu di sebelah kanan juga bergeser saat card kiri di-hover */
    .slip-card:hover ~ .slip-card {
        transform: translateX(20px);
    }

    /* Area gambar di bagian atas kartu */
    .slip-image {
        position: relative;
        width: 100%;
        height: 320px;
        overflow: hidden;
        background: linear-gradient(135deg, #1e293b, #0f172a);
    }

    .slip-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    /* Gambar sedikit membesar saat card di-hover */
    .slip-card:hover .slip-image img {
        transform: scale(1.05);
    }

    /* Lapisan gelap semi-transparan di atas gambar, muncul saat hover */
    .slip-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.7), transparent);
        padding: 30px 16px 16px;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .slip-card:hover .slip-overlay {
        opacity: 1;
    }

    /* Label kategori kecil berwarna emas */
    .slip-category {
        display: inline-block;
        background: #c6a43b;
        color: #003366;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 0.6rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .slip-title-overlay {
        color: white;
        font-size: 0.85rem;
        font-weight: 600;
        margin-top: 8px;
        line-height: 1.3;
    }

    /* Area informasi di bawah gambar */
    .slip-info {
        padding: 16px;
        background: white;
        position: relative;
        border-top: 1px solid #f0f0f0;
    }

    /* Garis emas di atas info card yang muncul saat hover */
    .slip-line {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, #c6a43b, #e8c45a, #c6a43b);
        transform: scaleX(0);
        transition: transform 0.3s ease;
    }

    .slip-card:hover .slip-line {
        transform: scaleX(1);
    }

    .slip-title {
        font-size: 0.9rem;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 6px;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Cuplikan isi berita singkat di bawah judul */
    .slip-excerpt {
        font-size: 0.7rem;
        color: #64748b;
        line-height: 1.4;
        margin-bottom: 8px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Tanggal publikasi berita */
    .slip-date {
        font-size: 0.7rem;
        color: #94a3b8;
        display: flex;
        align-items: center;
        gap: 5px;
        margin-bottom: 4px;
    }

    .slip-date i {
        font-size: 0.65rem;
        color: #c6a43b;
    }

    /* Counter tampilan/views di sudut kiri bawah kartu */
    .slip-views {
        position: absolute;
        bottom: 12px;
        left: 16px;
        font-size: 0.6rem;
        color: #cbd5e1;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .slip-views i {
        font-size: 0.55rem;
        color: #c6a43b;
    }

    /* Nomor urut berita di sudut kanan bawah kartu */
    .slip-number {
        position: absolute;
        bottom: 12px;
        right: 16px;
        font-size: 0.6rem;
        color: #cbd5e1;
        font-family: monospace;
        letter-spacing: 1px;
    }

    /* ========== EMPTY STATE (Jika belum ada berita) ========== */
    .empty-news {
        text-align: center;
        padding: 80px;
        background: white;
        border-radius: 16px;
    }

    .empty-news i {
        font-size: 3rem;
        color: #cbd5e1;
        margin-bottom: 15px;
    }

    /* ========== FULL SCREEN MODAL READER ========== */
    /* Modal membuka dari bawah layar ke atas */
    #fullReader {
        position: fixed;
        top: 100%;
        left: 0;
        width: 100%;
        height: 100%;
        background: white;
        z-index: 99999;
        transition: top 0.7s cubic-bezier(0.86, 0, 0.07, 1);
        overflow-y: auto;
        visibility: hidden;
    }

    #fullReader.active {
        top: 0;
        visibility: visible;
    }

    /* Progress bar di bagian paling atas saat membaca */
    .progress-container {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: rgba(0,0,0,0.01);
        z-index: 100;
    }

    /* Garis berwarna emas yang menunjukkan seberapa jauh artikel sudah dibaca */
    .progress-bar {
        height: 4px;
        background: linear-gradient(90deg, var(--gold) 0%, var(--gold-light) 100%);
        width: 0%;
        transition: width 0.1s ease;
    }

    /* Navigasi sticky di atas modal reader */
    .reader-nav {
        padding: 20px 5%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: rgba(255,255,255,0.95);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        position: sticky;
        top: 0;
        z-index: 99;
        border-bottom: 1px solid rgba(0,0,0,0.05);
    }

    /* Logo GeoToba di navigasi modal */
    .reader-logo {
        font-family: 'Playfair Display', serif;
        font-size: 1.35rem;
        font-weight: 700;
        color: var(--primary-dark);
    }

    .reader-logo span {
        color: var(--gold);
    }

    /* Tombol bulat untuk menutup modal reader */
    .btn-close-reader {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: var(--bg-gray);
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        color: var(--text-dark);
        font-size: 0.85rem;
    }

    .btn-close-reader:hover {
        background: var(--primary-dark);
        color: var(--white);
        transform: rotate(90deg);
    }

    /* Area konten utama artikel di dalam modal */
    .reader-content-wrap {
        max-width: 850px;
        margin: 0 auto;
        padding: 40px 30px 60px;
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.6s ease 0.2s;
    }

    /* Konten artikel muncul dengan animasi fade-in dari bawah saat modal terbuka */
    #fullReader.active .reader-content-wrap {
        opacity: 1;
        transform: translateY(0);
    }

    /* Area header artikel di dalam modal */
    .reader-header {
        text-align: center;
        margin-bottom: 40px;
    }

    /* Label kategori artikel berwarna emas di bagian atas */
    .reader-category {
        display: inline-block;
        background: rgba(198, 164, 59, 0.08);
        color: var(--gold-dark);
        padding: 5px 16px;
        border-radius: 30px;
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        margin-bottom: 16px;
    }

    /* Tanggal publikasi artikel di header modal */
    .reader-date {
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 3px;
        color: #c6a43b;
        display: block;
        margin-bottom: 10px;
    }

    /* Judul besar artikel di dalam modal reader */
    .reader-title-display {
        font-family: 'Playfair Display', serif;
        font-size: 2.5rem;
        line-height: 1.25;
        color: var(--primary-dark);
        margin: 16px 0 20px;
        font-weight: 700;
    }

    /* Garis pembatas kecil berwarna emas di antara judul dan meta info */
    .reader-divider {
        width: 50px;
        height: 2px;
        background: #c6a43b;
        margin: 20px auto;
    }

    /* Baris informasi meta: penulis, tanggal, jumlah pembaca */
    .reader-meta {
        display: flex;
        justify-content: center;
        gap: 24px;
        font-size: 0.82rem;
        color: var(--text-light);
        flex-wrap: wrap;
        padding-bottom: 20px;
        border-bottom: 1px solid var(--bg-gray);
        margin-bottom: 10px;
    }

    .reader-meta span {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    /* Gambar utama artikel dengan sudut melengkung dan bayangan */
    .reader-hero-img {
        width: 100%;
        height: auto;
        max-height: 500px;
        object-fit: cover;
        border-radius: 16px;
        margin: 30px 0 40px;
        box-shadow: 0 16px 40px rgba(0,0,0,0.12);
    }

    /* Area isi teks artikel */
    .reader-article-body {
        font-family: 'Inter', sans-serif;
        font-size: 1rem;
        line-height: 1.9;
        color: #2c3e50;
        text-align: left;
    }

    .reader-article-body p {
        margin-bottom: 1.4rem;
        text-align: justify;
    }

    /* Judul di dalam teks artikel yang berasal dari editor admin */
    .reader-article-body h1,
    .reader-article-body h2,
    .reader-article-body h3,
    .reader-article-body h4 {
        color: var(--primary-dark);
        font-family: 'Playfair Display', serif;
        font-weight: 700;
        line-height: 1.35;
        margin: 1.8rem 0 0.8rem;
    }

    .reader-article-body h2 {
        font-size: 1.5rem;
        border-left: 3px solid var(--gold);
        padding-left: 12px;
    }

    /* Gambar di dalam teks artikel menyesuaikan lebar kontainer */
    .reader-article-body img {
        max-width: 100%;
        height: auto;
        border-radius: var(--radius-sm);
        margin: 20px auto;
        display: block;
    }

    /* Kutipan teks dalam artikel */
    .reader-article-body blockquote {
        border-left: 3px solid var(--gold);
        padding: 16px 24px;
        margin: 30px 0;
        background: var(--bg-light);
        border-radius: 0 var(--radius-sm) var(--radius-sm) 0;
        font-style: italic;
        color: var(--primary-light);
        font-family: 'Playfair Display', serif;
    }

    /* Footer di dalam modal reader berisi tombol kembali dan bagikan */
    .reader-footer {
        margin: 60px 0 0;
        text-align: center;
        border-top: 1px solid #eee;
        padding-top: 40px;
        display: flex;
        justify-content: center;
        gap: 15px;
    }

    /* Tombol kembali ke daftar berita */
    .btn-back-reader {
        background: var(--primary-dark);
        color: white;
        padding: 12px 32px;
        border-radius: 40px;
        border: none;
        font-size: 12px;
        letter-spacing: 1px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .btn-back-reader:hover {
        background: var(--gold-dark);
        transform: translateY(-3px);
    }

    /* Tombol bagikan artikel */
    .btn-share-reader {
        background: transparent;
        color: var(--primary-dark);
        padding: 12px 32px;
        border-radius: 40px;
        border: 1px solid rgba(0, 31, 63, 0.15);
        font-size: 12px;
        letter-spacing: 1px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .btn-share-reader:hover {
        background: var(--bg-light);
        border-color: var(--primary-dark);
        transform: translateY(-3px);
    }

    /* ========== RESPONSIVE DESIGN ========== */
    @media (max-width: 1200px) {
        .slip-card { width: 240px; }
        .slip-image { height: 280px; }
    }

    @media (max-width: 992px) {
        .stack-container {
            justify-content: center;
            flex-wrap: wrap;
            gap: 20px;
        }
        .slip-card { margin-left: 0 !important; width: 260px; }
        .slip-card:hover ~ .slip-card { transform: none; }
        .slip-card:hover { transform: translateY(-10px); }
    }

    @media (max-width: 768px) {
        .slip-card { width: calc(50% - 8px); }
        .slip-image { height: 260px; }
        .news-hero h1 { font-size: 2rem; }
        .reader-title-display { font-size: 1.6rem; }
        .reader-content-wrap { padding: 20px; }
        .reader-meta { gap: 14px; }
    }

    @media (max-width: 560px) {
        .slip-card { width: 100%; }
        .slip-image { height: 280px; }
    }
</style>

{{-- ========== HERO SECTION ========== --}}
<div class="news-hero">
    <div class="news-hero-content">
        <div class="hero-badge">UPDATE TERBARU</div>
        <h1>Berita Terkini</h1>
        <p>Informasi & Perkembangan Terbaru Geopark Danau Toba</p>
        <div class="hero-divider"></div>
    </div>
</div>

{{-- ========== SECTION DAFTAR KARTU BERITA ========== --}}
<section class="news-section">
    <div class="container">
        <div class="stack-container">
            @php $counter = 1; @endphp
            @forelse($berita as $item)
                @php
                    // Menentukan sumber gambar berita: base64, URL eksternal, atau dari storage lokal
                    $imageSrc = \App\Helpers\ImageHelper::getFirstImage($item->gambar);
                    if (!$imageSrc) {
                        $imageSrc = asset('image/default.jpg');
                    }

                    // Membuat cuplikan teks pendek dari isi konten untuk pratinjau di kartu
                    $excerpt = strip_tags($item->konten);
                    $excerpt = \Illuminate\Support\Str::limit($excerpt, 80);
                @endphp

                {{-- Setiap kartu berita, saat diklik akan memanggil fungsi openReader --}}
                <div class="slip-card" onclick="openReader({{ $item->id }})">
                    <div class="slip-image">
                        <img src="{{ $imageSrc }}"
                             alt="{{ $item->judul }}"
                             loading="lazy"
                             onerror="this.onerror=null;this.src='{{ asset('image/default.jpg') }}'">
                        <div class="slip-overlay">
                            <span class="slip-category">BERITA</span>
                            <div class="slip-title-overlay">{{ Str::limit($item->judul, 35) }}</div>
                        </div>
                    </div>
                    <div class="slip-info">
                        <div class="slip-line"></div>
                        <div class="slip-title">{{ Str::limit($item->judul, 30) }}</div>
                        <div class="slip-excerpt">{{ $excerpt }}</div>
                        <div class="slip-date">
                            <i class="fas fa-calendar-alt"></i>
                            <span>{{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d M Y') }}</span>
                        </div>
                        {{-- Counter views ditampilkan dan akan diperbarui secara langsung setelah modal dibuka --}}
                        <div class="slip-views" id="views-{{ $item->id }}">
                            <i class="fas fa-eye"></i>
                            <span>{{ number_format($item->views ?? 0) }}</span>
                        </div>
                        <div class="slip-number">#{{ str_pad($counter, 3, '0', STR_PAD_LEFT) }}</div>
                    </div>
                </div>
                @php $counter++; @endphp
            @empty
                <div class="empty-news">
                    <i class="fas fa-newspaper"></i>
                    <h3>Belum Ada Berita</h3>
                    <p style="color: #999; margin-top: 10px;">Silakan tambah berita melalui panel admin.</p>
                </div>
            @endforelse
        </div>

        @if(method_exists($berita, 'links'))
        <div style="display:flex;justify-content:center;margin-top:40px;">
            {{ $berita->links() }}
        </div>
        @endif
    </div>
</section>

{{-- ========== MODAL READER PREMIUM (TAMPILAN DETAIL BERITA) ========== --}}
<div id="fullReader">
    {{-- Progress bar menunjukkan seberapa jauh artikel sudah digulir --}}
    <div class="progress-container">
        <div class="progress-bar" id="myBar"></div>
    </div>

    {{-- Navigasi sticky di atas modal dengan logo dan tombol tutup --}}
    <div class="reader-nav">
        <div class="reader-logo">Geo<span>Toba</span></div>
        <button class="btn-close-reader" onclick="closeReader()" title="Tutup artikel">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <div class="reader-content-wrap">
        {{-- Header artikel: kategori, tanggal, judul, garis, dan meta info --}}
        <div class="reader-header">
            <span class="reader-category">BERITA</span>
            <span class="reader-date" id="r-date"></span>
            <h1 id="r-title" class="reader-title-display"></h1>
            <div class="reader-divider"></div>
            {{-- Baris meta berisi penulis, tanggal, dan jumlah pembaca --}}
            <div class="reader-meta" id="r-meta"></div>
        </div>

        {{-- Gambar utama artikel --}}
        <img id="r-img" src="" class="reader-hero-img" alt="">

        {{-- Isi konten artikel lengkap yang diambil dari database --}}
        <div id="r-content" class="reader-article-body"></div>

        {{-- Footer modal berisi tombol kembali dan tombol bagikan --}}
        <div class="reader-footer">
            <button class="btn-back-reader" onclick="closeReader()">
                <i class="fas fa-arrow-left"></i> Kembali ke Berita
            </button>
            <button class="btn-share-reader" onclick="bagikanBerita()">
                <i class="fas fa-share-alt"></i> Bagikan Artikel
            </button>
        </div>
    </div>
</div>

<script>
    // Menyimpan seluruh data berita dari server ke variabel JavaScript
    // sehingga modal bisa diisi konten tanpa perlu reload halaman
    const newsData = @json($berita->items());

    /**
     * Fungsi openReader: membuka modal reader dan menampilkan detail berita
     * yang dipilih berdasarkan id, sekaligus mengirim permintaan ke server
     * untuk menambah jumlah pembaca (views) secara real-time via AJAX.
     */
    async function openReader(id) {
        // Cari data berita yang sesuai dengan id yang diklik
        const item = newsData.find(x => x.id === id);
        if (!item) return;

        // Menentukan sumber gambar berdasarkan format penyimpanannya
        let imgSrc = '{{ asset("image/default.jpg") }}';
        if (item.gambar && item.gambar.trim() !== '') {
            if (item.gambar.startsWith('data:image') || item.gambar.startsWith('http')) {
                imgSrc = item.gambar;
            } else {
                // Gambar yang disimpan di storage lokal Laravel
                imgSrc = '{{ asset("storage") }}/' + item.gambar;
            }
        }

        // Memformat tanggal ke format Indonesia, contoh: 15 Januari 2025
        const tgl = new Date(item.created_at);
        const tanggalFormatted = tgl.toLocaleDateString('id-ID', {
            day: 'numeric', month: 'long', year: 'numeric'
        });

        // Mengisi seluruh elemen HTML di dalam modal dengan data artikel
        document.getElementById('r-title').innerText   = item.judul;
        document.getElementById('r-content').innerHTML = item.konten;
        document.getElementById('r-img').src           = imgSrc;
        document.getElementById('r-date').innerText    = tanggalFormatted;

        // Mengisi baris meta informasi artikel (penulis, tanggal, views sementara)
        document.getElementById('r-meta').innerHTML = `
            <span><i class="far fa-calendar"></i> ${tanggalFormatted}</span>
            <span><i class="far fa-user"></i> ${item.penulis || 'Admin GeoToba'}</span>
            <span><i class="far fa-eye"></i> <span id="modalViews">${(item.views || 0).toLocaleString()}</span> dibaca</span>
        `;

        // Mengaktifkan modal dan mengunci scroll halaman utama
        const reader = document.getElementById('fullReader');
        reader.classList.add('active');
        document.body.style.overflow = 'hidden';

        // Mengatur ulang posisi scroll dan progress bar ke posisi awal
        reader.scrollTop = 0;
        document.getElementById('myBar').style.width = '0%';

        // Mengirim permintaan POST ke server untuk menambah +1 pada jumlah pembaca
        // Counter di kartu berita dan di dalam modal akan diperbarui secara langsung
        try {
            const response = await fetch('/api/berita/' + id + '/view', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            });
            const data = await response.json();

            if (data.success) {
                // Memperbarui tampilan counter di kartu berita pada halaman list
                const viewsEl = document.getElementById('views-' + id);
                if (viewsEl) {
                    viewsEl.innerHTML = `<i class="fas fa-eye"></i> <span>${data.views.toLocaleString()}</span>`;
                }
                // Memperbarui tampilan counter di dalam modal reader
                const modalViews = document.getElementById('modalViews');
                if (modalViews) {
                    modalViews.innerText = data.views.toLocaleString();
                }
            }
        } catch (err) {
            // Jika terjadi kesalahan jaringan, modal tetap terbuka namun counter tidak diperbarui
            console.error('Gagal memperbarui jumlah pembaca:', err);
        }
    }

    /**
     * Fungsi closeReader: menutup modal reader dan mengembalikan
     * kemampuan scroll pada halaman utama.
     */
    function closeReader() {
        const reader = document.getElementById('fullReader');
        reader.classList.remove('active');
        document.body.style.overflow = 'auto';
    }

    /**
     * Fungsi bagikanBerita: membagikan tautan artikel menggunakan
     * Web Share API jika tersedia di browser, atau menyalin tautan
     * ke clipboard sebagai alternatif.
     */
    function bagikanBerita() {
        const title = document.getElementById('r-title').innerText;
        const url   = window.location.href;

        if (navigator.share) {
            navigator.share({
                title: title,
                text: 'Baca berita menarik seputar GeoToba terbaru ini:',
                url: url
            }).catch(err => console.log('Share dibatalkan oleh pengguna'));
        } else {
            navigator.clipboard.writeText(url).then(() => {
                alert('Tautan berita berhasil disalin ke clipboard!');
            }).catch(() => {
                alert('Salin tautan berikut: ' + url);
            });
        }
    }

    /**
     * Listener scroll pada modal reader untuk memperbarui progress bar
     * secara real-time sesuai posisi guliran artikel yang sedang dibaca.
     */
    const readerElement = document.getElementById('fullReader');
    if (readerElement) {
        readerElement.addEventListener('scroll', function () {
            const winScroll  = readerElement.scrollTop;
            const height     = readerElement.scrollHeight - readerElement.clientHeight;
            const scrolled   = height > 0 ? (winScroll / height) * 100 : 0;
            const progressBar = document.getElementById('myBar');
            if (progressBar) {
                progressBar.style.width = scrolled + '%';
            }
        });
    }

    /**
     * Listener keyboard untuk menutup modal reader saat tombol ESC ditekan,
     * memberikan kemudahan navigasi bagi pengguna.
     */
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            const reader = document.getElementById('fullReader');
            if (reader && reader.classList.contains('active')) {
                closeReader();
            }
        }
    });
</script>

<link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script>
    AOS.init({ duration: 800, once: true, offset: 60, easing: 'ease-out-quad' });
</script>

@endsection