<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Geosite Danau Toba')</title>

    <!-- Bootstrap CSS - Framework utama untuk grid system dan komponen UI -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome - Library ikon untuk seluruh ikon yang digunakan di navbar, footer, dan konten -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Google Fonts Inter - Font utama seluruh halaman, dipilih karena bersih dan premium di semua ukuran -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- AOS Animation - Library animasi scroll untuk elemen yang muncul saat halaman di-scroll -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>

        /* Font global - Memastikan seluruh elemen di halaman menggunakan Inter sebagai font utama */
        * { font-family: 'Inter', sans-serif; }

        /* Variabel warna global - Didefinisikan di root agar mudah digunakan ulang di seluruh stylesheet tanpa menulis ulang nilai warna */
        :root {
            --blue-dark: #003366;
            --blue-medium: #1a4a7a;
            --gold: #c6a43b;
            --white: #ffffff;
        }

        /* NAVBAR - Kontainer utama navigasi, background putih bersih dengan shadow halus agar terasa premium dan logo menyatu tanpa border yang mengganggu */
        .navbar {
            transition: all 0.4s ease;
            padding: 0.8rem 0;
            background: #ffffff;
            border-bottom: 1px solid rgba(0, 0, 0, 0.07);
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.06);
        }

        /* NAVBAR SCROLLED - Saat halaman di-scroll lebih dari 50px, shadow diperdalam agar navbar tetap terbaca di atas konten halaman yang bervariasi */
        .navbar.scrolled {
            background: #ffffff;
            padding: 0.4rem 0;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.10);
        }

        /* NAVBAR CONTAINER - Wrapper flex untuk logo dan menu, dibatasi lebar 1200px agar layout tidak terlalu melebar di monitor besar */
        .navbar .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
        }

        /* LOGO WRAPPER - Flex container untuk dua logo dan teks brand, gap seragam agar jarak antar elemen logo konsisten di semua ukuran layar */
        .logo-wrapper {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 0;
            padding: 0;
        }

        /* LOGO IMG - Ukuran logo dijaga proporsional dengan object-fit cover, border-radius rounded agar terlihat modern, background transparan sehingga logo menyatu sempurna dengan header putih */
        .logo-img {
            height: 44px;
            width: auto;
            border-radius: 16px;
            object-fit: cover;
            transition: all 0.3s ease;
            box-shadow: none;
            background: transparent;
        }

        /* LOGO IMG HOVER - Efek scale naik sangat halus saat cursor masuk area logo, memberikan feedback visual interaktif tanpa terasa berlebihan */
        .logo-img:hover {
            transform: scale(1.02) translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        }

        /* LOGO DIVIDER - Garis pemisah vertikal tipis antar logo, menggunakan warna hitam sangat transparan agar terlihat subtle namun tetap memisahkan logo dengan jelas */
        .logo-divider {
            width: 1.5px;
            height: 28px;
            background: linear-gradient(145deg, rgba(0, 0, 0, 0.12), rgba(0, 0, 0, 0.04));
            border-radius: 2px;
        }

        /* NAVBAR BRAND - Teks GeoToba menggunakan biru gelap agar kontras dengan header putih dan tetap terasa premium, tidak menggunakan hitam penuh agar tidak terlalu flat */
        .navbar-brand {
            font-size: 1.65rem;
            font-weight: 800;
            color: var(--blue-dark) !important;
            margin: 0;
            padding: 0 0 0 6px;
            letter-spacing: -0.3px;
            text-shadow: none;
            text-decoration: none;
        }

        /* NAVBAR BRAND SPAN - Bagian kata "Toba" tetap berwarna gold sesuai identitas visual brand yang sudah ada, tidak diubah */
        .navbar-brand span {
            color: var(--gold);
            font-weight: 800;
        }

        /* NAV LINK - Teks menu default berwarna hitam gelap (#1a1a1a) bukan hitam murni agar terbaca nyaman di atas background putih dengan kesan lebih premium */
        .nav-link {
            color: #1a1a1a !important;
            font-weight: 500;
            margin: 0 0.2rem;
            transition: all 0.25s ease;
            font-size: 0.95rem;
            padding: 0.5rem 1rem !important;
            border-radius: 40px;
        }

        /* NAV LINK HOVER - Berubah ke warna gold dengan background abu sangat terang saat cursor masuk, memberikan efek hover premium tanpa terlalu mencolok */
        .nav-link:hover {
            color: var(--gold) !important;
            background: rgba(0, 0, 0, 0.04);
            transform: translateY(-2px);
        }

        /* NAV LINK ACTIVE - Warna gold dengan background kuning transparan sangat ringan, mempertahankan desain asli agar halaman yang sedang aktif tetap teridentifikasi dengan jelas */
        .nav-link.active {
            color: var(--gold) !important;
            background: rgba(198, 164, 59, 0.12);
        }

        /* DROPDOWN MENU - Background putih bersih dengan border abu sangat tipis dan shadow premium, menggantikan biru gelap sebelumnya agar konsisten dengan tema navbar putih */
        .dropdown-menu {
            background: #ffffff;
            backdrop-filter: none;
            border: 1px solid rgba(0, 0, 0, 0.08);
            border-radius: 20px;
            padding: 0.6rem 0;
            margin-top: 0.7rem;
            box-shadow: 0 16px 40px rgba(0, 0, 0, 0.10);
        }

        /* DROPDOWN ITEM - Teks abu gelap (#2c2c2c) agar terbaca nyaman di background putih, padding atas-bawah dan kiri-kanan cukup untuk area tap yang nyaman */
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

        /* DROPDOWN ITEM HOVER - Background abu terang (#f5f5f5) menggantikan biru gelap, warna teks berubah ke gold agar konsisten dengan aksen brand */
        .dropdown-item:hover {
            background: #f5f5f5;
            color: var(--gold);
            transform: translateX(5px);
        }

        /* DROPDOWN ITEM ACTIVE - State aktif menggunakan gold transparan sangat ringan agar item yang dipilih tetap teridentifikasi dengan jelas */
        .dropdown-item.active,
        .dropdown-item:active {
            background: rgba(198, 164, 59, 0.10);
            color: var(--gold);
        }

        /* DROPDOWN HEADER - Label kategori tetap berwarna gold agar berfungsi sebagai aksen premium di dalam dropdown putih */
        .dropdown-header {
            color: var(--gold);
            padding: 8px 24px;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* NAVBAR TOGGLER - Tombol hamburger untuk mobile, menggunakan border abu tipis dan background abu sangat terang agar terlihat dan kontras di atas background putih */
        .navbar-toggler {
            border: 1px solid rgba(0, 0, 0, 0.12);
            background: rgba(0, 0, 0, 0.03);
            padding: 8px 12px;
            border-radius: 14px;
            transition: all 0.25s ease;
        }

        /* NAVBAR TOGGLER HOVER - Background sedikit lebih gelap saat hover agar ada feedback visual yang terasa pada tombol hamburger */
        .navbar-toggler:hover {
            background: rgba(0, 0, 0, 0.07);
        }

        /* NAVBAR TOGGLER FOCUS - Menghilangkan outline bawaan browser saat tombol difokus agar tidak mengganggu tampilan visual */
        .navbar-toggler:focus {
            box-shadow: none;
            outline: none;
        }

        /* NAVBAR TOGGLER ICON - Ikon tiga garis berwarna biru gelap agar kontras dan terbaca dengan jelas di atas background putih */
        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(0, 51, 102, 0.9)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        /* LANG BTN - Tombol pilihan bahasa dengan border gold tipis dan background abu sangat terang agar tampil sebagai elemen tersendiri yang berbeda dari nav-link biasa */
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

        /* LANG BTN HOVER - Background gold transparan sangat ringan saat hover agar konsisten dengan tema aksen gold di seluruh navbar */
        .lang-btn:hover {
            background: rgba(198, 164, 59, 0.10);
            border-color: var(--gold);
            transform: translateY(-2px);
        }

        /* LANG DROPDOWN - Lebar minimum dropdown bahasa cukup untuk menampung dua pilihan bahasa tanpa terpotong */
        .lang-dropdown {
            min-width: 150px;
        }

        /* LANG DROPDOWN ITEM - Flex row agar ikon bendera dan teks bahasa sejajar rapi secara horizontal */
        .lang-dropdown .dropdown-item {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* LANG DROPDOWN ITEM ICON - Lebar tetap untuk ikon agar teks bahasa selalu sejajar meskipun ikon berbeda ukuran */
        .lang-dropdown .dropdown-item i {
            width: 20px;
        }

        /* RESPONSIVE 991px - Breakpoint tablet dan HP landscape, navbar beralih ke mode collapse dengan panel dropdown vertikal */
        @media (max-width: 991px) {
            .logo-img { height: 40px; }
            .logo-divider { height: 26px; }
            .navbar-brand { font-size: 1.4rem; }

            /* NAVBAR COLLAPSE MOBILE - Panel menu mobile menggunakan background putih dengan border abu dan shadow ringan, menggantikan biru gelap agar konsisten dengan header putih */
            .navbar-collapse {
                background: #ffffff;
                border: 1px solid rgba(0, 0, 0, 0.08);
                padding: 0.5rem 0.75rem;
                border-radius: 20px;
                margin-top: 0.8rem;
                box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
            }

            /* NAVBAR NAV MOBILE - Hilangkan gap antar item agar jarak teks tidak terlalu jauh di layar kecil */
            .navbar-nav {
                gap: 0;
            }

            /* NAV LINK MOBILE - Teks hitam gelap, text-align center agar semua menu sejajar di tengah, padding kompak agar tidak terlalu berjarak */
            .nav-link {
                color: #1a1a1a !important;
                text-align: center;
                padding: 8px 16px !important;
                margin: 1px 0;
                line-height: 1.4;
                border-radius: 12px;
            }

            /* NAV LINK HOVER MOBILE - Hilangkan translateY agar tidak menggeser konten di layar kecil yang ruangnya terbatas */
            .nav-link:hover {
                transform: none;
                background: rgba(0, 0, 0, 0.04);
            }

            /* NAV LINK ACTIVE MOBILE - Tetap gold sesuai desain asli agar konsisten antara tampilan desktop dan mobile */
            .nav-link.active {
                color: var(--gold) !important;
                background: rgba(198, 164, 59, 0.10);
            }

            /* DROPDOWN MENU MOBILE - Background abu sangat terang (#f9f9f9) agar terlihat berbeda dari panel utama yang putih, tanpa shadow agar tidak tumpang tindih */
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

            /* DROPDOWN ITEM MOBILE - Text center agar sejajar dengan nav-link lainnya, hilangkan translateX karena tidak relevan di mobile */
            .dropdown-item {
                text-align: center;
                margin: 2px 8px;
                padding: 8px 16px;
                color: #2c2c2c;
            }

            /* DROPDOWN ITEM HOVER MOBILE - Hilangkan translateX agar tidak menggeser konten di layar mobile */
            .dropdown-item:hover {
                transform: none;
                background: rgba(198, 164, 59, 0.08);
            }

            /* LANG BTN MOBILE - Tombol bahasa diposisikan center dan diberi margin atas agar terpisah rapi dari menu navigasi di atas */
            .lang-btn {
                margin: 6px auto 2px;
                width: fit-content;
            }
        }

        /* RESPONSIVE 768px - Breakpoint HP portrait ukuran sedang, logo dan brand diperkecil secara proporsional */
        @media (max-width: 768px) {
            .logo-img { height: 36px; }
            .logo-divider { height: 24px; }
            .navbar-brand { font-size: 1.3rem; }
        }

        /* RESPONSIVE 576px - Breakpoint HP kecil, semua elemen logo diperkecil lagi agar tidak overflow dari lebar layar */
        @media (max-width: 576px) {
            .logo-img { height: 32px; }
            .logo-divider { height: 20px; }
            .navbar-brand { font-size: 1.15rem; }
        }

        /* FOOTER - Background gradient biru gelap ke biru sangat gelap, diposisikan di bawah semua konten halaman */
        .footer {
            background: linear-gradient(135deg, #003366 0%, #0a2a4a 100%);
            color: white;
            padding: 50px 0 20px;
            margin-top: 0;
            position: relative;
        }

        /* FOOTER BEFORE - Garis dekoratif gold di bagian paling atas footer sebagai pemisah visual yang premium antara konten dan footer */
        .footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #c6a43b, #e8c45a, #c6a43b);
        }

        /* FOOTER TITLE - Judul setiap kolom footer, ukuran sedikit lebih besar dengan underline gold yang muncul dari bawah */
        .footer-title {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 1.2rem;
            position: relative;
            display: inline-block;
            padding-bottom: 8px;
        }

        /* FOOTER TITLE AFTER - Garis bawah gold pada judul kolom footer, lebar awal 40px dan melebar saat kolom di-hover */
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

        /* FOOTER COL HOVER TITLE AFTER - Saat kolom footer di-hover, garis bawah gold melebar dari 40px ke 60px sebagai animasi interaktif */
        .footer-col:hover .footer-title::after {
            width: 60px;
        }

        /* FOOTER LINKS - List tautan navigasi di footer, list-style dihilangkan dan padding direset agar tampil bersih */
        .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        /* FOOTER LINKS LI - Jarak bawah antar item link agar tidak terlalu rapat */
        .footer-links li {
            margin-bottom: 10px;
        }

        /* FOOTER LINKS A - Tautan berwarna putih transparan, menggunakan flex row agar ikon chevron dan teks sejajar horizontal */
        .footer-links a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 0.85rem;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        /* FOOTER LINKS A ICON - Ikon chevron tersembunyi secara default dan muncul saat link di-hover untuk efek dinamis */
        .footer-links a i {
            font-size: 0.7rem;
            opacity: 0;
            transition: all 0.3s ease;
        }

        /* FOOTER LINKS A HOVER - Warna gold dan bergerak ke kanan 5px saat hover untuk memberikan efek interaktif yang elegan */
        .footer-links a:hover {
            color: #c6a43b;
            transform: translateX(5px);
        }

        /* FOOTER LINKS A HOVER ICON - Ikon chevron muncul dan bergerak sedikit ke kanan bersama teks saat link di-hover */
        .footer-links a:hover i {
            opacity: 1;
            transform: translateX(3px);
        }

        /* FOOTER CONTACT - List informasi kontak di footer, list-style dihilangkan dan padding direset */
        .footer-contact {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        /* FOOTER CONTACT LI - Setiap item kontak menggunakan flex row agar ikon dan teks sejajar, dengan jarak bawah yang konsisten */
        .footer-contact li {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 12px;
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.7);
            transition: all 0.3s ease;
        }

        /* FOOTER CONTACT LI HOVER - Bergerak ke kanan dan berubah ke warna gold saat di-hover untuk efek interaktif */
        .footer-contact li:hover {
            transform: translateX(5px);
            color: #c6a43b;
        }

        /* FOOTER CONTACT LI ICON - Ikon kontak berwarna gold dengan lebar tetap 20px agar teks selalu sejajar rapi */
        .footer-contact li i {
            color: #c6a43b;
            width: 20px;
        }

        /* SOCIAL ICONS WRAPPER - Flex container untuk ikon sosial media dengan gap seragam dan flex-wrap agar tidak overflow di layar kecil */
        .social-icons {
            display: flex;
            gap: 12px;
            margin-top: 20px;
            flex-wrap: wrap;
        }

        /* SOCIAL ICON - Ikon sosial media berbentuk lingkaran dengan background putih sangat transparan dan border gold tipis */
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

        /* SOCIAL ICON HOVER - Background berubah ke gradient gold, warna ikon ke biru gelap, dan berputar 360 derajat untuk efek hover yang berkesan */
        .social-icon:hover {
            background: linear-gradient(135deg, #c6a43b, #a8892e);
            color: #003366;
            transform: translateY(-5px) rotate(360deg);
            border-color: transparent;
        }

        /* COPYRIGHT - Area copyright di bagian paling bawah footer dengan garis atas putih sangat transparan sebagai pemisah */
        .copyright {
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            padding-top: 20px;
            margin-top: 35px;
            text-align: center;
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.5);
        }

        /* FOOTER RESPONSIVE 991px - 577px - Kolom pertama melebar penuh sedangkan tiga kolom lainnya berbagi lebar sepertiga */
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

        /* FOOTER RESPONSIVE 576px - Layout grid dua kolom untuk HP kecil, kolom pertama dan terakhir melebar penuh */
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

        /* FOOTER RESPONSIVE 380px - HP sangat kecil, gap grid dikurangi dan font lebih kecil agar tidak overflow */
        @media (max-width: 380px) {
            .footer .row { gap: 20px; }
            .footer-title { font-size: 0.85rem; }
            .social-icon { width: 30px; height: 30px; font-size: 0.7rem; }
        }

        /* BACK TO TOP - Tombol kembali ke atas halaman, posisi fixed di pojok kanan bawah, tersembunyi secara default */
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

        /* BACK TO TOP SHOW - Kelas yang ditambahkan via JavaScript saat scroll melebihi 300px untuk menampilkan tombol */
        .back-to-top.show {
            opacity: 1;
            visibility: visible;
        }

        /* BACK TO TOP HOVER - Background berubah ke putih dan sedikit naik saat hover untuk memberikan feedback interaktif */
        .back-to-top:hover {
            background: white;
            transform: translateY(-4px) scale(1.05);
        }

        /* BACK TO TOP RESPONSIVE 576px - Ukuran diperkecil dan digeser ke pojok agar tidak menutupi terlalu banyak konten di HP kecil */
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

    <!-- NAVBAR - Fixed top agar selalu terlihat saat scroll, navbar-expand-lg berarti collapse aktif di bawah 992px -->
    <nav class="navbar navbar-expand-lg fixed-top" id="navbar">
        <div class="container">

            <!-- LOGO WRAPPER - Grup logo Bank Indonesia, logo Del, dan teks brand GeoToba dalam satu baris flex -->
            <div class="logo-wrapper">
                <img src="{{ asset('image/Logo/logobankindonesia.jpg') }}" alt="Bank Indonesia" class="logo-img" loading="lazy">
                <div class="logo-divider"></div>
                <img src="{{ asset('image/Logo/del.jpg') }}" alt="Logo Del" class="logo-img" loading="lazy">
                <div class="logo-divider"></div>
                <a class="navbar-brand" href="{{ url('/') }}">Geo<span>Toba</span></a>
            </div>

            <!-- NAVBAR TOGGLER - Tombol hamburger yang muncul di bawah breakpoint 992px untuk membuka menu collapse -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- NAVBAR COLLAPSE - Grup menu navigasi yang collapse di mobile, ms-auto mendorong menu ke kanan -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">

                    <!-- MENU BERANDA - Active class ditambahkan secara dinamis via Laravel route check -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ url('/') }}">
                            {{ app()->getLocale() == 'id' ? 'Beranda' : 'Home' }}
                        </a>
                    </li>

                    <!-- MENU INFORMASI - Active class ditambahkan jika route saat ini adalah 'informasi' -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('informasi') ? 'active' : '' }}" href="{{ url('/informasi') }}">
                            {{ app()->getLocale() == 'id' ? 'Informasi' : 'Information' }}
                        </a>
                    </li>

                    <!-- MENU DESTINASI - Dropdown dengan submenu kategori destinasi, active jika route diawali 'destinasi' -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('destinasi*') ? 'active' : '' }}" href="#" data-bs-toggle="dropdown">
                            {{ app()->getLocale() == 'id' ? 'Destinasi' : 'Destinations' }}
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <h6 class="dropdown-header">
                                    <i class="fas fa-tag me-1"></i>
                                    {{ app()->getLocale() == 'id' ? 'KATEGORI DESTINASI' : 'DESTINATION CATEGORIES' }}
                                </h6>
                            </li>
                            <li><a class="dropdown-item" href="{{ url('/destinasi/alam') }}">{{ app()->getLocale() == 'id' ? 'Destinasi Alam' : 'Natural Destinations' }}</a></li>
                            <li><a class="dropdown-item" href="{{ url('/destinasi/buatan') }}">{{ app()->getLocale() == 'id' ? 'Destinasi Buatan' : 'Man-made Destinations' }}</a></li>
                            <li><a class="dropdown-item" href="{{ url('/destinasi/budaya') }}">{{ app()->getLocale() == 'id' ? 'Destinasi Budaya' : 'Cultural Destinations' }}</a></li>
                            <li><hr class="dropdown-divider" style="border-color: rgba(0,0,0,0.08);"></li>
                            <li><a class="dropdown-item" href="{{ url('/destinasi') }}">{{ app()->getLocale() == 'id' ? 'Semua Destinasi' : 'All Destinations' }}</a></li>
                        </ul>
                    </li>

                    <!-- MENU GALERI - Active class ditambahkan jika route saat ini adalah 'galeri' -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('galeri') ? 'active' : '' }}" href="{{ url('/galeri') }}">
                            {{ app()->getLocale() == 'id' ? 'Galeri' : 'Gallery' }}
                        </a>
                    </li>

                    <!-- MENU BERITA - Active class ditambahkan jika route saat ini adalah 'berita' -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('berita') ? 'active' : '' }}" href="{{ url('/berita') }}">
                            {{ app()->getLocale() == 'id' ? 'Berita' : 'News' }}
                        </a>
                    </li>

                    <!-- MENU KONTAK - Active class ditambahkan jika route saat ini adalah 'kontak' -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('kontak') ? 'active' : '' }}" href="{{ url('/kontak') }}">
                            {{ app()->getLocale() == 'id' ? 'Kontak' : 'Contact' }}
                        </a>
                    </li>

                    <!-- TOMBOL BAHASA - Dropdown pilihan bahasa dengan ikon globe, ms-2 memberi jarak kiri dari menu kontak -->
                    <li class="nav-item dropdown ms-2">
                        <a class="nav-link dropdown-toggle lang-btn" href="#" data-bs-toggle="dropdown">
                            <i class="fas fa-globe"></i>
                            {{ app()->getLocale() == 'id' ? 'ID' : 'EN' }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end lang-dropdown">
                            <li>
                                <a class="dropdown-item {{ app()->getLocale() == 'id' ? 'active' : '' }}" href="{{ route('lang.switch', 'id') }}">
                                    <i class="fas fa-flag me-2"></i> Bahasa Indonesia
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item {{ app()->getLocale() == 'en' ? 'active' : '' }}" href="{{ route('lang.switch', 'en') }}">
                                    <i class="fas fa-flag-usa me-2"></i> English
                                </a>
                            </li>
                        </ul>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    <!-- MAIN CONTENT - Area yield untuk konten dari setiap child view yang meng-extend layout ini -->
    <main>@yield('content')</main>

    <!-- FOOTER PREMIUM - Footer dengan background biru gelap dan aksen gold -->
    <footer class="footer">
        <div class="container">
            <div class="row">

                <!-- KOLOM BRAND - Deskripsi singkat GeoToba dan ikon sosial media -->
                <div class="col-lg-4 col-md-12 mb-4 footer-col">
                    <h5 class="footer-title">Geo<span style="color: #c6a43b;">Toba</span></h5>
                    <p style="font-size: 0.85rem; color: rgba(255,255,255,0.7); line-height: 1.6;">
                        {{ app()->getLocale() == 'id' ? 'Sistem Informasi Geosite Danau Toba - Menyajikan informasi lengkap tentang keindahan geologi dan budaya Batak di kawasan Danau Toba.' : 'Geosite Toba Information System - Presents complete information about the geological beauty and Batak culture in the Lake Toba area.' }}
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
                    <h5 class="footer-title">{{ app()->getLocale() == 'id' ? 'Tautan' : 'Quick Links' }}</h5>
                    <ul class="footer-links">
                        <li><a href="{{ url('/') }}"><i class="fas fa-chevron-right"></i> {{ app()->getLocale() == 'id' ? 'Beranda' : 'Home' }}</a></li>
                        <li><a href="{{ url('/informasi') }}"><i class="fas fa-chevron-right"></i> {{ app()->getLocale() == 'id' ? 'Informasi' : 'Information' }}</a></li>
                        <li><a href="{{ url('/galeri') }}"><i class="fas fa-chevron-right"></i> {{ app()->getLocale() == 'id' ? 'Galeri' : 'Gallery' }}</a></li>
                        <li><a href="{{ url('/berita') }}"><i class="fas fa-chevron-right"></i> {{ app()->getLocale() == 'id' ? 'Berita' : 'News' }}</a></li>
                        <li><a href="{{ url('/kontak') }}"><i class="fas fa-chevron-right"></i> {{ app()->getLocale() == 'id' ? 'Kontak' : 'Contact' }}</a></li>
                    </ul>
                </div>

                <!-- KOLOM DESTINASI - Daftar link ke kategori-kategori destinasi wisata -->
                <div class="col-lg-3 col-md-4 col-sm-6 col-6 mb-4 footer-col">
                    <h5 class="footer-title">{{ app()->getLocale() == 'id' ? 'Destinasi' : 'Destinations' }}</h5>
                    <ul class="footer-links">
                        <li><a href="{{ url('/destinasi/alam') }}"><i class="fas fa-chevron-right"></i> {{ app()->getLocale() == 'id' ? 'Destinasi Alam' : 'Natural Destinations' }}</a></li>
                        <li><a href="{{ url('/destinasi/buatan') }}"><i class="fas fa-chevron-right"></i> {{ app()->getLocale() == 'id' ? 'Destinasi Buatan' : 'Man-made Destinations' }}</a></li>
                        <li><a href="{{ url('/destinasi/budaya') }}"><i class="fas fa-chevron-right"></i> {{ app()->getLocale() == 'id' ? 'Destinasi Budaya' : 'Cultural Destinations' }}</a></li>
                        <li><a href="{{ url('/destinasi') }}"><i class="fas fa-chevron-right"></i> {{ app()->getLocale() == 'id' ? 'Semua Destinasi' : 'All Destinations' }}</a></li>
                    </ul>
                </div>

                <!-- KOLOM KONTAK - Informasi kontak termasuk alamat, nomor telepon, email, dan jam operasional -->
                <div class="col-lg-3 col-md-4 col-sm-12 mb-4 footer-col">
                    <h5 class="footer-title">{{ app()->getLocale() == 'id' ? 'Kontak' : 'Contact Us' }}</h5>
                    <ul class="footer-contact">
                        <li><i class="fas fa-map-marker-alt"></i> {{ app()->getLocale() == 'id' ? 'Danau Toba, Sumatera Utara' : 'Lake Toba, North Sumatra' }}</li>
                        <li><i class="fas fa-phone"></i> +62 812 3456 7890</li>
                        <li><i class="fas fa-envelope"></i> info@geotoba.com</li>
                        <li><i class="fas fa-clock"></i> {{ app()->getLocale() == 'id' ? 'Senin - Minggu : 08.00 - 18.00 WIB' : 'Monday - Sunday : 08:00 - 18:00 WIB' }}</li>
                    </ul>
                </div>

            </div>

            <!-- COPYRIGHT - Teks hak cipta di bagian paling bawah footer -->
            <div class="copyright">
                <p>&copy; 2026 GeoToba - Geopark Danau Toba. {{ app()->getLocale() == 'id' ? 'Hak Cipta dilindungi.' : 'All rights reserved.' }}</p>
            </div>
        </div>
    </footer>

    <!-- BACK TO TOP - Tombol scroll ke atas, ditampilkan via JavaScript saat user scroll lebih dari 300px -->
    <div class="back-to-top" id="backToTop"><i class="fas fa-arrow-up"></i></div>

    <!-- Bootstrap JS Bundle - Termasuk Popper.js di dalamnya untuk dropdown dan collapse navbar -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- AOS JS - Inisialisasi library animasi scroll -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script>
        // Inisialisasi AOS dengan durasi animasi 1000ms dan hanya dijalankan sekali saat elemen pertama kali masuk viewport
        AOS.init({ duration: 1000, once: true });

        // Navbar scroll effect - Menambahkan class 'scrolled' ke navbar saat halaman di-scroll lebih dari 50px untuk mempertegas shadow
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', function() {
            if (window.scrollY > 50) navbar.classList.add('scrolled');
            else navbar.classList.remove('scrolled');
        });

        // Back to top visibility - Menampilkan tombol kembali ke atas saat halaman di-scroll lebih dari 300px
        const backToTop = document.getElementById('backToTop');
        window.addEventListener('scroll', function() {
            if (window.scrollY > 300) backToTop.classList.add('show');
            else backToTop.classList.remove('show');
        });

        // Back to top click - Scroll halaman kembali ke posisi paling atas dengan animasi smooth saat tombol diklik
        backToTop.addEventListener('click', function() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    </script>

    @stack('scripts')
</body>
</html>