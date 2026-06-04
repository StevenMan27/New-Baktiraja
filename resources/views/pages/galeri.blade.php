@extends('layouts.app')

@section('title', 'Galeri - GeoToba')

@section('content')

<style>
    /* Hero banner atas halaman galeri */
    .gallery-hero {
        background: linear-gradient(135deg, #003366 0%, #1a4a7a 100%);
        padding: 80px 0 50px;
        margin-top: 70px;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    /* Dekorasi animasi lingkaran putar di latar hero */
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

    .gallery-hero-content { position: relative; z-index: 2; }

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

    /* Section utama galeri */
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

    /* Wrapper semua baris stack, baris disusun vertikal dengan gap */
    .stack-wrapper {
        display: flex;
        flex-direction: column;
        gap: 40px;
        padding: 20px 0;
    }

    /* Setiap baris berisi N kartu yang saling menimpa secara horizontal */
    /* overflow: visible agar kartu yang hover bisa naik tanpa terpotong */
    .stack-row {
        display: flex;
        flex-direction: row;
        align-items: flex-end;
        justify-content: center;
        overflow: visible;
        padding: 20px 0 10px;
    }

    /* Kartu individual di dalam baris stack */
    .slip-card {
        position: relative;
        width: 280px;
        flex-shrink: 0;
        background: white;
        border-radius: 16px;
        overflow: hidden;
        cursor: pointer;
        /* Transisi halus saat hover */
        transition: all 0.4s cubic-bezier(0.2, 0.9, 0.4, 1.1);
        box-shadow: 0 10px 20px -5px rgba(0,0,0,0.12);
        /* Margin negatif menyebabkan kartu saling menimpa, dikontrol via JS */
        margin-left: -70px;
        z-index: 1;
    }

    /* Kartu pertama di setiap baris tidak membutuhkan margin negatif */
    .slip-card:first-child {
        margin-left: 0;
    }

    /* Saat hover kartu naik ke atas dan z-index nya tertinggi */
    .slip-card:hover {
        transform: translateY(-22px) scale(1.03);
        z-index: 100;
        box-shadow: 0 28px 44px -10px rgba(0,0,0,0.28);
    }

    /* Kartu setelah kartu yang di-hover bergeser ke kanan */
    .slip-card:hover ~ .slip-card {
        transform: translateX(18px);
    }

    /* Wrapper gambar dengan tinggi tetap agar semua kartu konsisten */
    .slip-image {
        position: relative;
        width: 100%;
        height: 300px;
        overflow: hidden;
        background: linear-gradient(135deg, #1e293b, #0f172a);
    }

    /* Gambar mengisi penuh area dengan object-fit cover */
    .slip-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
        display: block;
    }

    /* Zoom gambar saat hover kartu */
    .slip-card:hover .slip-image img {
        transform: scale(1.06);
    }

    /* Overlay gelap gradient dari bawah muncul saat hover */
    .slip-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.72), transparent);
        padding: 32px 16px 16px;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    /* Overlay terlihat saat hover */
    .slip-card:hover .slip-overlay {
        opacity: 1;
    }

    /* Badge kategori di dalam overlay berwarna gold */
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

    /* Judul di atas overlay dalam teks putih */
    .slip-title-overlay {
        color: white;
        font-size: 0.85rem;
        font-weight: 600;
        margin-top: 8px;
        line-height: 1.3;
    }

    /* Area info bawah kartu */
    .slip-info {
        padding: 14px 16px 16px;
        background: white;
        position: relative;
        border-top: 1px solid #f0f0f0;
    }

    /* Garis gold yang muncul dari kiri ke kanan saat hover */
    .slip-line {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, #c6a43b, #e8c45a, #c6a43b);
        transform: scaleX(0);
        transform-origin: left;
        transition: transform 0.3s ease;
    }

    /* Garis gold melebar penuh saat hover */
    .slip-card:hover .slip-line {
        transform: scaleX(1);
    }

    /* Judul foto di info bawah */
    .slip-title {
        font-size: 0.88rem;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 6px;
        line-height: 1.4;
    }

    /* Baris lokasi dengan ikon pin */
    .slip-location {
        font-size: 0.7rem;
        color: #94a3b8;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    /* Ikon lokasi berwarna gold */
    .slip-location i {
        font-size: 0.65rem;
        color: #c6a43b;
    }

    /* Nomor urut di pojok kanan bawah */
    .slip-number {
        position: absolute;
        bottom: 12px;
        right: 16px;
        font-size: 0.6rem;
        color: #cbd5e1;
        font-family: monospace;
    }

    /* Tampilan kosong jika tidak ada foto */
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
        display: block;
    }

    .empty-gallery p {
        color: #94a3b8;
        font-size: 0.9rem;
    }

    /* MODAL overlay penuh layar */
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

    /* Kotak modal dua kolom */
    .modal-box {
        background: #1a1a1a;
        width: 90%;
        max-width: 1000px;
        display: grid;
        grid-template-columns: 1.2fr 1fr;
        border-radius: 20px;
        overflow: hidden;
        animation: modalFadeIn 0.35s ease;
        position: relative;
    }

    @keyframes modalFadeIn {
        from { opacity: 0; transform: scale(0.96); }
        to { opacity: 1; transform: scale(1); }
    }

    /* Sisi kiri modal berisi gambar */
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

    /* Sisi kanan modal berisi info */
    .modal-text-part {
        padding: 35px;
        color: white;
        background: linear-gradient(135deg, #1a1a1a, #0d0d0d);
        display: flex;
        flex-direction: column;
    }

    /* Tombol tutup modal */
    .close-btn {
        position: absolute;
        top: 16px;
        right: 16px;
        color: white;
        font-size: 1.3rem;
        cursor: pointer;
        transition: all 0.3s ease;
        z-index: 10000;
        width: 38px;
        height: 38px;
        background: rgba(255,255,255,0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
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
        font-size: 1.4rem;
        margin: 10px 0 8px;
        font-family: 'Playfair Display', serif;
        line-height: 1.3;
    }

    .modal-text-part p {
        color: #bbb;
        line-height: 1.7;
        font-size: 0.85rem;
        margin: 0 0 8px;
    }

    /* Music player di dalam modal selalu di bagian bawah */
    .modal-music-player {
        margin-top: auto;
        padding: 12px 16px;
        background: rgba(0,0,0,0.5);
        border-radius: 50px;
        display: flex;
        align-items: center;
        gap: 12px;
        border: 1px solid rgba(198,164,59,0.4);
    }

    /* Avatar musik dengan animasi berdenyut */
    .modal-music-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #c6a43b, #e8c45a);
        display: flex;
        align-items: center;
        justify-content: center;
        animation: pulse 2s infinite;
        flex-shrink: 0;
    }

    @keyframes pulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.06); }
    }

    .modal-music-avatar i {
        color: #003366;
        font-size: 1.1rem;
    }

    .modal-music-info { flex: 1; min-width: 0; }

    .modal-music-title {
        font-size: 0.78rem;
        font-weight: 700;
        color: white;
    }

    .modal-music-artist {
        font-size: 0.65rem;
        color: #c6a43b;
    }

    .modal-music-controls button {
        background: rgba(255,255,255,0.15);
        border: none;
        color: white;
        cursor: pointer;
        font-size: 0.9rem;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        transition: all 0.2s;
        flex-shrink: 0;
    }

    .modal-music-controls button:hover {
        background: #c6a43b;
        color: #003366;
        transform: scale(1.1);
    }

    /* Responsive 1200px: lebar kartu dikecilkan */
    @media (max-width: 1200px) {
        .slip-card { width: 240px; }
        .slip-image { height: 260px; }
    }

    /* Responsive 992px: kartu lebih kecil dan overlap dikurangi */
    @media (max-width: 992px) {
        .slip-card {
            width: 200px;
            margin-left: -50px;
        }
        .slip-image { height: 230px; }
    }

    /* Responsive 768px: modal satu kolom dan kartu lebih kecil */
    @media (max-width: 768px) {
        .modal-box {
            grid-template-columns: 1fr;
            max-height: 88vh;
            overflow-y: auto;
        }
        .gallery-hero h1 { font-size: 2rem; }
        .slip-card {
            width: 160px;
            margin-left: -40px;
        }
        .slip-image { height: 190px; }
        .slip-title { font-size: 0.75rem; }
        .slip-location { font-size: 0.62rem; }
    }

    /* Responsive 480px: kartu sangat kecil dengan overlap minimal */
    @media (max-width: 480px) {
        .slip-card {
            width: 130px;
            margin-left: -32px;
        }
        .slip-image { height: 160px; }
        .stack-wrapper { gap: 28px; }
    }
