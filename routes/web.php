<?php

/*
   ======================================================================================
   [PENJELASAN LENGKAP FILE: routes/web.php]
   
   1. BAGAIMANA CODE INI BEKERJA:
      File ini adalah "Resepsionis" atau "Papan Petunjuk Jalan" utama dari framework Laravel. 
      Setiap kali ada pengunjung yang mengetik alamat URL di browser (misal: geotoba.com/galeri), Laravel akan membuka file ini pertama kali untuk mengecek apakah alamat tersebut terdaftar.
      
   2. UNTUK APA CODE INI:
      Mendefinisikan seluruh jalur URL (Routes) yang ada di aplikasi, baik untuk halaman publik, proses autentikasi (Login/OTP), maupun area Dasbor Admin.
      
   3. HUBUNGAN DENGAN CODE LAIN (RELASI):
      - Dikendalikan oleh: Framework Laravel Routing.
      - Terkait dengan Model/Tabel: Tidak berinteraksi langsung dengan database.
      - Mewarisi Desain: Tidak ada.
      
   4. KEMANA ARAHNYA JIKA CODE INI MEMANGGIL:
      Setiap Route mengarahkan (meneruskan) permintaan URL ke sebuah fungsi spesifik di dalam Controller (misal: [GaleriController::class, 'index']).
   ======================================================================================
*/

// Mengimpor class Route dari facade Illuminate untuk mendefinisikan rute web.
use Illuminate\Support\Facades\Route;
// Mengimpor AuthController untuk menangani logika login, logout, dan reset password.
use App\Http\Controllers\AuthController;
// Mengimpor GaleriController khusus bagian Admin untuk manajemen data galeri.
use App\Http\Controllers\Admin\GaleriController;
// Mengimpor BeritaController khusus bagian Admin untuk manajemen data berita.
use App\Http\Controllers\Admin\BeritaController;
// Mengimpor InformasiController khusus bagian Admin untuk manajemen data informasi.
use App\Http\Controllers\Admin\InformasiController;
// Mengimpor UmkmController khusus bagian Admin untuk manajemen data UMKM.
use App\Http\Controllers\Admin\UmkmController;
// Mengimpor FasilitasController khusus bagian Admin untuk manajemen data fasilitas.
use App\Http\Controllers\Admin\FasilitasController;
// Mengimpor PenginapanController khusus bagian Admin untuk manajemen data penginapan.
use App\Http\Controllers\Admin\PenginapanController;
// Mengimpor DestinasiController untuk menampilkan halaman destinasi bagi pengunjung publik.
use App\Http\Controllers\DestinasiController;
// Mengimpor HomeController untuk menangani tampilan halaman utama (beranda).
use App\Http\Controllers\HomeController;
// Mengimpor HomepageController khusus bagian Admin untuk mengatur konten beranda.
use App\Http\Controllers\Admin\HomepageController;
// Mengimpor KontakController khusus Admin (menggunakan alias AdminKontakController) untuk kelola kontak.
use App\Http\Controllers\Admin\KontakController as AdminKontakController;
// Mengimpor GaleriController publik (menggunakan alias PublicGaleriController) untuk tampilan galeri bagi pengunjung.
use App\Http\Controllers\GaleriController as PublicGaleriController;
// Mengimpor GeositeController untuk menangani rute-rute khusus geosite (lokasi wisata).
use App\Http\Controllers\GeositeController;
// Mengimpor InformasiController publik (menggunakan alias PublicInformasiController) untuk halaman info pengunjung.
use App\Http\Controllers\InformasiController as PublicInformasiController;
// Mengimpor KontakController publik untuk halaman hubungi kami.
use App\Http\Controllers\KontakController;
// Mengimpor facade DB dari Illuminate untuk melakukan query langsung ke database.
use Illuminate\Support\Facades\DB;

// ==================== LANGUAGE ROUTE ====================


// ==================== FRONTEND ROUTES ====================

// Tambahkan Route darurat untuk membuat Storage Link di Hosting (CPanel)
// Mendefinisikan rute GET darurat dengan URL '/linkstorage' untuk mengeksekusi artisan command membuat storage link.
Route::get('/linkstorage', function () {
    // Memanggil command artisan 'storage:link' menggunakan Facade Artisan untuk menghubungkan folder storage ke public.
    \Illuminate\Support\Facades\Artisan::call('storage:link');
    // Mengembalikan response berupa string teks pemberitahuan bahwa pembuatan storage link berhasil.
    return 'Berhasil membuat storage link! Silakan kembali ke website dan cek gambarnya.';
// Menutup closure rute darurat '/linkstorage'.
});

