@extends('layouts.app')

@section('title', 'Kontak - Kawasan Wisata Bakara Tipang Baktiraja')

@section('content')

<!-- Google Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">

@php $heroBg = asset('image/bakara/panatapan-bakara.jpg'); @endphp

<style>

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    :root {
        --primary: #003366;
        --gold: #c6a43b;
        --white: #fff;
        --gray: #666;
        --bg: #f8fafc;
        --shadow: 0 5px 20px rgba(0,0,0,0.05);
        --shadow-lg: 0 10px 30px rgba(0,0,0,0.1);
        --transition: all 0.3s ease;
    }

    body {
        font-family: 'Inter', sans-serif;
        background: var(--bg);
    }

    /* HERO */
    .hero-kontak {
        height: 40vh;
        min-height: 300px;
        background: linear-gradient(135deg, rgba(0,51,102,0.8) 0%, rgba(0,51,102,0.6) 100%), var(--hero-bg);
        background-size: cover;
        background-position: center;
        display: flex;
        align-items: center;
        justify-content: center;
        text-align: center;
        color: white;
        margin-top: 70px;
        position: relative;
    }

    .hero-kontak h1 {
        font-size: 3rem;
        font-family: 'Playfair Display', serif;
        margin-bottom: 10px;
    }

    .hero-kontak p {
        font-size: 0.9rem;
        letter-spacing: 2px;
        opacity: 0.85;
    }

    /* SECTION */
    .section {
        padding: 60px 0;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 24px;
    }

    /* CONTACT CARDS */
    .contact-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 30px;
        margin-bottom: 50px;
    }

    .contact-card {
        background: white;
        padding: 30px 20px;
        text-align: center;
        border-radius: 20px;
        box-shadow: var(--shadow);
        transition: var(--transition);
    }

    .contact-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
    }

    .contact-icon {
        width: 60px;
        height: 60px;
        background: rgba(198,164,59,0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 15px;
    }

    .contact-icon i {
        font-size: 24px;
        color: var(--gold);
    }

    .contact-card h3 {
        font-size: 1.1rem;
        font-weight: 600;
        margin-bottom: 10px;
        color: var(--primary);
    }

    .contact-card p {
        font-size: 0.85rem;
        color: var(--gray);
        line-height: 1.5;
    }

    /* ==================== FORM ==================== */
    .form-card {
        background: white;
        border-radius: 24px;
        padding: 35px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.04);
        border: 1px solid #f0f0f0;
        height: 100%;
    }
    
    .form-card h3 {
        font-size: 1.5rem;
        font-family: 'Cormorant Garamond', serif;
        font-weight: 500;
        margin-bottom: 20px;
        color: #1a1a1a;
    }
    
    .form-control, .form-select {
        border: 1px solid #e0e0e0;
        border-radius: 12px;
        padding: 12px 16px;
        font-size: 0.85rem;
        transition: all 0.3s ease;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #c6a43b;
        box-shadow: 0 0 0 3px rgba(198, 164, 59, 0.08);
        outline: none;
    }
    
    .btn-send {
        background: #1a1a1a;
        color: white;
        border: none;
        padding: 12px 30px;
        border-radius: 50px;
        font-weight: 600;
        letter-spacing: 1px;
        transition: all 0.3s ease;
        width: 100%;
        font-size: 0.75rem;
        text-transform: uppercase;
    }
    
    .btn-send:hover {
        background: #c6a43b;
        color: #1a1a1a;
        transform: translateY(-2px);
    }
    
    /* ==================== FORM + MAP GRID ==================== */
    .form-map-grid {
        display: flex;
        gap: 30px;
        align-items: stretch;
        margin-top: 30px;
    }

    .form-map-grid > .form-card {
        flex: 1;
        min-width: 0;
    }

    .form-map-grid > .map-card {
        flex: 1;
        min-width: 0;
    }
    
    /* ==================== MAPS ==================== */
    .map-card {
        border-radius: 24px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0,0,0,0.04);
        border: 1px solid #f0f0f0;
        background: white;
        display: flex;
        flex-direction: column;
    }
    
    .map-card iframe {
        width: 100%;
        flex: 1;
        min-height: 350px;
        border: 0;
    }
    
    .map-info {
        padding: 20px;
        text-align: center;
    }
    
    .map-info h4 {
        font-size: 1rem;
        font-weight: 600;
        margin-bottom: 6px;
        color: #1a1a1a;
    }

    .map-info p {
        font-size: 0.8rem;
        color: var(--gray);
    }

    /* INFO SECTION (Setelah Peta) */
    .info-section {
        margin-top: 20px;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 30px;
    }

    .info-card {
        background: white;
        border-radius: 20px;
        padding: 25px;
        box-shadow: var(--shadow);
    }

    .info-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--primary);
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid var(--gold);
        display: inline-block;
    }

    /* DESTINASI LIST - BAKARA TIPANG BAKTIRAJA */
    .dest-list {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .dest-item {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 12px;
        background: var(--bg);
        border-radius: 12px;
        cursor: pointer;
        transition: var(--transition);
    }

    .dest-item:hover {
        background: rgba(198,164,59,0.1);
        transform: translateX(5px);
    }

    .dest-icon {
        width: 45px;
        height: 45px;
        background: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: var(--shadow);
    }

    .dest-icon i {
        font-size: 1.1rem;
        color: var(--gold);
    }

    .dest-info h4 {
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--primary);
        margin-bottom: 3px;
    }

    .dest-info p {
        font-size: 0.7rem;
        color: var(--gray);
    }

    /* SOSIAL MEDIA */
    .social-section {
        margin: 25px 0;
        text-align: center;
    }

    .social-icons {
        display: flex;
        justify-content: center;
        gap: 15px;
        margin-top: 10px;
        flex-wrap: wrap;
    }

    .social-icons a {
        width: 38px;
        height: 38px;
        background: var(--bg);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary);
        transition: var(--transition);
        text-decoration: none;
    }

    .social-icons a:hover {
        background: var(--gold);
        color: white;
        transform: translateY(-3px);
    }

    /* JAM OPERASIONAL */
    .hours-box {
        background: linear-gradient(135deg, var(--primary), #1a4a7a);
        padding: 20px;
        border-radius: 16px;
        text-align: center;
        color: white;
        margin-top: 20px;
    }

    .hours-box h4 {
        font-size: 0.9rem;
        margin-bottom: 10px;
    }

    .hours-box p {
        font-size: 0.75rem;
        opacity: 0.9;
    }

    .hours-divider {
        width: 30px;
        height: 1px;
        background: rgba(255,255,255,0.3);
        margin: 10px auto;
    }

    /* FLOATING WHATSAPP */
    .whatsapp-float {
        position: fixed;
        bottom: 25px;
        right: 25px;
        z-index: 100;
    }

    .whatsapp-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 55px;
        height: 55px;
        background: #25D366;
        border-radius: 50%;
        color: white;
        font-size: 1.5rem;
        box-shadow: 0 5px 15px rgba(37,211,102,0.3);
        transition: var(--transition);
        text-decoration: none;
    }

    .whatsapp-btn:hover {
        transform: scale(1.1);
        box-shadow: 0 8px 20px rgba(37,211,102,0.4);
    }

    /* BADGE KATEGORI DESTINASI */
    .dest-category {
        font-size: 0.6rem;
        color: var(--gold);
        margin-top: 2px;
        display: block;
    }

    /* RESPONSIVE */
    {{ '@media' }} (max-width: 900px) {
        .contact-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        .info-grid {
            grid-template-columns: 1fr;
        }
    }

    {{ '@media' }} (max-width: 768px) {
        .hero-kontak h1 {
            font-size: 2rem;
        }
        .hero-kontak {
            min-height: 250px;
        }
        .contact-grid {
            grid-template-columns: 1fr;
            gap: 20px;
        }
        .section {
            padding: 40px 0;
        }
        .container {
            padding: 0 20px;
        }
        /* Form di atas, map di bawah saat HP */
        .form-map-grid {
            flex-direction: column;
        }
        .form-map-grid > .form-card {
            order: 1;
        }
        .form-map-grid > .map-card {
            order: 2;
        }
        .map-card iframe {
            min-height: 280px;
        }
    }

    {{ '@media' }} (max-width: 480px) {
        .hero-kontak h1 {
            font-size: 1.5rem;
        }
        .contact-card {
            padding: 20px;
        }
        .info-card {
            padding: 20px;
        }
        .whatsapp-btn {
            width: 48px;
            height: 48px;
            font-size: 1.3rem;
        }
        .map-full iframe {
            height: 220px;
        }
    }

