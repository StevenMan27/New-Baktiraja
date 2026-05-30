@extends('layouts.app')

@section('title', 'Galeri - GeoToba')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<style>
    /* ========== STACKED SLIP CARDS STYLE ========== */
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

    /* HERO SECTION - TETAP */
    .gallery-hero {
        background: linear-gradient(135deg, #003366 0%, #1a4a7a 100%);
        padding: 80px 0 50px;
        margin-top: 70px;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .gallery-hero::before {
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

    .gallery-hero-content {
        position: relative;
        z-index: 2;
    }

    .gallery-hero h1 {
        font-size: 2.8rem;
        font-weight: 700;
        font-family: 'Playfair Display', serif;
        color: white;
        margin-bottom: 10px;
        letter-spacing: 2px;
    }

    .gallery-hero p {
        font-size: 0.85rem;
        letter-spacing: 3px;
        text-transform: uppercase;
        color: rgba(255,255,255,0.8);
    }

    /* ========== STACKED SLIP CARDS ========== */
    .gallery-section {
        padding: 60px 0 100px;
        background: linear-gradient(135deg, #f8fafc 0%, #eef2f8 100%);
        min-height: 100vh;
    }

    .container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 24px;
    }

    /* STACK CONTAINER */
    .stack-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 0;
        padding: 40px 0;
        position: relative;
    }

    /* SLIP CARD - Seperti kertas slip/kartu */
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

    /* Container gambar */
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

    /* Overlay seperti watermark */
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

    /* Info Card - Seperti slip kertas */
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
    }

    .slip-location {
        font-size: 0.7rem;
        color: #94a3b8;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .slip-location i {
        font-size: 0.65rem;
        color: #c6a43b;
    }

    /* Nomor slip seperti antrian */
    .slip-number {
        position: absolute;
        bottom: 12px;
        right: 16px;
        font-size: 0.6rem;
        color: #cbd5e1;
        font-family: monospace;
        letter-spacing: 1px;
    }

    /* MODAL tetap */
    .modal-overlay { 
        position: fixed; 
        inset: 0; 
        background: rgba(0,0,0,0.96); 
        z-index: 9999; 
        display: none; 
        align-items: center; 
        justify-content: center; 
        backdrop-filter: blur(12px);
    }
    .modal-box { 
        background: #1a1a1a; 
        width: 90%; 
        max-width: 1000px; 
        display: grid; 
        grid-template-columns: 1.2fr 1fr; 
        border-radius: 20px; 
        overflow: hidden; 
        animation: modalFadeIn 0.4s ease;
    }
    @keyframes modalFadeIn {
        from { opacity: 0; transform: scale(0.96); }
        to { opacity: 1; transform: scale(1); }
    }
    .modal-img-part { 
        background: #0a0a0a;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }
    .modal-img-part img { 
        width: 100%; 
        max-height: 70vh; 
        object-fit: contain; 
    }
    .modal-text-part { 
        padding: 35px; 
        color: white; 
        text-align: left;
        background: linear-gradient(135deg, #1a1a1a, #0d0d0d);
    }
    .close-btn { 
        position: absolute; 
        top: 20px; 
        right: 20px; 
        color: white; 
        font-size: 1.5rem; 
        cursor: pointer; 
        transition: all 0.3s ease;
        z-index: 10000;
        width: 40px;
        height: 40px;
        background: rgba(0,0,0,0.5);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(5px);
    }
    .close-btn:hover { 
        background: #c6a43b; 
        color: #003366; 
        transform: rotate(90deg);
    }
    .modal-text-part small {
        color: #c6a43b;
        letter-spacing: 2px;
        font-size: 0.7rem;
        text-transform: uppercase;
    }
    .modal-text-part h2 {
        font-size: 1.5rem;
        margin: 12px 0;
        font-family: 'Playfair Display', serif;
    }
    .modal-text-part p {
        color: #bbb;
        line-height: 1.7;
        font-size: 0.85rem;
    }

    /* Music Control */
    .music-control {
        position: fixed;
        bottom: 25px;
        right: 25px;
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: rgba(0, 51, 102, 0.9);
        backdrop-filter: blur(8px);
        border: 1px solid rgba(198, 164, 59, 0.4);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        z-index: 1000;
        transition: all 0.3s ease;
        font-size: 1.1rem;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }
    .music-control:hover {
        background: #c6a43b;
        color: #003366;
        transform: scale(1.1);
    }

    .empty-gallery {
        text-align: center;
        padding: 80px;
        background: white;
        border-radius: 16px;
    }
    .empty-gallery i {
        font-size: 3rem;
        color: #cbd5e1;
        margin-bottom: 15px;
    }

    /* RESPONSIVE */
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
        .modal-box { 
            grid-template-columns: 1fr; 
            max-height: 85vh;
            overflow-y: auto;
        }
        .music-control { 
            bottom: 15px; 
            right: 15px; 
            width: 42px; 
            height: 42px; 
            font-size: 1rem; 
        }
        .gallery-hero h1 {
            font-size: 2rem;
        }
        .stack-container {
            gap: 16px;
        }
        .slip-card {
            width: calc(50% - 8px);
        }
        .slip-image {
            height: 260px;
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

<!-- Audio Background -->
<audio id="bgMusic" loop preload="auto">
    <source src="{{ asset('audio/GONDANG.mp4') }}" type="audio/mpeg">
    Your browser does not support the audio element.
</audio>

<!-- Music Control -->
<div class="music-control" id="musicControl">
    <i class="fas fa-music" id="musicIcon"></i>
</div>

<!-- HERO SECTION -->
<div class="gallery-hero">
    <div class="gallery-hero-content">
        <h1>GALERI</h1>
        <p>Koleksi Foto Terbaik</p>
    </div>
</div>

<!-- STACKED SLIP CARDS SECTION -->
<section class="gallery-section">
    <div class="container">
        <div class="stack-container">
            @php $counter = 1; @endphp
            @foreach($galeriByKategori as $kategori => $items)
                @foreach($items as $item)
                    @php $images = \App\Helpers\ImageHelper::getAllImages($item->gambar); @endphp
                    @foreach($images as $img)
                        <div class="slip-card" onclick="openPhoto('{{ $img }}', '{{ $item->judul }}', '{{ addslashes($item->deskripsi) }}', '{{ strtoupper($kategori) }}')">
                            <div class="slip-image">
                                <img src="{{ $img }}" alt="{{ $item->judul }}" loading="lazy" onerror="this.src='https://via.placeholder.com/400x500?text=No+Image'">
                                <div class="slip-overlay">
                                    <span class="slip-category">{{ strtoupper($kategori) }}</span>
                                    <div class="slip-title-overlay">{{ Str::limit($item->judul, 35) }}</div>
                                </div>
                            </div>
                            <div class="slip-info">
                                <div class="slip-line"></div>
                                <div class="slip-title">{{ Str::limit($item->judul, 30) }}</div>
                                <div class="slip-location">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span>{{ $item->lokasi ?? 'Danau Toba' }}</span>
                                </div>
                                <div class="slip-number">#{{ str_pad($counter, 3, '0', STR_PAD_LEFT) }}</div>
                            </div>
                        </div>
                        @php $counter++; @endphp
                    @endforeach
                @endforeach
            @endforeach
        </div>
        
        @if($counter == 1)
        <div class="empty-gallery">
            <i class="fas fa-images"></i>
            <p>Belum ada foto galeri</p>
        </div>
        @endif
    </div>
</section>

<!-- MODAL -->
<div id="pModal" class="modal-overlay" onclick="closePhoto()">
    <div class="close-btn" onclick="closePhoto()">&times;</div>
    <div class="modal-box" onclick="event.stopPropagation()">
        <div class="modal-img-part"><img src="" id="mImg"></div>
        <div class="modal-text-part">
            <small id="mTag"></small>
            <h2 id="mTitle"></h2>
            <p id="mDesc"></p>
        </div>
    </div>
</div>

<script>
    // ========== AUDIO CONTROL ==========
    const audio = document.getElementById('bgMusic');
    const musicControl = document.getElementById('musicControl');
    const musicIcon = document.getElementById('musicIcon');
    let isPlaying = false;
    
    function playAudio() {
        audio.play().then(() => {
            isPlaying = true;
            musicIcon.className = 'fas fa-music';
        }).catch(error => {
            isPlaying = false;
            musicIcon.className = 'fas fa-volume-mute';
        });
    }
    
    function pauseAudio() {
        audio.pause();
        isPlaying = false;
        musicIcon.className = 'fas fa-volume-mute';
    }
    
    let audioStarted = false;
    
    function startAudioOnFirstInteraction() {
        if (!audioStarted) {
            playAudio();
            audioStarted = true;
            document.removeEventListener('click', startAudioOnFirstInteraction);
            document.removeEventListener('touchstart', startAudioOnFirstInteraction);
        }
    }
    
    document.addEventListener('click', startAudioOnFirstInteraction);
    document.addEventListener('touchstart', startAudioOnFirstInteraction);
    
    // ========== MODAL FUNCTIONS ==========
    function openPhoto(src, title, desc, tag) {
        if (!audioStarted) {
            audioStarted = true;
        }
        playAudio();
        
        document.getElementById('mImg').src = src;
        document.getElementById('mTitle').innerText = title;
        document.getElementById('mTag').innerText = tag;
        document.getElementById('mDesc').innerText = desc || 'Tidak ada deskripsi.';
        document.getElementById('pModal').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }
    
    function closePhoto() {
        document.getElementById('pModal').style.display = 'none';
        document.body.style.overflow = 'auto';
        pauseAudio();
    }
    
    musicControl.addEventListener('click', function(e) {
        e.stopPropagation();
        if (isPlaying) {
            pauseAudio();
        } else {
            if (!audioStarted) {
                audioStarted = true;
            }
            playAudio();
        }
    });
    
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closePhoto();
        }
        if (e.key === ' ' || e.key === 'Space') {
            e.preventDefault();
            if (isPlaying) {
                pauseAudio();
            } else {
                if (!audioStarted) {
                    audioStarted = true;
                }
                playAudio();
            }
        }
    });
    
    audio.load();
</script>

@endsection