// Home
// Mendefinisikan rute GET untuk halaman utama ('/') yang diarahkan ke method 'index' pada HomeController dan diberi nama rute 'home'.
Route::get('/', [HomeController::class, 'index'])->name('home');

// ==================== DESTINASI ROUTES ====================
// Mendefinisikan rute GET untuk halaman daftar semua destinasi ('/destinasi') yang diarahkan ke method 'index' pada DestinasiController dan diberi nama rute 'destinasi'.
Route::get('/destinasi', [DestinasiController::class, 'index'])->name('destinasi');
// Mendefinisikan rute GET untuk halaman daftar destinasi alam ('/destinasi/alam') yang diarahkan ke method 'alam' pada DestinasiController dengan nama rute 'destinasi.alam'.
Route::get('/destinasi/alam', [DestinasiController::class, 'alam'])->name('destinasi.alam');
// Mendefinisikan rute GET untuk halaman daftar destinasi buatan ('/destinasi/buatan') yang diarahkan ke method 'buatan' pada DestinasiController dengan nama rute 'destinasi.buatan'.
Route::get('/destinasi/buatan', [DestinasiController::class, 'buatan'])->name('destinasi.buatan');
// Mendefinisikan rute GET untuk halaman daftar destinasi budaya ('/destinasi/budaya') yang diarahkan ke method 'budaya' pada DestinasiController dengan nama rute 'destinasi.budaya'.
Route::get('/destinasi/budaya', [DestinasiController::class, 'budaya'])->name('destinasi.budaya');
// Mendefinisikan rute GET untuk halaman detail destinasi berdasarkan parameter kategori dan slug URL, diarahkan ke method 'detail' pada DestinasiController dengan nama 'destinasi.detail'.
Route::get('/destinasi/{kategori}/{slug}', [DestinasiController::class, 'detail'])->name('destinasi.detail');

// Informasi
// Mendefinisikan rute GET untuk halaman informasi publik ('/informasi') diarahkan ke method 'index' pada PublicInformasiController dengan nama 'informasi'.
Route::get('/informasi', [PublicInformasiController::class, 'index'])->name('informasi');

// Galeri Publik
// Mendefinisikan rute GET untuk halaman galeri publik ('/galeri') diarahkan ke method 'index' pada PublicGaleriController dengan nama 'galeri'.
Route::get('/galeri', [PublicGaleriController::class, 'index'])->name('galeri');



// Berita Publik
// Mendefinisikan rute GET untuk halaman daftar berita ('/berita') menggunakan fungsi anonim (closure).
Route::get('/berita', function () {
    // Mengambil data berita dari model Berita, diurutkan dari yang terbaru (latest), dan dipaginasi 9 data per halaman, lalu disimpan ke variabel $berita.
    $berita = App\Models\Berita::latest()->paginate(9);
    // Mengembalikan view 'pages.berita' sambil mengirimkan data variabel $berita menggunakan fungsi compact.
    return view('pages.berita', compact('berita'));
// Menutup closure dan memberikan nama rute ini sebagai 'berita'.
})->name('berita');


// API endpoint untuk increment views berita via AJAX dari modal reader
// Setiap kali modal berita dibuka oleh pengunjung, endpoint ini dipanggil untuk menambah +1 pada kolom views
// Mendefinisikan rute POST untuk API penambah jumlah tontonan berita ('/api/berita/{id}/view') yang menerima parameter ID.
Route::post('/api/berita/{id}/view', function ($id) {
    // Mencari data berita berdasarkan ID dari database menggunakan model Berita, akan menghasilkan error 404 jika tidak ditemukan, lalu disimpan ke variabel $berita.
    $berita = App\Models\Berita::findOrFail($id);
    // Menaikkan nilai kolom 'views' sebanyak 1 (increment) pada data berita yang ditemukan.
    $berita->increment('views');
    // Mengembalikan respons dalam bentuk JSON yang berisi status sukses dan jumlah tontonan (views) yang terbaru.
    return response()->json([
        // Menetapkan key 'success' bernilai boolean true pada JSON response.
        'success' => true,
        // Menetapkan key 'views' dengan nilai properti 'views' dari objek berita pada JSON response.
        'views'   => $berita->views,
    // Menutup array untuk respons JSON.
    ]);
// Menutup closure dan memberikan nama rute ini 'berita.view.increment'.
})->name('berita.view.increment');

