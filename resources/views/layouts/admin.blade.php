<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Admin - GeoToba</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #f8fafc;
            color: #0f172a;
        }

        /* ========== SIDEBAR ========== */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 260px;
            height: 100%;
            background: #ffffff;
            border-right: 1px solid #e2e8f0;
            z-index: 1000;
            overflow-y: auto;
            transition: transform 0.3s ease;
        }

        .sidebar.closed {
            transform: translateX(-100%);
        }

        .sidebar-header {
            padding: 24px 20px;
            border-bottom: 1px solid #e2e8f0;
        }

        .sidebar-header h3 {
            font-size: 1.2rem;
            font-weight: 700;
            color: #0f172a;
        }

        .sidebar-header h3 span {
            color: #c6a43b;
        }

        .sidebar-header p {
            font-size: 0.7rem;
            color: #64748b;
            margin-top: 4px;
        }

        .sidebar-menu {
            padding: 16px 0;
        }

        .sidebar-menu .menu-title {
            padding: 8px 20px;
            font-size: 0.65rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #94a3b8;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 20px;
            color: #475569;
            text-decoration: none;
            transition: all 0.2s;
            font-size: 0.85rem;
            font-weight: 500;
            margin: 2px 8px;
            border-radius: 8px;
        }

        .sidebar-menu a:hover {
            background: #f1f5f9;
            color: #0f172a;
        }

        .sidebar-menu a.active {
            background: #eef2ff;
            color: #003366;
        }

        .sidebar-menu a i {
            width: 20px;
            font-size: 1rem;
        }

        /* ========== MAIN CONTENT ========== */
        .main-content {
            margin-left: 260px;
            padding: 24px 32px;
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }

        .main-content.expanded {
            margin-left: 0;
        }

        /* ========== TOP BAR ========== */
        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 28px;
            flex-wrap: wrap;
            gap: 12px;
        }

        .menu-toggle {
            display: none;
            background: white;
            border: 1px solid #e2e8f0;
            padding: 8px 12px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1rem;
            color: #475569;
        }

        .menu-toggle:hover {
            background: #f1f5f9;
        }

        .page-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: #0f172a;
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 16px;
            background: white;
            padding: 6px 16px;
            border-radius: 40px;
            border: 1px solid #e2e8f0;
        }

        .user-name {
            font-size: 0.85rem;
            font-weight: 500;
            color: #334155;
        }

        .logout-btn {
            background: #f1f5f9;
            color: #475569;
            padding: 6px 14px;
            border-radius: 30px;
            font-size: 0.75rem;
            font-weight: 500;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
        }

        .logout-btn:hover {
            background: #fee2e2;
            color: #dc2626;
        }

        /* ========== STATISTICS CARDS ========== */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 16px;
            margin-bottom: 32px;
        }

        .stat-card {
            background: white;
            padding: 16px;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            transition: all 0.2s;
        }

        .stat-card:hover {
            border-color: #cbd5e1;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }

        .stat-number {
            font-size: 1.5rem;
            font-weight: 700;
            color: #0f172a;
        }

        .stat-label {
            font-size: 0.7rem;
            color: #64748b;
            margin-top: 4px;
        }

        /* ========== TABLE CARD ========== */
        .card-table {
            background: white;
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 24px;
            border: 1px solid #e2e8f0;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            flex-wrap: wrap;
            gap: 12px;
        }

        .card-header h5 {
            font-size: 1rem;
            font-weight: 600;
            color: #0f172a;
        }

        /* ========== BUTTONS ========== */
        .btn-primary {
            background: #003366;
            color: white;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 0.8rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: none;
            cursor: pointer;
        }

        .btn-primary:hover {
            background: #1a4a7a;
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #64748b;
            text-decoration: none;
            font-size: 0.85rem;
            margin-bottom: 20px;
            transition: all 0.2s;
        }

        .btn-back:hover {
            color: #003366;
        }

        .btn-submit {
            background: #003366;
            color: white;
            padding: 10px 24px;
            border-radius: 10px;
            font-size: 0.85rem;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-submit:hover {
            background: #1a4a7a;
        }

        .btn-cancel {
            background: #f1f5f9;
            color: #475569;
            padding: 10px 24px;
            border-radius: 10px;
            font-size: 0.85rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-cancel:hover {
            background: #e2e8f0;
        }

        /* ========== FORM STYLES ========== */
        .form-page {
            max-width: 800px;
            margin: 0 auto;
        }

        .form-card {
            background: white;
            border-radius: 20px;
            padding: 32px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }

        .form-card h2 {
            font-size: 1.3rem;
            font-weight: 600;
            color: #0f172a;
            margin-bottom: 8px;
        }

        .form-card p {
            color: #64748b;
            font-size: 0.85rem;
            margin-bottom: 28px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 0.8rem;
            font-weight: 600;
            color: #334155;
            margin-bottom: 6px;
        }

        .form-group .required {
            color: #ef4444;
        }

        .form-control {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            font-size: 0.85rem;
            transition: all 0.2s;
        }

        .form-control:focus {
            outline: none;
            border-color: #003366;
            box-shadow: 0 0 0 3px rgba(0,51,102,0.1);
        }

        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }

        .form-group small {
            display: block;
            font-size: 0.7rem;
            color: #94a3b8;
            margin-top: 4px;
        }

        .form-check {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 20px 0;
        }

        .form-check input {
            width: 18px;
            height: 18px;
            cursor: pointer;
        }

        .form-check label {
            font-size: 0.85rem;
            color: #334155;
            cursor: pointer;
        }

        .form-actions {
            display: flex;
            gap: 12px;
            margin-top: 24px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
        }

        /* ========== TABLE STYLES ========== */
        .table-responsive {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 600px;
        }

        th {
            text-align: left;
            padding: 12px 8px;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #64748b;
            border-bottom: 1px solid #e2e8f0;
        }

        td {
            padding: 12px 8px;
            font-size: 0.85rem;
            color: #334155;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }

        /* ========== BADGES ========== */
        .badge {
            padding: 4px 10px;
            border-radius: 30px;
            font-size: 0.7rem;
            font-weight: 500;
        }

        .badge-success {
            background: #dcfce7;
            color: #166534;
        }

        .badge-danger {
            background: #fee2e2;
            color: #991b1b;
        }

        .badge-number {
            display: inline-block;
            min-width: 30px;
            text-align: center;
            background: #f1f5f9;
            padding: 4px 8px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 600;
            color: #475569;
        }

        /* ========== ACTION BUTTONS ========== */
        .btn-group {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .btn-edit {
            background: #e0e7ff;
            color: #3730a3;
            padding: 5px 12px;
            border-radius: 6px;
            font-size: 0.7rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s;
            display: inline-block;
        }

        .btn-edit:hover {
            background: #c7d2fe;
        }

        .btn-delete {
            background: #fee2e2;
            color: #991b1b;
            padding: 5px 12px;
            border-radius: 6px;
            font-size: 0.7rem;
            font-weight: 500;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-delete:hover {
            background: #fecaca;
        }

        /* ========== IMAGE PREVIEW ========== */
        .img-preview {
            width: 45px;
            height: 45px;
            object-fit: cover;
            border-radius: 8px;
        }

        .img-placeholder {
            width: 45px;
            height: 45px;
            background: #f1f5f9;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.65rem;
            color: #94a3b8;
        }

        /* ========== ALERT ========== */
        .alert-success {
            background: #dcfce7;
            color: #166534;
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 0.85rem;
        }

        /* ========== EMPTY STATE ========== */
        .empty-state {
            text-align: center;
            padding: 40px;
            color: #94a3b8;
        }

        /* ========== PAGINATION ========== */
        .pagination {
            margin-top: 20px;
            display: flex;
            justify-content: flex-end;
            flex-wrap: wrap;
            gap: 8px;
        }

        /* ========== RESPONSIVE ========== */
        @media (max-width: 1200px) {
            .stats-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 768px) {
            .menu-toggle {
                display: block;
            }
            
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.open {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
                padding: 16px;
            }
            
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 12px;
            }
            
            .card-header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .form-row {
                grid-template-columns: 1fr;
                gap: 0;
            }
            
            .form-card {
                padding: 20px;
            }
            
            .btn-group {
                flex-direction: row;
            }
            
            .page-title {
                font-size: 1.1rem;
            }
            
            .top-bar {
                flex-direction: row;
                flex-wrap: wrap;
            }
            
            .user-menu {
                padding: 4px 12px;
            }
            
            .user-name {
                font-size: 0.75rem;
            }
        }

        @media (max-width: 576px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .top-bar {
                flex-direction: column;
                align-items: stretch;
            }
            
            .user-menu {
                justify-content: space-between;
            }
            
            th, td {
                font-size: 0.7rem;
                padding: 6px 4px;
            }
            
            .btn-edit, .btn-delete {
                padding: 3px 8px;
                font-size: 0.6rem;
            }
            
            .stat-card {
                padding: 12px;
            }
            
            .stat-number {
                font-size: 1.2rem;
            }
            
            .card-table {
                padding: 12px;
            }
            
            .form-card {
                padding: 16px;
            }
            
            .form-card h2 {
                font-size: 1.1rem;
            }
        }

        @media (max-width: 480px) {
            .btn-group {
                flex-direction: column;
                gap: 4px;
            }
        }
    </style>
    @stack('styles')
</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <h3>Geo<span>Toba</span></h3>
        <p>Administrator</p>
    </div>
    <div class="sidebar-menu">
        <div class="menu-title">Menu</div>
        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-chart-pie"></i> Dashboard
        </a>
        
        <div class="menu-title">Konten</div>
        <a href="{{ route('admin.galeri.index') }}" class="{{ request()->routeIs('admin.galeri.*') ? 'active' : '' }}">
            <i class="fas fa-images"></i> Galeri
        </a>
        <a href="{{ route('admin.berita.index') }}" class="{{ request()->routeIs('admin.berita.*') ? 'active' : '' }}">
            <i class="fas fa-newspaper"></i> Berita
        </a>
        <a href="{{ route('admin.informasi.index') }}" class="{{ request()->routeIs('admin.informasi.*') ? 'active' : '' }}">
            <i class="fas fa-info-circle"></i> Informasi
        </a>
        
        <div class="menu-title">Desa Meat</div>
        <a href="{{ route('admin.umkm.index') }}" class="{{ request()->routeIs('admin.umkm.*') ? 'active' : '' }}">
            <i class="fas fa-store"></i> UMKM
        </a>
        <a href="{{ route('admin.fasilitas.index') }}" class="{{ request()->routeIs('admin.fasilitas.*') ? 'active' : '' }}">
            <i class="fas fa-tools"></i> Fasilitas
        </a>
        <a href="{{ route('admin.penginapan.index') }}" class="{{ request()->routeIs('admin.penginapan.*') ? 'active' : '' }}">
            <i class="fas fa-hotel"></i> Penginapan
        </a>
    </div>
</div>

<!-- MAIN CONTENT -->
<div class="main-content" id="mainContent">
    <div class="top-bar">
        <div style="display: flex; align-items: center; gap: 16px;">
            <button class="menu-toggle" id="menuToggle">
                <i class="fas fa-bars"></i>
            </button>
            <div class="page-title">@yield('title', 'Dashboard')</div>
        </div>
        <div class="user-menu">
            <span class="user-name"><i class="fas fa-user-circle"></i> {{ Auth::user()->name ?? 'Admin' }}</span>
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i> Keluar
                </button>
            </form>
        </div>
    </div>

    @yield('content')
</div>

<script>
    // Toggle sidebar untuk mobile
    const menuToggle = document.getElementById('menuToggle');
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');

    if (menuToggle) {
        menuToggle.addEventListener('click', function() {
            sidebar.classList.toggle('open');
        });
    }

    // Tutup sidebar saat klik di luar (untuk mobile)
    document.addEventListener('click', function(event) {
        const isMobile = window.innerWidth <= 768;
        if (isMobile && sidebar && !sidebar.contains(event.target) && !menuToggle.contains(event.target)) {
            sidebar.classList.remove('open');
        }
    });

    // Handle resize window
    window.addEventListener('resize', function() {
        if (window.innerWidth > 768) {
            sidebar.classList.remove('open');
        }
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>