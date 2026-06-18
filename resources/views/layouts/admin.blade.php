

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

        html, body {
            overflow-x: hidden;
            max-width: 100%;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #f1f5f9;
            color: #0f172a;
        }

        /* SIDEBAR */
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
            display: flex;
            flex-direction: column;
        }

        .sidebar.closed {
            transform: translateX(-100%);
        }

        .sidebar-header {
            padding: 28px 24px 24px;
            background: linear-gradient(135deg, #003366 0%, #1a4a7a 100%);
            position: relative;
            overflow: hidden;
        }

        .sidebar-header::before {
            content: '';
            position: absolute;
            top: -30px;
            right: -30px;
            width: 100px;
            height: 100px;
            background: rgba(255, 255, 255, 0.06);
            border-radius: 50%;
        }

        .sidebar-header::after {
            content: '';
            position: absolute;
            bottom: -20px;
            left: 20px;
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.04);
            border-radius: 50%;
        }

        .sidebar-header-icon {
            width: 42px;
            height: 42px;
            background: rgba(198, 164, 59, 0.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 12px;
            position: relative;
            z-index: 1;
        }

        .sidebar-header-icon i {
            color: #c6a43b;
            font-size: 1.1rem;
        }

        .sidebar-header h3 {
            font-size: 1.25rem;
            font-weight: 800;
            color: #ffffff;
            position: relative;
            z-index: 1;
            letter-spacing: -0.3px;
        }

        .sidebar-header h3 span {
            color: #c6a43b;
        }

        .sidebar-header p {
            font-size: 0.7rem;
            color: rgba(255, 255, 255, 0.6);
            margin-top: 6px;
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .sidebar-header p::before {
            content: '';
            width: 6px;
            height: 6px;
            background: #22c55e;
            border-radius: 50%;
            display: inline-block;
            flex-shrink: 0;
        }

        .sidebar-menu {
            padding: 12px 0 24px;
            flex: 1;
        }

        .sidebar-menu .menu-title {
            padding: 16px 20px 6px;
            font-size: 0.62rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: #94a3b8;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 16px;
            color: #64748b;
            text-decoration: none;
            transition: all 0.2s ease;
            font-size: 0.83rem;
            font-weight: 500;
            margin: 1px 10px;
            border-radius: 10px;
        }

        .sidebar-menu a:hover {
            background: #f8fafc;
            color: #0f172a;
        }

        .sidebar-menu a.active {
            background: linear-gradient(90deg, rgba(0, 51, 102, 0.08), rgba(0, 51, 102, 0.04));
            color: #003366;
            font-weight: 600;
            border-left: 3px solid #003366;
            padding-left: 13px;
        }

        .sidebar-menu a i {
            width: 18px;
            font-size: 0.9rem;
            text-align: center;
            flex-shrink: 0;
        }

        .sidebar-menu a.active i {
            color: #003366;
        }

        /* MAIN CONTENT */
        .main-content {
            margin-left: 260px;
            padding: 0;
            padding-top: 64px;
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }

        .main-content.expanded {
            margin-left: 0;
        }

        /* TOP BAR */
        .top-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 32px;
            height: 64px;
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            box-shadow: 0 1px 8px rgba(0, 0, 0, 0.04);
            position: fixed;
            top: 0;
            left: 260px;
            right: 0;
            z-index: 500;
            gap: 12px;
            flex-wrap: nowrap;
            transition: left 0.3s ease;
        }

        .top-bar-left {
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 0;
            flex: 1;
        }

        .top-bar-right {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-shrink: 0;
        }

        .menu-toggle {
            display: none;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 8px 10px;
            border-radius: 10px;
            cursor: pointer;
            font-size: 0.9rem;
            color: #475569;
            transition: all 0.2s;
            flex-shrink: 0;
            line-height: 1;
        }

        .menu-toggle:hover {
            background: #f1f5f9;
            color: #0f172a;
        }

        .page-title {
            font-size: 1.05rem;
            font-weight: 700;
            color: #0f172a;
            letter-spacing: -0.2px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 8px;
            background: #f8fafc;
            padding: 5px 5px 5px 12px;
            border-radius: 40px;
            border: 1px solid #e2e8f0;
            flex-shrink: 0;
        }

        .user-name {
            font-size: 0.8rem;
            font-weight: 500;
            color: #334155;
            display: flex;
            align-items: center;
            gap: 7px;
            white-space: nowrap;
        }

        .user-name i {
            color: #003366;
            font-size: 1rem;
            flex-shrink: 0;
        }

        .logout-btn {
            background: #ffffff;
            color: #64748b;
            padding: 6px 12px;
            border-radius: 30px;
            font-size: 0.75rem;
            font-weight: 500;
            border: 1px solid #e2e8f0;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 5px;
            white-space: nowrap;
            flex-shrink: 0;
        }

        .logout-btn:hover {
            background: #fee2e2;
            color: #dc2626;
            border-color: #fecaca;
        }

        .content-wrapper {
            padding: 28px 32px;
        }

        /* STATS GRID */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 16px;
            margin-bottom: 28px;
        }

        .stat-card {
            background: white;
            padding: 18px 16px;
            border-radius: 14px;
            border: 1px solid #e2e8f0;
            transition: all 0.2s ease;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #003366, #1a4a7a);
            border-radius: 14px 14px 0 0;
        }

        .stat-card:hover {
            border-color: #cbd5e1;
            box-shadow: 0 6px 20px rgba(0, 51, 102, 0.08);
            transform: translateY(-2px);
        }

        .stat-number {
            font-size: 1.6rem;
            font-weight: 800;
            color: #003366;
            letter-spacing: -0.5px;
            margin-top: 4px;
        }

        .stat-label {
            font-size: 0.68rem;
            color: #94a3b8;
            margin-top: 4px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* CARD TABLE */
        .card-table {
            background: white;
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 24px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.03);
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 16px;
            border-bottom: 1px solid #f1f5f9;
            flex-wrap: wrap;
            gap: 12px;
        }

        .card-header h5 {
            font-size: 1rem;
            font-weight: 700;
            color: #0f172a;
        }

        /* BUTTONS */
        .btn-primary {
            background: linear-gradient(135deg, #1e3a8a, #172554);
            color: white;
            padding: 9px 18px;
            border-radius: 10px;
            font-size: 0.8rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: none;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(30, 58, 138, 0.25);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #172554, #0f172a);
            box-shadow: 0 4px 14px rgba(30, 58, 138, 0.35);
            transform: translateY(-1px);
            color: white;
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #64748b;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 500;
            margin-bottom: 20px;
            transition: all 0.2s;
            padding: 8px 14px;
            border-radius: 10px;
            background: white;
            border: 1px solid #e2e8f0;
        }

        .btn-back:hover {
            color: #003366;
            border-color: #003366;
            background: rgba(0, 51, 102, 0.04);
        }

        .btn-submit {
            background: linear-gradient(135deg, #22c55e, #16a34a);
            color: white;
            padding: 10px 24px;
            border-radius: 10px;
            font-size: 0.85rem;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 115px;
            margin-right: 8px;
            box-shadow: 0 2px 8px rgba(34, 197, 94, 0.2);
        }

        .btn-submit:hover {
            background: linear-gradient(135deg, #16a34a, #15803d);
            box-shadow: 0 4px 12px rgba(34, 197, 94, 0.3);
        }

        .btn-cancel {
            background: #f8fafc;
            color: #64748b;
            padding: 10px 24px;
            border-radius: 10px;
            font-size: 0.85rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 115px;
            border: 1px solid #e2e8f0;
        }

        .btn-cancel:hover {
            background: #fee2e2;
            color: #dc2626;
            border-color: #fecaca;
        }

        /* FORM */
        .form-page {
            max-width: 800px;
            margin: 0 auto;
        }

        .form-card {
            background: white;
            border-radius: 20px;
            padding: 32px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04);
        }

        .form-card h2 {
            font-size: 1.25rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 6px;
        }

        .form-card p {
            color: #94a3b8;
            font-size: 0.82rem;
            margin-bottom: 28px;
            padding-bottom: 20px;
            border-bottom: 1px solid #f1f5f9;
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
            font-size: 0.78rem;
            font-weight: 600;
            color: #334155;
            margin-bottom: 7px;
        }

        .form-group .required {
            color: #ef4444;
        }

        .form-control {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            font-size: 0.84rem;
            transition: all 0.2s;
            color: #334155;
            background: #fafafa;
            font-family: 'Inter', sans-serif;
        }

        .form-control:focus {
            outline: none;
            border-color: #003366;
            box-shadow: 0 0 0 3px rgba(0, 51, 102, 0.08);
            background: #ffffff;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }

        .form-group small {
            display: block;
            font-size: 0.68rem;
            color: #94a3b8;
            margin-top: 5px;
        }

        .form-check {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 20px 0;
            padding: 12px 16px;
            background: #f8fafc;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
        }

        .form-check input {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: #003366;
        }

        .form-check label {
            font-size: 0.84rem;
            color: #334155;
            cursor: pointer;
            font-weight: 500;
        }

        .form-actions {
            display: flex;
            gap: 12px;
            margin-top: 24px;
            padding-top: 20px;
            border-top: 1px solid #f1f5f9;
        }

        /* TABLE */
        .table-responsive {
            overflow-x: auto;
            border-radius: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 600px;
        }

        th {
            text-align: left;
            padding: 12px 14px;
            font-size: 0.68rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: #64748b;
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
        }

        th:first-child {
            border-radius: 10px 0 0 0;
        }

        th:last-child {
            border-radius: 0 10px 0 0;
        }

        td {
            padding: 13px 14px;
            font-size: 0.83rem;
            color: #334155;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }

        tr:hover td {
            background: #fafafa;
        }

        tr:last-child td {
            border-bottom: none;
        }

        /* BADGES */
        .badge {
            padding: 4px 10px;
            border-radius: 30px;
            font-size: 0.68rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .badge-success {
            background: #dcfce7;
            color: #15803d;
        }

        .badge-danger {
            background: #fee2e2;
            color: #b91c1c;
        }

        .badge-number {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 28px;
            background: #f1f5f9;
            padding: 3px 8px;
            border-radius: 20px;
            font-size: 0.7rem;
            font-weight: 700;
            color: #475569;
        }

        .btn-group {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
        }

        .action-buttons {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-edit {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 6px 12px;
            background: #eff6ff;
            color: #003366;
            border-radius: 8px;
            font-size: 0.76rem;
            font-weight: 600;
            text-decoration: none;
            transition: background 0.2s ease;
            border: 1px solid #bfdbfe;
            white-space: nowrap;
            cursor: pointer;
        }

        .btn-edit:hover {
            background: #dbeafe;
            text-decoration: none;
            color: #003366;
        }

        .btn-delete, .btn-danger {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 6px 12px;
            background: #fff1f2;
            color: #be123c;
            border-radius: 8px;
            font-size: 0.76rem;
            font-weight: 600;
            border: 1px solid #fecdd3;
            cursor: pointer;
            transition: background 0.2s ease;
            white-space: nowrap;
            text-decoration: none;
        }

        .btn-delete:hover, .btn-danger:hover {
            background: #ffe4e6;
            color: #be123c;
        }

        .btn-warning {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 6px 12px;
            background: #eff6ff;
            color: #003366;
            border-radius: 8px;
            font-size: 0.76rem;
            font-weight: 600;
            text-decoration: none;
            transition: background 0.2s ease;
            border: 1px solid #bfdbfe;
            white-space: nowrap;
            cursor: pointer;
        }

        .btn-warning:hover {
            background: #dbeafe;
            text-decoration: none;
            color: #003366;
        }

        /* PAGE BANNER */
        .page-banner {
            background: linear-gradient(135deg, #003366 0%, #1a4a7a 100%);
            border-radius: 16px;
            padding: 28px 32px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 28px;
            position: relative;
            overflow: hidden;
        }

        .page-banner::before {
            content: '';
            position: absolute;
            top: -40px;
            right: -40px;
            width: 160px;
            height: 160px;
            background: rgba(255,255,255,0.05);
            border-radius: 50%;
        }

        .page-banner::after {
            content: '';
            position: absolute;
            bottom: -30px;
            left: 120px;
            width: 100px;
            height: 100px;
            background: rgba(255,255,255,0.04);
            border-radius: 50%;
        }

        .page-banner-left {
            display: flex;
            align-items: center;
            gap: 20px;
            position: relative;
            z-index: 1;
            min-width: 0;
        }

        .page-banner-icon {
            width: 52px;
            height: 52px;
            background: rgba(255,255,255,0.12);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .page-banner-icon i {
            color: #ffffff;
            font-size: 1.3rem;
        }

        .page-banner-text h1 {
            font-size: 1.35rem;
            font-weight: 700;
            color: #ffffff;
            margin: 0 0 5px;
            letter-spacing: -0.2px;
        }

        .page-banner-text p {
            font-size: 0.8rem;
            color: rgba(255,255,255,0.7);
            margin: 0;
        }

        .btn-tambah {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background: rgba(255,255,255,0.15);
            color: #ffffff;
            padding: 9px 18px;
            border-radius: 10px;
            font-size: 0.82rem;
            font-weight: 600;
            text-decoration: none;
            transition: background 0.2s ease, transform 0.2s ease;
            border: 1px solid rgba(255,255,255,0.25);
            cursor: pointer;
            position: relative;
            z-index: 1;
            white-space: nowrap;
            flex-shrink: 0;
        }

        .btn-tambah:hover {
            background: rgba(255,255,255,0.25);
            transform: translateY(-1px);
            color: #ffffff;
            text-decoration: none;
        }

        /* ALERTS */
        .alert-sukses {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: #15803d;
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 0.82rem;
            font-weight: 500;
            margin-bottom: 20px;
        }

        .alert-sukses i {
            font-size: 0.95rem;
            color: #22c55e;
            flex-shrink: 0;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        .row-number {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 26px;
            height: 26px;
            background: #f1f5f9;
            color: #64748b;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-geosite {
            display: inline-block;
            background: rgba(0, 51, 102, 0.07);
            color: #003366;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 0.72rem;
            font-weight: 600;
            white-space: nowrap;
        }

        .pagination-wrapper {
            margin-top: 20px;
            display: flex;
            justify-content: flex-end;
        }

        .img-preview {
            width: 44px;
            height: 44px;
            object-fit: cover;
            border-radius: 10px;
            border: 2px solid #f1f5f9;
        }

        .img-placeholder {
            width: 44px;
            height: 44px;
            background: #f1f5f9;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.6rem;
            color: #94a3b8;
            font-weight: 500;
            border: 2px solid #e2e8f0;
        }

        .alert-success {
            background: #f0fdf4;
            color: #15803d;
            padding: 14px 18px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 0.84rem;
            font-weight: 500;
            border: 1px solid #bbf7d0;
            border-left: 4px solid #22c55e;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .empty-state {
            text-align: center;
            padding: 48px 20px;
            color: #94a3b8;
        }

        .empty-state i {
            font-size: 2.5rem;
            margin-bottom: 12px;
            display: block;
            color: #cbd5e1;
        }

        .empty-state p {
            font-size: 0.85rem;
            font-weight: 500;
        }

        .pagination {
            margin-top: 20px;
            display: flex;
            justify-content: flex-end;
            flex-wrap: wrap;
            gap: 6px;
        }

        /* RESPONSIVE */
        @media (max-width: 1200px) {
            .stats-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 768px) {
            .menu-toggle {
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
                padding-top: 56px;
            }

            .top-bar {
                padding: 0 14px;
                height: 56px;
                flex-wrap: nowrap;
                gap: 10px;
                left: 0;
            }

            .top-bar-left {
                gap: 10px;
                flex: 1;
                min-width: 0;
            }

            .page-title {
                font-size: 0.9rem;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .top-bar-right {
                flex-shrink: 0;
            }

            .user-menu {
                padding: 4px 4px 4px 10px;
                gap: 6px;
            }

            .user-name span.user-name-text {
                display: none;
            }

            .user-name {
                font-size: 0;
                gap: 0;
            }

            .user-name i {
                font-size: 1.1rem;
            }

            .logout-btn {
                padding: 6px 10px;
                font-size: 0;
                gap: 0;
            }

            .logout-btn i {
                font-size: 0.85rem;
            }

            .content-wrapper {
                padding: 16px 14px;
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

            .page-banner {
                flex-direction: column;
                align-items: flex-start;
                gap: 14px;
                padding: 18px 20px;
            }

            .page-banner-text h1 {
                font-size: 1.1rem;
            }

            .page-banner-text p {
                font-size: 0.75rem;
            }

            .btn-tambah {
                width: 100%;
                justify-content: center;
            }

            .table-wrapper table {
                min-width: 800px;
            }

            .pagination-wrapper {
                justify-content: center;
                flex-wrap: wrap;
            }
        }

        @media (max-width: 576px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .top-bar {
                padding: 0 12px;
                height: 52px;
                left: 0;
            }

            .main-content {
                padding-top: 52px;
            }

            th, td {
                font-size: 0.7rem;
                padding: 8px 8px;
            }

            .btn-edit, .btn-delete, .btn-warning, .btn-danger {
                padding: 4px 8px;
                font-size: 0.62rem;
            }

            .stat-card {
                padding: 14px 12px;
            }

            .stat-number {
                font-size: 1.3rem;
            }

            .card-table {
                padding: 14px;
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

            .stats-grid {
                grid-template-columns: 1fr 1fr;
                gap: 10px;
            }
        }
    </style>
    @stack('styles')
</head>
<body>

{{-- [Summary] Sidebar navigasi admin dengan brand GeoToba, menu utama, dan manajemen konten. --}}
<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="sidebar-header-icon">
            <i class="fas fa-mountain"></i>
        </div>
        <h3>Geo<span>Toba</span></h3>
        <p>Administrator</p>
    </div>
    <div class="sidebar-menu">
        <div class="menu-title">Menu Utama</div>
        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-chart-pie"></i> Dashboard
        </a>

        <div class="menu-title">Manajemen Konten</div>
        <a href="{{ route('admin.homepage.edit') }}" class="{{ request()->routeIs('admin.homepage.*') ? 'active' : '' }}">
            <i class="fas fa-home"></i> Homepage
        </a>
        <a href="{{ route('admin.kontak.edit') }}" class="{{ request()->routeIs('admin.kontak.*') ? 'active' : '' }}">
            <i class="fas fa-address-book"></i> Kontak
        </a>
        <a href="{{ route('admin.profil.index') }}" class="{{ request()->routeIs('admin.profil.*') ? 'active' : '' }}">
            <i class="fas fa-id-card"></i> Profil Geosite
        </a>
        <a href="{{ route('admin.galeri.index') }}" class="{{ request()->routeIs('admin.galeri.*') ? 'active' : '' }}">
            <i class="fas fa-images"></i> Galeri
        </a>
        <a href="{{ route('admin.berita.index') }}" class="{{ request()->routeIs('admin.berita.*') ? 'active' : '' }}">
            <i class="fas fa-newspaper"></i> Berita
        </a>
        <a href="{{ route('admin.informasi.index') }}" class="{{ request()->routeIs('admin.informasi.*') ? 'active' : '' }}">
            <i class="fas fa-info-circle"></i> Informasi
        </a>
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

{{-- [Summary] Area konten utama dengan top-bar sticky dan wrapper yield konten child view. --}}
<div class="main-content" id="mainContent">

    <div class="top-bar">
        <div class="top-bar-left">
            <button class="menu-toggle" id="menuToggle">
                <i class="fas fa-bars"></i>
            </button>
            <div class="page-title">@yield('title', 'Dashboard')</div>
        </div>

        <div class="top-bar-right">
            <div class="user-menu">
                <span class="user-name">
                    <i class="fas fa-user-circle"></i>
                    <span class="user-name-text">{{ Auth::user()->name ?? 'Admin' }}</span>
                </span>
                <form action="{{ route('logout') }}" method="POST" style="display:inline; margin:0; padding:0;">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <i class="fas fa-sign-out-alt"></i>
                        <span class="logout-text"> Keluar</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="content-wrapper">
        @yield('content')
    </div>
</div>

<div id="sidebarOverlay" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.35); z-index:999;"></div>

<script>
    // [Summary] Toggle sidebar mobile: buka/tutup panel navigasi kiri via class 'open' dan overlay.
    const menuToggle = document.getElementById('menuToggle');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');

    function openSidebar() {
        sidebar.classList.add('open');
        overlay.style.display = 'block';
        document.body.style.overflow = 'hidden';
    }

    function closeSidebar() {
        sidebar.classList.remove('open');
        overlay.style.display = 'none';
        document.body.style.overflow = '';
    }

    if (menuToggle) {
        menuToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            if (sidebar.classList.contains('open')) {
                closeSidebar();
            } else {
                openSidebar();
            }
        });
    }

    overlay.addEventListener('click', function() {
        closeSidebar();
    });

    window.addEventListener('resize', function() {
        if (window.innerWidth > 768) {
            closeSidebar();
        }
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
    .swal-popup-geotoba {
        border-radius: 16px !important;
        padding: 32px 28px 24px !important;
        border: 1px solid #e2e8f0 !important;
        font-family: 'Inter', sans-serif !important;
    }

    .swal-actions-geotoba {
        gap: 10px !important;
        width: 100% !important;
        padding: 0 !important;
        margin-top: 8px !important;
    }

    .swal-btn-hapus {
        flex: 1;
        padding: 10px 16px !important;
        background: linear-gradient(135deg, #1e3a8a, #172554) !important;
        color: white !important;
        border: none !important;
        border-radius: 10px !important;
        font-size: 0.82rem !important;
        font-weight: 600 !important;
        cursor: pointer !important;
        font-family: 'Inter', sans-serif !important;
        transition: all 0.2s ease !important;
    }

    .swal-btn-hapus:hover {
        background: linear-gradient(135deg, #172554, #0f172a) !important;
        transform: translateY(-1px) !important;
    }

    .swal-btn-batal {
        flex: 1;
        padding: 10px 16px !important;
        background: #fee2e2 !important;
        color: #dc2626 !important;
        border: 1px solid #fecaca !important;
        border-radius: 10px !important;
        font-size: 0.82rem !important;
        font-weight: 600 !important;
        cursor: pointer !important;
        font-family: 'Inter', sans-serif !important;
        transition: all 0.2s ease !important;
    }

    .swal-btn-batal:hover {
        background: #fecaca !important;
    }

    .swal-btn-ok {
        width: 100%;
        padding: 10px 16px !important;
        background: linear-gradient(135deg, #1e3a8a, #172554) !important;
        color: white !important;
        border: none !important;
        border-radius: 10px !important;
        font-size: 0.82rem !important;
        font-weight: 600 !important;
        cursor: pointer !important;
        font-family: 'Inter', sans-serif !important;
        transition: all 0.2s ease !important;
    }

    .swal-btn-ok:hover {
        background: linear-gradient(135deg, #172554, #0f172a) !important;
        transform: translateY(-1px) !important;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        // [Summary] SweetAlert konfirmasi hapus: intercept semua .btn-delete, tampilkan popup konfirmasi lalu sukses sebelum submit form.
        const deleteButtons = document.querySelectorAll('.btn-delete');

        deleteButtons.forEach(button => {
            const form = button.closest('form');

            if (form) {
                form.removeAttribute('onsubmit');
                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    Swal.fire({
                        html: `
                            <div style="display:flex;flex-direction:column;align-items:center;padding:8px 0 4px;">
                                <div style="width:60px;height:60px;background:#fff1f2;border-radius:50%;display:flex;align-items:center;justify-content:center;margin-bottom:16px;">
                                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#be123c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path d="M19 6l-1 14H6L5 6"></path>
                                        <path d="M10 11v6M14 11v6"></path>
                                        <path d="M9 6V4h6v2"></path>
                                    </svg>
                                </div>
                                <div style="font-size:1.05rem;font-weight:700;color:#0f172a;margin-bottom:8px;">Hapus Data?</div>
                                <div style="font-size:0.82rem;color:#64748b;line-height:1.55;">Data yang dihapus tidak dapat dikembalikan. Pastikan Anda yakin sebelum melanjutkan.</div>
                            </div>
                        `,
                        showCancelButton: true,
                        confirmButtonText: 'Ya, Hapus',
                        cancelButtonText: 'Batal',
                        reverseButtons: true,
                        focusCancel: true,
                        background: '#ffffff',
                        buttonsStyling: false,
                        customClass: {
                            popup:         'swal-popup-geotoba',
                            confirmButton: 'swal-btn-hapus',
                            cancelButton:  'swal-btn-batal',
                            actions:       'swal-actions-geotoba',
                        },

                    }).then((result) => {

                        if (result.isConfirmed) {
                            Swal.fire({
                                html: `
                                    <div style="display:flex;flex-direction:column;align-items:center;padding:8px 0 4px;">
                                        <div style="width:60px;height:60px;background:#dcfce7;border-radius:50%;display:flex;align-items:center;justify-content:center;margin-bottom:16px;">
                                            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#15803d" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                                <polyline points="20 6 9 17 4 12"></polyline>
                                            </svg>
                                        </div>
                                        <div style="font-size:1.05rem;font-weight:700;color:#0f172a;margin-bottom:8px;">Berhasil Dihapus</div>
                                        <div style="font-size:0.82rem;color:#64748b;line-height:1.55;">Data telah dihapus dari sistem.</div>
                                    </div>
                                `,
                                confirmButtonText: 'OK',
                                background: '#ffffff',
                                buttonsStyling: false,
                                customClass: {
                                    popup:         'swal-popup-geotoba',
                                    confirmButton: 'swal-btn-ok',
                                    actions:       'swal-actions-geotoba',
                                },

                            }).then(() => {
                                // [Detail] Submit form ke server setelah user menutup notifikasi sukses.
                                form.submit();
                            });
                        }
                    });
                });
            }
        });
    });
</script>
@stack('scripts')
</body>