// API endpoint untuk increment views informasi via AJAX dari modal reader
// Setiap kali modal informasi dibuka oleh pengunjung, endpoint ini dipanggil untuk menambah +1 pada kolom views
// Mendefinisikan rute POST untuk API penambah jumlah tontonan informasi ('/api/informasi/{id}/view') yang menerima parameter ID.
Route::post('/api/informasi/{id}/view', function ($id) {
    // Mencari data informasi berdasarkan ID dari database menggunakan model Informasi, akan menghasilkan 404 jika tidak ditemukan, disimpan ke variabel $informasi.
    $informasi = App\Models\Informasi::findOrFail($id);
    // Menaikkan nilai kolom 'views' sebanyak 1 pada data informasi yang ditemukan.
    $informasi->increment('views');
    // Mengembalikan respons dalam bentuk JSON yang berisi status berhasil dan total jumlah views saat ini.
    return response()->json([
        // Menyisipkan key 'success' dengan nilai boolean true ke dalam array JSON.
        'success' => true,
        // Menyisipkan key 'views' dengan total views terkini dari data informasi ke dalam array JSON.
        'views'   => $informasi->views,
    // Menutup array yang akan dikonversi ke respons JSON.
    ]);
// Menutup closure dan menetapkan nama rute 'informasi.view.increment'.
})->name('informasi.view.increment');



// Kontak
// Mendefinisikan rute GET untuk halaman kontak ('/kontak') yang diarahkan ke method 'index' pada KontakController dengan nama rute 'kontak'.
Route::get('/kontak', [KontakController::class, 'index'])->name('kontak');
// Mendefinisikan rute POST untuk memproses form pengiriman pesan dari halaman kontak, diarahkan ke method 'kirim' pada KontakController dengan nama 'kontak.kirim'.
Route::post('/kontak/kirim', [KontakController::class, 'kirim'])->name('kontak.kirim');

// ==================== GEOSITE ROUTES (BAKARA - TIPANG - BAKTIRAJA) ====================
// DESTINASI ALAM (3)
// Mendefinisikan rute GET untuk halaman destinasi Air Terjun Janji, diarahkan ke method 'airTerjunJanji' pada GeositeController dengan nama 'geosite.air-terjun-janji'.
Route::get('/geosite/air-terjun-janji', [GeositeController::class, 'airTerjunJanji'])->name('geosite.air-terjun-janji');
// Mendefinisikan rute GET untuk halaman destinasi Aek Sitio Tio, diarahkan ke method 'aekSitioTio' pada GeositeController dengan nama 'geosite.aek-sitio-tio'.
Route::get('/geosite/aek-sitio-tio', [GeositeController::class, 'aekSitioTio'])->name('geosite.aek-sitio-tio');
// Mendefinisikan rute GET untuk halaman destinasi Desa Wisata Tipang, diarahkan ke method 'desaWisataTipang' pada GeositeController dengan nama 'geosite.desa-wisata-tipang'.
Route::get('/geosite/desa-wisata-tipang', [GeositeController::class, 'desaWisataTipang'])->name('geosite.desa-wisata-tipang');

// DESTINASI BUATAN (2)
// Mendefinisikan rute GET untuk halaman destinasi Panatapan Bakara, diarahkan ke method 'panatapanBakara' pada GeositeController dengan nama 'geosite.panatapan-bakara'.
Route::get('/geosite/panatapan-bakara', [GeositeController::class, 'panatapanBakara'])->name('geosite.panatapan-bakara');
// Mendefinisikan rute GET untuk halaman destinasi Gonting, diarahkan ke method 'gonting' pada GeositeController dengan nama 'geosite.gonting'.
Route::get('/geosite/gonting', [GeositeController::class, 'gonting'])->name('geosite.gonting');

// DESTINASI BUDAYA (3)
// Mendefinisikan rute GET untuk halaman destinasi Istana Sisingamangaraja, diarahkan ke method 'istanaSisingamangaraja' pada GeositeController dengan nama 'geosite.istana-sisingamangaraja'.
Route::get('/geosite/istana-sisingamangaraja', [GeositeController::class, 'istanaSisingamangaraja'])->name('geosite.istana-sisingamangaraja');
// Mendefinisikan rute GET untuk halaman destinasi Tombak Sulu Sulu, diarahkan ke method 'tombakSuluSulu' pada GeositeController dengan nama 'geosite.tombak-sulu-sulu'.
Route::get('/geosite/tombak-sulu-sulu', [GeositeController::class, 'tombakSuluSulu'])->name('geosite.tombak-sulu-sulu');
// Mendefinisikan rute GET untuk halaman destinasi Aek Sipangolu, diarahkan ke method 'aekSipangolu' pada GeositeController dengan nama 'geosite.aek-sipangolu'.
Route::get('/geosite/aek-sipangolu', [GeositeController::class, 'aekSipangolu'])->name('geosite.aek-sipangolu');

