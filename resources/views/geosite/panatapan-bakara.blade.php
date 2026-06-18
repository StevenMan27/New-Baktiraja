{{-- Menampilkan halaman profil detail geosite --}}
{{-- Memuat komponen UI interaktif seperti navbar, hero, galeri wisata, konten narasi, dan peta lokasi --}}


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Panatapan Bakara - Wisata Bakara Tipang Baktiraja</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Cormorant+Garamond:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #f0f4f3; }
        :root { --bi-blue: #003366; --bi-gold: #c6a43b; --bi-light: #e8f0f0; --bi-dark: #002244; }
        
         .navbar { 
            position: fixed; 
            top: 0; 
            left: 0; 
            width: 100%; 
            z-index: 1000; 
            background: rgba(255, 255, 255, 0.98); 
            backdrop-filter: blur(10px); 
            border-bottom: 1px solid rgba(0, 0, 0, 0.08); 
            padding: 12px 0; 
        }
        .nav-container { 
            max-width: 100%; 
            margin: 0 auto; 
            padding: 0 16px; 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
        }
        .nav-logo { display: flex; align-items: center; gap: 12px; }
        .flag-img { width: 65px; height: auto; border-radius: 5px; }
        .logo-divider { width: 1px; height: 30px; background: rgba(0, 0, 0, 0.1); }
        .del-img { width: 32px; height: auto; border-radius: 5px; }
        .logo-text h4 { font-size: 0.85rem; font-weight: 700; letter-spacing: 1.5px; color: var(--bi-blue); }
        .logo-text p { font-size: 0.4rem; font-weight: 400; color: rgba(0, 0, 0, 0.5); }
        .nav-menu { display: flex; gap: 28px; align-items: center; }
        .nav-link { 
            font-size: 0.7rem; 
            letter-spacing: 0.15em; 
            text-transform: uppercase; 
            text-decoration: none; 
            color: rgba(0, 0, 0, 0.7); 
            font-weight: 600; 
            transition: 0.3s; 
            padding: 6px 0; 
        }
        .nav-link:hover { color: var(--bi-gold); }
        .nav-link.active { color: var(--bi-gold); border-bottom: 2px solid var(--bi-gold); }
        .home-btn { 
            background: var(--bi-gold); 
            color: var(--bi-blue) !important; 
            padding: 6px 18px; 
            border-radius: 40px; 
        }
        .home-btn:hover { background: var(--bi-blue); color: white !important; }
        .hamburger { 
            display: none; 
            cursor: pointer; 
            background: rgba(0, 0, 0, 0.05); 
            padding: 8px 12px; 
            border-radius: 50px; 
            border: 1px solid rgba(0, 0, 0, 0.1); 
        }
        .hamburger span { 
            display: block; 
            width: 20px; 
            height: 2px; 
            background: var(--bi-blue); 
            margin: 4px 0; 
        }
        .mobile-overlay { 
            display: none; 
            position: fixed; 
            top: 70px; 
            left: 16px; 
            right: 16px; 
            background: white; 
            z-index: 1001; 
            padding: 15px 0; 
            border-radius: 20px; 
            box-shadow: 0 16px 40px rgba(0,0,0,0.1); 
            border: 1px solid rgba(0,0,0,0.08); 
        }
        .mobile-overlay.active { display: block; animation: zoomIn 0.3s ease; }
        .mobile-close { display: none; }
        .mobile-link { 
            display: block; 
            font-size: 0.95rem; 
            text-decoration: none; 
            color: #2c2c2c; 
            padding: 12px 24px; 
            text-align: center; 
            font-weight: 500; 
            transition: all 0.25s ease;
            margin: 4px 16px;
            border-radius: 14px;
        }
        .mobile-link:hover { color: var(--bi-gold); background: #f5f5f5; }
        .mobile-link.active { color: var(--bi-gold); font-weight: 700; background: rgba(198, 164, 59, 0.05); }
        
        .hero { height: 55vh; min-height: 450px; background-color: var(--bi-blue); background-image: linear-gradient(rgba(0,51,102,0.45), rgba(0,51,102,0.55)), url('{{ asset('image/bakara/panatapan-bakara.jpg') }}'); background-size: cover; background-position: center; display: flex; align-items: center; justify-content: center; text-align: center; color: white; margin-top: 65px; }
        .hero-title { font-size: 3rem; font-family: 'Cormorant Garamond', serif; margin-bottom: 12px; }
        .hero-subtitle { font-size: 0.75rem; letter-spacing: 0.2em; text-transform: uppercase; }
        
        .section { padding: 60px 0; }
        .bg-light { background: var(--bi-light); }
        .container { max-width: 1200px; margin: 0 auto; padding: 0 24px; }
        .section-title { text-align: center; margin-bottom: 45px; }
        .section-title h2 { font-size: 2rem; font-family: 'Cormorant Garamond', serif; color: var(--bi-blue); }
        .divider { width: 50px; height: 2px; background: var(--bi-gold); margin: 10px auto 0; }
        .section-title p { color: #6c7a7a; font-size: 0.85rem; margin-top: 12px; }
        
        .sejarah-grid { display: flex; flex-direction: column; gap: 50px; }
        .sejarah-item { display: flex; align-items: center; gap: 50px; flex-wrap: wrap; }
        .sejarah-item.reverse { flex-direction: row-reverse; }
        .sejarah-text { flex: 1; line-height: 1.8; color: #444; font-size: 0.95rem; }
        .sejarah-image { flex: 1; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.08); }
        .sejarah-image img { width: 100%; height: 280px; object-fit: cover; transition: 0.3s; }
        .sejarah-image:hover img { transform: scale(1.02); }
        
        .galeri-grid { display: flex; flex-wrap: wrap; justify-content: center; gap: 15px; }
        .galeri-item { width: 250px; max-width: 100%; display: block; aspect-ratio: 1/1; overflow: hidden; border-radius: 14px; cursor: pointer; background: #e8e8e8; }
        .galeri-item img { width: 100%; height: 100%; object-fit: cover; transition: 0.3s; }
        .galeri-item:hover img { transform: scale(1.03); }
        
        .info-praktis { background: white; border-radius: 20px; padding: 30px; box-shadow: 0 10px 25px rgba(0,0,0,0.08); }
        .info-praktis-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; text-align: center; }
        .info-praktis-item h4 { font-size: 0.7rem; letter-spacing: 0.15em; color: var(--bi-gold); margin-bottom: 8px; }
        .info-praktis-item p { color: var(--bi-blue); font-weight: 500; }
        .tags { display: flex; flex-wrap: wrap; justify-content: center; gap: 10px; margin-top: 20px; }
        .tag { background: rgba(0,51,102,0.1); padding: 5px 15px; border-radius: 30px; font-size: 0.7rem; color: var(--bi-blue); }
        
        .umkm-grid { display: flex; flex-wrap: wrap; justify-content: center; gap: 25px; }
        .umkm-card { width: 340px; max-width: 100%; background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.08); transition: all 0.3s; }
        .umkm-card:hover { transform: translateY(-5px); box-shadow: 0 15px 30px rgba(0,0,0,0.15); }
        .umkm-img { height: 180px; overflow: hidden; }
        .umkm-img img { width: 100%; height: 100%; object-fit: cover; transition: 0.3s; }
        .umkm-card:hover .umkm-img img { transform: scale(1.05); }
        .umkm-content { padding: 20px; }
        .umkm-content h4 { font-size: 1rem; color: var(--bi-blue); margin-bottom: 5px; }
        .umkm-content p { font-size: 0.7rem; color: var(--bi-gold); margin-bottom: 10px; }
        .umkm-content .desc { font-size: 0.75rem; color: #666; line-height: 1.5; }
        
        .penginapan-grid { display: flex; flex-wrap: wrap; justify-content: center; gap: 25px; }
        .penginapan-card { width: 340px; max-width: 100%; background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.08); transition: all 0.3s; }
        .penginapan-card:hover { transform: translateY(-5px); box-shadow: 0 15px 30px rgba(0,0,0,0.15); }
        .penginapan-img { height: 180px; overflow: hidden; }
        .penginapan-img img { width: 100%; height: 100%; object-fit: cover; transition: 0.3s; }
        .penginapan-card:hover .penginapan-img img { transform: scale(1.05); }
        .penginapan-content { padding: 20px; }
        .penginapan-content h4 { font-size: 1rem; color: var(--bi-blue); margin-bottom: 5px; }
        .penginapan-content .price { font-size: 0.75rem; color: var(--bi-gold); font-weight: 600; margin-bottom: 8px; }
        .penginapan-content .desc { font-size: 0.7rem; color: #666; }
        
        .card-location { font-size: 0.72rem; color: #555; margin-top: 6px; }
        .card-contact { font-size: 0.72rem; color: #555; margin-top: 4px; }

        /* Penginapan Cards (CRUD-driven) */
        .penginapan-grid { display: flex; flex-wrap: wrap; justify-content: center; gap: 25px; }
        .penginapan-card { width: 340px; max-width: 100%; background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.08); transition: all 0.3s; }
        .penginapan-card:hover { transform: translateY(-5px); box-shadow: 0 15px 30px rgba(0,0,0,0.15); }
        .penginapan-img { height: 180px; overflow: hidden; }
        .penginapan-img img { width: 100%; height: 100%; object-fit: cover; transition: 0.3s; }
        .penginapan-card:hover .penginapan-img img { transform: scale(1.05); }
        .penginapan-content { padding: 20px; }
        .penginapan-content h4 { font-size: 1rem; color: var(--bi-blue); margin-bottom: 5px; }
        .penginapan-content .price { font-size: 0.75rem; color: var(--bi-gold); font-weight: 600; margin-bottom: 8px; }
        .penginapan-content .desc { font-size: 0.7rem; color: #666; }
        .card-price { font-size: 0.75rem; color: var(--bi-gold); font-weight: 600; margin-top: 6px; }

        /* Fasilitas (CRUD-driven) */
        .fasilitas-grid { display: flex; flex-wrap: wrap; justify-content: center; gap: 25px; }
        .fasilitas-item { width: 340px; max-width: 100%; display: flex; flex-direction: column; gap: 0; background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.08); transition: all 0.3s; }
        .fasilitas-item:hover { transform: translateY(-4px); box-shadow: 0 15px 30px rgba(0,0,0,0.12); }
        .fasilitas-img { width: 100%; height: 200px; object-fit: cover; flex-shrink: 0; }
        .fasilitas-content { padding: 20px; display: flex; flex-direction: column; justify-content: center; }
        .fasilitas-content h4 { font-size: 0.95rem; color: var(--bi-blue); margin-bottom: 6px; }
        .fasilitas-content p { font-size: 0.75rem; color: #666; line-height: 1.5; }
        .fasilitas-price { font-size: 0.72rem; color: var(--bi-gold); font-weight: 600; margin-top: 6px; }

        /* Berita Cards (CRUD-driven) */
        .berita-grid { display: flex; flex-wrap: wrap; justify-content: center; gap: 20px; }
        .berita-card { width: 265px; max-width: 100%; background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.08); transition: all 0.3s; }
        .berita-card:hover { transform: translateY(-5px); box-shadow: 0 15px 30px rgba(0,0,0,0.15); }
        .berita-img { height: 160px; overflow: hidden; }
        .berita-img img { width: 100%; height: 100%; object-fit: cover; transition: 0.3s; }
        .berita-card:hover .berita-img img { transform: scale(1.05); }
        .berita-content { padding: 20px; }
        .berita-content h4 { font-size: 1rem; color: var(--bi-blue); margin-bottom: 8px; font-family: 'Cormorant Garamond', serif; line-height: 1.4; }
        .berita-content .berita-meta { font-size: 0.65rem; color: var(--bi-gold); text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 10px; }
        .berita-content .berita-excerpt { font-size: 0.75rem; color: #666; line-height: 1.6; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }

        .rekomendasi-grid { display: flex; flex-wrap: wrap; justify-content: center; gap: 20px; }
        .rekomendasi-card { width: 265px; max-width: 100%; background: white; border-radius: 16px; overflow: hidden; cursor: pointer; transition: all 0.3s; box-shadow: 0 5px 15px rgba(0,0,0,0.08); }
        .rekomendasi-card:hover { transform: translateY(-5px); box-shadow: 0 15px 30px rgba(0,0,0,0.15); }
        .rekomendasi-img { height: 150px; overflow: hidden; }
        .rekomendasi-img img { width: 100%; height: 100%; object-fit: cover; transition: 0.3s; }
        .rekomendasi-card:hover .rekomendasi-img img { transform: scale(1.05); }
        .rekomendasi-content { padding: 15px; text-align: center; }
        .rekomendasi-content h4 { font-size: 0.85rem; color: var(--bi-blue); margin-bottom: 5px; }
        .rekomendasi-content p { font-size: 0.65rem; color: #888; }
        
        .maps-container { border-radius: 20px; overflow: hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
        .maps-container iframe { width: 100%; height: 400px; border: 0; }
        .maps-info { background: var(--bi-blue); padding: 20px; text-align: center; color: white; }
        .maps-info p { font-size: 0.75rem; opacity: 0.9; }
        
        .cta { background: var(--bi-blue); padding: 50px 0; text-align: center; color: white; }
        .cta h3 { font-size: 1.6rem; font-family: 'Cormorant Garamond', serif; margin-bottom: 12px; }
        .cta .divider { margin: 0 auto 18px; background: var(--bi-gold); }
        .cta p { opacity: 0.8; margin-bottom: 25px; }
        .cta-btn { display: inline-block; background: var(--bi-gold); color: var(--bi-blue); padding: 12px 35px; font-size: 0.7rem; letter-spacing: 0.2em; text-transform: uppercase; border-radius: 50px; text-decoration: none; font-weight: 600; transition: 0.3s; }
        .cta-btn:hover { background: white; transform: translateY(-2px); }
        
        .lightbox { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.9); z-index: 10002; justify-content: center; align-items: center; cursor: pointer; }
        .lightbox.active { display: flex; }
        .lightbox img { max-width: 90%; max-height: 85vh; border-radius: 6px; }
        .lightbox-close { position: absolute; top: 20px; right: 30px; color: white; font-size: 32px; cursor: pointer; }
        .lightbox-close:hover { color: var(--bi-gold); }
        
        @media (max-width: 992px) { .umkm-grid, .penginapan-grid, .fasilitas-grid, .berita-grid { grid-template-columns: repeat(2, 1fr); } .rekomendasi-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 768px) {
            .nav-menu { display: none; } .hamburger { display: block; }
            .hero { margin-top: 65px; min-height: 350px; } .hero-title { font-size: 2rem; }
            .section { padding: 40px 0; } .galeri-grid { grid-template-columns: repeat(2, 1fr); }
            .sejarah-item, .sejarah-item.reverse { flex-direction: column; text-align: center; }
            .umkm-grid, .penginapan-grid, .fasilitas-grid, .berita-grid { grid-template-columns: 1fr; }
            .fasilitas-item { flex-direction: column; } .fasilitas-img { width: 100%; height: 180px; } .rekomendasi-grid { grid-template-columns: 1fr; }
            .maps-container iframe { height: 280px; }
        }
        @media (max-width: 576px) { .hero-title { font-size: 1.6rem; } .galeri-grid { grid-template-columns: 1fr; } .hero { min-height: 300px; } }

    
        /* Section title scroll highlight animation */
        .section-title h2 { transition: color 0.5s ease; }
        .section-title.in-view h2 { color: var(--bi-gold) !important; }
            .sejarah-intro { text-align: justify; }
    .sejarah-text p { text-align: justify; }
    </style>
</head>
<body>

<div class="navbar">
    <div class="nav-container">
        <div class="nav-logo">
            <img src="{{ asset('image/Logo/logobankindonesia.jpg') }}" alt="Bank Indonesia" class="flag-img">
            <div class="logo-divider"></div>
            <img src="{{ asset('image/Logo/del.jpg') }}" alt="Logo Del" class="del-img">
            <div class="logo-divider"></div>
            <a href="{{ url('/') }}" style="font-size: 1.65rem; font-weight: 800; color: var(--bi-blue); text-decoration: none; padding-left: 4px; letter-spacing: -0.3px;">Geo<span style="color: var(--bi-gold);">Toba</span></a>
        </div>
        <div class="nav-menu">
            <a href="#sejarah" class="nav-link">Tentang</a>
            <a href="#informasi" class="nav-link">Informasi</a>
            <a href="#galeri" class="nav-link">Galeri</a>
            <a href="#umkm" class="nav-link">UMKM</a>
            <a href="#penginapan" class="nav-link">Penginapan</a>
        <a href="#fasilitas" class="nav-link">Fasilitas</a>
            <a href="#berita" class="nav-link">Berita</a>
        </div>
        <div class="hamburger" id="hamburger"><span></span><span></span><span></span></div>
    </div>
</div>

<div class="mobile-overlay" id="mobileOverlay">
    <a href="#sejarah" class="mobile-link">Tentang</a>
    <a href="#informasi" class="mobile-link">Informasi</a>
    <a href="#galeri" class="mobile-link">Galeri</a>
    <a href="#umkm" class="mobile-link">UMKM</a>
    <a href="#penginapan" class="mobile-link">Penginapan</a>
<a href="#fasilitas" class="mobile-link">Fasilitas</a>
    <a href="#berita" class="mobile-link">Berita</a>
</div>

@php
    $bgHero = ($profil && $profil->bg_hero && is_array($profil->bg_hero) && count($profil->bg_hero) > 0) 
        ? asset('storage/' . $profil->bg_hero[0]) 
        : asset('image/default-hero.jpg');
@endphp
<section class="hero" style="background-color: #003366; background-image: linear-gradient(rgba(0,51,102,0.45), rgba(0,51,102,0.55)), url('{{ $bgHero }}'); background-size: cover; background-position: center;">
    <div data-aos="fade-up">
        <h1 class="hero-title">{{ $profil->judul_utama ?? 'JUDUL UTAMA' }}</h1>
        <p class="hero-subtitle">{{ $profil->sub_judul ?? 'SUB JUDUL' }}</p>
    </div>
</section>

<section id="sejarah" class="section">
    <div class="container">
        <div class="section-title" data-aos="fade-up">
            <h2>{{ $profil->deskripsi_1_judul ?? 'Judul Deskripsi' }}</h2>
            <div class="divider"></div>
        </div>
        <div class="sejarah-intro" style="margin-bottom: 50px; line-height: 1.8; color: #444; font-size: 0.95rem;">
            {!! nl2br(e($profil->deskripsi_1_teks ?? '')) !!}
        </div>

        <div class="sejarah-grid">
            @if($profil && $profil->deskripsi_2_judul)
            <div class="sejarah-item reverse" data-aos="fade-left">
                <div class="sejarah-image">
                    @php $img2 = (is_array($profil->deskripsi_2_gambar) && count($profil->deskripsi_2_gambar) > 0) ? asset('storage/' . $profil->deskripsi_2_gambar[0]) : asset('image/default-image.jpg'); @endphp
                    <img src="{{ $img2 }}" alt="Gambar">
                </div>
                <div class="sejarah-text">
                    <h4 style="color: var(--bi-blue); margin-bottom: 12px; font-family: 'Cormorant Garamond', serif;">{{ $profil->deskripsi_2_judul }}</h4>
                    <p>{!! nl2br(e($profil->deskripsi_2_teks)) !!}</p>
                </div>
            </div>
            @endif

            @if($profil && $profil->deskripsi_3_judul)
            <div class="sejarah-item" data-aos="fade-right">
                <div class="sejarah-image">
                    @php $img3 = (is_array($profil->deskripsi_3_gambar) && count($profil->deskripsi_3_gambar) > 0) ? asset('storage/' . $profil->deskripsi_3_gambar[0]) : asset('image/default-image.jpg'); @endphp
                    <img src="{{ $img3 }}" alt="Gambar">
                </div>
                <div class="sejarah-text">
                    <h4 style="color: var(--bi-blue); margin-bottom: 12px; font-family: 'Cormorant Garamond', serif;">{{ $profil->deskripsi_3_judul }}</h4>
                    <p>{!! nl2br(e($profil->deskripsi_3_teks)) !!}</p>
                </div>
            </div>
            @endif

            @if($profil && $profil->deskripsi_4_judul)
            <div class="sejarah-item reverse" data-aos="fade-left">
                <div class="sejarah-image">
                    @php $img4 = (is_array($profil->deskripsi_4_gambar) && count($profil->deskripsi_4_gambar) > 0) ? asset('storage/' . $profil->deskripsi_4_gambar[0]) : asset('image/default-image.jpg'); @endphp
                    <img src="{{ $img4 }}" alt="Gambar">
                </div>
                <div class="sejarah-text">
                    <h4 style="color: var(--bi-blue); margin-bottom: 12px; font-family: 'Cormorant Garamond', serif;">{{ $profil->deskripsi_4_judul }}</h4>
                    <p>{!! nl2br(e($profil->deskripsi_4_teks)) !!}</p>
                </div>
            </div>
            @endif

            @if($profil && $profil->deskripsi_5_judul)
            <div class="sejarah-item" data-aos="fade-right">
                <div class="sejarah-image">
                    @php $img5 = (is_array($profil->deskripsi_5_gambar) && count($profil->deskripsi_5_gambar) > 0) ? asset('storage/' . $profil->deskripsi_5_gambar[0]) : asset('image/default-image.jpg'); @endphp
                    <img src="{{ $img5 }}" alt="Gambar">
                </div>
                <div class="sejarah-text">
                    <h4 style="color: var(--bi-blue); margin-bottom: 12px; font-family: 'Cormorant Garamond', serif;">{{ $profil->deskripsi_5_judul }}</h4>
                    <p>{!! nl2br(e($profil->deskripsi_5_teks)) !!}</p>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>

<section id="informasi" class="section bg-light">
    <div class="container">
        <div class="section-title" data-aos="fade-up">
            <h2>Informasi Praktis</h2>
            <div class="divider"></div>
        </div>
        <div class="info-praktis">
            <div class="info-praktis-grid">
                <div class="info-praktis-item">
                    <h4>LOKASI</h4>
                    <p>{{ $profil->info_lokasi ?? '-' }}</p>
                </div>
                <div class="info-praktis-item">
                    <h4>JAM OPERASIONAL</h4>
                    <p>{{ $profil->info_jam ?? '-' }}</p>
                </div>
                <div class="info-praktis-item">
                    <h4>HARGA TIKET</h4>
                    <p>{{ $profil->info_harga ?? '-' }}</p>
                </div>
            </div>
            <div class="tags">
                @if($profil && is_array($profil->tags))
                    @foreach($profil->tags as $tag)
                        <span class="tag">{{ $tag }}</span>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</section>

<section id="galeri" class="section"><div class="container"><div class="section-title" data-aos="fade-up"><h2>Galeri Foto</h2><div class="divider"></div></div>
<div class="galeri-grid" id="galeriGrid">
    @forelse($galeri as $item)
    @php $images = \App\Helpers\ImageHelper::getAllImages($item->gambar); @endphp
    @foreach($images as $img)

    <div class="galeri-item" onclick="openLightbox('{{ $img }}')">
        <img src="{{ $img }}" alt="{{ $item->judul }}">
    </div>
    
    @endforeach
    @empty
    <div style="grid-column:1/-1;text-align:center;padding:2rem;color:#888;">
        <p>Belum ada foto galeri untuk geosite ini.</p>
    </div>
    @endforelse
</div></div></section>

<!-- UMKM — CRUD Read dari database via $umkm (injected dari TUKTUK.txt) -->
<section id="umkm" class="section bg-light"><div class="container"><div class="section-title" data-aos="fade-up"><h2>UMKM Lokal</h2><div class="divider"></div></div>
<div class="umkm-grid">
    @forelse($umkm as $item)
    @php $images = \App\Helpers\ImageHelper::getAllImages($item->gambar); @endphp
    @if(count($images) > 0)
        @foreach($images as $img)
        <div class="umkm-card" data-aos="zoom-in">
        <div class="umkm-img">
            <img src="{{ $img }}" alt="{{ $item->nama }}">
        </div>
        <div class="umkm-content">
            <h4>{{ $item->nama }}</h4>
            <p class="desc">{{ $item->deskripsi }}</p>
            @if($item->lokasi)
            <div class="card-location">ðŸ“ {{ $item->lokasi }}</div>
            @endif
            @if($item->kontak)
            <div class="card-contact">ðŸ“ž {{ $item->kontak }}</div>
            @endif
            </div>
    </div>
        @endforeach
    @else
        <div class="umkm-card" data-aos="zoom-in">
        
        <div class="umkm-content">
            <h4>{{ $item->nama }}</h4>
            <p class="desc">{{ $item->deskripsi }}</p>
            @if($item->lokasi)
            <div class="card-location">ðŸ“ {{ $item->lokasi }}</div>
            @endif
             
            @if($item->kontak)
            <div class="card-contact">ðŸ“ž {{ $item->kontak }}</div>
            @endif
             
        </div>
    </div>
    @endif

    @empty
    <div style="grid-column:1/-1;text-align:center;padding:2rem;color:#888;">
        <p>Belum ada data UMKM untuk geosite ini.</p>
    </div>
    @endforelse
</div></div></section>

<!-- PENGINAPAN — CRUD Read dari database via $penginapan (injected dari TUKTUK.txt) -->
<section id="penginapan" class="section"><div class="container"><div class="section-title" data-aos="fade-up"><h2>Penginapan & Homestay</h2><div class="divider"></div></div>
<div class="penginapan-grid">
    @forelse($penginapan as $item)
    @php $images = \App\Helpers\ImageHelper::getAllImages($item->gambar); @endphp
    @if(count($images) > 0)
        @foreach($images as $img)
        <div class="penginapan-card" data-aos="zoom-in">
        <div class="penginapan-img">
            <img src="{{ $img }}" alt="{{ $item->nama }}">
        </div>
        <div class="penginapan-content">
            <h4>{{ $item->nama }}</h4>
            <p class="desc">{{ $item->deskripsi }}</p>
            @if($item->harga)
            <div class="card-price">Rp. {{ $item->harga }}</div>
            @endif
            @if($item->kontak)
            <div class="card-contact">ðŸ“ž {{ $item->kontak }}</div>
            @endif
            </div>
    </div>
        @endforeach
    @else
        <div class="penginapan-card" data-aos="zoom-in">
        
        <div class="penginapan-content">
            <h4>{{ $item->nama }}</h4>
            <p class="desc">{{ $item->deskripsi }}</p>
            @if($item->harga)
            <div class="card-price">Rp. {{ $item->harga }}</div>
            @endif
             
            @if($item->kontak)
            <div class="card-contact">ðŸ“ž {{ $item->kontak }}</div>
            @endif
             
        </div>
    </div>
    @endif

    @empty
    <div style="grid-column:1/-1;text-align:center;padding:2rem;color:#888;">
        <p>Belum ada data penginapan untuk geosite ini.</p>
    </div>
    @endforelse
</div></div></section>

<!-- FASILITAS — CRUD Read dari database via $fasilitas (injected dari TUKTUK.txt) -->
<section id="fasilitas" class="section bg-light"><div class="container"><div class="section-title" data-aos="fade-up"><h2>Fasilitas & Layanan</h2><div class="divider"></div></div>
<div class="fasilitas-grid">
    @forelse($fasilitas as $item)
    @php $images = \App\Helpers\ImageHelper::getAllImages($item->gambar); @endphp
    @if(count($images) > 0)
        @foreach($images as $img)
        <div class="fasilitas-item" data-aos="zoom-in">
        <img src="{{ $img }}" class="fasilitas-img" alt="{{ $item->nama }}">
        <div class="fasilitas-content">
            <h4>{{ $item->nama }}</h4>
            <p>{{ $item->deskripsi }}</p>
            @if($item->harga)
            <div class="fasilitas-price">{{ $item->harga }}</div>
            @endif
            </div>
    </div>
        @endforeach
    @else
        <div class="fasilitas-item" data-aos="zoom-in">
        
        <div class="fasilitas-content">
            <h4>{{ $item->nama }}</h4>
            <p>{{ $item->deskripsi }}</p>
            @if($item->harga)
            <div class="fasilitas-price">{{ $item->harga }}</div>
            @endif
             
        </div>
    </div>
    @endif

    @empty
    <div style="grid-column:1/-1;text-align:center;padding:2rem;color:#888;">
        <p>Belum ada data fasilitas untuk geosite ini.</p>
    </div>
    @endforelse
</div></div></section>

<!-- BERITA — CRUD Read dari database via $berita (model Berita, status aktif) -->
<section id="berita" class="section"><div class="container"><div class="section-title" data-aos="fade-up"><h2>Berita & Informasi Terkini</h2><div class="divider"></div></div>
@if($berita->count() == 0 && $informasi_dinamis->count() == 0)
    <div style="text-align:center;padding:2rem;color:#888;">
        <p>Belum ada Berita & Informasi untuk geosite ini.</p>
    </div>
@else
    @if($berita->count() > 0)
    <div class="berita-grid">
        @foreach($berita as $item)
        @php $images = \App\Helpers\ImageHelper::getAllImages($item->gambar); @endphp
        @if(count($images) > 0)
            @foreach($images as $img)
            <div class="berita-card" data-aos="zoom-in" onclick="openReader({{ $item->id }}, 'berita')" style="cursor:pointer;">
        <div class="berita-img">
            <img src="{{ $img }}" alt="{{ $item->judul }}">
        </div>
        <div class="berita-content">
            
            <h4>{{ $item->judul }}</h4>
            <p class="berita-excerpt">{{ strip_tags($item->konten) }}</p>
        </div>
    </div>
            @endforeach
        @else
            <div class="berita-card" data-aos="zoom-in" onclick="openReader({{ $item->id }}, 'berita')" style="cursor:pointer;">
        
        <div class="berita-content">
            
            <h4>{{ $item->judul }}</h4>
            <p class="berita-excerpt">{{ strip_tags($item->konten) }}</p>
        </div>
    </div>
        @endif
        @endforeach
    </div>
    @endif

@if($informasi_dinamis->count() > 0)
<div class="berita-grid" style="margin-top: 25px;">
    @foreach($informasi_dinamis as $item)
    @php $images = \App\Helpers\ImageHelper::getAllImages($item->gambar); @endphp
    @if(count($images) > 0)
        @foreach($images as $img)
        <div class="berita-card" data-aos="zoom-in" onclick="openReader({{ $item->id }}, 'informasi')" style="cursor:pointer;">
        <div class="berita-img">
            <img src="{{ $img }}" alt="{{ $item->judul }}">
        </div>
        <div class="berita-content">
            <h4>{{ $item->judul }}</h4>
            <div class="berita-excerpt">{!! $item->konten !!}</div>
        </div>
    </div>
        @endforeach
    @else
        <div class="berita-card" data-aos="zoom-in" onclick="openReader({{ $item->id }}, 'informasi')" style="cursor:pointer;">
        
        <div class="berita-content">
            <h4>{{ $item->judul }}</h4>
            <div class="berita-excerpt">{!! $item->konten !!}</div>
        </div>
    </div>
    @endif
    @endforeach
</div>
@endif

@endif
</div></section>

<section id="rekomendasi" class="section bg-light"><div class="container"><div class="section-title" data-aos="fade-up"><h2>Destinasi Lain di Sekitar</h2><div class="divider"></div></div>
<div class="rekomendasi-grid">
    <div class="rekomendasi-card" onclick="window.location.href='{{ url('/geosite/air-terjun-janji') }}'"><div class="rekomendasi-img"><img src="{{ asset('image/bakara/air-terjun-janji.jpg') }}" alt="Air Terjun"></div><div class="rekomendasi-content"><h4>Air Terjun Janji</h4><p>Air Terjun Mitos</p></div></div>
    <div class="rekomendasi-card" onclick="window.location.href='{{ url('/geosite/gonting') }}'"><div class="rekomendasi-img"><img src="{{ asset('image/bakara/gonting.jpg') }}" alt="Gonting"></div><div class="rekomendasi-content"><h4>Gonting</h4><p>Bukit Trekking</p></div></div>
    <div class="rekomendasi-card" onclick="window.location.href='{{ url('/geosite/istana-sisingamangaraja') }}'"><div class="rekomendasi-img"><img src="{{ asset('image/bakara/istana-sisingamangaraja.jpg') }}" alt="Istana"></div><div class="rekomendasi-content"><h4>Istana Sisingamangaraja</h4><p>Wisata Sejarah</p></div></div>
    <div class="rekomendasi-card" onclick="window.location.href='{{ url('/geosite/aek-sipangolu') }}'"><div class="rekomendasi-img"><img src="{{ asset('image/bakara/aek-sipangolu.jpg') }}" alt="Aek Sipangolu"></div><div class="rekomendasi-content"><h4>Aek Sipangolu</h4><p>Mata Air Panas</p></div></div>
</div></div></section>

<section id="maps" class="section"><div class="container"><div class="section-title" data-aos="fade-up"><h2>Lokasi Kami</h2><div class="divider"></div></div>
<div class="maps-container" data-aos="zoom-in">
    <iframe src="{{ $profil->maps_link ?? 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d255193.1325813422!2d98.69644291915316!3d2.470043988424604!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x302e0057d16c05ff%3A0xee8ecfd05118386e!2sBakara%2C%20Kec.%20Baktiraja%2C%20Kabupaten%20Humbang%20Hasundutan%2C%20Sumatera%20Utara!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid' }}" allowfullscreen="" loading="lazy"></iframe>
    <div class="maps-info"><p><i class="fas fa-map-marker-alt"></i> Panatapan Bakara, Desa Bakara, Kecamatan Baktiraja, Kabupaten Humbang Hasundutan</p></div>
</div></div></section>

<!-- CTA -->
<section class="cta">
    <div class="container" data-aos="fade-up">
        <h3>Saksikan Keindahan Danau Toba dari Ketinggian</h3>
        <div class="divider"></div>
        <p>Panorama spektakuler yang akan membuat Anda terpukau</p>
        <a href="{{ url('/destinasi') }}" class="cta-btn">Lihat Semua Destinasi</a>
    </div>
</section>

<div class="lightbox" id="lightbox" onclick="closeLightbox()"><div class="lightbox-close">Ã—</div><img id="lightboxImg"></div>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<script>
    AOS.init({ duration: 700, once: true, offset: 50 });
    const hamburger = document.getElementById('hamburger');
    const mobileOverlay = document.getElementById('mobileOverlay');
    hamburger.addEventListener('click', () => { mobileOverlay.classList.toggle('active'); });
    const closeMenu = () => { mobileOverlay.classList.remove('active'); document.body.style.overflow = ''; };
    document.querySelectorAll('.mobile-link').forEach(link => { link.addEventListener('click', closeMenu); });
    const sections = document.querySelectorAll('section[id]');
    const navLinks = document.querySelectorAll('.nav-link:not(.home-btn), .mobile-link:not(.mobile-home)');
    const sectionTitles = document.querySelectorAll('.section-title');
    
    // Scroll observer for nav link active state
    window.addEventListener('scroll', () => {
        if (mobileOverlay.classList.contains('active')) { closeMenu(); }
        let current = '';
        sections.forEach(section => { const top = section.offsetTop - 150; if (scrollY >= top) current = section.getAttribute('id'); });
        navLinks.forEach(link => { link.classList.remove('active'); if (link.getAttribute('href') === `#${current}`) link.classList.add('active'); });
    });
    
    // IntersectionObserver for section title color animation
    const titleObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('in-view');
                setTimeout(() => { entry.target.classList.remove('in-view'); }, 1200);
            }
        });
    }, { threshold: 0.5, rootMargin: '0px 0px -80px 0px' });
    
    sectionTitles.forEach(title => titleObserver.observe(title));
    const lightbox = document.getElementById('lightbox');
    function openLightbox(src) { lightbox.classList.add('active'); document.getElementById('lightboxImg').src = src; }
    function closeLightbox() { lightbox.classList.remove('active'); }
    lightbox.addEventListener('click', (e) => { if (e.target === lightbox) closeLightbox(); });
    document.querySelectorAll('.nav-link[href^="#"], .mobile-link[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) { e.preventDefault(); const target = document.querySelector(this.getAttribute('href')); if (target) target.scrollIntoView({ behavior: 'smooth' }); });
    });
</script>
@include('geosite.reader-modal')
</body>
</html>