/* ========== OVERRIDE NAVBAR MENJADI PUTIH & RAPAT ========== */
.navbar {
    background: rgba(255, 255, 255, 0.98) !important;
    backdrop-filter: blur(10px);
    border-bottom: 1px solid rgba(0, 0, 0, 0.08) !important;
    padding: 12px 0 !important;
}

.navbar .container {
    max-width: 100% !important;
    padding: 0 16px !important;
}

.navbar-brand {
    display: flex !important;
    align-items: center !important;
    gap: 12px !important;
}

.navbar-brand img:first-child {
    width: 65px !important;
    height: auto !important;
}

.navbar-brand .logo-divider {
    width: 1px !important;
    height: 30px !important;
    background: rgba(0, 0, 0, 0.1) !important;
}

.navbar-brand h4 {
    font-size: 0.85rem !important;
    font-weight: 700 !important;
    color: #003366 !important;
    margin: 0 !important;
}

.navbar-brand p {
    font-size: 0.4rem !important;
    color: rgba(0, 0, 0, 0.5) !important;
    margin: 0 !important;
}

.navbar-nav {
    gap: 28px !important;
}

.navbar-nav .nav-link {
    font-size: 0.7rem !important;
    letter-spacing: 0.15em !important;
    text-transform: uppercase !important;
    color: rgba(0, 0, 0, 0.7) !important;
    font-weight: 600 !important;
    padding: 6px 0 !important;
}