// ==================== AUTH ROUTES ====================
// Mendefinisikan rute GET untuk menampilkan halaman form login, diarahkan ke method 'showLogin' pada AuthController dengan nama 'login'.
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
// Mendefinisikan rute POST untuk memproses data form login yang dikirim oleh user, diarahkan ke method 'login' pada AuthController.
Route::post('/login', [AuthController::class, 'login']);
// Mendefinisikan rute POST untuk memproses aksi keluar akun (logout), diarahkan ke method 'logout' pada AuthController dengan nama 'logout'.
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Lupa Password — Step 1: Input Email
// Mendefinisikan rute GET untuk menampilkan halaman form lupa password (input email), diarahkan ke method 'showForgotForm' pada AuthController dengan nama 'password.request'.
Route::get('/forgot-password', [AuthController::class, 'showForgotForm'])->name('password.request');
// Mendefinisikan rute POST untuk memproses pengiriman kode OTP ke email user yang lupa password, diarahkan ke method 'sendOtp' pada AuthController dengan nama 'password.send-otp'.
Route::post('/forgot-password', [AuthController::class, 'sendOtp'])->name('password.send-otp');

// Lupa Password — Step 2: Verifikasi OTP
// Mendefinisikan rute GET untuk menampilkan halaman form verifikasi kode OTP, diarahkan ke method 'showVerifyOtp' pada AuthController dengan nama 'password.verify-otp'.
Route::get('/verify-otp', [AuthController::class, 'showVerifyOtp'])->name('password.verify-otp');
// Mendefinisikan rute POST untuk memproses kode OTP yang diinputkan user, diarahkan ke method 'verifyOtp' pada AuthController.
Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);

// Lupa Password — Step 3: Buat Password Baru
// Mendefinisikan rute GET untuk menampilkan halaman form pembuatan password baru, diarahkan ke method 'showResetForm' pada AuthController dengan nama 'password.reset-form'.
Route::get('/reset-password', [AuthController::class, 'showResetForm'])->name('password.reset-form');
// Mendefinisikan rute POST untuk memproses penyimpanan password baru user ke database, diarahkan ke method 'resetPassword' pada AuthController dengan nama 'password.update'.
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

