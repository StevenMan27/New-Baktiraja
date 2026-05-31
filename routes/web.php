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

// ==================== LANGUAGE ROUTE ====================


// ==================== FRONTEND ROUTES ====================

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');

// ==================== DESTINASI ROUTES ====================
Route::get('/destinasi', [DestinasiController::class, 'index'])->name('destinasi');
Route::get('/destinasi/alam', [DestinasiController::class, 'alam'])->name('destinasi.alam');
Route::get('/destinasi/buatan', [DestinasiController::class, 'buatan'])->name('destinasi.buatan');
Route::get('/destinasi/budaya', [DestinasiController::class, 'budaya'])->name('destinasi.budaya');
Route::get('/destinasi/{kategori}/{slug}', [DestinasiController::class, 'detail'])->name('destinasi.detail');

// Informasi
Route::get('/informasi', [PublicInformasiController::class, 'index'])->name('informasi');

// Galeri Publik
Route::get('/galeri', [PublicGaleriController::class, 'index'])->name('galeri');

// Detail Galeri
Route::get('/galeri/{slug}', function ($slug) {
    $galeri = App\Models\Galeri::where('slug', $slug)->firstOrFail();
    $galeri->increment('views');
    return view('pages.galeri-detail', compact('galeri'));
})->name('galeri.detail');

// Berita Publik
Route::get('/berita', function () {
    $berita = App\Models\Berita::where('status', true)->latest()->paginate(9);
    return view('pages.berita', compact('berita'));
})->name('berita');

// Detail Berita
Route::get('/berita/{slug}', function ($slug) {
    $berita = App\Models\Berita::where('slug', $slug)->where('status', true)->firstOrFail();
    $berita->increment('views');
    return view('pages.berita-detail', compact('berita'));
})->name('berita.detail');

// UMKM Publik
Route::get('/umkm', [HomeController::class, 'umkm'])->name('umkm');

// Budaya
Route::get('/budaya', [HomeController::class, 'budaya'])->name('budaya');

// Kontak
Route::get('/kontak', [KontakController::class, 'index'])->name('kontak');
Route::post('/kontak/kirim', [KontakController::class, 'kirim'])->name('kontak.kirim');

// ==================== GEOSITE ROUTES (BAKARA - TIPANG - BAKTIRAJA) ====================
// DESTINASI ALAM (3)
Route::get('/geosite/air-terjun-janji', [GeositeController::class, 'airTerjunJanji'])->name('geosite.air-terjun-janji');
Route::get('/geosite/aek-sitio-tio', [GeositeController::class, 'aekSitioTio'])->name('geosite.aek-sitio-tio');
Route::get('/geosite/desa-wisata-tipang', [GeositeController::class, 'desaWisataTipang'])->name('geosite.desa-wisata-tipang');

// DESTINASI BUATAN (2)
Route::get('/geosite/panatapan-bakara', [GeositeController::class, 'panatapanBakara'])->name('geosite.panatapan-bakara');
Route::get('/geosite/gonting', [GeositeController::class, 'gonting'])->name('geosite.gonting');

// DESTINASI BUDAYA (3)
Route::get('/geosite/istana-sisingamangaraja', [GeositeController::class, 'istanaSisingamangaraja'])->name('geosite.istana-sisingamangaraja');
Route::get('/geosite/tombak-sulu-sulu', [GeositeController::class, 'tombakSuluSulu'])->name('geosite.tombak-sulu-sulu');
Route::get('/geosite/aek-sipangolu', [GeositeController::class, 'aekSipangolu'])->name('geosite.aek-sipangolu');

// ==================== AUTH ROUTES ====================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Lupa Password — Step 1: Input Email
Route::get('/forgot-password', [AuthController::class, 'showForgotForm'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendOtp'])->name('password.send-otp');

// Lupa Password — Step 2: Verifikasi OTP
Route::get('/verify-otp', [AuthController::class, 'showVerifyOtp'])->name('password.verify-otp');
Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);

// Lupa Password — Step 3: Buat Password Baru
Route::get('/reset-password', [AuthController::class, 'showResetForm'])->name('password.reset-form');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

// ==================== ADMIN ROUTES ====================
Route::prefix('admin')->middleware(['auth'])->group(function () {
    
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
