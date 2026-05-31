<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Admin - GeoToba</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>

        /* Reset global - Menghapus margin, padding, dan box-sizing default browser agar semua elemen mulai dari nol dan konsisten di semua browser */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body - Font Inter sebagai font utama, background abu sangat terang agar konten putih di atasnya terasa timbul dan tidak flat */
        body {
            font-family: 'Inter', sans-serif;
            background: #f1f5f9;
            color: #0f172a;
        }

        /* SIDEBAR - Panel navigasi fixed di sisi kiri, lebar tetap 260px, background putih dengan border kanan tipis sebagai pemisah dari konten utama */
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

        /* SIDEBAR CLOSED - State tersembunyi sidebar saat di-toggle, digeser sepenuhnya ke kiri layar dengan translateX negatif */
        .sidebar.closed {
            transform: translateX(-100%);
        }

        /* SIDEBAR HEADER - Area brand GeoToba di bagian paling atas sidebar, menggunakan gradient biru gelap ke biru sedang agar terasa premium dan berbeda dari menu di bawahnya */
        .sidebar-header {
            padding: 28px 24px 24px;
            background: linear-gradient(135deg, #003366 0%, #1a4a7a 100%);
            position: relative;
            overflow: hidden;
        }

        /* SIDEBAR HEADER DEKORATIF - Lingkaran besar putih transparan sebagai elemen dekoratif di pojok kanan atas header untuk memberikan kedalaman visual */
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

        /* SIDEBAR HEADER DEKORATIF 2 - Lingkaran kedua lebih kecil di posisi berbeda untuk memperkaya elemen dekoratif tanpa mengganggu teks */
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

        /* SIDEBAR HEADER ICON - Ikon bangunan sebagai avatar brand di atas teks GeoToba, warna gold agar konsisten dengan identitas brand */
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

        /* SIDEBAR HEADER ICON I - Ikon font awesome di dalam kotak brand, warna gold */
        .sidebar-header-icon i {
            color: #c6a43b;
            font-size: 1.1rem;
        }

        /* SIDEBAR HEADER H3 - Teks brand GeoToba berwarna putih, posisi relative agar tidak tertimpa pseudo-element dekoratif */
        .sidebar-header h3 {
            font-size: 1.25rem;
            font-weight: 800;
            color: #ffffff;
            position: relative;
            z-index: 1;
            letter-spacing: -0.3px;
        }

        /* SIDEBAR HEADER H3 SPAN - Bagian kata Toba berwarna gold sesuai identitas brand */
        .sidebar-header h3 span {
            color: #c6a43b;
        }

        /* SIDEBAR HEADER P - Teks kecil Administrator di bawah brand, putih transparan agar terasa sebagai keterangan sekunder */
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

        /* SIDEBAR HEADER P DOT - Titik hijau kecil di samping teks Administrator sebagai indikator status aktif/online */
        .sidebar-header p::before {
            content: '';
            width: 6px;
            height: 6px;
            background: #22c55e;
            border-radius: 50%;
            display: inline-block;
            flex-shrink: 0;
        }

        /* SIDEBAR MENU - Wrapper seluruh item navigasi sidebar dengan padding atas-bawah */
        .sidebar-menu {
            padding: 12px 0 24px;
            flex: 1;
        }

        /* SIDEBAR MENU TITLE - Label grup menu seperti "Menu" dan "Konten", ukuran sangat kecil dan uppercase agar jelas berfungsi sebagai judul kategori bukan link navigasi */
        .sidebar-menu .menu-title {
            padding: 16px 20px 6px;
            font-size: 0.62rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: #94a3b8;
        }

        /* SIDEBAR MENU A - Setiap item navigasi, menggunakan flex row agar ikon dan teks sejajar, padding nyaman untuk area klik, border-radius rounded agar terasa modern */
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

        /* SIDEBAR MENU A HOVER - Background abu terang dan teks lebih gelap saat hover, memberikan feedback visual yang jelas */
        .sidebar-menu a:hover {
            background: #f8fafc;
            color: #0f172a;
        }

        /* SIDEBAR MENU A ACTIVE - State halaman aktif menggunakan background biru sangat terang dengan teks biru gelap dan border kiri biru sebagai penanda visual yang kuat */
        .sidebar-menu a.active {
            background: linear-gradient(90deg, rgba(0, 51, 102, 0.08), rgba(0, 51, 102, 0.04));
            color: #003366;
            font-weight: 600;
            border-left: 3px solid #003366;
            padding-left: 13px;
        }

        /* SIDEBAR MENU A ICON - Lebar tetap 18px untuk semua ikon agar teks di sebelahnya selalu sejajar rapi meskipun ikon berbeda ukuran */
        .sidebar-menu a i {
            width: 18px;
            font-size: 0.9rem;
            text-align: center;
            flex-shrink: 0;
        }

        /* SIDEBAR MENU A ACTIVE ICON - Ikon pada item aktif berwarna biru gelap agar selaras dengan warna teks aktif */
        .sidebar-menu a.active i {
            color: #003366;
        }

        /* MAIN CONTENT - Area konten utama di sebelah kanan sidebar, margin kiri sebesar lebar sidebar agar tidak tertimpa */
        .main-content {
            margin-left: 260px;
            padding: 0;
            min-height: 100vh;
            transition: margin-left 0.3s ease;
        }

        /* MAIN CONTENT EXPANDED - State saat sidebar ditutup di mobile, margin kiri direset ke nol agar konten mengisi penuh */
        .main-content.expanded {
            margin-left: 0;
        }

        /* TOP BAR - Bar navigasi atas yang menampilkan judul halaman dan info user, menggunakan background putih dengan shadow bawah agar terasa sebagai elemen terpisah dari konten */
        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 32px;
            height: 68px;
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            box-shadow: 0 1px 8px rgba(0, 0, 0, 0.04);
            flex-wrap: wrap;
            gap: 12px;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        /* MENU TOGGLE - Tombol hamburger untuk membuka sidebar di mode mobile, tersembunyi di desktop */
        .menu-toggle {
            display: none;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 8px 12px;
            border-radius: 10px;
            cursor: pointer;
            font-size: 0.95rem;
            color: #475569;
            transition: all 0.2s;
        }

        /* MENU TOGGLE HOVER - Background sedikit lebih gelap saat hover agar ada feedback visual pada tombol hamburger */
        .menu-toggle:hover {
            background: #f1f5f9;
            color: #0f172a;
        }

        /* PAGE TITLE - Judul halaman yang ditampilkan di top bar, ukuran sedang dan font weight tebal agar jelas terbaca */
        .page-title {
            font-size: 1.15rem;
            font-weight: 700;
            color: #0f172a;
            letter-spacing: -0.2px;
        }

        /* USER MENU - Kontainer info user dan tombol logout di sisi kanan top bar, berbentuk pill dengan border tipis */
        .user-menu {
            display: flex;
            align-items: center;
            gap: 12px;
            background: #f8fafc;
            padding: 6px 6px 6px 14px;
            border-radius: 40px;
            border: 1px solid #e2e8f0;
        }

        /* USER NAME - Nama user yang sedang login, ukuran kecil dengan ikon user di depannya */
        .user-name {
            font-size: 0.82rem;
            font-weight: 500;
            color: #334155;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* USER NAME ICON - Ikon user circle di depan nama, warna biru gelap agar berkesan profesional */
        .user-name i {
            color: #003366;
            font-size: 1rem;
        }

        /* LOGOUT BTN - Tombol keluar berbentuk pill, ukuran compact, menggunakan warna merah saat hover sebagai peringatan visual tindakan destructive */
        .logout-btn {
            background: #ffffff;
            color: #64748b;
            padding: 7px 14px;
            border-radius: 30px;
            font-size: 0.75rem;
            font-weight: 500;
            border: 1px solid #e2e8f0;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        /* LOGOUT BTN HOVER - Warna merah saat hover sebagai sinyal visual bahwa ini adalah aksi keluar yang perlu perhatian */
        .logout-btn:hover {
            background: #fee2e2;
            color: #dc2626;
            border-color: #fecaca;
        }

        /* CONTENT WRAPPER - Padding untuk area konten di dalam main-content, terpisah dari top-bar agar layout lebih terstruktur */
        .content-wrapper {
            padding: 28px 32px;
        }

        /* STATS GRID - Grid enam kolom untuk kartu statistik di dashboard, gap seragam antar kartu */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 16px;
            margin-bottom: 28px;
        }

        /* STAT CARD - Kartu statistik individual, background putih dengan border tipis dan border-radius rounded, transisi shadow saat hover */
        .stat-card {
            background: white;
            padding: 18px 16px;
            border-radius: 14px;
            border: 1px solid #e2e8f0;
            transition: all 0.2s ease;
            position: relative;
            overflow: hidden;
        }

        /* STAT CARD BEFORE - Garis berwarna di bagian atas setiap kartu statistik sebagai aksen visual yang membedakan kartu statistik dari kartu biasa */
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

        /* STAT CARD HOVER - Shadow lebih dalam dan border lebih gelap saat hover untuk memberikan efek depth */
        .stat-card:hover {
            border-color: #cbd5e1;
            box-shadow: 0 6px 20px rgba(0, 51, 102, 0.08);
            transform: translateY(-2px);
        }

        /* STAT NUMBER - Angka statistik utama, ukuran besar dan bold agar langsung terbaca sebagai data penting */
        .stat-number {
            font-size: 1.6rem;
            font-weight: 800;
            color: #003366;
            letter-spacing: -0.5px;
            margin-top: 4px;
        }

        /* STAT LABEL - Keterangan angka statistik, ukuran kecil dan warna abu agar berperan sebagai label sekunder */
        .stat-label {
            font-size: 0.68rem;
            color: #94a3b8;
            margin-top: 4px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* CARD TABLE - Kartu wrapper untuk tabel data, background putih dengan border tipis dan padding nyaman */
        .card-table {
            background: white;
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 24px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.03);
        }

        /* CARD HEADER - Baris judul dan tombol aksi di atas tabel, flex row dengan space-between agar judul di kiri dan tombol di kanan */
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

        /* CARD HEADER H5 - Judul tabel, ukuran sedang dan bold agar jelas terbaca sebagai heading section */
        .card-header h5 {
            font-size: 1rem;
            font-weight: 700;
            color: #0f172a;
        }

        /* BTN PRIMARY - Tombol aksi utama seperti tambah data, menggunakan warna biru gelap sebagai sinyal aksi positif */
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

        /* BTN PRIMARY HOVER - Shadow lebih dalam dan sedikit naik saat hover untuk memberikan efek tombol yang ditekan */
        .btn-primary:hover {
            background: linear-gradient(135deg, #172554, #0f172a);
            box-shadow: 0 4px 14px rgba(30, 58, 138, 0.35);
            transform: translateY(-1px);
            color: white;
        }

        /* BTN BACK - Tombol kembali ke halaman sebelumnya, tampil sebagai link biasa bukan tombol untuk tidak terlalu mencolok */
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

        /* BTN BACK HOVER - Warna teks dan border berubah ke biru saat hover untuk memberikan feedback navigasi */
        .btn-back:hover {
            color: #003366;
            border-color: #003366;
            background: rgba(0, 51, 102, 0.04);
        }

        /* BTN SUBMIT - Tombol simpan data form, lebar tetap 115px agar konsisten dengan tombol batal di sebelahnya */
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

        /* BTN SUBMIT HOVER - Shadow diperdalam saat hover sebagai feedback tombol simpan */
        .btn-submit:hover {
            background: linear-gradient(135deg, #16a34a, #15803d);
            box-shadow: 0 4px 12px rgba(34, 197, 94, 0.3);
        }

        /* BTN CANCEL - Tombol batal form, lebar sama dengan tombol simpan untuk keseragaman visual */
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

        /* BTN CANCEL HOVER - Warna merah saat hover sebagai sinyal bahwa tindakan ini membatalkan perubahan */
        .btn-cancel:hover {
            background: #fee2e2;
            color: #dc2626;
            border-color: #fecaca;
        }

        /* FORM PAGE - Wrapper form dengan max-width 800px dan auto margin agar form tidak terlalu lebar dan tercentar di layar besar */
        .form-page {
            max-width: 800px;
            margin: 0 auto;
        }

        /* FORM CARD - Kartu form dengan background putih, border-radius besar, dan shadow ringan agar form terasa sebagai area terfokus */
        .form-card {
            background: white;
            border-radius: 20px;
            padding: 32px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04);
        }

        /* FORM CARD H2 - Judul form, ukuran sedang dan bold sebagai heading utama halaman form */
        .form-card h2 {
            font-size: 1.25rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 6px;
        }

        /* FORM CARD P - Deskripsi singkat di bawah judul form, warna abu agar berperan sebagai teks sekunder */
        .form-card p {
            color: #94a3b8;
            font-size: 0.82rem;
            margin-bottom: 28px;
            padding-bottom: 20px;
            border-bottom: 1px solid #f1f5f9;
        }

        /* FORM ROW - Grid dua kolom untuk form input yang sejajar secara horizontal di layar lebar */
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        /* FORM GROUP - Wrapper satu field form yang mencakup label dan input-nya */
        .form-group {
            margin-bottom: 20px;
        }

        /* FORM GROUP LABEL - Label field form, ukuran kecil dan semi-bold agar jelas terbaca sebagai keterangan input */
        .form-group label {
            display: block;
            font-size: 0.78rem;
            font-weight: 600;
            color: #334155;
            margin-bottom: 7px;
        }

        /* FORM GROUP REQUIRED - Tanda bintang merah untuk field wajib isi */
        .form-group .required {
            color: #ef4444;
        }

        /* FORM CONTROL - Elemen input, select, dan textarea, padding nyaman dengan border abu dan border-radius rounded */
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

        /* FORM CONTROL FOCUS - Border berubah ke biru gelap dengan shadow tipis saat input difokus agar user tahu field mana yang sedang diisi */
        .form-control:focus {
            outline: none;
            border-color: #003366;
            box-shadow: 0 0 0 3px rgba(0, 51, 102, 0.08);
            background: #ffffff;
        }

        /* TEXTAREA FORM CONTROL - Textarea bisa di-resize vertikal oleh user, tinggi minimum 100px agar tidak terlalu sempit */
        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }

        /* FORM GROUP SMALL - Teks helper kecil di bawah input sebagai panduan pengisian, warna abu sangat terang */
        .form-group small {
            display: block;
            font-size: 0.68rem;
            color: #94a3b8;
            margin-top: 5px;
        }

        /* FORM CHECK - Wrapper checkbox dengan teks label, flex row agar kotak dan teks sejajar */
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

        /* FORM CHECK INPUT - Ukuran checkbox sedikit lebih besar dari default agar mudah diklik */
        .form-check input {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: #003366;
        }

        /* FORM CHECK LABEL - Teks di samping checkbox, cursor pointer agar user bisa klik teks untuk toggle checkbox */
        .form-check label {
            font-size: 0.84rem;
            color: #334155;
            cursor: pointer;
            font-weight: 500;
        }

        /* FORM ACTIONS - Baris tombol submit dan cancel di bagian bawah form, dipisahkan dari form dengan border atas */
        .form-actions {
            display: flex;
            gap: 12px;
            margin-top: 24px;
            padding-top: 20px;
            border-top: 1px solid #f1f5f9;
        }

        /* TABLE RESPONSIVE - Wrapper tabel dengan overflow horizontal agar tabel tidak merusak layout di layar kecil */
        .table-responsive {
            overflow-x: auto;
            border-radius: 10px;
        }

        /* TABLE - Tabel data utama, lebar penuh, border-collapse untuk menghilangkan gap antar cell */
        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 600px;
        }

        /* TH - Header kolom tabel, teks sangat kecil uppercase dengan background abu sangat terang untuk membedakan dari baris data */
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

        /* TH FIRST CHILD - Sudut kiri atas header tabel diberi border-radius agar selaras dengan border-radius container */
        th:first-child {
            border-radius: 10px 0 0 0;
        }

        /* TH LAST CHILD - Sudut kanan atas header tabel diberi border-radius */
        th:last-child {
            border-radius: 0 10px 0 0;
        }

        /* TD - Cell data tabel dengan padding nyaman dan border bawah sangat tipis sebagai pemisah baris */
        td {
            padding: 13px 14px;
            font-size: 0.83rem;
            color: #334155;
            border-bottom: 1px solid #f1f5f9;
            vertical-align: middle;
        }

        /* TR HOVER - Baris tabel memiliki background abu sangat terang saat hover untuk memudahkan user mengikuti baris yang sedang dibaca */
        tr:hover td {
            background: #fafafa;
        }

        /* TR LAST CHILD TD - Baris terakhir tabel tidak memiliki border bawah agar tidak double dengan border container */
        tr:last-child td {
            border-bottom: none;
        }

        /* BADGE - Label status berbentuk pill, ukuran sangat kecil dengan padding horizontal untuk teks */
        .badge {
            padding: 4px 10px;
            border-radius: 30px;
            font-size: 0.68rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        /* BADGE SUCCESS - Badge hijau untuk status aktif atau berhasil */
        .badge-success {
            background: #dcfce7;
            color: #15803d;
        }

        /* BADGE DANGER - Badge merah untuk status tidak aktif atau error */
        .badge-danger {
            background: #fee2e2;
            color: #b91c1c;
        }

        /* BADGE NUMBER - Badge angka untuk menampilkan jumlah item, background abu terang dengan teks gelap */
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

        /* BTN GROUP - Wrapper flex untuk kelompok tombol aksi dalam satu baris */
        .btn-group {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
        }

        /* ACTION BUTTONS - Wrapper tombol aksi yang disusun vertikal untuk layout kolom yang sempit */
        .action-buttons {
            display: flex;
            flex-direction: column;
            gap: 6px;
            width: fit-content;
        }

        /* BTN EDIT / BTN WARNING - Tombol edit berwarna kuning, lebar tetap 82px agar seragam dengan tombol delete */
        .btn-edit, .btn-warning {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: white;
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 0.73rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            width: 82px;
            border: none;
            cursor: pointer;
            box-shadow: 0 1px 4px rgba(245, 158, 11, 0.2);
        }

        /* BTN EDIT HOVER / BTN WARNING HOVER - Shadow diperdalam dan warna lebih gelap saat hover */
        .btn-edit:hover, .btn-warning:hover {
            background: linear-gradient(135deg, #d97706, #b45309);
            color: white;
            box-shadow: 0 3px 8px rgba(217, 119, 6, 0.3);
        }

        /* BTN DELETE / BTN DANGER - Tombol hapus berwarna merah sebagai sinyal aksi destructive, lebar sama dengan tombol edit */
        .btn-delete, .btn-danger {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 0.73rem;
            font-weight: 600;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            width: 82px;
            text-decoration: none;
            box-shadow: 0 1px 4px rgba(239, 68, 68, 0.2);
        }

        /* BTN DELETE HOVER / BTN DANGER HOVER - Shadow diperdalam saat hover untuk feedback visual tombol hapus */
        .btn-delete:hover, .btn-danger:hover {
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            color: white;
            box-shadow: 0 3px 8px rgba(220, 38, 38, 0.3);
        }

        /* IMG PREVIEW - Thumbnail gambar di dalam tabel, ukuran kotak kecil dengan object-fit cover agar gambar tidak gepeng */
        .img-preview {
            width: 44px;
            height: 44px;
            object-fit: cover;
            border-radius: 10px;
            border: 2px solid #f1f5f9;
        }

        /* IMG PLACEHOLDER - Placeholder gambar saat tidak ada foto, background abu terang dengan teks sangat kecil */
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

        /* ALERT SUCCESS - Notifikasi berhasil dengan background hijau terang dan teks hijau gelap, border kiri tebal sebagai aksen */
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

        /* EMPTY STATE - Area kosong saat tidak ada data, teks centered berwarna abu */
        .empty-state {
            text-align: center;
            padding: 48px 20px;
            color: #94a3b8;
        }

        /* EMPTY STATE I - Ikon di dalam empty state, ukuran besar dan warna abu terang */
        .empty-state i {
            font-size: 2.5rem;
            margin-bottom: 12px;
            display: block;
            color: #cbd5e1;
        }

        /* EMPTY STATE P - Teks keterangan kosong di bawah ikon */
        .empty-state p {
            font-size: 0.85rem;
            font-weight: 500;
        }

        /* PAGINATION - Wrapper tombol pagination, diposisikan di kanan bawah tabel */
        .pagination {
            margin-top: 20px;
            display: flex;
            justify-content: flex-end;
            flex-wrap: wrap;
            gap: 6px;
        }

        /* RESPONSIVE 1200px - Pada layar tablet landscape, grid statistik berubah dari 6 kolom menjadi 3 kolom agar tidak terlalu sempit */
        @media (max-width: 1200px) {
            .stats-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        /* RESPONSIVE 768px - Pada layar mobile, sidebar disembunyikan dan top-bar menggunakan padding lebih kecil */
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
            }

            .top-bar {
                padding: 0 16px;
                height: auto;
                padding-top: 12px;
                padding-bottom: 12px;
            }

            .content-wrapper {
                padding: 20px 16px;
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
                font-size: 1.05rem;
            }

            .top-bar {
                flex-direction: row;
                flex-wrap: wrap;
            }

            .user-menu {
                padding: 4px 4px 4px 12px;
            }

            .user-name {
                font-size: 0.75rem;
            }
        }

        /* RESPONSIVE 576px - Pada HP kecil, grid statistik menjadi satu kolom dan beberapa elemen disederhanakan */
        @media (max-width: 576px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .top-bar {
                flex-direction: column;
                align-items: stretch;
                gap: 10px;
            }

            .user-menu {
                justify-content: space-between;
            }

            th, td {
                font-size: 0.7rem;
                padding: 8px 8px;
            }

            .btn-edit, .btn-delete {
                padding: 4px 8px;
                font-size: 0.62rem;
                width: 72px;
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

        /* RESPONSIVE 480px - HP sangat kecil, tombol aksi disusun vertikal agar tidak overflow dari kolom tabel */
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

<!-- SIDEBAR - Panel navigasi tetap di sisi kiri, berisi brand dan seluruh link menu admin -->
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

    <!-- TOP BAR - Bar atas sticky yang menampilkan tombol hamburger, judul halaman, dan info user -->
    <div class="top-bar">
        <div style="display: flex; align-items: center; gap: 14px;">
            <button class="menu-toggle" id="menuToggle">
                <i class="fas fa-bars"></i>
            </button>
            <div class="page-title">@yield('title', 'Dashboard')</div>
        </div>
        <div class="user-menu">
            <span class="user-name">
                <i class="fas fa-user-circle"></i>
                {{ Auth::user()->name ?? 'Admin' }}
            </span>
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i> Keluar
                </button>
            </form>
        </div>
    </div>

    <!-- CONTENT WRAPPER - Padding wrapper untuk seluruh konten yield dari child view -->
    <div class="content-wrapper">
        @yield('content')
    </div>
</div>

<script>
    // Toggle sidebar - Menambahkan atau menghapus class 'open' pada sidebar saat tombol hamburger diklik di mode mobile
    const menuToggle = document.getElementById('menuToggle');
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');

    if (menuToggle) {
        menuToggle.addEventListener('click', function() {
            sidebar.classList.toggle('open');
        });
    }

    // Tutup sidebar saat klik di luar - Mendeteksi klik di luar area sidebar dan menutupnya secara otomatis khusus di mode mobile
    document.addEventListener('click', function(event) {
        const isMobile = window.innerWidth <= 768;
        if (isMobile && sidebar && !sidebar.contains(event.target) && !menuToggle.contains(event.target)) {
            sidebar.classList.remove('open');
        }
    });

    // Handle resize window - Menutup sidebar saat ukuran window berubah ke desktop agar tidak ada state sidebar terbuka yang tersisa
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