// ==================== ADMIN ROUTES ====================
// Membuat grup rute dengan prefix URL 'admin' dan dilindungi oleh middleware 'auth' sehingga hanya user yang sudah login yang bisa mengakses rute di dalamnya.
Route::prefix('admin')->middleware('auth')->group(function () {
    
    // Mendefinisikan rute GET untuk halaman utama dashboard admin ('/admin/') yang menggunakan fungsi closure.
    Route::get('/', function () {
        // Menghitung total jumlah baris data pada tabel 'galeris' di database dan menyimpannya ke variabel $totalGaleri.
        $totalGaleri = DB::table('galeris')->count();
        // Menghitung total jumlah baris data pada tabel 'berita' di database dan menyimpannya ke variabel $totalBerita.
        $totalBerita = DB::table('berita')->count();
        // Menghitung total jumlah baris data pada tabel 'informasi' di database dan menyimpannya ke variabel $totalInformasi.
        $totalInformasi = DB::table('informasi')->count();
        // Menghitung total jumlah baris data pada tabel 'umkm' di database dan menyimpannya ke variabel $totalUmkm.
        $totalUmkm = DB::table('umkm')->count();
        // Menghitung total jumlah baris data pada tabel 'fasilitas' di database dan menyimpannya ke variabel $totalFasilitas.
        $totalFasilitas = DB::table('fasilitas')->count();
        // Menghitung total jumlah baris data pada tabel 'penginapan' di database dan menyimpannya ke variabel $totalPenginapan.
        $totalPenginapan = DB::table('penginapan')->count();
        // Menginisialisasi variabel $totalViews dengan nilai awal integer 0, yang mungkin nantinya digunakan untuk menghitung total tayangan keseluruhan.
        $totalViews = 0;
        
        // Mengembalikan tampilan view 'admin.dashboard' ke browser, sembari mem-passing beberapa variabel perhitungan menggunakan fungsi compact agar bisa dipakai di tampilan (blade).
        return view('admin.dashboard', compact('totalGaleri', 'totalBerita', 'totalInformasi', 'totalUmkm', 'totalFasilitas', 'totalPenginapan', 'totalViews'));
    // Menutup definisi closure untuk rute dashboard dan memberikan nama rute 'admin.dashboard'.
    })->name('admin.dashboard');
    
    // Mendefinisikan rute GET untuk menampilkan form edit konten homepage di sisi admin, diarahkan ke method 'edit' pada HomepageController dengan nama 'admin.homepage.edit'.
    Route::get('homepage', [HomepageController::class, 'edit'])->name('admin.homepage.edit');
    // Mendefinisikan rute PUT untuk memproses pembaruan (update) konten homepage di database, diarahkan ke method 'update' pada HomepageController dengan nama 'admin.homepage.update'.
    Route::put('homepage', [HomepageController::class, 'update'])->name('admin.homepage.update');

    // Mendefinisikan rute GET untuk menampilkan form edit informasi kontak di admin, diarahkan ke method 'edit' pada AdminKontakController dengan nama 'admin.kontak.edit'.
    Route::get('kontak', [AdminKontakController::class, 'edit'])->name('admin.kontak.edit');
    // Mendefinisikan rute PUT untuk memproses pengubahan (update) informasi kontak di database, diarahkan ke method 'update' pada AdminKontakController dengan nama 'admin.kontak.update'.
    Route::put('kontak', [AdminKontakController::class, 'update'])->name('admin.kontak.update');
    
    // Mendefinisikan serangkaian rute CRUD lengkap (index, create, store, show, edit, update, destroy) untuk pengelolaan entitas 'galeri' menggunakan GaleriController, dengan awalan penamaan rute 'admin.galeri'.
    Route::resource('galeri', GaleriController::class)->names('admin.galeri');
    // Mendefinisikan serangkaian rute CRUD lengkap untuk pengelolaan entitas 'berita' menggunakan BeritaController, dengan awalan penamaan rute 'admin.berita'.
    Route::resource('berita', BeritaController::class)->names('admin.berita');
    // Mendefinisikan serangkaian rute CRUD lengkap untuk pengelolaan entitas 'informasi' menggunakan InformasiController, dengan awalan penamaan rute 'admin.informasi'.
    Route::resource('informasi', InformasiController::class)->names('admin.informasi');
    // Mendefinisikan serangkaian rute CRUD lengkap untuk pengelolaan entitas 'umkm' menggunakan UmkmController, dengan awalan penamaan rute 'admin.umkm'.
    Route::resource('umkm', UmkmController::class)->names('admin.umkm');
    // Mendefinisikan serangkaian rute CRUD lengkap untuk pengelolaan entitas 'fasilitas' menggunakan FasilitasController, dengan awalan penamaan rute 'admin.fasilitas'.
    Route::resource('fasilitas', FasilitasController::class)->names('admin.fasilitas');
    // Mendefinisikan serangkaian rute CRUD lengkap untuk pengelolaan entitas 'penginapan' menggunakan PenginapanController, dengan awalan penamaan rute 'admin.penginapan'.
    Route::resource('penginapan', PenginapanController::class)->names('admin.penginapan');
    
    // Mendefinisikan rute GET untuk menampilkan daftar profil geosite, diarahkan ke method 'index' pada class ProfilGeositeController dengan nama 'admin.profil.index'.
    Route::get('profil', [\App\Http\Controllers\Admin\ProfilGeositeController::class, 'index'])->name('admin.profil.index');
    // Mendefinisikan rute GET untuk menampilkan form edit suatu profil geosite tertentu berdasarkan parameternya, diarahkan ke method 'edit' pada class ProfilGeositeController dengan nama 'admin.profil.edit'.
    Route::get('profil/{geosite}/edit', [\App\Http\Controllers\Admin\ProfilGeositeController::class, 'edit'])->name('admin.profil.edit');
    // Mendefinisikan rute PUT untuk memproses pembaruan data suatu profil geosite tertentu di database, diarahkan ke method 'update' pada class ProfilGeositeController dengan nama 'admin.profil.update'.
    Route::put('profil/{geosite}', [\App\Http\Controllers\Admin\ProfilGeositeController::class, 'update'])->name('admin.profil.update');
    
// Menutup definisi grup fungsi untuk rute yang dilindungi auth dan di bawah prefix 'admin'.
});
