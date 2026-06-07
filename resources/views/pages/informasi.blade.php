@extends('layouts.app')

@section('title', 'INFORMASI TERKINI - Geosite Danau Toba')

@section('content')

<style>
    /* ========== STACKED SLIP CARDS STYLE - SAME AS GALERI ========== */
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:wght@400;500;600;700&display=swap');

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Inter', sans-serif;
        background: #f0f2f5;
    }

    /*
       [STYLE HERO BANNER INFORMASI]
       Bagian ini bertugas menghias bagian teratas halaman Informasi.
       Menggunakan efek background gradasi (linear-gradient) dan animasi efek berputar (slowRotate).
    */
    /* HERO SECTION - SAME AS GALERI */
    .news-hero {
        background: linear-gradient(135deg, #003366 0%, #1a4a7a 100%);
        padding: 80px 0 50px;
        margin-top: 70px;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

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

    .hero-badge {
        display: inline-block;
        background: rgba(198, 164, 59, 0.12);
        border: 1px solid rgba(198, 164, 59, 0.3);
        color: #f1d26b; /* gold-light */
        padding: 6px 20px;
        border-radius: 50px;
        font-size: 0.72rem;
        font-weight: 700;
        letter-spacing: 2px;
        text-transform: uppercase;
        margin-bottom: 20px;
    }

    .hero-divider {
        width: 50px;
        height: 3px;
        background: #c6a43b; /* gold */
        margin: 20px auto 0;
        border-radius: 4px;
    }

    /* NEWS SECTION */
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

    /*
       [STYLE GRID KARTU INFORMASI]
       Bagian ini bertugas mengatur ratusan informasi agar tampil sejajar dalam grid 3 kolom.
       Digunakan di: div class="news-grid"
    */
    /* ========== GRID KARTU INFORMASI ========== */
    .news-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 28px;
        padding: 10px 0 20px;
    }

    /* Kartu informasi individual */
    .news-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(0,0,0,0.07);
        cursor: pointer;
        display: flex;
        flex-direction: column;
        transition: all 0.35s cubic-bezier(0.25, 0.8, 0.25, 1);
    }

    .news-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 50px rgba(0,0,0,0.15);
    }

    /* Area gambar */
    .news-card-img {
        width: 100%;
        height: 220px;
        overflow: hidden;
        position: relative;
        background: linear-gradient(135deg, #1e293b, #0f172a);
    }

    .news-card-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
        display: block;
    }

    .news-card:hover .news-card-img img {
        transform: scale(1.07);
    }

    /* Badge kategori di atas gambar */
    .news-card-badge {
        position: absolute;
        top: 14px;
        left: 14px;
        background: #c6a43b;
        color: #003366;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.6rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    /* Area teks bawah kartu */
    .news-card-body {
        padding: 20px 22px 22px;
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 8px;
        border-top: 3px solid transparent;
        transition: border-color 0.3s ease;
    }

    .news-card:hover .news-card-body {
        border-color: #c6a43b;
    }

    .news-card-title {
        font-size: 1rem;
        font-weight: 700;
        color: #003366;
        font-family: 'Playfair Display', serif;
        line-height: 1.35;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .news-card-excerpt {
        font-size: 0.82rem;
        color: #64748b;
        line-height: 1.6;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .news-card-meta {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 4px;
    }

    .news-card-date {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 0.72rem;
        color: #94a3b8;
    }

    .news-card-date i { color: #c6a43b; font-size: 0.65rem; }

    .news-card-views {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 0.7rem;
        color: #94a3b8;
    }

    .news-card-views i { color: #c6a43b; font-size: 0.65rem; }

    .news-card-read {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-top: 6px;
        font-size: 0.72rem;
        font-weight: 700;
        color: #003366;
        letter-spacing: 0.3px;
        transition: color 0.2s;
    }

    .news-card:hover .news-card-read { color: #c6a43b; }

    /*
       [STYLE MODAL READER PENGUMUMAN]
       Ini adalah desain kotak pembaca layar penuh (Modal Reader) khusus untuk pengumuman.
       Efek transisinya dibuat muncul dari bawah saat artikel ditekan.
       Digunakan di: div id="fullReader"
    */
    /* MODAL READER - TETAP SAMA (FUNGSI BERITA) */
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

    .progress-container {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: #eee;
        z-index: 100;
    }

    .progress-bar {
        height: 4px;
        background: #c6a43b;
        width: 0%;
        transition: width 0.1s ease;
    }

    .reader-nav {
        padding: 20px 5%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: rgba(255,255,255,0.98);
        backdrop-filter: blur(12px);
        position: sticky;
        top: 0;
        z-index: 99;
        border-bottom: 1px solid rgba(0,0,0,0.05);
    }

    .reader-logo {
        font-family: 'Playfair Display', serif;
        font-size: 1.2rem;
        font-weight: 700;
        color: #003366;
    }

    .reader-logo span {
        color: #c6a43b;
    }

    .btn-close-circle {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: #f0f0f0;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        color: #1a1a1a;
    }

    .btn-close-circle:hover {
        background: #c6a43b;
        color: #003366;
        transform: rotate(90deg);
    }

    .reader-content-wrap {
        max-width: 850px;
        margin: 0 auto;
        padding: 40px 30px 60px;
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.6s ease 0.2s;
    }

    #fullReader.active .reader-content-wrap {
        opacity: 1;
        transform: translateY(0);
    }

    .reader-header {
        text-align: center;
        margin-bottom: 40px;
    }

    .reader-date {
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 3px;
        color: #c6a43b;
        display: inline-block;
        margin-bottom: 15px;
    }

    .reader-title-display {
        font-family: 'Playfair Display', serif;
        font-size: 2.5rem;
        line-height: 1.25;
        color: #1a1a1a;
        margin: 20px 0;
        font-weight: 700;
    }

    .reader-divider {
        width: 50px;
        height: 2px;
        background: #c6a43b;
        margin: 20px auto;
    }

    .reader-author {
        font-size: 13px;
        color: #999;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .reader-hero-img {
        width: 100%;
        height: auto;
        border-radius: 16px;
        margin: 30px 0 40px;
        box-shadow: 0 16px 40px rgba(0,0,0,0.12);
        display: block;
    }

    /* Sembunyikan gambar jika src kosong */
    .reader-hero-img[src=""] {
        display: none;
    }

    .reader-article-body {
        font-size: 16px;
        line-height: 1.9;
        color: #2c3e50;
        text-align: left;
        font-family: 'Inter', sans-serif;
    }

    .reader-article-body p {
        margin-bottom: 25px;
    }

    .reader-footer {
        margin: 60px 0 0;
        text-align: center;
        border-top: 1px solid #eee;
        padding-top: 40px;
    }

    /* Label kategori artikel berwarna emas */
    .reader-category {
        display: inline-block;
        background: rgba(198, 164, 59, 0.08);
        border: 1px solid rgba(198, 164, 59, 0.3);
        color: #967a28;
        padding: 5px 16px;
        border-radius: 30px;
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        margin-bottom: 16px;
    }

    /* Baris informasi meta: tanggal, views */
    .reader-meta {
        display: flex;
        justify-content: center;
        gap: 24px;
        font-size: 0.82rem;
        color: #64748b;
        flex-wrap: wrap;
        padding-bottom: 20px;
        border-bottom: 1px solid #f1f5f9;
        margin-bottom: 10px;
    }

    .reader-meta span {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    /* Tombol kembali di footer reader */
    .btn-back-reader {
        background: #003366;
        color: white;
        padding: 14px 32px;
        border-radius: 40px;
        border: none;
        font-size: 0.82rem;
        font-weight: 600;
        letter-spacing: 0.5px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-back-reader:hover {
        background: #c6a43b;
        color: #003366;
        transform: translateY(-3px);
    }

    /* Tombol bagikan artikel */
    .btn-share-reader {
        background: transparent;
        color: #003366;
        padding: 13px 28px;
        border-radius: 40px;
        border: 2px solid #003366;
        font-size: 0.82rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-share-reader:hover {
        background: #003366;
        color: white;
        transform: translateY(-3px);
    }

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

    /* RESPONSIVE - SAME AS GALERI */
    /* ========== RESPONSIVE DESIGN ========== */
    @media (max-width: 1024px) {
        .news-grid { grid-template-columns: repeat(2, 1fr); gap: 22px; }
    }

    @media (max-width: 768px) {
        .news-grid { grid-template-columns: repeat(2, 1fr); gap: 16px; }
        .news-card-img { height: 180px; }
        .news-card-title { font-size: 0.9rem; }
        .news-hero h1 { font-size: 2rem; }
        .reader-title-display { font-size: 1.6rem; }
        .reader-content-wrap { padding: 20px; }
    }

    @media (max-width: 480px) {
        .news-grid { grid-template-columns: 1fr; gap: 16px; }
        .news-card-img { height: 200px; }
    }
</style>

<!-- HERO SECTION - SAME AS GALERI -->
<div class="news-hero">
    <div class="news-hero-content">
        <div class="hero-badge">UPDATE TERBARU</div>
        <h1>Informasi Terkini</h1>
        <p>Informasi Lengkap Geopark Danau Toba</p>
        <div class="hero-divider"></div>
    </div>
</div>

<!-- STACKED SLIP CARDS SECTION - SAME VISUAL AS GALERI -->
<section class="news-section">
    <div class="container">
        <div class="news-grid">
            @forelse($informasiList as $item)
                @php
                    $imageSrc = \App\Helpers\ImageHelper::getFirstImage($item->gambar);
                    if (!$imageSrc) { $imageSrc = asset('image/default.jpg'); }
                    $excerpt = strip_tags($item->konten);
                    $excerpt = Str::limit($excerpt, 100);
                @endphp

                <div class="news-card" onclick="openReader({{ $item->id }})">
                    <div class="news-card-img">
                        <img src="{{ $imageSrc }}"
                             alt="{{ $item->judul }}"
                             loading="lazy"
                             onerror="this.onerror=null;this.src='{{ asset('image/default.jpg') }}'">
                        <span class="news-card-badge">INFORMASI</span>
                    </div>
                    <div class="news-card-body">
                        <div class="news-card-title">{{ $item->judul }}</div>
                        <div class="news-card-excerpt">{{ $excerpt }}</div>
                        <div class="news-card-meta">
                            <div class="news-card-date">
                                <i class="fas fa-calendar-alt"></i>
                                <span>{{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d M Y') }}</span>
                            </div>
                            <div class="news-card-views">
                                <i class="fas fa-eye"></i>
                                <span>{{ number_format($item->views ?? 0) }}</span>
                            </div>
                        </div>
                        <span class="news-card-read">Baca Selengkapnya <i class="fas fa-arrow-right"></i></span>
                    </div>
                </div>
            @empty
                <div class="empty-news" style="grid-column:1/-1;">
                    <i class="fas fa-newspaper"></i>
                    <h3>Belum Ada Informasi</h3>
                    <p style="color:#999;margin-top:10px;">Silakan tambah informasi melalui panel admin.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- READER MODAL -->
<div id="fullReader">
    <div class="progress-container">
        <div class="progress-bar" id="myBar"></div>
    </div>

    <div class="reader-nav">
        <div class="reader-logo">Geo<span>Toba</span></div>
        <button class="btn-close-circle" onclick="closeReader()">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <div class="reader-content-wrap">
        {{-- Header artikel: kategori, judul, garis emas, meta info --}}
        <div class="reader-header">
            <span class="reader-category">INFORMASI</span>
            <h1 id="r-title" class="reader-title-display"></h1>
            <div class="reader-divider"></div>
            {{-- Baris meta berisi tanggal dan jumlah pembaca --}}
            <div class="reader-meta" id="r-meta"></div>
        </div>

        {{-- Gambar utama artikel (ukuran asli) --}}
        <img id="r-img" src="" class="reader-hero-img" alt="">

        {{-- Isi konten artikel --}}
        <div id="r-content" class="reader-article-body"></div>

        {{-- Footer modal --}}
        <div class="reader-footer" style="display:flex; justify-content:center; gap:12px; flex-wrap:wrap;">
            <button class="btn-back-reader" onclick="closeReader()">
                <i class="fas fa-arrow-left"></i> Kembali ke Informasi
            </button>
            <button class="btn-share-reader" onclick="bagikanInformasi()">
                <i class="fas fa-share-alt"></i> Bagikan Artikel
            </button>
        </div>
    </div>
</div>

<script>
    /*
       [FUNGSI JAVASCRIPT: LOGIKA MODAL PEMBACA INFORMASI (AJAX)]
       Bagian skrip ini bertugas:
       1. Menyimpan data pengumuman ke memori saat halaman dimuat (infoData).
       2. Jika ada kotak yang diklik, skrip ini mencari teks aslinya dan memasukkannya ke dalam div #fullReader.
       3. Mengirimkan sinyal ke backend (/api/informasi/id/view) agar view counter pengumuman tersebut bertambah secara real-time.
    */
    // Data informasi dari server
    const infoData = @json($informasiList);

    async function openReader(id) {
        const item = infoData.find(x => x.id === id);
        if (!item) return;

        // Menentukan sumber gambar — gambar disimpan sebagai JSON array di database
        let imgSrc = '';
        if (item.gambar && item.gambar.trim() !== '') {
            try {
                const gambarArr = JSON.parse(item.gambar);
                const firstImg = Array.isArray(gambarArr) ? gambarArr[0] : gambarArr;
                if (firstImg && firstImg.trim() !== '') {
                    if (firstImg.startsWith('data:image') || firstImg.startsWith('http')) {
                        imgSrc = firstImg;
                    } else {
                        imgSrc = '{{ asset("storage") }}/' + firstImg;
                    }
                }
            } catch (e) {
                // Jika bukan JSON, gunakan langsung sebagai string
                if (item.gambar.startsWith('data:image') || item.gambar.startsWith('http')) {
                    imgSrc = item.gambar;
                } else {
                    imgSrc = '{{ asset("storage") }}/' + item.gambar;
                }
            }
        }

        // Mengisi judul dan konten
        document.getElementById('r-title').innerText   = item.judul;
        document.getElementById('r-content').innerHTML = item.konten;

        // Tampilkan atau sembunyikan gambar
        const imgEl = document.getElementById('r-img');
        if (imgSrc) {
            imgEl.src = imgSrc;
            imgEl.style.display = 'block';
        } else {
            imgEl.src = '';
            imgEl.style.display = 'none';
        }

        // Format tanggal ke format Indonesia
        const tgl = new Date(item.created_at);
        const tanggalFormatted = tgl.toLocaleDateString('id-ID', {
            day: 'numeric', month: 'long', year: 'numeric'
        });

        // Mengisi baris meta: tanggal dan jumlah pembaca
        document.getElementById('r-meta').innerHTML = `
            <span><i class="far fa-calendar"></i> ${tanggalFormatted}</span>
            <span><i class="far fa-eye"></i> <span id="modalViews">${(item.views || 0).toLocaleString()}</span> dibaca</span>
        `;

        // Aktifkan modal dan kunci scroll
        const reader = document.getElementById('fullReader');
        reader.classList.add('active');
        document.body.style.overflow = 'hidden';

        // Reset posisi scroll dan progress bar
        reader.scrollTop = 0;
        document.getElementById('myBar').style.width = '0%';

        // Tambah jumlah pembaca via AJAX jika ada endpoint
        try {
            const response = await fetch('/api/informasi/' + id + '/view', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
                }
            });
            if (response.ok) {
                const result = await response.json();
                const viewsEl = document.getElementById('modalViews');
                if (viewsEl && result.views !== undefined) {
                    viewsEl.innerText = result.views.toLocaleString();
                }
            }
        } catch (e) {
            // Abaikan jika endpoint belum ada
        }
    }

    function closeReader() {
        const reader = document.getElementById('fullReader');
        reader.classList.remove('active');
        document.body.style.overflow = 'auto';
    }

    // Progress Bar saat scroll
    const readerElement = document.getElementById('fullReader');
    if (readerElement) {
        readerElement.onscroll = function() {
            const winScroll = readerElement.scrollTop;
            const height = readerElement.scrollHeight - readerElement.clientHeight;
            const scrolled = (winScroll / height) * 100;
            const progressBar = document.getElementById("myBar");
            if (progressBar) {
                progressBar.style.width = scrolled + "%";
            }
        };
    }

    // ESC key to close
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const reader = document.getElementById('fullReader');
            if (reader && reader.classList.contains('active')) {
                closeReader();
            }
        }
    });

    // Fungsi bagikan artikel informasi via Web Share API atau salin URL
    function bagikanInformasi() {
        const judul = document.getElementById('r-title').innerText;
        if (navigator.share) {
            navigator.share({
                title: judul + ' — GeoToba Baktiraja',
                text: 'Baca informasi menarik dari GeoToba Baktiraja: ' + judul,
                url: window.location.href
            }).catch(() => {});
        } else {
            navigator.clipboard.writeText(window.location.href).then(() => {
                alert('Link halaman berhasil disalin!');
            }).catch(() => {
                alert('Salin URL ini untuk berbagi: ' + window.location.href);
            });
        }
    }
</script>

@endsection