</style>

<div class="gallery-hero">
    <div class="gallery-hero-content">
        <div class="hero-badge">UPDATE TERBARU</div>
        <h1>Galeri</h1>
        <p>Koleksi Foto Terbaik Geopark Danau Toba</p>
        <div class="hero-divider"></div>
    </div>
</div>

<section class="gallery-section">
    <div class="container">

        {{-- Kumpulkan semua foto ke dalam satu array flat terlebih dahulu --}}
        @php
            $allPhotos = [];
            foreach($galeriByKategori as $kategori => $items) {
                foreach($items as $item) {
                    $images = \App\Helpers\ImageHelper::getAllImages($item->gambar);
                    foreach($images as $img) {
                        $allPhotos[] = [
                            'src'      => $img,
                            'judul'    => $item->judul,
                            'deskripsi'=> $item->deskripsi ?? 'Tidak ada deskripsi',
                            'kategori' => strtoupper($kategori),
                            'lokasi'   => $item->lokasi ?? 'Danau Toba',
                        ];
                    }
                }
            }
            /* Jumlah kartu per baris dikunci di sini, ubah angka ini sesuai kebutuhan */
            $perRow = 5;
            $rows = array_chunk($allPhotos, $perRow);
            $counter = 1;
        @endphp

        @if(count($allPhotos) > 0)
            <div class="stack-wrapper">
                @foreach($rows as $row)
                    <div class="stack-row">
                        @foreach($row as $photo)
                            <div class="slip-card"
                                 onclick="openPhoto(
                                     '{{ $photo['src'] }}',
                                     '{{ addslashes($photo['judul']) }}',
                                     '{{ addslashes($photo['deskripsi']) }}',
                                     '{{ $photo['kategori'] }}',
                                     '{{ addslashes($photo['lokasi']) }}'
                                 )">
                                <div class="slip-image">
                                    <img src="{{ $photo['src'] }}"
                                         alt="{{ $photo['judul'] }}"
                                         loading="lazy"
                                         onerror="this.src='{{ asset('image/default.jpg') }}'">
                                    <div class="slip-overlay">
                                        <span class="slip-category">{{ $photo['kategori'] }}</span>
                                        <div class="slip-title-overlay">{{ Str::limit($photo['judul'], 38) }}</div>
                                    </div>
                                </div>
                                <div class="slip-info">
                                    <div class="slip-line"></div>
                                    <div class="slip-title">{{ Str::limit($photo['judul'], 30) }}</div>
                                    <div class="slip-location">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <span>{{ $photo['lokasi'] }}</span>
                                    </div>
                                    <div class="slip-number">#{{ str_pad($counter, 3, '0', STR_PAD_LEFT) }}</div>
                                </div>
                            </div>
                            @php $counter++; @endphp
                        @endforeach
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-gallery">
                <i class="fas fa-images"></i>
                <p>Belum ada foto galeri</p>
            </div>
        @endif

    </div>