.navbar-nav .nav-link:hover {
    color: #c6a43b !important;
}

.navbar-toggler {
    background: rgba(0, 0, 0, 0.05) !important;
    border: 1px solid rgba(0, 0, 0, 0.1) !important;
    padding: 8px 12px !important;
    border-radius: 50px !important;
}

.navbar-toggler-icon {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3E%3Cpath stroke='%23003366' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3E%3C/svg%3E") !important;
}

</style>

<!-- HERO -->
<section class="hero-kontak" style="--hero-bg: url('{{ $heroBg }}')">
    <div data-aos="fade-up">
        <h1>Hubungi Kami</h1>
        <p>Senang mendengar dari Anda</p>
    </div>
</section>

<!-- CONTACT CARDS -->
<section class="section">
    <div class="container">
        <div class="contact-grid">
            <div class="contact-card" data-aos="fade-up" data-aos-delay="0">
                <div class="contact-icon"><i class="fas fa-map-marker-alt"></i></div>
                <h3>Alamat</h3>
                <p>Kawasan Wisata Bakara - Tipang - Baktiraja</p>
                <p>Kabupaten Humbang Hasundutan</p>
                <p>Sumatera Utara, Indonesia</p>
            </div>
            <div class="contact-card" data-aos="fade-up" data-aos-delay="100">
                <div class="contact-icon"><i class="fas fa-phone-alt"></i></div>
                <h3>Telepon</h3>
                <p>+62 812 3456 7890</p>
                <p>+62 813 9876 5432</p>
                <p>(0622) 12345</p>
            </div>
            <div class="contact-card" data-aos="fade-up" data-aos-delay="200">
                <div class="contact-icon"><i class="fas fa-envelope"></i></div>
                <h3>Email</h3>
                <p>info@geotoba.com</p>
                <p>wisata@bakara-tipang.com</p>
                <p>support@geotoba.com</p>
            </div>
        </div>

        <div class="form-map-grid">
            <!-- FORM KONTAK -->
            <div class="form-card" data-aos="fade-right">
                <h3>Kirim Pesan</h3>

                @if(session('success'))
                    <div class="alert alert-success d-flex align-items-center gap-2 py-2 px-3 mb-3" role="alert" style="font-size:0.85rem; border-radius:12px;">
                        <span>✅</span> {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger d-flex align-items-center gap-2 py-2 px-3 mb-3" role="alert" style="font-size:0.85rem; border-radius:12px;">
                        <span>❌</span> {{ $errors->first() }}
                    </div>
                @endif

                <form action="{{ route('kontak.kirim') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <input type="text" name="nama" class="form-control" placeholder="Nama Lengkap"
                               value="{{ old('nama') }}" required>
                    </div>
                    <div class="mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Email"
                               value="{{ old('email') }}" required>
                    </div>
                    <div class="mb-3">
                        <input type="tel" name="telepon" class="form-control" placeholder="Nomor Telepon"
                               value="{{ old('telepon') }}">
                    </div>
                    <div class="mb-3">
                        <select name="subjek" class="form-select" required>
                            <option value="" selected disabled>-- Pilih Subjek --</option>
                            <option value="Informasi Wisata"   {{ old('subjek')=='Informasi Wisata'   ? 'selected':'' }}>Informasi Wisata</option>
                            <option value="Reservasi Tiket"    {{ old('subjek')=='Reservasi Tiket'    ? 'selected':'' }}>Reservasi Tiket</option>
                            <option value="Kerjasama"          {{ old('subjek')=='Kerjasama'          ? 'selected':'' }}>Kerjasama</option>
                            <option value="Saran & Masukan"    {{ old('subjek')=='Saran & Masukan'    ? 'selected':'' }}>Saran & Masukan</option>
                            <option value="Lainnya"            {{ old('subjek')=='Lainnya'            ? 'selected':'' }}>Lainnya</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <textarea name="pesan" class="form-control" rows="5" placeholder="Pesan Anda..." required>{{ old('pesan') }}</textarea>
                    </div>
                    <button type="submit" class="btn-send">
                        Kirim Pesan <i class="fas fa-paper-plane ms-2"></i>
                    </button>
                </form>
            </div>

            <!-- MAP -->
            <div class="map-card" data-aos="fade-left">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d255193.1325813422!2d98.69644291915316!3d2.470043988424604!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x302e0057d16c05ff%3A0xee8ecfd05118386e!2sBakara%2C%20Kec.%20Baktiraja%2C%20Kabupaten%20Humbang%20Hasundutan%2C%20Sumatera%20Utara!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid"
                    allowfullscreen=""
                    loading="lazy">
                </iframe>
                <div class="map-info">
                    <h4><i class="fas fa-map-marker-alt" style="color:var(--gold)"></i> Lokasi Kami</h4>
                    <p>Bakara · Tipang · Baktiraja<br>Kabupaten Humbang Hasundutan, Sumatera Utara</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- INFO SECTION (Setelah Peta) -->
<section class="section">
    <div class="container">
        <div class="info-grid">
            <!-- DESTINASI UNGGULAN - BAKARA TIPANG BAKTIRAJA -->
            <div class="info-card" data-aos="fade-right">
                <h3 class="info-title">Destinasi Unggulan</h3>
                <div class="dest-list">
                    <div class="dest-item" onclick="window.location.href='{{ url("/geosite/panatapan-bakara") }}'">
                        <div class="dest-icon"><i class="fas fa-mountain"></i></div>
                        <div class="dest-info">
                            <h4>Panatapan Bakara</h4>
                            <p>Panorama spektakuler Danau Toba</p>
                            <span class="dest-category">● Buatan</span>
                        </div>
                    </div>
                    <div class="dest-item" onclick="window.location.href='{{ url("/geosite/air-terjun-janji") }}'">
                        <div class="dest-icon"><i class="fas fa-water"></i></div>
                        <div class="dest-info">
                            <h4>Air Terjun Janji</h4>
                            <p>Air terjun dengan mitos "janji alam"</p>
                            <span class="dest-category">● Alam</span>
                        </div>
                    </div>
                    <div class="dest-item" onclick="window.location.href='{{ url("/geosite/istana-sisingamangaraja") }}'">
                        <div class="dest-icon"><i class="fas fa-landmark"></i></div>
                        <div class="dest-info">
                            <h4>Istana Sisingamangaraja</h4>
                            <p>Pusat spiritual raja-raja Batak</p>
                            <span class="dest-category">● Budaya</span>
                        </div>
                    </div>
                    <div class="dest-item" onclick="window.location.href='{{ url("/destinasi") }}'">
                        <div class="dest-icon"><i class="fas fa-tree"></i></div>
                        <div class="dest-info">
                            <h4>8 Destinasi Lainnya</h4>
                            <p>Aek Sitio-tio, Gonting, Desa Tipang, Tombak Sulu-sulu, Aek Sipangolu</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SOSIAL & JAM OPERASIONAL -->
            <div class="info-card" data-aos="fade-left">
                <h3 class="info-title">Ikuti Kami</h3>
                <div class="social-section">
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                        <a href="#"><i class="fab fa-tiktok"></i></a>
                    </div>
                </div>

                <div class="hours-box">
                    <h4><i class="far fa-clock"></i> Jam Operasional</h4>
                    <p>Senin - Jumat: 08:00 - 17:00 WIB</p>
                    <p>Sabtu - Minggu: 08:00 - 18:00 WIB</p>
                    <div class="hours-divider"></div>
                    <p><i class="fas fa-map-marker-alt"></i> Bakara · Tipang · Baktiraja</p>
                    <p style="margin-top: 8px;">Kabupaten Humbang Hasundutan</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FLOATING WHATSAPP -->
<div class="whatsapp-float">
    <a href="https://wa.me/6281234567890" class="whatsapp-btn" target="_blank">
        <i class="fab fa-whatsapp"></i>
    </a>
</div>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<!-- AOS Animation -->
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({ duration: 700, once: true, offset: 50 });
</script>

@endsection