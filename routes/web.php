<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\GaleriController;
use App\Http\Controllers\Admin\BeritaController;
use App\Http\Controllers\Admin\InformasiController;
use App\Http\Controllers\Admin\UmkmController;
use App\Http\Controllers\Admin\FasilitasController;
use App\Http\Controllers\Admin\PenginapanController;
use App\Http\Controllers\DestinasiController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\HomepageController;
use App\Http\Controllers\Admin\KontakController as AdminKontakController;
use App\Http\Controllers\GaleriController as PublicGaleriController;
use App\Http\Controllers\GeositeController;
use App\Http\Controllers\InformasiController as PublicInformasiController;
use App\Http\Controllers\KontakController;
use Illuminate\Support\Facades\DB;

// Utility: membuat storage link via browser
// Menjalankan artisan storage:link agar file upload dapat diakses publik
Route::get('/linkstorage', function () {
    \Illuminate\Support\Facades\Artisan::call('storage:link');
    return 'Berhasil membuat storage link! Silakan kembali ke website dan cek gambarnya.';
});

// Route halaman publik utama
// Mengarahkan URL publik ke controller masing-masing halaman
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/destinasi', [DestinasiController::class, 'index'])->name('destinasi');
Route::get('/destinasi/alam', [DestinasiController::class, 'alam'])->name('destinasi.alam');
Route::get('/destinasi/buatan', [DestinasiController::class, 'buatan'])->name('destinasi.buatan');
Route::get('/destinasi/budaya', [DestinasiController::class, 'budaya'])->name('destinasi.budaya');
Route::get('/destinasi/{kategori}/{slug}', [DestinasiController::class, 'detail'])->name('destinasi.detail');

Route::get('/informasi', [PublicInformasiController::class, 'index'])->name('informasi');
Route::get('/galeri', [PublicGaleriController::class, 'index'])->name('galeri');

Route::get('/berita', function () {
    $berita = App\Models\Berita::latest()->paginate(9);
    return view('pages.berita', compact('berita'));
})->name('berita');

// Route API penambah views
// Menerima POST request dan menginkremen kolom views pada berita atau informasi
Route::post('/api/berita/{id}/view', function ($id) {
    $berita = App\Models\Berita::findOrFail($id);
    $berita->increment('views');
    return response()->json([
        'success' => true,
        'views'   => $berita->views,
    ]);
})->name('berita.view.increment');

Route::post('/api/informasi/{id}/view', function ($id) {
    $informasi = App\Models\Informasi::findOrFail($id);
    $informasi->increment('views');
    return response()->json([
        'success' => true,
        'views'   => $informasi->views,
    ]);
})->name('informasi.view.increment');

Route::get('/kontak', [KontakController::class, 'index'])->name('kontak');
Route::post('/kontak/kirim', [KontakController::class, 'kirim'])->name('kontak.kirim');

// Route halaman detail geosite
// Mengarahkan URL tiap geosite ke method spesifik di GeositeController
Route::get('/geosite/air-terjun-janji', [GeositeController::class, 'airTerjunJanji'])->name('geosite.air-terjun-janji');
Route::get('/geosite/aek-sitio-tio', [GeositeController::class, 'aekSitioTio'])->name('geosite.aek-sitio-tio');
Route::get('/geosite/desa-wisata-tipang', [GeositeController::class, 'desaWisataTipang'])->name('geosite.desa-wisata-tipang');

Route::get('/geosite/panatapan-bakara', [GeositeController::class, 'panatapanBakara'])->name('geosite.panatapan-bakara');
Route::get('/geosite/gonting', [GeositeController::class, 'gonting'])->name('geosite.gonting');

Route::get('/geosite/istana-sisingamangaraja', [GeositeController::class, 'istanaSisingamangaraja'])->name('geosite.istana-sisingamangaraja');
Route::get('/geosite/tombak-sulu-sulu', [GeositeController::class, 'tombakSuluSulu'])->name('geosite.tombak-sulu-sulu');
Route::get('/geosite/aek-sipangolu', [GeositeController::class, 'aekSipangolu'])->name('geosite.aek-sipangolu');

// Route autentikasi admin
// Menangani login, logout, dan alur reset password via OTP
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/forgot-password', [AuthController::class, 'showForgotForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendOtp'])->name('password.send-otp');

Route::get('/verify-otp', [AuthController::class, 'showVerifyOtp'])->name('password.verify-otp');
Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);

Route::get('/reset-password', [AuthController::class, 'showResetForm'])->name('password.reset-form');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

// Route area admin (dilindungi middleware auth)
// Mengelola dasbor, konten homepage, kontak, dan resource CRUD semua entitas
Route::prefix('admin')->middleware('auth')->group(function () {
    
    Route::get('/', function () {
        $totalGaleri = DB::table('galeris')->count();
        $totalBerita = DB::table('berita')->count();
        $totalInformasi = DB::table('informasi')->count();
        $totalUmkm = DB::table('umkm')->count();
        $totalFasilitas = DB::table('fasilitas')->count();
        $totalPenginapan = DB::table('penginapan')->count();
        $totalViews = 0;
        
        return view('admin.dashboard', compact('totalGaleri', 'totalBerita', 'totalInformasi', 'totalUmkm', 'totalFasilitas', 'totalPenginapan', 'totalViews'));
    })->name('admin.dashboard');
    
    Route::get('homepage', [HomepageController::class, 'edit'])->name('admin.homepage.edit');
    Route::put('homepage', [HomepageController::class, 'update'])->name('admin.homepage.update');

    Route::get('kontak', [AdminKontakController::class, 'edit'])->name('admin.kontak.edit');
    Route::put('kontak', [AdminKontakController::class, 'update'])->name('admin.kontak.update');
    
    Route::resource('galeri', GaleriController::class)->names('admin.galeri');
    Route::resource('berita', BeritaController::class)->names('admin.berita');
    Route::resource('informasi', InformasiController::class)->names('admin.informasi');
    Route::resource('umkm', UmkmController::class)->names('admin.umkm');
    Route::resource('fasilitas', FasilitasController::class)->names('admin.fasilitas');
    Route::resource('penginapan', PenginapanController::class)->names('admin.penginapan');
    
    Route::get('profil', [\App\Http\Controllers\Admin\ProfilGeositeController::class, 'index'])->name('admin.profil.index');
    Route::get('profil/{geosite}/edit', [\App\Http\Controllers\Admin\ProfilGeositeController::class, 'edit'])->name('admin.profil.edit');
    Route::put('profil/{geosite}', [\App\Http\Controllers\Admin\ProfilGeositeController::class, 'update'])->name('admin.profil.update');
    
});
