

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Admin - GeoToba</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>

        /* Reset global menghapus margin, padding, dan box-sizing default browser */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Mencegah overflow horizontal di seluruh halaman pada layar mobile */
        html, body {
            overflow-x: hidden;
            max-width: 100%;
        }

        /* Body menggunakan font Inter dengan background abu terang agar konten putih terasa timbul */
        body {
            font-family: 'Inter', sans-serif;
            background: #f1f5f9;
            color: #0f172a;
        }

        /* SIDEBAR - Panel navigasi fixed di sisi kiri dengan lebar tetap 260px */
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

        /* SIDEBAR CLOSED - State tersembunyi sidebar digeser ke kiri layar */
        .sidebar.closed {
            transform: translateX(-100%);
        }

        /* SIDEBAR HEADER - Area brand GeoToba dengan gradient biru gelap */
        .sidebar-header {
            padding: 28px 24px 24px;
            background: linear-gradient(135deg, #003366 0%, #1a4a7a 100%);
            position: relative;
            overflow: hidden;
        }

        /* Dekorasi lingkaran besar transparan di pojok kanan atas header sidebar */
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

        /* Dekorasi lingkaran kecil di posisi berbeda untuk memperkaya elemen dekoratif */
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

        /* Ikon brand di atas teks GeoToba dengan warna gold */
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

        /* Ikon font awesome di dalam kotak brand */
        .sidebar-header-icon i {
            color: #c6a43b;
            font-size: 1.1rem;
        }

        /* Teks brand GeoToba berwarna putih */
        .sidebar-header h3 {
            font-size: 1.25rem;
            font-weight: 800;
            color: #ffffff;
            position: relative;
            z-index: 1;
            letter-spacing: -0.3px;
        }

        /* Kata Toba berwarna gold sesuai identitas brand */
        .sidebar-header h3 span {
            color: #c6a43b;
        }

        /* Teks Administrator berwarna putih transparan sebagai keterangan sekunder */
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

        /* Titik hijau kecil sebagai indikator status aktif di samping teks Administrator */
        .sidebar-header p::before {
            content: '';
            width: 6px;
            height: 6px;
            background: #22c55e;
            border-radius: 50%;
            display: inline-block;
            flex-shrink: 0;
        }

        /* Wrapper seluruh item navigasi sidebar */
        .sidebar-menu {
            padding: 12px 0 24px;
            flex: 1;
        }

        /* Label grup menu dalam ukuran sangat kecil uppercase */
        .sidebar-menu .menu-title {
            padding: 16px 20px 6px;
            font-size: 0.62rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: #94a3b8;
        }

        /* Setiap item navigasi menggunakan flex row agar ikon dan teks sejajar */
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

        /* Background abu terang saat hover item menu */
        .sidebar-menu a:hover {
            background: #f8fafc;
            color: #0f172a;
        }

        /* Item aktif dengan background biru transparan dan border kiri biru */
        .sidebar-menu a.active {
            background: linear-gradient(90deg, rgba(0, 51, 102, 0.08), rgba(0, 51, 102, 0.04));
            color: #003366;
            font-weight: 600;
            border-left: 3px solid #003366;
            padding-left: 13px;
        }

        /* Lebar tetap untuk semua ikon agar teks selalu sejajar */
        .sidebar-menu a i {
            width: 18px;
            font-size: 0.9rem;
            text-align: center;
            flex-shrink: 0;
        }

        /* Ikon pada item aktif berwarna biru gelap */
        .sidebar-menu a.active i {
            color: #003366;
        }

        /* Area konten utama di sebelah kanan sidebar dengan margin kiri sebesar lebar sidebar. padding-top setara tinggi top-bar agar konten tidak tertindih header yang fixed */
        .main-content {
            margin-left: 260px;
            padding: 0;
            padding-top: 64px;
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }

        /* State saat sidebar ditutup di mobile, margin kiri direset ke nol */
        .main-content.expanded {
            margin-left: 0;
        }

        /* TOP BAR - Bar navigasi atas fixed agar selalu terlihat saat scroll. left:260px mengikuti lebar sidebar, right:0 menutup sisa lebar layar */
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

        /* Sisi kiri top bar berisi tombol hamburger dan judul halaman */
        .top-bar-left {
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 0;
            flex: 1;
        }

        /* Sisi kanan top bar berisi info user dan tombol keluar */
        .top-bar-right {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-shrink: 0;
        }

        /* Tombol hamburger untuk membuka sidebar di mobile */
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

        /* Background sedikit lebih gelap saat hover tombol hamburger */
        .menu-toggle:hover {
            background: #f1f5f9;
            color: #0f172a;
        }

        /* Judul halaman di top bar dengan teks terpotong jika terlalu panjang */
        .page-title {
            font-size: 1.05rem;
            font-weight: 700;
            color: #0f172a;
            letter-spacing: -0.2px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Wrapper info user berbentuk pill dengan border tipis */
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

        /* Nama user yang sedang login dengan ikon user di depannya */
        .user-name {
            font-size: 0.8rem;
            font-weight: 500;
            color: #334155;
            display: flex;
            align-items: center;
            gap: 7px;
            white-space: nowrap;
        }

        /* Ikon user circle berwarna biru gelap */
        .user-name i {
            color: #003366;
            font-size: 1rem;
            flex-shrink: 0;
        }

        /* Tombol keluar berbentuk pill dengan warna merah saat hover */
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

        /* Warna merah saat hover tombol keluar */
        .logout-btn:hover {
            background: #fee2e2;
            color: #dc2626;
            border-color: #fecaca;
        }

        /* Padding untuk area konten di dalam main-content */
        .content-wrapper {
            padding: 28px 32px;
        }

        /* Grid enam kolom untuk kartu statistik dashboard */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 16px;
            margin-bottom: 28px;
        }

        /* Kartu statistik individual dengan background putih */
        .stat-card {
            background: white;
            padding: 18px 16px;
            border-radius: 14px;
            border: 1px solid #e2e8f0;
            transition: all 0.2s ease;
            position: relative;
            overflow: hidden;
        }

        /* Garis berwarna di bagian atas setiap kartu statistik */
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

        /* Shadow lebih dalam dan sedikit naik saat hover kartu statistik */
        .stat-card:hover {
            border-color: #cbd5e1;
            box-shadow: 0 6px 20px rgba(0, 51, 102, 0.08);
            transform: translateY(-2px);
        }

        /* Angka statistik utama dengan ukuran besar dan bold */
        .stat-number {
            font-size: 1.6rem;
            font-weight: 800;
            color: #003366;
            letter-spacing: -0.5px;
            margin-top: 4px;
        }

        /* Label keterangan angka statistik berwarna abu */
        .stat-label {
            font-size: 0.68rem;
            color: #94a3b8;
            margin-top: 4px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Kartu wrapper untuk tabel data */
        .card-table {
            background: white;
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 24px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.03);
        }

        /* Baris judul dan tombol aksi di atas tabel */
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

        /* Judul tabel dengan ukuran sedang dan bold */
        .card-header h5 {
            font-size: 1rem;
            font-weight: 700;
            color: #0f172a;
        }

        /* Tombol aksi utama dengan warna biru gelap */
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

        /* Shadow lebih dalam dan sedikit naik saat hover tombol primary */
        .btn-primary:hover {
            background: linear-gradient(135deg, #172554, #0f172a);
            box-shadow: 0 4px 14px rgba(30, 58, 138, 0.35);
            transform: translateY(-1px);
            color: white;
        }

        /* Tombol kembali ke halaman sebelumnya */
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

        /* Warna teks dan border biru saat hover tombol kembali */
        .btn-back:hover {
            color: #003366;
            border-color: #003366;
            background: rgba(0, 51, 102, 0.04);
        }

        /* Tombol simpan data form berwarna hijau */
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

        /* Shadow diperdalam saat hover tombol simpan */
        .btn-submit:hover {
            background: linear-gradient(135deg, #16a34a, #15803d);
            box-shadow: 0 4px 12px rgba(34, 197, 94, 0.3);
        }

        /* Tombol batal form dengan lebar sama dengan tombol simpan */
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

        /* Warna merah saat hover tombol batal */
        .btn-cancel:hover {
            background: #fee2e2;
            color: #dc2626;
            border-color: #fecaca;
        }

        /* Wrapper form dengan max-width dan auto margin */
        .form-page {
            max-width: 800px;
            margin: 0 auto;
        }

        /* Kartu form dengan background putih dan shadow ringan */
        .form-card {
            background: white;
            border-radius: 20px;
            padding: 32px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04);
        }

        /* Judul form ukuran sedang dan bold */
        .form-card h2 {
            font-size: 1.25rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 6px;
        }

        /* Deskripsi singkat di bawah judul form berwarna abu */
        .form-card p {
            color: #94a3b8;
            font-size: 0.82rem;
            margin-bottom: 28px;
            padding-bottom: 20px;
            border-bottom: 1px solid #f1f5f9;
        }

        /* Grid dua kolom untuk input form sejajar */
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        /* Wrapper satu field form yang mencakup label dan input */
        .form-group {
            margin-bottom: 20px;
        }

        /* Label field form ukuran kecil dan semi-bold */
        .form-group label {
            display: block;
            font-size: 0.78rem;
            font-weight: 600;
            color: #334155;
            margin-bottom: 7px;
        }

        /* Tanda bintang merah untuk field wajib isi */
        .form-group .required {
            color: #ef4444;
        }

        /* Input, select, dan textarea dengan padding nyaman dan border abu */
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

        /* Border biru dan shadow tipis saat input difokus */
        .form-control:focus {
            outline: none;
            border-color: #003366;
            box-shadow: 0 0 0 3px rgba(0, 51, 102, 0.08);
            background: #ffffff;
        }

        /* Textarea bisa di-resize vertikal dengan tinggi minimum 100px */
        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }

        /* Teks helper kecil di bawah input berwarna abu */
        .form-group small {
            display: block;
            font-size: 0.68rem;
            color: #94a3b8;
            margin-top: 5px;
        }

        /* Wrapper checkbox dengan flex row agar kotak dan teks sejajar */
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

        /* Ukuran checkbox sedikit lebih besar dari default */
        .form-check input {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: #003366;
        }

        /* Teks di samping checkbox dengan cursor pointer */
        .form-check label {
            font-size: 0.84rem;
            color: #334155;
            cursor: pointer;
            font-weight: 500;
        }

        /* Baris tombol submit dan cancel di bawah form */
        .form-actions {
            display: flex;
            gap: 12px;
            margin-top: 24px;
            padding-top: 20px;
            border-top: 1px solid #f1f5f9;
        }

        /* Wrapper tabel dengan overflow horizontal untuk layar kecil */
        .table-responsive {
            overflow-x: auto;
            border-radius: 10px;
        }

        /* Tabel data utama lebar penuh */
        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 600px;
        }

        /* Header kolom tabel ukuran sangat kecil uppercase */
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

        /* Sudut kiri atas header tabel dengan border-radius */
        th:first-child {
            border-radius: 10px 0 0 0;
        }

        /* Sudut kanan atas header tabel dengan border-radius */
        th:last-child {
            border-radius: 0 10px 0 0;
        }

        /* Cell data tabel dengan padding nyaman dan border bawah tipis */
        td {
            padding: 13px 14px;
            font-size: 0.83rem;
            color: #334155;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }

        /* Background abu sangat terang saat hover baris tabel */
        tr:hover td {
            background: #fafafa;
        }

        /* Baris terakhir tabel tanpa border bawah */
        tr:last-child td {
            border-bottom: none;
        }

        /* Label status berbentuk pill dengan ukuran sangat kecil */
        .badge {
            padding: 4px 10px;
            border-radius: 30px;
            font-size: 0.68rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        /* Badge hijau untuk status aktif */
        .badge-success {
            background: #dcfce7;
            color: #15803d;
        }

        /* Badge merah untuk status tidak aktif */
        .badge-danger {
            background: #fee2e2;
            color: #b91c1c;
        }

        /* Badge angka dengan background abu terang */
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

        /* Wrapper flex untuk kelompok tombol aksi dalam satu baris */
        .btn-group {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
        }

        /* Wrapper tombol aksi edit dan hapus secara horizontal */
        .action-buttons {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Tombol edit berwarna biru muda */
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

        /* Biru lebih gelap saat hover tombol edit */
        .btn-edit:hover {
            background: #dbeafe;
            text-decoration: none;
            color: #003366;
        }

        /* Tombol hapus berwarna merah muda sebagai sinyal aksi destructive */
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

        /* Merah lebih gelap saat hover tombol hapus */
        .btn-delete:hover, .btn-danger:hover {
            background: #ffe4e6;
            color: #be123c;
        }

        /* Tombol warning alias btn-edit */
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

        /* Biru lebih gelap saat hover tombol warning */
        .btn-warning:hover {
            background: #dbeafe;
            text-decoration: none;
            color: #003366;
        }

        /* Header banner biru gradient di setiap halaman index admin */
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

        /* Dekorasi lingkaran besar di pojok kanan banner */
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

        /* Dekorasi lingkaran kecil di pojok kiri bawah banner */
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

        /* Wrapper ikon dan teks di sisi kiri banner */
        .page-banner-left {
            display: flex;
            align-items: center;
            gap: 20px;
            position: relative;
            z-index: 1;
            min-width: 0;
        }

        /* Kotak ikon di sisi kiri banner */
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

        /* Ikon font awesome di dalam kotak banner */
        .page-banner-icon i {
            color: #ffffff;
            font-size: 1.3rem;
        }

        /* Teks judul utama banner */
        .page-banner-text h1 {
            font-size: 1.35rem;
            font-weight: 700;
            color: #ffffff;
            margin: 0 0 5px;
            letter-spacing: -0.2px;
        }

        /* Teks deskripsi di bawah judul banner */
        .page-banner-text p {
            font-size: 0.8rem;
            color: rgba(255,255,255,0.7);
            margin: 0;
        }

        /* Tombol tambah di dalam banner berwarna putih transparan */
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

        /* Background sedikit lebih terang saat hover tombol tambah */
        .btn-tambah:hover {
            background: rgba(255,255,255,0.25);
            transform: translateY(-1px);
            color: #ffffff;
            text-decoration: none;
        }

        /* Alert sukses setelah aksi berhasil */
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

        /* Ikon centang di dalam alert sukses */
        .alert-sukses i {
            font-size: 0.95rem;
            color: #22c55e;
            flex-shrink: 0;
        }

        /* Wrapper tabel agar bisa scroll horizontal di layar kecil */
        .table-wrapper {
            overflow-x: auto;
        }

        /* Badge nomor urut di kolom pertama tabel */
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

        /* Badge lokasi geosite berwarna biru muda */
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

        /* Wrapper pagination di bawah tabel */
        .pagination-wrapper {
            margin-top: 20px;
            display: flex;
            justify-content: flex-end;
        }

        /* Thumbnail gambar di dalam tabel */
        .img-preview {
            width: 44px;
            height: 44px;
            object-fit: cover;
            border-radius: 10px;
            border: 2px solid #f1f5f9;
        }

        /* Placeholder gambar saat tidak ada foto */
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

        /* Notifikasi berhasil dengan background hijau terang dan border kiri tebal */
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

        /* Area kosong saat tidak ada data dengan teks centered */
        .empty-state {
            text-align: center;
            padding: 48px 20px;
            color: #94a3b8;
        }

        /* Ikon dalam empty state dengan ukuran besar */
        .empty-state i {
            font-size: 2.5rem;
            margin-bottom: 12px;
            display: block;
            color: #cbd5e1;
        }

        /* Teks keterangan kosong di bawah ikon */
        .empty-state p {
            font-size: 0.85rem;
            font-weight: 500;
        }

        /* Wrapper tombol pagination di kanan bawah tabel */
        .pagination {
            margin-top: 20px;
            display: flex;
            justify-content: flex-end;
            flex-wrap: wrap;
            gap: 6px;
        }

        /* RESPONSIVE 1200px - Grid statistik dari 6 menjadi 3 kolom */
        @media (max-width: 1200px) {
            .stats-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        /* RESPONSIVE 768px - Sidebar disembunyikan dan top-bar menggunakan satu baris konsisten */
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

            /* Top bar fixed dari kiri 0 di mobile karena sidebar disembunyikan, padding dikurangi */
            .top-bar {
                padding: 0 14px;
                height: 56px;
                flex-wrap: nowrap;
                gap: 10px;
                left: 0;
            }

            /* Sisi kiri top bar dengan min-width nol agar bisa menyusut */
            .top-bar-left {
                gap: 10px;
                flex: 1;
                min-width: 0;
            }

            /* Judul halaman diperkecil agar muat di satu baris */
            .page-title {
                font-size: 0.9rem;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            /* Sisi kanan top bar tidak boleh menyusut */
            .top-bar-right {
                flex-shrink: 0;
            }

            /* User menu dikompakkan dengan padding lebih kecil */
            .user-menu {
                padding: 4px 4px 4px 10px;
                gap: 6px;
            }

            /* Nama user disembunyikan di mobile untuk menghemat ruang */
            .user-name span.user-name-text {
                display: none;
            }

            .user-name {
                font-size: 0;
                gap: 0;
            }

            /* Ikon user tetap tampil meskipun teks nama disembunyikan */
            .user-name i {
                font-size: 1.1rem;
            }

            /* Tombol keluar hanya tampilkan ikon tanpa teks di mobile */
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

            /* Banner menyusun konten secara vertikal di mobile */
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

            /* Tombol tambah melebar penuh di mobile */
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

        /* RESPONSIVE 576px - Penyesuaian lebih lanjut untuk HP kecil */
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

        /* RESPONSIVE 480px - Tombol aksi disusun vertikal agar tidak overflow */
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

<!-- SIDEBAR - Panel navigasi tetap di sisi kiri berisi brand dan seluruh link menu admin -->
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

<!-- MAIN CONTENT - Area konten utama di sebelah kanan sidebar -->
<div class="main-content" id="mainContent">

    <!-- TOP BAR - Bar atas sticky dalam satu baris konsisten di semua ukuran layar -->
    <div class="top-bar">
        <!-- Sisi kiri berisi tombol hamburger dan judul halaman -->
        <div class="top-bar-left">
            <button class="menu-toggle" id="menuToggle">
                <i class="fas fa-bars"></i>
            </button>
            <div class="page-title">@yield('title', 'Dashboard')</div>
        </div>

        <!-- Sisi kanan berisi info user dan tombol keluar -->
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

    <!-- CONTENT WRAPPER - Padding wrapper untuk seluruh konten dari child view -->
    <div class="content-wrapper">
        @yield('content')
    </div>
</div>

<!-- Overlay gelap yang muncul di belakang sidebar saat terbuka di mobile -->
<div id="sidebarOverlay" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.35); z-index:999;"></div>

<script>
    /*
       [FUNGSI JAVASCRIPT: TOGGLE MENU SIDEBAR]
       Fungsi ini bertugas mengontrol buka-tutup panel navigasi kiri (sidebar) pada layar HP/Mobile.
       Logikanya: Memanipulasi penambahan/penghapusan class 'open' pada elemen HTML sidebar.
    */
    const menuToggle = document.getElementById('menuToggle');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');

    /* Fungsi membuka sidebar dan menampilkan overlay gelap di belakangnya */
    function openSidebar() {
        sidebar.classList.add('open');
        overlay.style.display = 'block';
        document.body.style.overflow = 'hidden';
    }

    /* Fungsi menutup sidebar dan menyembunyikan overlay */
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

    /* Menutup sidebar saat overlay di belakangnya diklik */
    overlay.addEventListener('click', function() {
        closeSidebar();
    });

    /* Menutup sidebar saat ukuran window berubah ke desktop */
    window.addEventListener('resize', function() {
        if (window.innerWidth > 768) {
            closeSidebar();
        }
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
    /* Popup utama SweetAlert disesuaikan dengan desain admin GeoToba */
    .swal-popup-geotoba {
        border-radius: 16px !important;
        padding: 32px 28px 24px !important;
        border: 1px solid #e2e8f0 !important;
        font-family: 'Inter', sans-serif !important;
    }

    /* Wrapper tombol aksi agar sejajar penuh dan rapi */
    .swal-actions-geotoba {
        gap: 10px !important;
        width: 100% !important;
        padding: 0 !important;
        margin-top: 8px !important;
    }

    /* Tombol konfirmasi hapus berwarna biru gelap sesuai brand GeoToba */
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

    /* Efek hover tombol hapus sedikit lebih gelap dan naik */
    .swal-btn-hapus:hover {
        background: linear-gradient(135deg, #172554, #0f172a) !important;
        transform: translateY(-1px) !important;
    }

    /* Tombol batal berwarna merah muda sebagai sinyal pembatalan */
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

    /* Efek hover tombol batal sedikit lebih gelap */
    .swal-btn-batal:hover {
        background: #fecaca !important;
    }

    /* Tombol OK pada notifikasi sukses menggunakan warna biru gelap */
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

    /* Efek hover tombol OK sedikit lebih gelap */
    .swal-btn-ok:hover {
        background: linear-gradient(135deg, #172554, #0f172a) !important;
        transform: translateY(-1px) !important;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        /*
           [FUNGSI JAVASCRIPT: SWEETALERT KONFIRMASI HAPUS]
           Fungsi ini bertugas mencegat (intercept) semua tombol hapus data (btn-delete) di halaman admin.
           Alih-alih langsung menghapus, ia akan menampilkan popup peringatan (SweetAlert) terlebih dahulu.
           Jika user menekan 'Ya, Hapus', ia akan menampilkan popup sukses kedua, lalu men-submit form aslinya.
        */
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

                        /* Jika pengguna menekan tombol Ya Hapus, tampilkan notifikasi sukses dulu */
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

                                /* Setelah pengguna menutup notifikasi sukses, baru form di-submit ke server */
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
</html>