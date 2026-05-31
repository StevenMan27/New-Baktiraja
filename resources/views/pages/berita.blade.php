@extends('layouts.app')

@section('title', 'Berita Terkini - Geosite Danau Toba')

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

    /* STACK CONTAINER - SAME AS GALERI */
    .stack-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 0;
        padding: 40px 0;
        position: relative;
    }

    /* SLIP CARD - SAME EXACT STYLE AS GALERI */
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

    /* Efek hover - card naik ke atas seperti slip */
    .slip-card:hover {
        transform: translateY(-20px) scale(1.02);
        z-index: 100;
        box-shadow: 0 25px 40px -10px rgba(0,0,0,0.25);
    }

    /* Efek hover untuk card di sampingnya */
    .slip-card:hover ~ .slip-card {
        transform: translateX(20px);
    }

    /* Container gambar - SAME AS GALERI */
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

    .slip-card:hover .slip-image img {
        transform: scale(1.05);
    }

    /* Overlay - SAME AS GALERI */
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

    /* Info Card - SAME AS GALERI */
    .slip-info {
        padding: 16px;
        background: white;
        position: relative;
        border-top: 1px solid #f0f0f0;
    }

    /* Decorative line seperti slip */
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

    /* News specific - excerpt preview */
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

    .slip-date {
        font-size: 0.7rem;
        color: #94a3b8;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .slip-date i {
        font-size: 0.65rem;
        color: #c6a43b;
    }

    /* Nomor slip seperti antrian - SAME AS GALERI */
    .slip-number {
        position: absolute;
        bottom: 12px;
        right: 16px;
        font-size: 0.6rem;
        color: #cbd5e1;
        font-family: monospace;
        letter-spacing: 1px;
    }

    /* Views counter */
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
        max-height: 500px;
        object-fit: cover;
        border-radius: 16px;
        margin: 30px 0 40px;
        box-shadow: 0 16px 40px rgba(0,0,0,0.12);
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

    .btn-back {
        background: #003366;
        color: white;
        padding: 12px 32px;
        border-radius: 40px;
        border: none;
        font-size: 12px;
        letter-spacing: 1px;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-back:hover {
        background: #c6a43b;
        color: #003366;
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
    @media (max-width: 1200px) {
        .slip-card {
            width: 240px;
        }
        .slip-image {
            height: 280px;
        }
    }

    @media (max-width: 992px) {
        .stack-container {
            justify-content: center;
            flex-wrap: wrap;
            gap: 20px;
        }
        .slip-card {
            margin-left: 0 !important;
            width: 260px;
        }
        .slip-card:hover ~ .slip-card {
            transform: none;
        }
        .slip-card:hover {
            transform: translateY(-10px);
        }
    }

    @media (max-width: 768px) {
        .slip-card {
            width: calc(50% - 8px);
        }
        .slip-image {
            height: 260px;
        }
        .news-hero h1 {
            font-size: 2rem;
        }
        .reader-title-display {
            font-size: 1.6rem;
        }
        .reader-content-wrap {
            padding: 20px;
        }
    }

    @media (max-width: 560px) {
        .slip-card {
            width: 100%;
        }
        .slip-image {
            height: 280px;
        }
    }
</style>

<!-- HERO SECTION - SAME AS GALERI -->
<div class="news-hero">
    <div class="news-hero-content">
        <h1>BERITA TERKINI</h1>
        <p>Discover Geosite Toba</p>
    </div>
</div>

<!-- STACKED SLIP CARDS SECTION - SAME VISUAL AS GALERI -->
<section class="news-section">
    <div class="container">
        <div class="stack-container">
            @php $counter = 1; @endphp
            @forelse($berita as $item)
                @php
                    $imageSrc = \App\Helpers\ImageHelper::getFirstImage($item->gambar);
                    if (!$imageSrc) {
                        $imageSrc = 'https://via.placeholder.com/400x500?text=No+Image';
                    }
                    
                    // Excerpt untuk preview
                    $excerpt = strip_tags($item->konten);
                    $excerpt = Str::limit($excerpt, 80);
                @endphp
                
                <div class="slip-card" onclick="openReader({{ $item->id }})">
                    <div class="slip-image">
                        <img src="{{ $imageSrc }}" 
                             alt="{{ $item->judul }}" 
                             loading="lazy" 
                             onerror="this.onerror=null;this.src='https://via.placeholder.com/400x500?text=No+Image'">
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
                        <div class="slip-views">
                            <i class="fas fa-eye"></i>
                            <span>{{ $item->views ?? 0 }}</span>
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
    </div>
</section>

<!-- READER MODAL - FUNGSI BERITA TETAP -->
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
        <div class="reader-header">
            <span class="reader-date" id="r-date"></span>
            <h1 id="r-title" class="reader-title-display"></h1>
            <div class="reader-divider"></div>
            <div class="reader-author">
                <i class="far fa-user"></i>
                <span id="r-author">Admin GeoToba</span>
            </div>
        </div>

        <img id="r-img" src="" class="reader-hero-img" alt="">

        <div id="r-content" class="reader-article-body"></div>

        <div class="reader-footer">
            <button class="btn-back" onclick="closeReader()">
                <i class="fas fa-arrow-left"></i> Kembali ke Berita
            </button>
        </div>
    </div>
</div>

<script>
    // Data berita dari server
    const newsData = @json($berita->items());

    function openReader(id) {
        const item = newsData.find(x => x.id === id);
        if(!item) return;

        // Handle gambar untuk reader
        let imgSrc = 'https://via.placeholder.com/400x500?text=No+Image';
        
        if (item.gambar && item.gambar.trim() !== '') {
            if (item.gambar.length > 500 && !item.gambar.startsWith('http')) {
                imgSrc = item.gambar;
            } else if (item.gambar.startsWith('http')) {
                imgSrc = item.gambar;
            } else if (item.gambar) {
                imgSrc = '{{ asset("storage") }}/' + item.gambar;
            }
        }

        // Set content
        document.getElementById('r-title').innerText = item.judul;
        document.getElementById('r-content').innerHTML = item.konten;
        document.getElementById('r-img').src = imgSrc;
        document.getElementById('r-date').innerHTML = new Date(item.created_at).toLocaleDateString('id-ID', {
            day: 'numeric',
            month: 'long',
            year: 'numeric'
        });
        document.getElementById('r-author').innerHTML = item.penulis || 'Admin GeoToba';

        // Aktifkan Reader
        const reader = document.getElementById('fullReader');
        reader.classList.add('active');
        document.body.style.overflow = 'hidden';

        // Reset Scroll Progress
        const progressBar = document.getElementById("myBar");
        if (progressBar) {
            progressBar.style.width = "0%";
        }
        
        // Increment views via AJAX
        fetch(`/api/berita/${id}/view`, { 
            method: 'POST', 
            headers: { 
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            } 
        }).catch(err => console.log('View increment error:', err));
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
</script>

@endsection