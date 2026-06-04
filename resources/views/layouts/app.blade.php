<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Geosite Danau Toba')</title>

    <!-- Bootstrap CSS - Framework utama untuk grid system dan komponen UI -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome - Library ikon untuk seluruh ikon yang digunakan di navbar, footer, dan konten -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Google Fonts Inter - Font utama seluruh halaman -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- AOS Animation - Library animasi scroll -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>

        /* Font global seluruh elemen menggunakan Inter */
        * { font-family: 'Inter', sans-serif; }

        /* Variabel warna global yang digunakan di seluruh stylesheet */
        :root {
            --blue-dark: #003366;
            --blue-medium: #1a4a7a;
            --gold: #c6a43b;
            --white: #ffffff;
        }

        /* Mencegah overflow horizontal di seluruh halaman pada layar kecil */
        html, body {
            overflow-x: hidden;
            max-width: 100%;
        }

        /* NAVBAR - Kontainer navigasi utama dengan background putih dan shadow halus */
        .navbar {
            transition: all 0.4s ease;
            height: 72px;
            padding: 0;
            background: #ffffff;
            border-bottom: 1px solid rgba(0, 0, 0, 0.07);
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.06);
        }

        /* NAVBAR SCROLLED - Shadow diperdalam saat halaman di-scroll lebih dari 50px */
        .navbar.scrolled {
            background: #ffffff;
            height: 72px;
            padding: 0;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.10);
        }

        /* NAVBAR CONTAINER - Wrapper flex untuk logo dan menu dengan padding responsif */
        .navbar .container {
            max-width: 100%;
            margin: 0 auto;
            padding: 0 48px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            box-sizing: border-box;
        }

        /* LOGO WRAPPER - Flex container untuk dua logo dan teks brand */
        .logo-wrapper {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 0;
            padding: 0;
            flex-shrink: 1;
            min-width: 0;
            overflow: hidden;
        }

        /* LOGO IMG - Ukuran logo dijaga proporsional dengan object-fit contain */
        .logo-img {
            height: 44px;
            width: auto;
            border-radius: 0;
            object-fit: contain;
            transition: all 0.3s ease;
            box-shadow: none;
            background: transparent;
            flex-shrink: 0;
        }

        /* LOGO IMG HOVER - Efek scale naik halus saat cursor masuk */
        .logo-img:hover {
            transform: scale(1.02) translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        }

        /* LOGO DIVIDER - Garis pemisah vertikal tipis antar logo */
        .logo-divider {
            width: 1.5px;
            height: 28px;
            background: linear-gradient(145deg, rgba(0, 0, 0, 0.12), rgba(0, 0, 0, 0.04));
            border-radius: 2px;
            flex-shrink: 0;
        }

        /* NAVBAR BRAND - Teks GeoToba dengan warna biru gelap */
        .navbar-brand {
            font-size: 1.65rem;
            font-weight: 800;
            color: var(--blue-dark) !important;
            margin: 0;
            padding: 0 0 0 4px;
            letter-spacing: -0.3px;
            text-shadow: none;
            text-decoration: none;
            white-space: nowrap;
            flex-shrink: 0;
        }

        /* NAVBAR BRAND SPAN - Kata "Toba" berwarna gold sesuai identitas visual brand */
        .navbar-brand span {
            color: var(--gold);
            font-weight: 800;
        }

        /* NAV LINK - Teks menu default berwarna hitam gelap */
        .nav-link {
            color: #1a1a1a !important;
            font-weight: 500;
            margin: 0 0.2rem;
            transition: all 0.25s ease;
            font-size: 0.95rem;
            padding: 0.5rem 1rem !important;
            border-radius: 40px;
        }

        /* NAV LINK HOVER - Berubah ke gold dengan background abu terang */
        .nav-link:hover {
            color: var(--gold) !important;
            background: rgba(0, 0, 0, 0.04);
            transform: translateY(-2px);
        }

        /* NAV LINK ACTIVE - Warna gold dengan background kuning transparan */
        .nav-link.active {
            color: var(--gold) !important;
            background: rgba(198, 164, 59, 0.12);
        }

        /* DROPDOWN MENU - Background putih bersih dengan shadow premium */
        .dropdown-menu {
            background: #ffffff;
            backdrop-filter: none;
            border: 1px solid rgba(0, 0, 0, 0.08);
            border-radius: 20px;
            padding: 0.6rem 0;
            margin-top: 0.7rem;
            box-shadow: 0 16px 40px rgba(0, 0, 0, 0.10);
        }

        /* DROPDOWN ITEM - Teks abu gelap dengan padding yang nyaman */
        .dropdown-item {
            color: #2c2c2c;
            padding: 10px 24px;
            font-size: 0.85rem;
            transition: all 0.25s ease;
            border-radius: 14px;
            margin: 3px 8px;
            width: auto;
            display: block;
            background: transparent;
        }

        /* DROPDOWN ITEM HOVER - Background abu terang dengan teks gold */
        .dropdown-item:hover {
            background: #f5f5f5;
            color: var(--gold);
            transform: translateX(5px);
        }

        /* DROPDOWN ITEM ACTIVE - State aktif dengan gold transparan */
        .dropdown-item.active,
        .dropdown-item:active {
            background: rgba(198, 164, 59, 0.10);
            color: var(--gold);
        }

        /* DROPDOWN HEADER - Label kategori berwarna gold */
        .dropdown-header {
            color: var(--gold);
            padding: 8px 24px;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* NAVBAR TOGGLER - Tombol hamburger untuk mobile dengan border abu tipis */
        .navbar-toggler {
            border: 1px solid rgba(0, 0, 0, 0.12);
            background: rgba(0, 0, 0, 0.03);
            padding: 8px 12px;
            border-radius: 14px;
            transition: all 0.25s ease;
            flex-shrink: 0;
            margin-left: 8px;
        }

        /* NAVBAR TOGGLER HOVER - Background sedikit lebih gelap */
        .navbar-toggler:hover {
            background: rgba(0, 0, 0, 0.07);
        }

        /* NAVBAR TOGGLER FOCUS - Menghilangkan outline bawaan browser */
        .navbar-toggler:focus {
            box-shadow: none;
            outline: none;
        }

        /* NAVBAR TOGGLER ICON - Ikon hamburger berwarna biru gelap */
        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(0, 51, 102, 0.9)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        /* LANG BTN - Tombol pilihan bahasa dengan border gold tipis */
        .lang-btn {
            background: rgba(0, 0, 0, 0.03);
            border: 1.5px solid rgba(198, 164, 59, 0.35);
            border-radius: 40px;
            padding: 0.45rem 1rem;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: all 0.3s ease;
            cursor: pointer;
            color: #1a1a1a !important;
            font-weight: 600;
        }

        /* LANG BTN HOVER - Background gold transparan saat hover */
        .lang-btn:hover {
            background: rgba(198, 164, 59, 0.10);
            border-color: var(--gold);
            transform: translateY(-2px);
        }

        /* LANG DROPDOWN - Lebar minimum dropdown bahasa */
        .lang-dropdown {
            min-width: 150px;
        }

        /* LANG DROPDOWN ITEM - Flex row agar ikon bendera dan teks sejajar */
        .lang-dropdown .dropdown-item {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* LANG DROPDOWN ITEM ICON - Lebar tetap untuk ikon agar teks selalu sejajar */
        .lang-dropdown .dropdown-item i {
            width: 20px;
        }

        /* RESPONSIVE 1200px - Kurangi padding container sedikit */
        @media (max-width: 1200px) {
            .navbar .container {
                padding: 0 32px;
            }
        }

        /* RESPONSIVE 991px - Breakpoint tablet dan HP landscape */
        @media (max-width: 991px) {
            .navbar { height: 64px; }
            .navbar.scrolled { height: 64px; }
            .navbar .container {
                padding: 0 20px;
            }

            .logo-img { height: 38px; }
            .logo-divider { height: 24px; }
            .navbar-brand { font-size: 1.3rem; }

            /* NAVBAR COLLAPSE MOBILE - Panel menu mobile dengan background putih */
            .navbar-collapse {
                background: #ffffff;
                border: 1px solid rgba(0, 0, 0, 0.08);
                padding: 0.5rem 0.75rem;
                border-radius: 20px;
                margin-top: 0.8rem;
                box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
            }

            /* NAVBAR NAV MOBILE - Hilangkan gap antar item */
            .navbar-nav {
                gap: 0;
            }

            /* NAV LINK MOBILE - Teks hitam gelap, text-align center */
            .nav-link {
                color: #1a1a1a !important;
                text-align: center;
                padding: 8px 16px !important;
                margin: 1px 0;
                line-height: 1.4;
                border-radius: 12px;
            }

            /* NAV LINK HOVER MOBILE - Hilangkan translateY di layar kecil */
            .nav-link:hover {
                transform: none;
                background: rgba(0, 0, 0, 0.04);
            }

            /* NAV LINK ACTIVE MOBILE - Tetap gold sesuai desain asli */
            .nav-link.active {
                color: var(--gold) !important;
                background: rgba(198, 164, 59, 0.10);
            }

            /* DROPDOWN MENU MOBILE - Background abu sangat terang tanpa shadow */
            .dropdown-menu {
                position: static !important;
                float: none;
                background: #f9f9f9;
                border: none;
                box-shadow: none;
                border-radius: 12px;
                margin: 2px 0;
                padding: 4px 0;
            }

            /* DROPDOWN ITEM MOBILE - Text center dan hilangkan translateX */
            .dropdown-item {
                text-align: center;
                margin: 2px 8px;
                padding: 8px 16px;
                color: #2c2c2c;
            }

            /* DROPDOWN ITEM HOVER MOBILE - Hilangkan translateX di mobile */
            .dropdown-item:hover {
                transform: none;
                background: rgba(198, 164, 59, 0.08);
            }

            /* LANG BTN MOBILE - Tombol bahasa center dengan margin atas */
            .lang-btn {
                margin: 6px auto 2px;
                width: fit-content;
            }
        }

        /* RESPONSIVE 768px - HP portrait ukuran sedang */
        @media (max-width: 768px) {
            .navbar { height: 60px; padding: 0; }
            .navbar.scrolled { height: 60px; padding: 0; }

            .navbar .container {
                padding: 0 14px;
            }

            .logo-img { height: 34px; }
            .logo-divider { height: 22px; }
            .logo-wrapper { gap: 8px; }
            .navbar-brand { font-size: 1.2rem; padding-left: 2px; }
        }

        /* RESPONSIVE 576px - HP kecil, semua elemen logo diperkecil */
        @media (max-width: 576px) {
            .navbar { height: 56px; padding: 0; }
            .navbar.scrolled { height: 56px; padding: 0; }

            .navbar .container {
                padding: 0 12px;
            }

            .logo-img { height: 30px; }
            .logo-divider { height: 20px; }
            .logo-wrapper { gap: 7px; }
            .navbar-brand { font-size: 1.1rem; }
        }

        /* RESPONSIVE 400px - HP sangat kecil, logo diperkecil lebih jauh */
        @media (max-width: 400px) {
            .navbar .container {
                padding: 0 10px;
            }

            .logo-img { height: 26px; }
            .logo-divider { height: 18px; }
            .logo-wrapper { gap: 6px; }
            .navbar-brand { font-size: 1rem; }
        }

        /* RESPONSIVE 360px - HP ukuran minimum yang umum */
        @media (max-width: 360px) {
            .logo-img { height: 24px; }
            .navbar-brand { font-size: 0.95rem; }
            .logo-wrapper { gap: 5px; }
        }

        /* FOOTER - Background gradient biru gelap */
        .footer {
            background: linear-gradient(135deg, #003366 0%, #0a2a4a 100%);
            color: white;
            padding: 50px 0 20px;
            margin-top: 0;
            position: relative;
        }

        /* FOOTER BEFORE - Garis dekoratif gold di bagian paling atas footer */
        .footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #c6a43b, #e8c45a, #c6a43b);
        }

        /* FOOTER TITLE - Judul setiap kolom footer dengan underline gold */
        .footer-title {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 1.2rem;
            position: relative;
            display: inline-block;
            padding-bottom: 8px;
        }

        /* FOOTER TITLE AFTER - Garis bawah gold pada judul kolom footer */
        .footer-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 40px;
            height: 2px;
            background: #c6a43b;
            border-radius: 2px;
            transition: width 0.3s ease;
        }

        /* FOOTER COL HOVER TITLE AFTER - Garis bawah gold melebar saat di-hover */
        .footer-col:hover .footer-title::after {
            width: 60px;
        }

        /* FOOTER LINKS - List tautan navigasi di footer */
        .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        /* FOOTER LINKS LI - Jarak bawah antar item link */
        .footer-links li {
            margin-bottom: 10px;
        }

        /* FOOTER LINKS A - Tautan berwarna putih transparan dengan flex row */
        .footer-links a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 0.85rem;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        /* FOOTER LINKS A ICON - Ikon chevron tersembunyi dan muncul saat hover */
        .footer-links a i {
            font-size: 0.7rem;
            opacity: 0;
            transition: all 0.3s ease;
        }

        /* FOOTER LINKS A HOVER - Warna gold dan bergerak ke kanan */
        .footer-links a:hover {
            color: #c6a43b;
            transform: translateX(5px);
        }

        /* FOOTER LINKS A HOVER ICON - Ikon chevron muncul saat link di-hover */
        .footer-links a:hover i {
            opacity: 1;
            transform: translateX(3px);
        }

        /* FOOTER CONTACT - List informasi kontak di footer */
        .footer-contact {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        /* FOOTER CONTACT LI - Setiap item kontak menggunakan flex row */
        .footer-contact li {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 12px;
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.7);
            transition: all 0.3s ease;
        }

        /* FOOTER CONTACT LI HOVER - Bergerak ke kanan dan berubah ke gold */
        .footer-contact li:hover {
            transform: translateX(5px);
            color: #c6a43b;
        }

        /* FOOTER CONTACT LI ICON - Ikon kontak berwarna gold dengan lebar tetap */
        .footer-contact li i {
            color: #c6a43b;
            width: 20px;
            flex-shrink: 0;
        }

        /* SOCIAL ICONS WRAPPER - Flex container untuk ikon sosial media */
        .social-icons {
            display: flex;
            gap: 12px;
            margin-top: 20px;
            flex-wrap: wrap;
        }

        /* SOCIAL ICON - Ikon sosial berbentuk lingkaran dengan border gold tipis */
        .social-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.08);
            color: white;
            transition: all 0.3s ease;
            text-decoration: none;
            border: 1px solid rgba(198, 164, 59, 0.2);
        }

        /* SOCIAL ICON HOVER - Background gold, warna biru gelap, dan rotasi penuh */
        .social-icon:hover {
            background: linear-gradient(135deg, #c6a43b, #a8892e);
            color: #003366;
            transform: translateY(-5px) rotate(360deg);
            border-color: transparent;
        }

        /* COPYRIGHT - Area copyright paling bawah footer */
        .copyright {
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            padding-top: 20px;
            margin-top: 35px;
            text-align: center;
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.5);
        }

        /* FOOTER RESPONSIVE 991px hingga 577px - Layout kolom pertama full lebar */
        @media (max-width: 991px) and (min-width: 577px) {
            .footer .row {
                display: flex;
                flex-wrap: wrap;
            }
            .footer .row > div:nth-child(1) {
                width: 100%;
                margin-bottom: 30px;
            }
            .footer .row > div:nth-child(2),
            .footer .row > div:nth-child(3),
            .footer .row > div:nth-child(4) {
                width: 33.333%;
            }
        }

        /* FOOTER RESPONSIVE 576px - Grid dua kolom untuk HP kecil */
        @media (max-width: 576px) {
            .footer {
                padding: 40px 0 20px;
            }
            .footer .row {
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 25px;
            }
            .footer .row > div:nth-child(1) {
                grid-column: span 2;
            }
            .footer .row > div:nth-child(4) {
                grid-column: span 2;
            }
            .footer-title { font-size: 0.95rem; }
            .footer-links a, .footer-contact li { font-size: 0.75rem; }
            .social-icon { width: 34px; height: 34px; }
            .copyright { font-size: 0.65rem; }
        }

        /* FOOTER RESPONSIVE 380px - HP sangat kecil */
        @media (max-width: 380px) {
            .footer .row { gap: 20px; }
            .footer-title { font-size: 0.85rem; }
            .social-icon { width: 30px; height: 30px; font-size: 0.7rem; }
        }

        /* BACK TO TOP - Tombol kembali ke atas halaman posisi fixed */
        .back-to-top {
            position: fixed;
            bottom: 25px;
            right: 25px;
            width: 44px;
            height: 44px;
            border-radius: 22px;
            background: linear-gradient(135deg, #c6a43b, #a8892e);
            color: #003366;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 1000;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        }

        /* BACK TO TOP SHOW - Kelas yang ditambahkan saat scroll melebihi 300px */
        .back-to-top.show {
            opacity: 1;
            visibility: visible;
        }

        /* BACK TO TOP HOVER - Background putih dan sedikit naik saat hover */
        .back-to-top:hover {
            background: white;
            transform: translateY(-4px) scale(1.05);
        }

        /* BACK TO TOP RESPONSIVE 576px - Ukuran diperkecil di HP kecil */
        @media (max-width: 576px) {
            .back-to-top {
                bottom: 15px;
                right: 15px;
                width: 38px;
                height: 38px;
                font-size: 0.8rem;
            }
        }
    </style>

    @stack('styles')
</head>
<body>

    <!-- NAVBAR - Fixed top dengan navbar-expand-lg untuk collapse di bawah 992px -->
    <nav class="navbar navbar-expand-lg fixed-top" id="navbar">
        <div class="container">

            <!-- LOGO WRAPPER - Grup logo Bank Indonesia, logo Del, dan teks brand -->
            <div class="logo-wrapper">
                <img src="{{ asset('image/Logo/logobankindonesia.jpg') }}" alt="Bank Indonesia" class="logo-img" loading="lazy">
                <div class="logo-divider"></div>
                <img src="{{ asset('image/Logo/del.jpg') }}" alt="Logo Del" class="logo-img" loading="lazy">
                <div class="logo-divider"></div>
                <a class="navbar-brand" href="{{ url('/') }}">Geo<span>Toba</span></a>
            </div>

            <!-- NAVBAR TOGGLER - Tombol hamburger yang muncul di bawah 992px -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- NAVBAR COLLAPSE - Grup menu yang collapse di mobile -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">

                    <!-- MENU BERANDA - Active class via Laravel route check -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ url('/') }}">
                            Beranda
                        </a>
                    </li>

                    <!-- MENU INFORMASI - Active class jika route adalah 'informasi' -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('informasi') ? 'active' : '' }}" href="{{ url('/informasi') }}">
                            Informasi
                        </a>
                    </li>

                    <!-- MENU DESTINASI - Dropdown dengan submenu kategori destinasi -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('destinasi*') ? 'active' : '' }}" href="#" data-bs-toggle="dropdown">
                            Destinasi
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <h6 class="dropdown-header">
                                    <i class="fas fa-tag me-1"></i>
                                    KATEGORI DESTINASI
                                </h6>
                            </li>
                            <li><a class="dropdown-item" href="{{ url('/destinasi/alam') }}">Destinasi Alam</a></li>
                            <li><a class="dropdown-item" href="{{ url('/destinasi/buatan') }}">Destinasi Buatan</a></li>
                            <li><a class="dropdown-item" href="{{ url('/destinasi/budaya') }}">Destinasi Budaya</a></li>
                            <li><hr class="dropdown-divider" style="border-color: rgba(0,0,0,0.08);"></li>
                            <li><a class="dropdown-item" href="{{ url('/destinasi') }}">Semua Destinasi</a></li>
                        </ul>
                    </li>

                    <!-- MENU GALERI - Active class jika route adalah 'galeri' -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('galeri') ? 'active' : '' }}" href="{{ url('/galeri') }}">
                            Galeri
                        </a>
                    </li>

                    <!-- MENU BERITA - Active class jika route adalah 'berita' -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('berita') ? 'active' : '' }}" href="{{ url('/berita') }}">
                            Berita
                        </a>
                    </li>

                    <!-- MENU KONTAK - Active class jika route adalah 'kontak' -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('kontak') ? 'active' : '' }}" href="{{ url('/kontak') }}">
                            Kontak
                        </a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    <!-- MAIN CONTENT - Area yield untuk konten dari setiap child view -->
    <main>@yield('content')</main>

    <!-- FOOTER PREMIUM - Footer dengan background biru gelap dan aksen gold -->
    <footer class="footer">
        <div class="container">
            <div class="row">

                <!-- KOLOM BRAND - Deskripsi singkat GeoToba dan ikon sosial media -->
                <div class="col-lg-4 col-md-12 mb-4 footer-col">
                    <h5 class="footer-title">Geo<span style="color: #c6a43b;">Toba</span></h5>
                    <p style="font-size: 0.85rem; color: rgba(255,255,255,0.7); line-height: 1.6;">
                        Sistem Informasi Geosite Danau Toba - Menyajikan informasi lengkap tentang keindahan geologi dan budaya Batak di kawasan Danau Toba.
                    </p>
                    <div class="social-icons">
                        <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-youtube"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-tiktok"></i></a>
                    </div>
                </div>

                <!-- KOLOM TAUTAN - Daftar link navigasi cepat ke halaman utama -->
                <div class="col-lg-2 col-md-4 col-sm-6 col-6 mb-4 footer-col">
                    <h5 class="footer-title">Tautan</h5>
                    <ul class="footer-links">
                        <li><a href="{{ url('/') }}"><i class="fas fa-chevron-right"></i> Beranda</a></li>
                        <li><a href="{{ url('/informasi') }}"><i class="fas fa-chevron-right"></i> Informasi</a></li>
                        <li><a href="{{ url('/galeri') }}"><i class="fas fa-chevron-right"></i> Galeri</a></li>
                        <li><a href="{{ url('/berita') }}"><i class="fas fa-chevron-right"></i> Berita</a></li>
                        <li><a href="{{ url('/kontak') }}"><i class="fas fa-chevron-right"></i> Kontak</a></li>
                    </ul>
                </div>

                <!-- KOLOM DESTINASI - Daftar link ke kategori destinasi wisata -->
                <div class="col-lg-3 col-md-4 col-sm-6 col-6 mb-4 footer-col">
                    <h5 class="footer-title">Destinasi</h5>
                    <ul class="footer-links">
                        <li><a href="{{ url('/destinasi/alam') }}"><i class="fas fa-chevron-right"></i> Destinasi Alam</a></li>
                        <li><a href="{{ url('/destinasi/buatan') }}"><i class="fas fa-chevron-right"></i> Destinasi Buatan</a></li>
                        <li><a href="{{ url('/destinasi/budaya') }}"><i class="fas fa-chevron-right"></i> Destinasi Budaya</a></li>
                        <li><a href="{{ url('/destinasi') }}"><i class="fas fa-chevron-right"></i> Semua Destinasi</a></li>
                    </ul>
                </div>

                <!-- KOLOM KONTAK - Informasi kontak termasuk alamat, telepon, email, dan jam operasional -->
                <div class="col-lg-3 col-md-4 col-sm-12 mb-4 footer-col">
                    @php $globalKontak = \App\Models\Kontak::first(); @endphp
                    <h5 class="footer-title">Kontak</h5>
                    <ul class="footer-contact">
                        <li><i class="fas fa-map-marker-alt"></i> {{ explode("\n", $globalKontak->lokasi_bawah ?? '')[0] ?? 'Danau Toba, Sumatera Utara' }}</li>
                        <li><i class="fas fa-phone"></i> {{ explode("\n", str_replace("\r", "", $globalKontak->telepon ?? ''))[0] ?? '+62 812 3456 7890' }}</li>
                        <li><i class="fas fa-envelope"></i> {{ explode("\n", str_replace("\r", "", $globalKontak->email ?? ''))[0] ?? 'info@geotoba.com' }}</li>
                        <li><i class="fas fa-clock"></i> {{ explode("\n", str_replace("\r", "", $globalKontak->jam_operasional ?? ''))[0] ?? 'Senin - Minggu : 08.00 - 18.00 WIB' }}</li>
                    </ul>
                </div>

            </div>

            <!-- COPYRIGHT - Teks hak cipta di bagian paling bawah footer -->
            <div class="copyright">
                <p>&copy; 2026 GeoToba - Geopark Danau Toba. Hak Cipta dilindungi.</p>
            </div>
        </div>
    </footer>

    <!-- BACK TO TOP - Tombol scroll ke atas, ditampilkan via JavaScript -->
    <div class="back-to-top" id="backToTop"><i class="fas fa-arrow-up"></i></div>

    <!-- Bootstrap JS Bundle - Termasuk Popper.js untuk dropdown dan collapse navbar -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- AOS JS - Inisialisasi library animasi scroll -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script>
        /* Inisialisasi AOS dengan durasi 1000ms dan animasi hanya dijalankan sekali */
        AOS.init({ duration: 1000, once: true });

        /* Navbar scroll effect menambahkan class scrolled saat halaman di-scroll lebih dari 50px */
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', function() {
            if (window.scrollY > 50) navbar.classList.add('scrolled');
            else navbar.classList.remove('scrolled');
        });

        /* Back to top visibility menampilkan tombol saat scroll melebihi 300px */
        const backToTop = document.getElementById('backToTop');
        window.addEventListener('scroll', function() {
            if (window.scrollY > 300) backToTop.classList.add('show');
            else backToTop.classList.remove('show');
        });

        /* Back to top click melakukan scroll halus ke posisi paling atas saat diklik */
        backToTop.addEventListener('click', function() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    </script>

    @stack('scripts')
</body>
</html>