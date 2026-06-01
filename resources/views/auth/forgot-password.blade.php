<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - GeoToba</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>

        /* Reset global - Menghapus margin dan padding default browser agar semua elemen dimulai dari nol */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body - Background gradient biru gelap konsisten dengan halaman login, flex center untuk memusatkan card */
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #001f40 0%, #003366 50%, #0a4a7a 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        /* BG CIRCLE 1 - Lingkaran dekoratif putih transparan di pojok kanan atas, konsisten dengan halaman login */
        body::before {
            content: '';
            position: absolute;
            top: -120px;
            right: -120px;
            width: 400px;
            height: 400px;
            background: rgba(255, 255, 255, 0.04);
            border-radius: 50%;
        }

        /* BG CIRCLE 2 - Lingkaran dekoratif gold transparan di pojok kiri bawah sebagai elemen pasangan dekoratif */
        body::after {
            content: '';
            position: absolute;
            bottom: -80px;
            left: -80px;
            width: 280px;
            height: 280px;
            background: rgba(198, 164, 59, 0.06);
            border-radius: 50%;
        }

        /* LOGIN CONTAINER - Wrapper utama yang membatasi lebar card agar tidak terlalu lebar di layar besar */
        .login-container {
            width: 100%;
            max-width: 440px;
            padding: 20px;
            position: relative;
            z-index: 1;
        }

        /* LOGIN CARD - Kartu utama dengan background putih, border-radius besar, dan shadow dalam agar timbul di atas background gelap */
        .login-card {
            background: #ffffff;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 32px 64px rgba(0, 0, 0, 0.3), 0 0 0 1px rgba(255, 255, 255, 0.1);
            max-height: 90vh;
            display: flex;
            flex-direction: column;
        }

        /* LOGIN HEADER - Bagian atas card dengan gradient biru gelap, konsisten dengan header halaman login */
        .login-header {
            background: linear-gradient(135deg, #003366 0%, #1a4a7a 100%);
            padding: 36px 32px 32px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        /* LOGIN HEADER DEKORATIF - Lingkaran putih transparan sebagai elemen dekoratif di pojok header */
        .login-header::before {
            content: '';
            position: absolute;
            top: -40px;
            right: -40px;
            width: 120px;
            height: 120px;
            background: rgba(255, 255, 255, 0.06);
            border-radius: 50%;
        }

        /* LOGIN ICON - Kotak ikon di atas judul header, background gold transparan dengan border gold tipis */
        .login-icon {
            width: 64px;
            height: 64px;
            background: rgba(198, 164, 59, 0.2);
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 16px;
            position: relative;
            z-index: 1;
            border: 1px solid rgba(198, 164, 59, 0.3);
        }

        /* LOGIN ICON I - Ikon kunci berwarna gold sebagai simbol reset password */
        .login-icon i {
            font-size: 1.6rem;
            color: #c6a43b;
        }

        /* LOGIN HEADER H1 - Judul halaman berwarna putih dengan font weight tebal */
        .login-header h1 {
            font-size: 1.35rem;
            font-weight: 800;
            color: #ffffff;
            letter-spacing: -0.3px;
            position: relative;
            z-index: 1;
        }

        /* LOGIN HEADER H1 SPAN - Kata "GeoToba" berwarna gold sesuai identitas brand */
        .login-header h1 span {
            color: #c6a43b;
        }

        /* LOGIN HEADER P - Teks deskripsi singkat di bawah judul, putih transparan sebagai teks sekunder */
        .login-header p {
            font-size: 0.78rem;
            color: rgba(255, 255, 255, 0.6);
            margin-top: 6px;
            position: relative;
            z-index: 1;
        }

        /* LOGIN BODY - Area konten form dengan padding yang cukup agar form tidak terasa sempit */
        .login-body {
            padding: 32px;
            overflow-y: auto;
        }

        /* STEP INDICATOR WRAPPER - Flex container untuk tiga langkah proses reset password, diposisikan di tengah */
        .step-indicator {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0;
            margin-bottom: 28px;
            padding: 16px;
            background: #f8fafc;
            border-radius: 16px;
            border: 1px solid #f1f5f9;
        }

        /* STEP ITEM - Wrapper satu langkah yang berisi lingkaran nomor dan label teks di bawahnya */
        .step-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 6px;
            flex: 1;
        }

        /* STEP CIRCLE - Lingkaran nomor langkah, ukuran tetap dengan font weight tebal */
        .step-circle {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.78rem;
            font-weight: 700;
            transition: all 0.3s ease;
        }

        /* STEP CIRCLE ACTIVE - Langkah yang sedang aktif menggunakan background biru gelap dengan teks putih */
        .step-circle.active {
            background: linear-gradient(135deg, #003366, #1a4a7a);
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(0, 51, 102, 0.3);
        }

        /* STEP CIRCLE DONE - Langkah yang sudah selesai menggunakan background hijau dengan ikon centang */
        .step-circle.done {
            background: linear-gradient(135deg, #22c55e, #16a34a);
            color: #ffffff;
        }

        /* STEP CIRCLE INACTIVE - Langkah yang belum dicapai menggunakan background abu terang dengan teks abu */
        .step-circle.inactive {
            background: #e2e8f0;
            color: #94a3b8;
        }

        /* STEP LABEL - Teks nama langkah di bawah lingkaran, ukuran sangat kecil */
        .step-label {
            font-size: 0.65rem;
            font-weight: 600;
            text-align: center;
            white-space: nowrap;
        }

        /* STEP LABEL ACTIVE - Label langkah aktif berwarna biru gelap agar lebih menonjol */
        .step-label.active {
            color: #003366;
        }

        /* STEP LABEL INACTIVE - Label langkah belum aktif berwarna abu */
        .step-label.inactive {
            color: #94a3b8;
        }

        /* STEP CONNECTOR - Garis penghubung antar langkah, lebar fleksibel mengisi ruang antar step-item */
        .step-connector {
            flex: 0.8;
            height: 2px;
            background: #e2e8f0;
            margin-bottom: 22px;
            border-radius: 2px;
        }

        /* STEP CONNECTOR ACTIVE - Garis penghubung yang sudah dilalui berubah ke warna biru gelap */
        .step-connector.active {
            background: linear-gradient(90deg, #003366, #1a4a7a);
        }

        /* DESCRIPTION BOX - Kotak deskripsi instruksi di atas form, background abu sangat terang dengan border kiri biru sebagai aksen informasi */
        .description-box {
            background: #f0f6ff;
            border: 1px solid #dbeafe;
            border-left: 4px solid #003366;
            border-radius: 12px;
            padding: 14px 16px;
            margin-bottom: 24px;
            display: flex;
            gap: 12px;
            align-items: flex-start;
        }

        /* DESCRIPTION BOX I - Ikon info di dalam kotak deskripsi berwarna biru gelap */
        .description-box i {
            color: #003366;
            font-size: 0.9rem;
            margin-top: 1px;
            flex-shrink: 0;
        }

        /* DESCRIPTION BOX P - Teks deskripsi instruksi, ukuran kecil berwarna biru gelap */
        .description-box p {
            font-size: 0.8rem;
            color: #1e40af;
            line-height: 1.6;
            margin: 0;
        }

        /* DESCRIPTION BOX P STRONG - Teks tebal di dalam deskripsi untuk menekankan kata kunci penting */
        .description-box p strong {
            color: #003366;
        }

        /* ALERT SUCCESS - Notifikasi berhasil dengan background hijau sangat terang dan border kiri hijau */
        .alert-success {
            background: #f0fdf4;
            color: #15803d;
            padding: 12px 16px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 0.82rem;
            font-weight: 500;
            border: 1px solid #bbf7d0;
            border-left: 4px solid #22c55e;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* ALERT DANGER - Notifikasi error dengan background merah sangat terang dan border kiri merah */
        .alert-danger {
            background: #fff5f5;
            color: #b91c1c;
            padding: 12px 16px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 0.82rem;
            font-weight: 500;
            border: 1px solid #fecaca;
            border-left: 4px solid #ef4444;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* FORM GROUP - Wrapper satu field form yang mencakup label dan input */
        .form-group {
            margin-bottom: 20px;
        }

        /* FORM LABEL - Label field form, ukuran kecil dan semi-bold sebagai keterangan input */
        .form-label {
            display: block;
            font-size: 0.78rem;
            font-weight: 600;
            color: #334155;
            margin-bottom: 7px;
        }

        /* INPUT WRAPPER - Wrapper relatif untuk input agar ikon di dalam bisa diposisikan secara absolut */
        .input-wrapper {
            position: relative;
        }

        /* INPUT ICON - Ikon di dalam input yang diposisikan absolut di sisi kiri */
        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 0.9rem;
            pointer-events: none;
        }

        /* FORM CONTROL - Input field dengan padding kiri lebih besar untuk memberi ruang bagi ikon */
        .form-control {
            width: 100%;
            padding: 12px 14px 12px 42px;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            font-size: 0.88rem;
            font-family: 'Inter', sans-serif;
            color: #334155;
            background: #f8fafc;
            transition: all 0.2s ease;
        }

        /* FORM CONTROL FOCUS - Border berubah ke biru gelap dengan glow tipis saat input difokus */
        .form-control:focus {
            outline: none;
            border-color: #003366;
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(0, 51, 102, 0.08);
        }

        /* BTN LOGIN - Tombol submit lebar penuh dengan gradient biru gelap, konsisten dengan tombol login */
        .btn-login {
            width: 100%;
            padding: 13px;
            background: linear-gradient(135deg, #003366 0%, #1a4a7a 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 0.9rem;
            font-weight: 700;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: all 0.25s ease;
            margin-top: 8px;
            letter-spacing: 0.3px;
            box-shadow: 0 4px 16px rgba(0, 51, 102, 0.25);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        /* BTN LOGIN HOVER - Shadow diperdalam dan tombol naik sedikit saat hover */
        .btn-login:hover {
            background: linear-gradient(135deg, #002244 0%, #003366 100%);
            box-shadow: 0 8px 24px rgba(0, 51, 102, 0.35);
            transform: translateY(-2px);
        }

        /* BTN LOGIN ACTIVE - Tombol turun saat ditekan untuk efek klik natural */
        .btn-login:active {
            transform: translateY(0);
            box-shadow: 0 2px 8px rgba(0, 51, 102, 0.2);
        }

        /* BACK LINK WRAPPER - Wrapper teks link kembali ke login, diposisikan di tengah bawah form */
        .back-link {
            text-align: center;
            margin-top: 20px;
        }

        /* BACK LINK A - Link kembali ke halaman login, warna abu dengan ikon panah kiri */
        .back-link a {
            color: #64748b;
            font-size: 0.78rem;
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: 30px;
            border: 1px solid #e2e8f0;
            transition: all 0.2s ease;
            background: #f8fafc;
        }

        /* BACK LINK A HOVER - Border dan teks berubah ke biru saat hover sebagai feedback navigasi */
        .back-link a:hover {
            color: #003366;
            border-color: #003366;
            background: rgba(0, 51, 102, 0.04);
        }

        /* LOGIN FOOTER - Area bawah card dengan background abu sangat terang dan teks copyright */
        .login-footer {
            background: #f8fafc;
            border-top: 1px solid #f1f5f9;
            padding: 14px 32px;
            text-align: center;
        }

        /* LOGIN FOOTER P - Teks copyright sangat kecil berwarna abu terang */
        .login-footer p {
            font-size: 0.7rem;
            color: #94a3b8;
        }

        /* LOGIN FOOTER SPAN - Nama brand di footer berwarna gold agar konsisten dengan identitas brand */
        .login-footer span {
            color: #c6a43b;
            font-weight: 600;
        }

        /* RESPONSIVE 480px - Pada HP kecil, padding dikurangi agar form tidak terasa sempit */
        @media (max-width: 480px) {
            .login-container { padding: 16px; }
            .login-header { padding: 28px 24px 24px; }
            .login-body { padding: 24px; }
            .login-footer { padding: 14px 24px; }
        }
    </style>
</head>
<body>

    <!-- LOGIN CONTAINER - Wrapper utama yang membatasi lebar dan memusatkan card di tengah layar -->
    <div class="login-container">
        <div class="login-card">

            <!-- LOGIN HEADER - Bagian atas card dengan gradient biru, ikon kunci, judul, dan deskripsi singkat -->
            <div class="login-header">
                <div class="login-icon">
                    <i class="fas fa-key"></i>
                </div>
                <h1>Lupa <span>Password</span></h1>
                <p>Verifikasi identitas Anda melalui OTP email</p>
            </div>

            <!-- LOGIN BODY - Area form berisi step indicator, alert, deskripsi, dan input email -->
            <div class="login-body">

                <!-- STEP INDICATOR - Visualisasi tiga langkah proses reset password dengan garis penghubung antar langkah -->
                <div class="step-indicator">
                    <div class="step-item">
                        <div class="step-circle active">1</div>
                        <div class="step-label active">Email</div>
                    </div>
                    <div class="step-connector"></div>
                    <div class="step-item">
                        <div class="step-circle inactive">2</div>
                        <div class="step-label inactive">Kode OTP</div>
                    </div>
                    <div class="step-connector"></div>
                    <div class="step-item">
                        <div class="step-circle inactive">3</div>
                        <div class="step-label inactive">Password Baru</div>
                    </div>
                </div>

                <!-- ALERT SUCCESS - Ditampilkan saat OTP berhasil dikirim atau ada pesan sukses dari Laravel -->
                @if(session('success'))
                    <div class="alert-success">
                        <i class="fas fa-circle-check"></i>
                        {{ session('success') }}
                    </div>
                @endif

                <!-- ALERT DANGER - Ditampilkan saat ada error validasi dari server maupun dari validasi JavaScript di sisi browser -->
                <div class="alert-danger" id="clientErrorBox" style="display:none;">
                    <i class="fas fa-circle-exclamation"></i>
                    <span id="clientErrorMsg"></span>
                </div>
                @if($errors->any())
                    <div class="alert-danger">
                        <i class="fas fa-circle-exclamation"></i>
                        {{ $errors->first() }}
                    </div>
                @endif

                <!-- DESCRIPTION BOX - Kotak informasi instruksi pengisian email dengan border kiri biru sebagai aksen -->
                <div class="description-box">
                    <i class="fas fa-circle-info"></i>
                    <p>
                        Masukkan email yang terdaftar pada akun Anda. Kami akan mengirimkan <strong>kode OTP 6 digit</strong> untuk verifikasi identitas Anda.
                    </p>
                </div>

                <!-- FORM KIRIM OTP - Form POST ke route send-otp Laravel dengan CSRF token -->
                <!-- novalidate menonaktifkan validasi HTML bawaan browser agar validasi ditangani sepenuhnya oleh JavaScript -->
                <form method="POST" action="{{ route('password.send-otp') }}" id="forgotForm" novalidate>
                    @csrf

                    <!-- FIELD EMAIL - Input email dengan ikon amplop di dalam input sebagai petunjuk visual tipe field -->
                    <div class="form-group">
                        <label class="form-label">Alamat Email</label>
                        <div class="input-wrapper">
                            <i class="fas fa-envelope input-icon"></i>
                            <input
                                type="text"
                                name="email"
                                id="emailInput"
                                class="form-control"
                                placeholder="contoh@email.com"
                                value="{{ old('email') }}"
                                autofocus
                            >
                        </div>
                    </div>

                    <!-- TOMBOL KIRIM OTP - Submit form untuk mengirim kode OTP ke email yang dimasukkan -->
                    <button type="submit" class="btn-login">
                        <i class="fas fa-paper-plane"></i>
                        Kirim Kode OTP
                    </button>
                </form>

                <script>
                    // Fungsi untuk menampilkan pesan error di kotak merah yang sudah ada di halaman
                    function tampilkanError(pesan) {
                        const box = document.getElementById('clientErrorBox');
                        const msg = document.getElementById('clientErrorMsg');
                        msg.innerText = pesan;
                        box.style.display = 'flex';
                        // Scroll ke atas agar kotak merah terlihat oleh pengguna
                        box.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                    }

                    // Fungsi untuk menyembunyikan kotak error saat pengguna mulai mengetik
                    function sembunyikanError() {
                        document.getElementById('clientErrorBox').style.display = 'none';
                    }

                    // Saat pengguna mengetik di input email, sembunyikan pesan error
                    document.getElementById('emailInput').addEventListener('input', sembunyikanError);

                    // Mencegat submit form dan melakukan validasi manual sebelum form dikirim ke server
                    document.getElementById('forgotForm').addEventListener('submit', function(e) {
                        const emailVal = document.getElementById('emailInput').value.trim();
                        // Pola regex standar untuk memvalidasi format email yang mengandung @ dan domain
                        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                        if (emailVal === '') {
                            e.preventDefault();
                            tampilkanError('Alamat email tidak boleh kosong.');
                            return;
                        }

                        if (!emailRegex.test(emailVal)) {
                            e.preventDefault();
                            tampilkanError('Format email tidak valid. Pastikan email Anda mengandung tanda @ dan domain. Contoh: nama@gmail.com');
                            return;
                        }
                    });
                </script>

                <!-- BACK LINK - Link untuk kembali ke halaman login jika user ingat password -->
                <div class="back-link">
                    <a href="{{ route('login') }}">
                        <i class="fas fa-arrow-left"></i>
                        Kembali ke Login
                    </a>
                </div>

            </div>

            <!-- LOGIN FOOTER - Area bawah card dengan teks copyright -->
            <div class="login-footer">
                <p>&copy; 2026 <span>GeoToba</span> — Geopark Danau Toba. Hak cipta dilindungi.</p>
            </div>

        </div>
    </div>

</body>
</html>