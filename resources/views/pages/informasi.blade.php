@extends('layouts.app')

@section('title', 'Informasi - Geosite Danau Toba')

@section('content')

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
    /* ==================== BASE & TYPOGRAPHY ==================== */
    .geopark-wrapper {
        font-family: 'Plus Jakarta Sans', sans-serif;
        color: #666;
        background-color: #f8fafc;
        min-height: 100vh;
        overflow-x: hidden;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 24px;
    }

    /* ==================== HERO SECTION ==================== */
    .hero-informasi {
        background: #ffffff;
        padding: 130px 0 40px; /* Jarak disesuaikan dengan tinggi navbar */
        text-align: center;
        border-bottom: 1px solid #edf2f7;
    }
    
    .hero-informasi h2 {
        font-size: 2rem;
        font-weight: 700;
        color: #1a3c5e;
        margin-bottom: 12px;
    }
    
    .hero-informasi p {
        font-size: 0.95rem;
        color: #718096;
        max-width: 600px;
        margin: 0 auto;
        line-height: 1.6;
    }

    /* ==================== GRID SECTION ==================== */
    .informasi-section {
        padding: 60px 0;
        transition: all 0.4s ease;
    }
    
    .informasi-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 32px;
    }
    
    .informasi-card {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        flex-direction: column;
    }
    
    .informasi-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.12);
    }
    
    .informasi-card-img {
        height: 200px;
        overflow: hidden;
        position: relative;
    }
    
    .informasi-card-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }
    
    .informasi-card-body {
        padding: 24px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .informasi-card-body .card-date {
        font-size: 12px;
        color: #c6a43b;
        font-weight: 500;
        margin-bottom: 8px;
        display: block;
    }
    
    .informasi-card-body h3 {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1a3c5e;
        margin: 8px 0 12px;
        line-height: 1.4;
    }
    
    .informasi-card-body p {
        color: #666;
        font-size: 14px;
        line-height: 1.6;
        margin-bottom: 20px;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .btn-read {
        margin-top: auto;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: #c6a43b;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        background: none;
        border: none;
        padding: 0;
        cursor: pointer;
        width: fit-content;
        transition: all 0.2s ease;
    }
    
    .btn-read:hover {
        color: #1a3c5e;
        gap: 10px;
    }
    
    /* ==================== FULL ARTICLE VIEW ==================== */
    .article-view-section {
        display: none;
        padding: 20px 0 100px;
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.4s ease, transform 0.4s ease;
    }

    .article-view-section.active {
        display: block;
        opacity: 1;
        transform: translateY(0);
    }

    /* Pembungkus untuk memberikan jarak aman dari Navbar melayang */
    .article-container-box {
        margin-top: 110px; 
    }

    .btn-back-container {
        margin-bottom: 24px;
        text-align: left;
    }

    /* Tombol Kembali yang Dipercantik & Stabil */
    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        padding: 12px 26px;
        border-radius: 50px;
        font-size: 0.88rem;
        font-weight: 600;
        color: #1a3c5e;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 12px rgba(26, 60, 94, 0.08);
        position: relative;
        z-index: 10;
    }

    .btn-back i {
        transition: transform 0.3s ease;
    }

    .btn-back:hover {
        background: #1a3c5e;
        color: #ffffff;
        border-color: #1a3c5e;
        box-shadow: 0 6px 20px rgba(26, 60, 94, 0.2);
    }

    .btn-back:hover i {
        transform: translateX(-4px);
    }

    .article-wrapper {
        background: white;
        border-radius: 20px;
        box-shadow: 0 15px 45px rgba(0,0,0,0.06);
        overflow: hidden;
    }

    .article-hero-img {
        width: 100%;
        height: 450px;
        object-fit: cover;
    }

    .article-content-padding {
        padding: 40px 50px;
        max-width: 800px;
        margin: 0 auto;
    }

    .article-meta {
        display: flex;
        gap: 20px;
        color: #718096;
        font-size: 13px;
        margin-bottom: 20px;
        border-bottom: 1px solid #edf2f7;
        padding-bottom: 16px;
    }

    .article-meta span {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .article-main-title {
        font-size: 2.2rem;
        font-weight: 700;
        color: #1a3c5e;
        line-height: 1.3;
        margin-bottom: 24px;
    }

    .article-body-text {
        font-size: 15px;
        line-height: 1.8;
        color: #4a5568;
    }

    .article-body-text p {
        margin-bottom: 1.5rem;
    }

    /* ==================== UTILITIES ==================== */
    .pagination-wrapper {
        display: flex;
        justify-content: center;
        margin-top: 40px;
    }
    
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: white;
        border-radius: 16px;
        grid-column: span 3;
        box-shadow: 0 10px 30px rgba(0,0,0,0.04);
    }

    /* ==================== RESPONSIVE ==================== */
    @media (max-width: 992px) {
        .informasi-grid { grid-template-columns: repeat(2, 1fr); gap: 24px; }
        .article-main-title { font-size: 1.8rem; }
        .article-content-padding { padding: 30px; }
        .article-hero-img { height: 320px; }
    }
    
    @media (max-width: 768px) {
        .informasi-grid { grid-template-columns: 1fr; }
        .hero-informasi { padding: 110px 0 30px; }
        .hero-informasi h2 { font-size: 1.6rem; }
        .article-main-title { font-size: 1.5rem; }
        .article-hero-img { height: 240px; }
        .article-container-box { margin-top: 90px; }
    }
</style>

<div class="geopark-wrapper">
    <div class="hero-informasi" id="heroSection">
        <div class="container">
            <h2>Informasi Terbaru</h2>
            <p>Jelajahi wawasan ilmiah, warisan budaya, dan keanekaragaman geologi Geosite Danau Toba.</p>
        </div>
    </div>

    <section class="informasi-section" id="gridSection">
        <div class="container">
            <div class="informasi-grid">
                @forelse($informasiList as $index => $item)
                <div class="informasi-card" data-aos="fade-up">
                    
                    @php
                        $imgSrc = asset('image/default.jpg');
                        if (!empty($item->gambar)) {
                            if (str_starts_with($item->gambar, 'data:image')) {
                                $imgSrc = $item->gambar;
                            } elseif (filter_var($item->gambar, FILTER_VALIDATE_URL)) {
                                $imgSrc = $item->gambar;
                            } elseif (file_exists(public_path('storage/' . $item->gambar))) {
                                $imgSrc = asset('storage/' . $item->gambar);
                            } elseif (file_exists(public_path($item->gambar))) {
                                $imgSrc = asset($item->gambar);
                            } else {
                                $imgSrc = asset('storage/' . $item->gambar);
                            }
                        }
                    @endphp

                    <div class="informasi-card-img">
                        <img src="{{ $imgSrc }}" alt="{{ $item->judul }}" onerror="this.src='{{ asset('image/default.jpg') }}'">
                    </div>
                    
                    <div class="informasi-card-body">
                        <span class="card-date">{{ $item->created_at->format('d M Y') }}</span>
                        <h3>{{ Str::limit($item->judul, 50) }}</h3>
                        <p>{{ Str::limit(strip_tags($item->konten), 120) }}</p>
                        <button class="btn-read" onclick="showArticle({{ $index }})">
                            Baca Selengkapnya →
                        </button>
                    </div>
                </div>
                @empty
                <div class="empty-state">
                    <p>Belum ada informasi tersedia.</p>
                </div>
                @endforelse
            </div>
            
            @if(method_exists($informasiList, 'links'))
            <div class="pagination-wrapper">
                {{ $informasiList->links() }}
            </div>
            @endif
        </div>
    </section>

    <section class="article-view-section" id="articleSection">
        <div class="container">
            <div class="article-container-box">
                
                <div class="btn-back-container">
                    <button class="btn-back" onclick="hideArticle()">
                        <i class="fas fa-arrow-left"></i> Kembali ke Informasi
                    </button>
                </div>

                <div class="article-wrapper">
                    <img id="viewImg" class="article-hero-img" src="" alt="">
                    <div class="article-content-padding">
                        <div class="article-meta">
                            <span><i class="far fa-calendar-alt"></i> <span id="viewDate"></span></span>
                            <span><i class="far fa-eye"></i> <span id="viewViews"></span> Pembaca</span>
                        </div>
                        <h1 class="article-main-title" id="viewTitle"></h1>
                        <div class="article-body-text" id="viewContent"></div>
                    </div>
                </div>

            </div>
        </div>
    </section>
</div>

<link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css" />
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({ duration: 600, once: true, offset: 40 });
    
    // Sinkronisasi data dari Backend ke Frontend JS
    const informasiData = @json(method_exists($informasiList, 'items') ? $informasiList->items() : $informasiList);
    
    const gridSection = document.getElementById('gridSection');
    const articleSection = document.getElementById('articleSection');
    const heroSection = document.getElementById('heroSection');

    function showArticle(index) {
        const item = informasiData[index];
        if (!item) return;
        
        let imgSrc = '{{ asset("image/default.jpg") }}';
        if (item.gambar) {
            if (item.gambar.startsWith('data:image') || item.gambar.startsWith('http')) {
                imgSrc = item.gambar;
            } else {
                imgSrc = item.gambar.includes('storage/') ? '{{ asset("") }}' + item.gambar : '{{ asset("storage") }}/' + item.gambar;
            }
        }
        
        const tanggal = new Date(item.created_at);
        const tanggalFormatted = tanggal.toLocaleDateString('id-ID', {
            day: 'numeric',
            month: 'long',
            year: 'numeric'
        });
        
        document.getElementById('viewImg').src = imgSrc;
        document.getElementById('viewTitle').innerText = item.judul;
        document.getElementById('viewDate').innerText = tanggalFormatted;
        document.getElementById('viewViews').innerText = (item.views || 0).toLocaleString();
        document.getElementById('viewContent').innerHTML = item.konten;
        
        gridSection.style.display = 'none';
        heroSection.style.display = 'none';
        
        articleSection.classList.add('active');
        window.scrollTo({ top: 0, behavior: 'smooth' });

        // Fitur Tambah Views dari Project Anda (Berjalan di Latar Belakang)
        if (item.id) {
            const csrfMeta = document.querySelector('meta[name="csrf-token"]');
            const csrfToken = csrfMeta ? csrfMeta.getAttribute('content') : '{{ csrf_token() }}';
            
            fetch('{{ url("/informasi") }}/' + item.id + '/view', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success && data.views !== undefined) {
                    document.getElementById('viewViews').innerText = data.views.toLocaleString();
                }
            })
            .catch(err => {
                console.warn('Gagal menambah views secara asinkron:', err);
            });
        }
    }
    
    function hideArticle() {
        articleSection.classList.remove('active');
        
        setTimeout(() => {
            gridSection.style.display = 'block';
            heroSection.style.display = 'block';
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }, 150);
    }
</script>

@endsection
