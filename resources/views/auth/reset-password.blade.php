<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Password Baru - GeoToba</title>
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

        /* Body - Background gradient biru gelap konsisten dengan seluruh halaman auth GeoToba. height:100dvh mengunci tinggi tepat satu layar, overflow:hidden memastikan tidak ada scroll pada latar belakang */
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

        /* LOGIN HEADER H1 SPAN - Kata "Baru" berwarna gold sesuai identitas brand */
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

        /* STEP CONNECTOR - Garis penghubung antar langkah yang mengisi ruang fleksibel */
        .step-connector {
            flex: 0.8;
            height: 2px;
            border-radius: 2px;
            margin-bottom: 22px;
        }

        /* STEP CONNECTOR DONE - Garis penghubung yang sudah dilalui berwarna hijau */
        .step-connector.done {
            background: linear-gradient(90deg, #22c55e, #16a34a);
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

        /* FORM GROUP - Wrapper satu field form yang mencakup label, input, dan elemen pendukung */
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

        /* INPUT ICON - Ikon di sisi kiri dalam input sebagai petunjuk visual tipe field */
        .input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 0.9rem;
            pointer-events: none;
        }

        /* FORM CONTROL - Input field dengan padding kiri dan kanan lebih besar untuk memberi ruang ikon */
        .form-control {
            width: 100%;
            padding: 12px 44px 12px 42px;
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

        /* TOGGLE PW - Tombol mata untuk show/hide password, diposisikan absolut di sisi kanan input */
        .toggle-pw {
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

        /* TOGGLE PW HOVER - Warna ikon berubah ke biru gelap saat hover untuk feedback interaktif */
        .toggle-pw:hover {
            color: #003366;
        }

        /* STRENGTH BAR WRAPPER - Container bar indikator kekuatan password, background abu terang sebagai rel */
        .strength-bar {
            height: 5px;
            border-radius: 3px;
            background: #e2e8f0;
            margin-top: 8px;
            overflow: hidden;
        }

        /* STRENGTH FILL - Bar yang berubah lebar dan warna sesuai kekuatan password yang dideteksi */
        .strength-fill {
            height: 100%;
            border-radius: 3px;
            transition: all 0.4s ease;
            width: 0;
        }

        /* STRENGTH TEXT - Teks keterangan level kekuatan password di bawah bar, berubah warna mengikuti level */
        .strength-text {
            font-size: 0.72rem;
            margin-top: 5px;
            font-weight: 600;
            min-height: 16px;
        }

        /* MATCH TEXT - Teks indikator kesesuaian dua password di bawah field konfirmasi */
        .match-text {
            font-size: 0.72rem;
            margin-top: 5px;
            font-weight: 600;
            min-height: 16px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        /* STRENGTH HINTS - Kotak petunjuk syarat password kuat, background abu sangat terang */
        .strength-hints {
            background: #f8fafc;
            border: 1px solid #f1f5f9;
            border-radius: 10px;
            padding: 12px 14px;
            margin-top: 10px;
        }

        /* STRENGTH HINTS P - Label judul syarat password */
        .strength-hints p {
            font-size: 0.7rem;
            font-weight: 600;
            color: #64748b;
            margin-bottom: 8px;
        }

        /* HINT ITEM - Satu baris syarat password, flex row agar ikon dan teks sejajar */
        .hint-item {
            display: flex;
            align-items: center;
            gap: 7px;
            font-size: 0.7rem;
            color: #94a3b8;
            margin-bottom: 4px;
            transition: color 0.2s ease;
        }

        /* HINT ITEM LAST CHILD - Baris syarat terakhir tanpa margin bawah */
        .hint-item:last-child { margin-bottom: 0; }

        /* HINT ITEM MET - State syarat yang sudah terpenuhi, teks berubah hijau */
        .hint-item.met {
            color: #16a34a;
        }

        /* HINT ITEM I - Ikon lingkaran di depan setiap syarat, ukuran kecil */
        .hint-item i {
            font-size: 0.65rem;
            width: 14px;
            text-align: center;
        }

        /* BTN LOGIN - Tombol simpan password lebar penuh dengan gradient biru gelap, konsisten di semua halaman auth */
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

        /* RESPONSIVE 480px - Pada HP kecil, padding kontainer dan header dikurangi agar kartu tidak berhimpit dengan tepi layar */
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

            <div class="login-header">
                <h1>Password <span>Baru</span></h1>
                <p>Langkah terakhir — buat password yang kuat</p>
            </div>

            <!-- LOGIN BODY - Area form berisi step indicator, alert, field password, dan tombol simpan -->
            <div class="login-body">

                <!-- STEP INDICATOR - Visualisasi tiga langkah dengan dua langkah pertama sudah selesai dan langkah ketiga aktif -->
                <div class="step-indicator">
                    <div class="step-item">
                        <div class="step-circle done">
                            <i class="fas fa-check" style="font-size: 0.7rem;"></i>
                        </div>
                        <div class="step-label done">Email</div>
                    </div>
                    <div class="step-connector done"></div>
                    <div class="step-item">
                        <div class="step-circle done">
                            <i class="fas fa-check" style="font-size: 0.7rem;"></i>
                        </div>
                        <div class="step-label done">Kode OTP</div>
                    </div>
                    <div class="step-connector done"></div>
                    <div class="step-item">
                        <div class="step-circle active">3</div>
                        <div class="step-label active">Password Baru</div>
                    </div>
                </div>

                <!-- ALERT DANGER - Ditampilkan saat ada error dari server maupun dari validasi JavaScript di sisi browser -->
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

                <!-- FORM RESET PASSWORD - novalidate menonaktifkan validasi bawaan browser, validasi sepenuhnya ditangani oleh JavaScript sebelum form dikirim ke server -->
                <form method="POST" action="{{ route('password.update') }}" id="resetForm" novalidate>
                    @csrf

                    <!-- FIELD PASSWORD BARU - Input password dengan ikon gembok, tombol toggle show/hide, bar kekuatan, dan petunjuk syarat -->
                    <div class="form-group">
                        <label class="form-label">Password Baru</label>
                        <div class="input-wrapper">
                            <i class="fas fa-lock input-icon"></i>
                            <input
                                type="password"
                                name="password"
                                id="pwNew"
                                class="form-control"
                                placeholder="Minimal 6 karakter"
                                required
                                autofocus
                            >
                            <!-- TOGGLE PASSWORD BARU - Tombol mata untuk menampilkan atau menyembunyikan karakter password baru -->
                            <button type="button" class="toggle-pw" id="toggleNew" aria-label="Toggle password">
                                <i class="fas fa-eye" id="iconNew"></i>
                            </button>
                        </div>

                        <!-- STRENGTH BAR - Bar visual yang menunjukkan kekuatan password secara real-time berdasarkan panjang dan kompleksitas -->
                        <div class="strength-bar">
                            <div class="strength-fill" id="strengthFill"></div>
                        </div>
                        <div class="strength-text" id="strengthText"></div>

                        <!-- STRENGTH HINTS - Daftar syarat password yang wajib dipenuhi, berubah hijau saat syarat terpenuhi -->
                        <div class="strength-hints">
                            <p><i class="fas fa-list-check"></i> Syarat password kuat:</p>
                            <div class="hint-item" id="hint-length">
                                <i class="fas fa-circle"></i> Minimal 6 karakter
                            </div>
                            <div class="hint-item" id="hint-upper">
                                <i class="fas fa-circle"></i> Mengandung huruf kapital (A-Z)
                            </div>
                            <div class="hint-item" id="hint-number">
                                <i class="fas fa-circle"></i> Mengandung angka (0-9)
                            </div>
                        </div>
                    </div>

                    <!-- FIELD KONFIRMASI PASSWORD - Input ulang password untuk memastikan keduanya sama -->
                    <div class="form-group">
                        <label class="form-label">Konfirmasi Password</label>
                        <div class="input-wrapper">
                            <i class="fas fa-lock input-icon"></i>
                            <input
                                type="password"
                                name="password_confirmation"
                                id="pwConfirm"
                                class="form-control"
                                placeholder="Ulangi password baru"
                                required
                            >
                            <!-- TOGGLE KONFIRMASI PASSWORD - Tombol mata untuk menampilkan atau menyembunyikan karakter konfirmasi password -->
                            <button type="button" class="toggle-pw" id="toggleConfirm" aria-label="Toggle password">
                                <i class="fas fa-eye" id="iconConfirm"></i>
                            </button>
                        </div>
                        <div class="match-text" id="matchText"></div>
                    </div>

                    <!-- TOMBOL SIMPAN - Submit form untuk menyimpan password baru ke database -->
                    <button type="submit" class="btn-login">
                        <i class="fas fa-floppy-disk"></i>
                        Simpan Password Baru
                    </button>

                </form>
            </div>

            <!-- LOGIN FOOTER - Area bawah card dengan teks copyright -->
            <div class="login-footer">
                <p>&copy; 2026 <span>GeoToba</span> — Geopark Danau Toba. Hak cipta dilindungi.</p>
            </div>

        </div>
    </div>

<script>
    // Toggle password baru - Mengubah type input password baru antara 'password' dan 'text' saat tombol mata diklik, serta mengganti ikon sesuai state
    document.getElementById('toggleNew').addEventListener('click', function () {
        const input = document.getElementById('pwNew');
        const icon  = document.getElementById('iconNew');
        const isHidden = input.type === 'password';
        input.type = isHidden ? 'text' : 'password';
        icon.className = isHidden ? 'fas fa-eye-slash' : 'fas fa-eye';
    });

    // Toggle konfirmasi password - Mengubah type input konfirmasi password antara 'password' dan 'text' saat tombol mata diklik
    document.getElementById('toggleConfirm').addEventListener('click', function () {
        const input = document.getElementById('pwConfirm');
        const icon  = document.getElementById('iconConfirm');
        const isHidden = input.type === 'password';
        input.type = isHidden ? 'text' : 'password';
        icon.className = isHidden ? 'fas fa-eye-slash' : 'fas fa-eye';
    });

    // Password strength meter - Mengevaluasi kekuatan password secara real-time berdasarkan panjang, huruf kapital, dan angka
    document.getElementById('pwNew').addEventListener('input', function () {
        const val  = this.value;
        const fill = document.getElementById('strengthFill');
        const text = document.getElementById('strengthText');

        // Evaluasi setiap syarat wajib - Mengecek apakah password memenuhi tiga kriteria yang tersisa
        const checks = {
            length: val.length >= 6,
            upper:  /[A-Z]/.test(val),
            number: /[0-9]/.test(val),
        };

        // Update hint items - Menambahkan atau menghapus class 'met' dan mengganti ikon pada setiap baris syarat sesuai hasil evaluasi
        Object.keys(checks).forEach(key => {
            const el   = document.getElementById('hint-' + key);
            if (!el) return;
            const icon = el.querySelector('i');
            if (checks[key]) {
                el.classList.add('met');
                icon.className = 'fas fa-circle-check';
            } else {
                el.classList.remove('met');
                icon.className = 'fas fa-circle';
            }
        });

        // Hitung skor kekuatan berdasarkan tiga syarat yang tersisa
        const strength = Object.values(checks).filter(Boolean).length;

        // Konfigurasi tampilan per level - Setiap level memiliki warna dan label berbeda
        const config = [
            { color: '',        label: '' },
            { color: '#ef4444', label: 'Sangat Lemah' },
            { color: '#f97316', label: 'Lemah' },
            { color: '#22c55e', label: 'Kuat' },
        ];

        // Perbarui tampilan bar dan teks sesuai skor kekuatan
        fill.style.width      = val.length ? (strength * 33.3) + '%' : '0';
        fill.style.background = config[strength]?.color || '';
        text.textContent      = val.length ? config[strength]?.label || '' : '';
        text.style.color      = config[strength]?.color || '#94a3b8';

        // Trigger cek kesesuaian - Memperbarui indikator match saat password baru berubah
        document.getElementById('pwConfirm').dispatchEvent(new Event('input'));

        // Sembunyikan kotak error saat pengguna mengetik ulang
        document.getElementById('clientErrorBox').style.display = 'none';
    });

    // Match checker - Membandingkan nilai password baru dan konfirmasi setiap kali field konfirmasi berubah
    document.getElementById('pwConfirm').addEventListener('input', function () {
        const pw1   = document.getElementById('pwNew').value;
        const match = this.value === pw1;
        const el    = document.getElementById('matchText');

        if (!this.value) {
            el.innerHTML = '';
            return;
        }

        // Tampilkan hasil match - Ikon centang hijau jika cocok, ikon silang merah jika berbeda
        if (match) {
            el.innerHTML = '<i class="fas fa-circle-check" style="color:#16a34a;"></i> <span style="color:#16a34a;">Password cocok</span>';
        } else {
            el.innerHTML = '<i class="fas fa-circle-xmark" style="color:#dc2626;"></i> <span style="color:#dc2626;">Password tidak cocok</span>';
        }

        // Sembunyikan kotak error saat pengguna mengetik ulang konfirmasi
        document.getElementById('clientErrorBox').style.display = 'none';
    });

    // Fungsi untuk menampilkan pesan error di kotak merah dan scroll ke posisi kotak tersebut
    function tampilkanErrorPassword(pesan) {
        const box = document.getElementById('clientErrorBox');
        const msg = document.getElementById('clientErrorMsg');
        msg.innerText = pesan;
        box.style.display = 'flex';
        box.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }

    // Validasi saat form disubmit - Mencegat pengiriman form dan memeriksa semua syarat sebelum data dikirim ke server
    document.getElementById('resetForm').addEventListener('submit', function (e) {
        const pw      = document.getElementById('pwNew').value;
        const confirm = document.getElementById('pwConfirm').value;

        // Cek apakah password kosong
        if (pw === '') {
            e.preventDefault();
            tampilkanErrorPassword('Password baru tidak boleh kosong.');
            return;
        }

        // Cek minimal 6 karakter
        if (pw.length < 6) {
            e.preventDefault();
            tampilkanErrorPassword('Password tidak memenuhi persyaratan: minimal harus 6 karakter.');
            return;
        }

        // Cek harus mengandung huruf kapital A-Z
        if (!/[A-Z]/.test(pw)) {
            e.preventDefault();
            tampilkanErrorPassword('Password tidak memenuhi persyaratan: harus mengandung minimal satu huruf kapital (A-Z).');
            return;
        }

        // Cek harus mengandung angka 0-9
        if (!/[0-9]/.test(pw)) {
            e.preventDefault();
            tampilkanErrorPassword('Password tidak memenuhi persyaratan: harus mengandung minimal satu angka (0-9).');
            return;
        }

        // Cek konfirmasi password kosong
        if (confirm === '') {
            e.preventDefault();
            tampilkanErrorPassword('Konfirmasi password tidak boleh kosong.');
            return;
        }

        // Cek apakah password baru dan konfirmasi password sama
        if (pw !== confirm) {
            e.preventDefault();
            tampilkanErrorPassword('Password baru dan konfirmasi password tidak sama. Ketik ulang kedua password dengan benar.');
            return;
        }
    });
</script>

</body>
</html>