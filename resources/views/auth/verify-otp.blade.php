{{--
   ======================================================================================
   [PENJELASAN LENGKAP FILE: a:/PA111/real/New folder/Proyek akhir 1 Real/resources/views/auth/verify-otp.blade.php]

   1. BAGAIMANA CODE INI BEKERJA:
      Ini adalah file Blade Template (HTML yang dicampur kode PHP ala Laravel). Kode ini merender tampilan visual (UI) dengan menggunakan tata letak dasar dari layouts/app.blade.php.

   2. UNTUK APA CODE INI:
      File komponen view pendukung untuk bagian a:.

   3. HUBUNGAN DENGAN CODE LAIN (RELASI):
      - Mewarisi Desain (Layout): layouts/app.blade.php

   4. KEMANA ARAHNYA JIKA CODE INI MEMANGGIL:
      Dipanggil oleh controller terkait atau di-include oleh file blade lainnya.
   ======================================================================================
--}}

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP - GeoToba</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>

        /* Reset global - Menghapus margin dan padding default browser agar semua elemen dimulai dari nol */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* HTML dan BODY dikunci bersamaan agar tidak ada satu pun lapisan yang bisa melampaui tinggi layar. overflow:hidden di html mencegah scroll di level dokumen paling atas */
        html {
            height: 100vh;
            height: 100dvh;
            overflow: hidden;
        }

        /* Body - Background gradient biru gelap konsisten dengan halaman login dan lupa password. height:100dvh mengunci tinggi tepat satu layar, overflow:hidden memastikan tidak ada scroll pada latar belakang */
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #001f40 0%, #003366 50%, #0a4a7a 100%);
            margin: 0;
            padding: 0;
            height: 100vh;
            height: 100dvh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        /* BG CIRCLE 1 - Lingkaran dekoratif putih transparan di pojok kanan atas, konsisten di semua halaman auth */
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

        /* BG CIRCLE 2 - Lingkaran dekoratif gold transparan di pojok kiri bawah sebagai elemen pasangan */
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

        /* LOGIN CONTAINER - Wrapper pembatas lebar card. height:100dvh mengunci tingginya setara layar, overflow:hidden memastikan card tidak bisa keluar batas */
        .login-container {
            width: 100%;
            max-width: 460px;
            height: 100vh;
            height: 100dvh;
            padding: 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            z-index: 1;
            overflow: hidden;
        }

        /* LOGIN CARD - Kartu utama dengan background putih, border-radius besar, dan shadow dalam */
        .login-card {
            background: #ffffff;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 32px 64px rgba(0, 0, 0, 0.3), 0 0 0 1px rgba(255, 255, 255, 0.1);
            width: 100%;
            display: flex;
            flex-direction: column;
        }

        /* LOGIN HEADER - Bagian atas card dengan gradient biru gelap, konsisten di semua halaman auth. Padding diperbesar karena ikon dihapus agar header tidak terlihat terlalu sempit */
        .login-header {
            background: linear-gradient(135deg, #003366 0%, #1a4a7a 100%);
            padding: 48px 32px 40px;
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

        /* LOGIN HEADER H1 - Judul halaman berwarna putih dengan font weight tebal */
        .login-header h1 {
            font-size: 1.35rem;
            font-weight: 800;
            color: #ffffff;
            letter-spacing: -0.3px;
            position: relative;
            z-index: 1;
        }

        /* LOGIN HEADER H1 SPAN - Kata "OTP" berwarna gold sesuai identitas brand */
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

        /* LOGIN BODY - Area konten form. flex:1 mengisi sisa ruang di antara header dan footer agar kartu memanfaatkan seluruh tinggi layar. overflow-y:auto memungkinkan hanya konten di dalam kartu yang bisa di-scroll jika layar terlalu pendek, sementara latar belakang tetap diam */
        .login-body {
            padding: 32px;
            overflow-y: auto;
            flex: 1;
        }

        /* STEP INDICATOR WRAPPER - Flex container untuk tiga langkah proses reset password */
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

        /* STEP ITEM - Wrapper satu langkah berisi lingkaran nomor dan label teks */
        .step-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 6px;
            flex: 1;
        }

        /* STEP CIRCLE - Lingkaran nomor langkah dengan ukuran dan font weight tetap */
        .step-circle {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.78rem;
            font-weight: 700;
        }

        /* STEP CIRCLE DONE - Langkah yang sudah selesai menggunakan background hijau dengan ikon centang */
        .step-circle.done {
            background: linear-gradient(135deg, #22c55e, #16a34a);
            color: #ffffff;
            box-shadow: 0 3px 8px rgba(34, 197, 94, 0.3);
        }

        /* STEP CIRCLE ACTIVE - Langkah yang sedang aktif menggunakan background biru gelap */
        .step-circle.active {
            background: linear-gradient(135deg, #003366, #1a4a7a);
            color: #ffffff;
            box-shadow: 0 3px 10px rgba(0, 51, 102, 0.3);
        }

        /* STEP CIRCLE INACTIVE - Langkah yang belum dicapai menggunakan background abu terang */
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

        /* STEP LABEL DONE - Label langkah selesai berwarna hijau */
        .step-label.done { color: #16a34a; }

        /* STEP LABEL ACTIVE - Label langkah aktif berwarna biru gelap agar lebih menonjol */
        .step-label.active { color: #003366; }

        /* STEP LABEL INACTIVE - Label langkah belum aktif berwarna abu */
        .step-label.inactive { color: #94a3b8; }

        /* STEP CONNECTOR - Garis penghubung antar langkah yang mengisi ruang fleksibel antar step-item */
        .step-connector {
            flex: 0.8;
            height: 2px;
            border-radius: 2px;
            margin-bottom: 22px;
        }

        /* STEP CONNECTOR DONE - Garis penghubung yang sudah dilalui berubah ke warna hijau */
        .step-connector.done {
            background: linear-gradient(90deg, #22c55e, #16a34a);
        }

        /* STEP CONNECTOR INACTIVE - Garis penghubung yang belum dilalui berwarna abu terang */
        .step-connector.inactive {
            background: #e2e8f0;
        }

        /* INFO BOX EMAIL - Kotak informasi email tujuan OTP dengan background biru sangat terang dan border kiri biru */
        .info-box {
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

        /* INFO BOX I - Ikon amplop di dalam kotak info berwarna biru gelap */
        .info-box i {
            color: #003366;
            font-size: 0.9rem;
            margin-top: 1px;
            flex-shrink: 0;
        }

        /* INFO BOX P - Teks informasi email dan masa berlaku OTP, ukuran kecil berwarna biru */
        .info-box p {
            font-size: 0.8rem;
            color: #1e40af;
            line-height: 1.6;
            margin: 0;
        }

        /* INFO BOX P STRONG - Teks tebal untuk email dan durasi berlaku agar menonjol */
        .info-box p strong {
            color: #003366;
        }

        /* ALERT SUCCESS - Notifikasi berhasil dengan background hijau terang dan border kiri hijau */
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

        /* ALERT DANGER - Notifikasi error dengan background merah terang dan border kiri merah */
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

        /* OTP LABEL - Label judul di atas kotak input OTP, teks kecil semi-bold */
        .otp-label {
            font-size: 0.78rem;
            font-weight: 600;
            color: #334155;
            text-align: center;
            margin-bottom: 16px;
        }

        /* OTP INPUTS - Flex container enam kotak input OTP, diposisikan di tengah dengan gap seragam */
        .otp-inputs {
            display: flex;
            gap: 10px;
            justify-content: center;
            margin-bottom: 28px;
        }

        /* OTP DIGIT - Satu kotak input angka OTP, berbentuk kotak dengan teks angka besar di tengah */
        .otp-digit {
            width: 52px;
            height: 60px;
            text-align: center;
            font-size: 1.5rem;
            font-weight: 800;
            border: 2px solid #e2e8f0;
            border-radius: 14px;
            color: #003366;
            background: #f8fafc;
            transition: all 0.2s ease;
            outline: none;
            font-family: 'Inter', sans-serif;
        }

        /* OTP DIGIT FOCUS - Border berubah ke biru gelap dengan glow saat kotak difokus */
        .otp-digit:focus {
            border-color: #003366;
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(0, 51, 102, 0.1);
            transform: scale(1.05);
        }

        /* OTP DIGIT FILLED - Border berubah ke gold dan background biru sangat terang saat kotak sudah terisi angka */
        .otp-digit.filled {
            border-color: #c6a43b;
            background: #fefce8;
            color: #003366;
        }

        /* TIMER WRAPPER - Area countdown dan link kirim ulang OTP, diposisikan di tengah */
        .timer-wrapper {
            text-align: center;
            margin-bottom: 24px;
            padding: 14px;
            background: #f8fafc;
            border-radius: 12px;
            border: 1px solid #f1f5f9;
        }

        /* TIMER TEXT - Teks keterangan countdown, ukuran kecil berwarna abu */
        .timer-text {
            font-size: 0.78rem;
            color: #64748b;
            font-weight: 500;
        }

        /* TIMER COUNTDOWN - Angka countdown yang berubah setiap detik, berwarna merah sebagai sinyal urgensi */
        .timer-countdown {
            font-size: 1.1rem;
            font-weight: 800;
            color: #dc2626;
            display: block;
            margin: 6px 0 4px;
            letter-spacing: 1px;
        }

        /* TIMER COUNTDOWN EXPIRED - State kadaluarsa menggunakan warna abu dan font size lebih kecil */
        .timer-countdown.expired {
            color: #94a3b8;
            font-size: 0.85rem;
        }

        /* RESEND LINK - Link kirim ulang OTP yang tersembunyi sampai timer habis */
        .resend-link {
            color: #003366;
            font-size: 0.78rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: none;
            align-items: center;
            gap: 6px;
            justify-content: center;
            padding: 6px 14px;
            border-radius: 30px;
            border: 1px solid #003366;
            transition: all 0.2s;
            background: transparent;
            font-family: 'Inter', sans-serif;
            margin-top: 6px;
        }

        /* RESEND LINK HOVER - Background biru saat hover dengan teks putih */
        .resend-link:hover {
            background: #003366;
            color: white;
        }

        /* BTN LOGIN - Tombol verifikasi lebar penuh dengan gradient biru gelap, konsisten di semua halaman auth */
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

        /* BTN LOGIN DISABLED - State disabled saat timer habis, opacity dikurangi dan cursor berubah ke not-allowed */
        .btn-login:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        /* BACK LINK WRAPPER - Wrapper teks link kembali ke login, diposisikan di tengah bawah form */
        .back-link {
            text-align: center;
            margin-top: 20px;
        }

        /* BACK LINK A - Link kembali berbentuk pill dengan border tipis, konsisten dengan halaman lupa password */
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

        /* RESPONSIVE 480px - Pada HP kecil, padding dikurangi dan kotak OTP sedikit diperkecil */
        @media (max-width: 480px) {
            .login-container { padding: 16px; }
            .login-header { padding: 28px 24px 24px; }
            .login-body { padding: 24px; }
            .login-footer { padding: 14px 24px; }
            .otp-digit {
                width: 42px;
                height: 52px;
                font-size: 1.3rem;
                border-radius: 10px;
            }
            .otp-inputs { gap: 7px; }
        }

        /* RESPONSIVE 360px - Pada HP sangat kecil, kotak OTP diperkecil lagi agar tidak overflow */
        @media (max-width: 360px) {
            .otp-digit {
                width: 36px;
                height: 46px;
                font-size: 1.1rem;
            }
            .otp-inputs { gap: 5px; }
        }

        /* RESPONSIVE HEIGHT - Jika layar monitor kurang tinggi, kecilkan padding/margin agar card muat tanpa scroll */
        @media (max-height: 850px) {
            .login-header { padding: 20px 24px 16px; }
            .login-header h1 { font-size: 1.2rem; }
            .login-body { padding: 20px 24px; }
            .step-indicator { margin-bottom: 16px; padding: 12px; }
            .step-connector { margin-bottom: 16px; }
            .info-box { margin-bottom: 16px; padding: 10px 12px; }
            .info-box p { font-size: 0.75rem; }
            .otp-label { margin-bottom: 12px; }
            .otp-inputs { margin-bottom: 16px; }
            .otp-digit { height: 50px; font-size: 1.2rem; }
            .timer-wrapper { margin-bottom: 16px; padding: 10px; }
            .timer-countdown { margin: 2px 0; font-size: 1rem; }
            .back-link { margin-top: 12px; }
            .login-footer { padding: 10px 24px; }
        }
        
        @media (max-height: 650px) {
            .login-header::before { display: none; }
            .step-indicator { display: none; } /* Hilangkan step indicator jika layar benar-benar sangat pendek */
        }
    </style>
</head>
<body>

    <!-- LOGIN CONTAINER - Wrapper utama yang membatasi lebar dan memusatkan card di tengah layar -->
    <div class="login-container">
        <div class="login-card">

            <div class="login-header">
                <h1>Verifikasi <span>OTP</span></h1>
                <p>Masukkan kode 6 digit yang dikirim ke email Anda</p>
            </div>

            <!-- LOGIN BODY - Area konten form berisi step indicator, info box, input OTP, timer, dan tombol -->
            <div class="login-body">

                <!-- STEP INDICATOR - Visualisasi tiga langkah dengan langkah pertama sudah selesai dan langkah kedua aktif -->
                <div class="step-indicator">
                    <div class="step-item">
                        <div class="step-circle done">
                            <i class="fas fa-check" style="font-size: 0.7rem;"></i>
                        </div>
                        <div class="step-label done">Email</div>
                    </div>
                    <div class="step-connector done"></div>
                    <div class="step-item">
                        <div class="step-circle active">2</div>
                        <div class="step-label active">Kode OTP</div>
                    </div>
                    <div class="step-connector inactive"></div>
                    <div class="step-item">
                        <div class="step-circle inactive">3</div>
                        <div class="step-label inactive">Password Baru</div>
                    </div>
                </div>

                <!-- ALERT SUCCESS - Ditampilkan saat ada pesan sukses dari Laravel -->
                @if(session('success'))
                    <div class="alert-success">
                        <i class="fas fa-circle-check"></i>
                        {{ session('success') }}
                    </div>
                @endif

                <!-- ALERT DANGER - Ditampilkan saat OTP salah atau kadaluarsa -->
                @if($errors->any())
                    <div class="alert-danger">
                        <i class="fas fa-circle-exclamation"></i>
                        {{ $errors->first() }}
                    </div>
                @endif

                <!-- INFO BOX - Menampilkan email tujuan OTP dan informasi masa berlaku kode -->
                <div class="info-box">
                    <i class="fas fa-envelope"></i>
                    <p>
                        Kode OTP dikirim ke <strong>{{ session('otp_email') }}</strong>.<br>
                        Berlaku selama <strong>10 menit</strong> sejak dikirim.
                    </p>
                </div>

                <!-- FORM VERIFIKASI OTP - Form POST ke route verify-otp Laravel dengan CSRF token -->
                <form method="POST" action="{{ route('password.verify-otp') }}" id="otpForm">
                    @csrf

                    <!-- LABEL INPUT OTP - Teks petunjuk di atas kotak input OTP -->
                    <div class="otp-label">Masukkan 6 digit kode OTP</div>

                    <!-- OTP INPUTS - Enam kotak input terpisah untuk setiap digit kode OTP -->
                    <div class="otp-inputs">
                        <input type="text" class="otp-digit" maxlength="1" pattern="[0-9]" inputmode="numeric" id="d1" autofocus>
                        <input type="text" class="otp-digit" maxlength="1" pattern="[0-9]" inputmode="numeric" id="d2">
                        <input type="text" class="otp-digit" maxlength="1" pattern="[0-9]" inputmode="numeric" id="d3">
                        <input type="text" class="otp-digit" maxlength="1" pattern="[0-9]" inputmode="numeric" id="d4">
                        <input type="text" class="otp-digit" maxlength="1" pattern="[0-9]" inputmode="numeric" id="d5">
                        <input type="text" class="otp-digit" maxlength="1" pattern="[0-9]" inputmode="numeric" id="d6">
                    </div>

                    <!-- HIDDEN INPUT OTP - Input tersembunyi yang menyimpan gabungan enam digit OTP untuk dikirim ke server -->
                    <input type="hidden" name="otp" id="otpHidden">

                    <!-- TIMER WRAPPER - Area countdown dan tombol kirim ulang OTP -->
                    <div class="timer-wrapper">
                        <div class="timer-text">Kode kadaluarsa dalam</div>
                        <span class="timer-countdown" id="countdown">10:00</span>
                        <button type="button" class="resend-link" id="resendLink"
                            onclick="window.location='{{ route('password.request') }}'">
                            <i class="fas fa-rotate-right"></i> Kirim Ulang OTP
                        </button>
                    </div>

                    <!-- TOMBOL VERIFIKASI - Submit form OTP, disabled secara otomatis saat timer habis -->
                    <button type="submit" class="btn-login" id="submitBtn">
                        <i class="fas fa-circle-check"></i>
                        Verifikasi & Lanjutkan
                    </button>
                </form>

                <!-- BACK LINK - Link kembali ke halaman login -->
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

<script>
    // OTP INPUT BEHAVIOUR - Mengelola navigasi antar kotak input OTP saat user mengetik, menghapus, atau paste kode
    const digits = document.querySelectorAll('.otp-digit');
    const hidden = document.getElementById('otpHidden');

    digits.forEach((input, i) => {

        // Input event - Memfilter karakter non-angka, menambahkan class filled, dan memindahkan fokus ke kotak berikutnya setelah diisi
        input.addEventListener('input', () => {
            input.value = input.value.replace(/\D/, '');
            if (input.value) {
                input.classList.add('filled');
                if (i < digits.length - 1) digits[i + 1].focus();
            } else {
                input.classList.remove('filled');
            }
            updateHidden();
        });

        // Keydown event - Menangani tombol Backspace untuk kembali ke kotak sebelumnya saat kotak kosong
        input.addEventListener('keydown', (e) => {
            if (e.key === 'Backspace' && !input.value && i > 0) {
                digits[i - 1].focus();
                digits[i - 1].value = '';
                digits[i - 1].classList.remove('filled');
                updateHidden();
            }
        });

        // Paste event - Menangani paste seluruh kode OTP sekaligus, memisahkan karakter ke masing-masing kotak secara otomatis
        input.addEventListener('paste', (e) => {
            e.preventDefault();
            const pasted = e.clipboardData.getData('text').replace(/\D/g, '').slice(0, 6);
            pasted.split('').forEach((ch, j) => {
                if (digits[j]) {
                    digits[j].value = ch;
                    digits[j].classList.add('filled');
                }
            });
            if (digits[pasted.length - 1]) digits[Math.min(pasted.length, 5)].focus();
            updateHidden();
        });
    });

    // updateHidden - Menggabungkan nilai dari semua kotak digit menjadi satu string dan menyimpannya ke hidden input agar terkirim bersama form
    function updateHidden() {
        hidden.value = Array.from(digits).map(d => d.value).join('');
    }

    // COUNTDOWN TIMER - Menghitung mundur dari 10 menit, memperbarui tampilan setiap detik, dan menampilkan tombol kirim ulang serta menonaktifkan tombol verifikasi saat timer habis
    let totalSeconds = 600;
    const countdownEl = document.getElementById('countdown');
    const resendLink  = document.getElementById('resendLink');
    const submitBtn   = document.getElementById('submitBtn');

    const timer = setInterval(() => {
        totalSeconds--;
        const m = String(Math.floor(totalSeconds / 60)).padStart(2, '0');
        const s = String(totalSeconds % 60).padStart(2, '0');
        countdownEl.textContent = m + ':' + s;

        // State kadaluarsa - Menghentikan timer, mengubah tampilan countdown, menampilkan tombol kirim ulang, dan menonaktifkan tombol verifikasi
        if (totalSeconds <= 0) {
            clearInterval(timer);
            countdownEl.textContent = 'Kode telah kadaluarsa';
            countdownEl.classList.add('expired');
            resendLink.style.display = 'inline-flex';
            submitBtn.disabled = true;
        }

        // Peringatan sisa waktu - Mengubah warna countdown ke oranye saat tersisa kurang dari 60 detik sebagai peringatan visual
        if (totalSeconds <= 60 && totalSeconds > 0) {
            countdownEl.style.color = '#f97316';
        }
    }, 1000);
</script>

</body>
</html>