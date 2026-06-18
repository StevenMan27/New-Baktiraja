@extends('layouts.app')

{{-- Halaman Detail Kategori Destinasi --}}
{{-- Menampilkan daftar destinasi spesifik berdasarkan kategori yang dipilih oleh pengunjung. --}}

@section('title', 'Destinasi ' . $kategori . ' - Geosite Danau Toba')

@section('content')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Cormorant+Garamond:wght@400;500;600;700&display=swap');
    
    .kategori-hero {
        height: 40vh;
        min-height: 350px;
        background: linear-gradient(135deg, rgba(0,51,102,0.8), rgba(0,51,102,0.6));
        background-size: cover;
        background-position: center;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: white;
        margin-top: 76px;
    }
    
    .kategori-hero h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 10px;
        font-family: 'Cormorant Garamond', serif;
        text-shadow: 2px 2px 5px rgba(0,0,0,0.3);
    }
    
    .kategori-hero p {
        font-size: 0.9rem;
        letter-spacing: 0.2em;
        text-transform: uppercase;
        opacity: 0.9;
    }
    
    .destinasi-section {
        padding: 60px 0;
        background: #f8f9fa;
    }
    
    .destinasi-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 30px;
    }
    
    .dest-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        transition: all 0.4s cubic-bezier(0.2, 0.9, 0.4, 1.1);
        text-decoration: none;
        display: block;
    }
    
    .dest-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    }
    
    .card-image {
        height: 220px;
        overflow: hidden;
    }
    
    .card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }
    
    .dest-card:hover .card-image img {
        transform: scale(1.08);
    }
    
    .card-content {
        padding: 20px;
    }
    
    .card-title {
        font-size: 1.3rem;
        font-weight: 700;
        margin-bottom: 8px;
        color: #003366;
        font-family: 'Cormorant Garamond', serif;
    }
    
    .card-location {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 0.7rem;
        color: #c6a43b;
        margin-bottom: 12px;
    }
    
    .card-location i {
        font-size: 0.6rem;
    }
    
    .card-desc {
        font-size: 0.85rem;
        color: #666;
        line-height: 1.6;
        margin-bottom: 15px;
    }
    
    .card-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }
    
    .card-tags span {
        background: #f0f4f0;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.7rem;
        color: #003366;
    }
    
    .empty-state {
        grid-column: 1 / -1;
        text-align: center;
        padding: 60px 20px;
        background: white;
        border-radius: 20px;
    }
    
    .empty-state i {
        font-size: 3rem;
        color: #ccc;
        margin-bottom: 15px;
    }
    
    .empty-state h3 {
        font-size: 1.3rem;
        color: #666;
    }
    
    .back-button {
        text-align: center;
        margin-top: 40px;
    }
    
    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #003366;
        color: white;
        padding: 12px 30px;
        border-radius: 50px;
        text-decoration: none;
        font-size: 0.85rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-back:hover {
        background: #c6a43b;
        color: #003366;
        transform: translateX(-5px);
    }
    
    @media (max-width: 992px) {
        .destinasi-grid { grid-template-columns: repeat(2, 1fr); gap: 25px; }
    }
    
    @media (max-width: 768px) {
        .kategori-hero { min-height: 280px; }
        .kategori-hero h1 { font-size: 1.8rem; }
        .destinasi-section { padding: 40px 0; }
        .destinasi-grid { grid-template-columns: 1fr; gap: 20px; }
        .card-image { height: 200px; }
    }
</style>

@php
    $homepage = \App\Models\Homepage::first();
    $bgImage = !empty($homepage->hero_slide_1) ? asset("storage/" . $homepage->hero_slide_1) : asset("image/bakara/bakara-slide1.jpg");
    $heroSubtitle = $homepage->hero_subtitle ?? 'KAWASAN WISATA GEOPARK DANAU TOBA';
    $heroTitle = $homepage->hero_title ?? 'BAKARA &middot; TIPANG<br>BAKTIRAJA';
@endphp

{{-- Hero Banner Kategori --}}
{{-- Menampilkan informasi visual utama untuk kategori wisata yang sedang dilihat oleh pengunjung. --}}
<section class="kategori-hero" style="background-image: linear-gradient(135deg, rgba(0,51,102,0.5), rgba(0,102,153,0.3)), url('{{ $bgImage }}');">
    <div data-aos="fade-up">
        <div style="font-size: 0.7rem; letter-spacing: 0.35em; text-transform: uppercase; margin-bottom: 20px; font-weight: 300; opacity: 0.9; margin-right: -0.35em;">{{ $heroSubtitle }}</div>
        <h1 style="font-size: 3.8rem; font-weight: 700; font-family: 'Cormorant Garamond', serif; line-height: 1.2; margin-bottom: 10px; color: white; text-shadow: 0 2px 15px rgba(0, 0, 0, 0.4);">{!! $heroTitle !!}</h1>
        <div style="font-size: 1rem; opacity: 0.9; margin-top: 15px;">Keajaiban Alam, Jejak Sejarah, dan Pesona Budaya di Tepian Danau Toba</div>
    </div>
</section>

{{-- Daftar Destinasi --}}
{{-- Menampilkan grid berisi kartu destinasi wisata sesuai dengan kategori yang dipilih. --}}
<section class="destinasi-section">
    <div class="container">
        <div class="destinasi-grid">
            @forelse($destinasi as $item)
            @php
                // Mapping slug langsung ke named route geosite
                $geositeRoutes = [
                    'air-terjun-janji'        => 'geosite.air-terjun-janji',
                    'aek-sitio-tio'           => 'geosite.aek-sitio-tio',
                    'desa-wisata-tipang'      => 'geosite.desa-wisata-tipang',
                    'panatapan-bakara'        => 'geosite.panatapan-bakara',
                    'gonting'                 => 'geosite.gonting',
                    'istana-sisingamangaraja' => 'geosite.istana-sisingamangaraja',
                    'tombak-sulu-sulu'        => 'geosite.tombak-sulu-sulu',
                    'aek-sipangolu'           => 'geosite.aek-sipangolu',
                ];
                $targetRoute = $geositeRoutes[$item->slug] ?? null;
            @endphp
            
            @if($targetRoute)
                <a href="{{ route($targetRoute) }}" class="dest-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
            @else
                <a href="{{ url('/destinasi/' . $item->kategori . '/' . $item->slug) }}" class="dest-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
            @endif
                <div class="card-image">
                    <img src="{{ asset($item->gambar) }}" alt="{{ $item->nama }}">
                </div>
                <div class="card-content">
                    <h3 class="card-title">{{ $item->nama }}</h3>
                    <div class="card-location">
                        <i class="fas fa-map-marker-alt"></i> {{ $item->lokasi }}
                    </div>
                    <p class="card-desc">{{ Str::limit($item->deskripsi, 100) }}</p>
                    <div class="card-tags">
                        @foreach(array_slice($item->tags, 0, 3) as $tag)
                        <span>#{{ $tag }}</span>
                        @endforeach
                    </div>
                </div>
            </a>
            @empty
            <div class="empty-state">
                <i class="fas fa-mountain"></i>
                <h3>Belum Ada Destinasi</h3>
                <p>Destinasi pada kategori ini akan segera ditambahkan.</p>
            </div>
            @endforelse
        </div>
        
        <div class="back-button">
            <a href="{{ url('/destinasi') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i> Kembali ke Semua Destinasi
            </a>
        </div>
    </div>
</section>

<link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script>
    AOS.init({ duration: 800, once: true, offset: 50 });
</script>

@endsection