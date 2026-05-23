<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Geosite Danau Toba')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
   <style>
        * { font-family: 'Inter', sans-serif; }
        
        :root {
            --blue-dark: #003366;
            --blue-medium: #1a4a7a;
            --gold: #c6a43b;
            --white: #ffffff;
        }
        
        .navbar {
            transition: all 0.4s ease;
            padding: 0.8rem 0;
            background: rgba(0, 51, 102, 0.92);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(198, 164, 59, 0.25);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }
        
        .navbar.scrolled {
            background: rgba(0, 51, 102, 0.96);
            padding: 0.4rem 0;
            box-shadow: 0 6px 24px rgba(0, 0, 0, 0.12);
        }
        
        .navbar .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
        }
        
        .logo-wrapper {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 0;
            padding: 0;
        }
        
        .logo-img {
            height: 60px;
            width: auto;
            border-radius: 16px;
            object-fit: cover;
            transition: all 0.3s ease;
            box-shadow: 0 8px 16px -6px rgba(0, 0, 0, 0.2);
        }
        
        .logo-img:hover {
            transform: scale(1.02) translateY(-2px);
            box-shadow: 0 14px 24px -8px rgba(0, 0, 0, 0.3);
        }
        
        .logo-divider {
            width: 1.5px;
            height: 42px;
            background: linear-gradient(145deg, rgba(255,255,255,0.5), rgba(255,255,255,0.1));
            border-radius: 2px;
        }
        
        .navbar-brand {
            font-size: 1.65rem;
            font-weight: 800;
            color: white !important;
            margin: 0;
            padding: 0 0 0 6px;
            letter-spacing: -0.3px;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }
        
        .navbar-brand span { color: var(--gold); font-weight: 800; }
        
        .nav-link {
            color: white !important;
            font-weight: 500;
            margin: 0 0.2rem;
            transition: all 0.25s ease;
            font-size: 0.95rem;
            padding: 0.5rem 1rem;
            border-radius: 40px;
        }
        
        .nav-link:hover {
            color: var(--gold) !important;
            background: rgba(255, 255, 255, 0.12);
            transform: translateY(-2px);
        }
        
        .nav-link.active {
            color: var(--gold) !important;
            background: rgba(198, 164, 59, 0.2);
        }
        
        .dropdown-menu {
            background: rgba(0, 51, 102, 0.96);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 24px;
            padding: 0.6rem 0;
            margin-top: 0.7rem;
            box-shadow: 0 20px 35px -12px rgba(0, 0, 0, 0.3);
        }
        
        .dropdown-item {
            color: white;
            padding: 10px 24px;
            font-size: 0.85rem;
            transition: all 0.25s ease;
            border-radius: 18px;
            margin: 4px 10px;
        }
        
        .dropdown-item:hover {
            background: rgba(198, 164, 59, 0.2);
            color: var(--gold);
            transform: translateX(5px);
        }
        
        .dropdown-header {
            color: var(--gold);
            padding: 8px 24px;
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .navbar-toggler {
            border: none;
            background: rgba(255, 255, 255, 0.15);
            padding: 8px 12px;
            border-radius: 14px;
        }
        
        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba(255, 255, 255, 1)' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }
        
        /* Language Button Style */
        .lang-btn {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 40px;
            padding: 0.5rem 1rem;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .lang-btn:hover {
            background: rgba(198, 164, 59, 0.3);
            transform: translateY(-2px);
        }
        
        .lang-dropdown {
            min-width: 140px;
        }
        
        .lang-dropdown .dropdown-item {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .lang-dropdown .dropdown-item i {
            width: 20px;
        }
        
        /* Responsive */
        @media (max-width: 991px) {
            .logo-img { height: 52px; }
            .logo-divider { height: 36px; }
            .navbar-brand { font-size: 1.5rem; }
            .navbar-collapse {
                background: rgba(0, 51, 102, 0.96);
                backdrop-filter: blur(20px);
                padding: 1.2rem;
                border-radius: 28px;
                margin-top: 1rem;
            }
            .nav-link { text-align: center; }
        }
        
        @media (max-width: 768px) {
            .logo-img { height: 46px; }
            .logo-divider { height: 32px; }
            .navbar-brand { font-size: 1.35rem; }
        }
        
        @media (max-width: 576px) {
            .logo-img { height: 40px; }
            .logo-divider { height: 28px; }
            .navbar-brand { font-size: 1.2rem; }
        }
        
@include('layouts.footer-css')

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
        
        .back-to-top.show {
            opacity: 1;
            visibility: visible;
        }
        
        .back-to-top:hover {
            background: white;
            transform: translateY(-4px) scale(1.05);
        }
        
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
    <nav class="navbar navbar-expand-lg fixed-top" id="navbar">
        <div class="container">
            <div class="logo-wrapper">
                <img src="{{ asset('image/Logo/logobankindonesia.jpg') }}" alt="Bank Indonesia" class="logo-img" loading="lazy">
                <div class="logo-divider"></div>
                <img src="{{ asset('image/Logo/del.jpg') }}" alt="Logo Del" class="logo-img" loading="lazy">
                <div class="logo-divider"></div>
                <a class="navbar-brand" href="{{ url('/') }}">Geo<span>Toba</span></a>
            </div>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ url('/') }}">{{ app()->getLocale() == 'id' ? 'Beranda' : 'Home' }}</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('informasi') ? 'active' : '' }}" href="{{ url('/informasi') }}">{{ app()->getLocale() == 'id' ? 'Informasi' : 'Information' }}</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('destinasi*') ? 'active' : '' }}" href="#" data-bs-toggle="dropdown">{{ app()->getLocale() == 'id' ? 'Destinasi' : 'Destinations' }}</a>
                        <ul class="dropdown-menu">
                            <li><h6 class="dropdown-header"><i class="fas fa-tag me-1"></i> {{ app()->getLocale() == 'id' ? 'KATEGORI DESTINASI' : 'DESTINATION CATEGORIES' }}</h6></li>
                            <li><a class="dropdown-item" href="{{ url('/destinasi/alam') }}">{{ app()->getLocale() == 'id' ? 'Destinasi Alam' : 'Natural Destinations' }}</a></li>
                            <li><a class="dropdown-item" href="{{ url('/destinasi/buatan') }}">{{ app()->getLocale() == 'id' ? 'Destinasi Buatan' : 'Man-made Destinations' }}</a></li>
                            <li><a class="dropdown-item" href="{{ url('/destinasi/budaya') }}">{{ app()->getLocale() == 'id' ? 'Destinasi Budaya' : 'Cultural Destinations' }}</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ url('/destinasi') }}">{{ app()->getLocale() == 'id' ? 'Semua Destinasi' : 'All Destinations' }}</a></li>
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('galeri') ? 'active' : '' }}" href="{{ url('/galeri') }}">{{ app()->getLocale() == 'id' ? 'Galeri' : 'Gallery' }}</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('berita') ? 'active' : '' }}" href="{{ url('/berita') }}">{{ app()->getLocale() == 'id' ? 'Berita' : 'News' }}</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('kontak') ? 'active' : '' }}" href="{{ url('/kontak') }}">{{ app()->getLocale() == 'id' ? 'Kontak' : 'Contact' }}</a></li>
                    
                    <!-- TOMBOL BAHASA -->
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

    <main>@yield('content')</main>

    @include('layouts.footer')

    <div class="back-to-top" id="backToTop"><i class="fas fa-arrow-up"></i></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <script>
        AOS.init({ duration: 1000, once: true });
        
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', function() {
            if (window.scrollY > 50) navbar.classList.add('scrolled');
            else navbar.classList.remove('scrolled');
        });
        
        const backToTop = document.getElementById('backToTop');
        window.addEventListener('scroll', function() {
            if (window.scrollY > 300) backToTop.classList.add('show');
            else backToTop.classList.remove('show');
        });
        
        backToTop.addEventListener('click', function() {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    </script>
    
    @stack('scripts')
</body>
</html>