</section>

<!-- MODAL FOTO DENGAN MUSIC PLAYER -->
<div id="pModal" class="modal-overlay" onclick="closePhoto()">
    <div class="close-btn" onclick="closePhoto()">&times;</div>
    <div class="modal-box" onclick="event.stopPropagation()">
        <div class="modal-img-part">
            <img src="" id="mImg" alt="">
        </div>
        <div class="modal-text-part">
            <small id="mTag"></small>
            <h2 id="mTitle"></h2>
            <p><i class="fas fa-map-marker-alt" style="color:#c6a43b; margin-right:6px;"></i><span id="mLocation"></span></p>
            <p id="mDesc"></p>

            <div class="modal-music-player">
                <div class="modal-music-avatar">
                    <i class="fas fa-music"></i>
                </div>
                <div class="modal-music-info">
                    <div class="modal-music-title">Gondang Batak</div>
                    <div class="modal-music-artist">Musik Instrumental Batak</div>
                </div>
                <div class="modal-music-controls">
                    <button id="modalPlayPauseBtn" onclick="toggleModalMusic(event)">
                        <i class="fas fa-play"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    /* Inisialisasi audio lagu yang diputar otomatis saat modal foto terbuka */
    const songUrl = "{{ asset('audio/GONDANG.weba') }}";
    let modalAudio = new Audio(songUrl);
    let isModalPlaying = false;
    modalAudio.loop = true;

    /* Fungsi toggle play dan pause musik di dalam modal */
    function toggleModalMusic(event) {
        if (event) event.stopPropagation();
        if (isModalPlaying) {
            modalAudio.pause();
            document.getElementById('modalPlayPauseBtn').innerHTML = '<i class="fas fa-play"></i>';
        } else {
            modalAudio.play().catch(e => console.log('Play error:', e));
            document.getElementById('modalPlayPauseBtn').innerHTML = '<i class="fas fa-pause"></i>';
        }
        isModalPlaying = !isModalPlaying;
    }

    /* Fungsi menghentikan musik dan mereset posisi ke awal */
    function stopModalMusic() {
        modalAudio.pause();
        modalAudio.currentTime = 0;
        isModalPlaying = false;
        document.getElementById('modalPlayPauseBtn').innerHTML = '<i class="fas fa-play"></i>';
    }

    /* Fungsi memutar musik otomatis saat modal pertama kali dibuka */
    function startModalMusic() {
        if (!isModalPlaying) {
            modalAudio.play().catch(e => console.log('Play error:', e));
            document.getElementById('modalPlayPauseBtn').innerHTML = '<i class="fas fa-pause"></i>';
            isModalPlaying = true;
        }
    }

    /* Fungsi membuka modal dan mengisi semua konten foto yang diklik */
    function openPhoto(src, title, desc, tag, location) {
        document.getElementById('mImg').src = src;
        document.getElementById('mImg').alt = title;
        document.getElementById('mTitle').innerText = title;
        document.getElementById('mTag').innerText = tag;
        document.getElementById('mDesc').innerHTML = desc || 'Tidak ada deskripsi.';
        document.getElementById('mLocation').innerText = location || 'Danau Toba';
        document.getElementById('pModal').style.display = 'flex';
        document.body.style.overflow = 'hidden';
        startModalMusic();
    }

    /* Fungsi menutup modal dan menghentikan musik */
    function closePhoto() {
        document.getElementById('pModal').style.display = 'none';
        document.body.style.overflow = 'auto';
        stopModalMusic();
    }

    /* Tutup modal saat tombol Escape ditekan */
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closePhoto();
    });

    /* Hentikan audio saat halaman di-refresh atau ditutup */
    window.addEventListener('beforeunload', function() {
        modalAudio.pause();
    });
</script>

@endsection