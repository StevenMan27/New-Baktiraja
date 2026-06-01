<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - GeoToba</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>

        /* Reset global - Menghapus margin dan padding default browser, box-sizing border-box agar padding tidak menambah lebar elemen */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Body - Background gradient biru gelap ke biru sedang sebagai latar login, min-height 100vh agar mengisi seluruh layar, flex center untuk memusatkan card */
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

        /* BG CIRCLE 1 - Lingkaran dekoratif besar putih transparan di pojok kanan atas untuk memberikan kedalaman visual pada background */
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

        /* BG CIRCLE 2 - Lingkaran dekoratif kedua di pojok kiri bawah, lebih kecil, sebagai pasangan elemen dekoratif pertama */
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

        /* CONTAINER LOGIN - Wrapper utama yang membatasi lebar form login agar tidak terlalu lebar di layar besar */
        .login-container {
            width: 100%;
            max-width: 420px;
            padding: 20px;
            position: relative;
            z-index: 1;
        }

        /* LOGIN CARD - Kartu form login dengan background putih, border-radius besar, dan shadow dalam untuk kesan timbul di atas background gelap */
        .login-card {
            background: #ffffff;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 32px 64px rgba(0, 0, 0, 0.3), 0 0 0 1px rgba(255, 255, 255, 0.1);
            max-height: 90vh;
            display: flex;
            flex-direction: column;
        }

        /* LOGIN HEADER - Bagian atas kartu dengan background gradient biru gelap, menampilkan logo dan judul halaman login */
        .login-header {
            background: linear-gradient(135deg, #003366 0%, #1a4a7a 100%);
            padding: 36px 32px 32px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        /* LOGIN HEADER DEKORATIF - Lingkaran putih transparan di header sebagai aksen visual yang memperkaya tampilan header biru */
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

        /* LOGIN ICON - Kotak ikon gembok di bagian atas header, background gold transparan agar kontras dengan header biru */
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

        /* LOGIN ICON I - Ikon gembok berwarna gold sebagai simbol keamanan halaman login */
        .login-icon i {
            font-size: 1.6rem;
            color: #c6a43b;
        }

        /* LOGIN HEADER H1 - Judul halaman login berwarna putih, ukuran sedang dan bold agar terbaca jelas di atas background biru */
        .login-header h1 {
            font-size: 1.35rem;
            font-weight: 800;
            color: #ffffff;
            letter-spacing: -0.3px;
            position: relative;
            z-index: 1;
        }

        /* LOGIN HEADER H1 SPAN - Kata "GeoToba" berwarna gold agar sesuai dengan identitas brand */
        .login-header h1 span {
            color: #c6a43b;
        }

        /* LOGIN HEADER P - Subjudul kecil di bawah judul, putih transparan sebagai keterangan sekunder */
        .login-header p {
            font-size: 0.78rem;
            color: rgba(255, 255, 255, 0.6);
            margin-top: 6px;
            position: relative;
            z-index: 1;
        }

        /* LOGIN BODY - Area form login dengan padding yang cukup besar agar form tidak terasa sempit */
        .login-body {
            padding: 32px;
            overflow-y: auto;
        }

        /* ALERT SUCCESS - Notifikasi berhasil dengan background hijau sangat terang dan border kiri hijau sebagai aksen */
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

        /* ALERT DANGER - Notifikasi error dengan background merah sangat terang dan border kiri merah sebagai sinyal peringatan */
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

        /* FORM GROUP - Wrapper satu field form yang mencakup label, input, dan helper text */
        .form-group {
            margin-bottom: 20px;
        }

        /* FORM LABEL - Label field form, ukuran kecil dan semi-bold agar terbaca sebagai keterangan input */
        .form-label {
            display: block;
            font-size: 0.78rem;
            font-weight: 600;
            color: #334155;
            margin-bottom: 7px;
        }

        /* INPUT WRAPPER - Wrapper relatif untuk input agar ikon di dalam input bisa diposisikan secara absolut */
        .input-wrapper {
            position: relative;
        }

        /* INPUT ICON - Ikon di dalam input yang diposisikan absolut di sisi kiri, berwarna abu sebagai visual petunjuk tipe input */
        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 0.9rem;
            pointer-events: none;
        }

        /* FORM CONTROL - Input field dengan padding kiri lebih besar untuk memberi ruang bagi ikon di dalam input */
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

        /* FORM CONTROL FOCUS - Border berubah ke biru gelap dengan glow tipis saat input difokus agar user tahu field mana yang aktif */
        .form-control:focus {
            outline: none;
            border-color: #003366;
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(0, 51, 102, 0.08);
        }

        /* PASSWORD WRAPPER - Wrapper khusus field password dengan position relative agar tombol show/hide bisa diposisikan di dalam input */
        .password-wrapper {
            position: relative;
        }

        /* PASSWORD TOGGLE - Tombol mata untuk show/hide password, diposisikan absolut di sisi kanan input, tanpa background agar tidak mengganggu tampilan */
        .password-toggle {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #94a3b8;
            font-size: 0.9rem;
            padding: 4px;
            transition: color 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* PASSWORD TOGGLE HOVER - Warna ikon berubah ke biru gelap saat hover untuk memberikan feedback interaktif */
        .password-toggle:hover {
            color: #003366;
        }

        /* PASSWORD CONTROL - Input password dengan padding kanan lebih besar agar teks tidak tertimpa tombol toggle mata */
        .password-wrapper .form-control {
            padding-right: 44px;
        }

        /* FORGOT LINK - Link lupa password diposisikan di kanan dengan teks kecil berwarna gold */
        .forgot-link {
            text-align: right;
            margin-top: 8px;
        }

        /* FORGOT LINK A - Teks link lupa password berwarna gold, tanpa underline secara default */
        .forgot-link a {
            color: #c6a43b;
            text-decoration: none;
            font-size: 0.75rem;
            font-weight: 500;
            transition: all 0.2s;
        }

        /* FORGOT LINK A HOVER - Underline muncul saat hover sebagai feedback navigasi */
        .forgot-link a:hover {
            text-decoration: underline;
            color: #a8892e;
        }

        /* BTN LOGIN - Tombol login lebar penuh dengan gradient biru gelap, shadow tipis, dan transisi smooth */
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
            margin-top: 24px;
            letter-spacing: 0.3px;
            box-shadow: 0 4px 16px rgba(0, 51, 102, 0.25);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        /* BTN LOGIN HOVER - Shadow diperdalam, tombol naik sedikit, dan warna sedikit lebih terang sebagai feedback hover yang jelas */
        .btn-login:hover {
            background: linear-gradient(135deg, #002244 0%, #003366 100%);
            box-shadow: 0 8px 24px rgba(0, 51, 102, 0.35);
            transform: translateY(-2px);
        }

        /* BTN LOGIN ACTIVE - Tombol turun saat ditekan untuk memberikan efek klik yang natural */
        .btn-login:active {
            transform: translateY(0);
            box-shadow: 0 2px 8px rgba(0, 51, 102, 0.2);
        }

        /* LOGIN FOOTER - Area bawah card dengan background abu sangat terang, teks copyright kecil */
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
            font-weight: 400;
        }

        /* LOGIN FOOTER SPAN - Nama brand di footer berwarna gold agar tetap konsisten dengan identitas brand */
        .login-footer span {
            color: #c6a43b;
            font-weight: 600;
        }

        /* RESPONSIVE 480px - Pada HP kecil, padding dikurangi agar form tidak terlalu sempit */
        @media (max-width: 480px) {
            .login-container {
                padding: 16px;
            }
            .login-header {
                padding: 28px 24px 24px;
            }
            .login-body {
                padding: 24px;
            }
            .login-footer {
                padding: 14px 24px;
            }
        }
    </style>
</head>
<body>

    <!-- LOGIN CONTAINER - Wrapper utama yang membatasi lebar dan memusatkan card login di tengah layar -->
    <div class="login-container">
        <div class="login-card">

            <!-- LOGIN HEADER - Bagian atas kartu dengan gradient biru, ikon gembok, judul, dan subjudul -->
            <div class="login-header">
                <div class="login-icon">
                    <i class="fas fa-shield-halved"></i>
                </div>
                <h1>Admin <span>GeoToba</span></h1>
                <p>Masukkan kredensial Anda untuk melanjutkan</p>
            </div>

            <!-- LOGIN BODY - Area form yang berisi alert, input email, input password, dan tombol login -->
            <div class="login-body">

                <!-- ALERT SUCCESS - Ditampilkan saat ada session success dari Laravel, misal setelah logout -->
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

                <!-- FORM LOGIN - Form POST ke route login Laravel dengan CSRF token -->
                <!-- novalidate menonaktifkan validasi HTML bawaan browser agar validasi ditangani sepenuhnya oleh JavaScript -->
                <form method="POST" action="{{ route('login') }}" id="loginForm" novalidate>
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
                                placeholder="admin@geotoba.com"
                                value="{{ old('email') }}"
                                autofocus
                            >
                        </div>
                    </div>

                    <!-- FIELD PASSWORD - Input password dengan ikon gembok dan tombol mata di sisi kanan untuk show/hide password -->
                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <div class="input-wrapper password-wrapper">
                            <i class="fas fa-lock input-icon"></i>
                            <input
                                type="password"
                                name="password"
                                id="passwordInput"
                                class="form-control"
                                placeholder="Masukkan password"
                                required
                            >
                            <!-- TOMBOL TOGGLE PASSWORD - Tombol ikon mata yang mengubah type input antara password dan text saat diklik -->
                            <button type="button" class="password-toggle" id="passwordToggle" aria-label="Toggle password visibility">
                                <i class="fas fa-eye" id="toggleIcon"></i>
                            </button>
                        </div>

                        <!-- LUPA PASSWORD - Link ke halaman reset password, diposisikan di kanan bawah field password -->
                        <div class="forgot-link">
                            <a href="{{ route('password.request') }}">
                                <i class="fas fa-key" style="font-size: 0.65rem;"></i> Lupa Password?
                            </a>
                        </div>
                    </div>

                    <!-- TOMBOL LOGIN - Submit form login, lebar penuh dengan ikon masuk di sebelah teks -->
                    <button type="submit" class="btn-login">
                        <i class="fas fa-right-to-bracket"></i>
                        Masuk ke Dashboard
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
                    document.getElementById('loginForm').addEventListener('submit', function(e) {
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
            </div>

            <!-- LOGIN FOOTER - Area bawah kartu dengan teks copyright -->
            <div class="login-footer">
                <p>&copy; 2026 <span>GeoToba</span> — Geopark Danau Toba. Hak cipta dilindungi.</p>
            </div>

        </div>
    </div>

    <script>
        // Toggle password visibility - Mengubah type input password antara 'password' (tersembunyi) dan 'text' (terlihat) saat tombol mata diklik, serta mengganti ikon mata sesuai state saat ini
        const passwordInput = document.getElementById('passwordInput');
        const passwordToggle = document.getElementById('passwordToggle');
        const toggleIcon = document.getElementById('toggleIcon');

        passwordToggle.addEventListener('click', function () {
            const isPassword = passwordInput.type === 'password';

            // Ubah type input - Jika sebelumnya password maka ubah ke text agar karakter terlihat, jika text maka kembali ke password agar tersembunyi
            passwordInput.type = isPassword ? 'text' : 'password';

            // Ganti ikon - fa-eye-slash ditampilkan saat password terlihat sebagai sinyal bahwa klik berikutnya akan menyembunyikan, fa-eye ditampilkan saat password tersembunyi
            toggleIcon.className = isPassword ? 'fas fa-eye-slash' : 'fas fa-eye';
        });
    </script>

</body>
</html>