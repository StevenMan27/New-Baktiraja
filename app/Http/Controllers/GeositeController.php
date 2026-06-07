<?php

// Menentukan namespace untuk meletakkan kelas di dalam hierarki sistem yang benar
namespace App\Http\Controllers;

// Mengimpor kelas Model Umkm
use App\Models\Umkm;
// Mengimpor kelas Model Fasilitas
use App\Models\Fasilitas;
// Mengimpor kelas Model Penginapan
use App\Models\Penginapan;
// Mengimpor kelas Model Berita
use App\Models\Berita;
// Mengimpor kelas Model Galeri
use App\Models\Galeri;

// Mendeklarasikan class GeositeController yang diperluas dari base Controller
class GeositeController extends Controller {
    /*
       [CONTROLLER GeositeController]
       File ini bertugas mengontrol logika aplikasi untuk bagian publik dari GeositeController.
       Berfungsi mengambil data dari Model dan melemparkannya ke file View yang sesuai.
       Tabel Database yang digunakan: menyesuaikan dengan fungsi yang dipanggil.
    */
    /*
       [FUNGSI PENGAMBIL DATA GLOBAL GEOSITE]
       Fungsi ini bertugas untuk menyedot semua data (UMKM, Galeri, Fasilitas, dll) dari database berdasarkan nama geosite (slug) yang dipilih.
       Logikanya adalah: Menerima nama geosite, lalu mencari data yang cocok di 7 tabel berbeda sekaligus.
       Tabel Database yang digunakan: 'profil_geosites', 'umkm', 'fasilitas', 'penginapan', 'berita', 'galeris', 'informasi'
    */
    // Membuat metode private untuk mengambil seluruh data terkait sebuah geosite berdasarkan slug
    private function getGeositeData($slug)
    {
        // Mengembalikan associative array yang berisi koleksi data dari beberapa model
        return [
            // Mengambil profil geosite pertama yang cocok dengan nilai slug
            'profil' => \App\Models\ProfilGeosite::where('geosite', $slug)->first(),
            // Mengambil seluruh data UMKM yang cocok dengan nilai slug geosite
            'umkm' => Umkm::where('geosite', $slug)->get(),
            // Mengambil seluruh data fasilitas yang cocok dengan nilai slug geosite
            'fasilitas' => Fasilitas::where('geosite', $slug)->get(),
            // Mengambil seluruh data penginapan yang cocok dengan nilai slug geosite
            'penginapan' => Penginapan::where('geosite', $slug)->get(),
            // Mengambil 6 data berita terbaru yang sesuai dengan slug geosite
            'berita' => Berita::where('geosite', $slug)->latest()->take(6)->get(),
            // Mengambil seluruh data galeri terbaru yang cocok dengan slug geosite
            'galeri' => Galeri::where('geosite', $slug)->latest()->get(),
            // Mengambil seluruh informasi dinamis tambahan berdasarkan slug geosite
            'informasi_dinamis' => \App\Models\Informasi::where('geosite', $slug)->get(),
        ];
    }

    // ==================== DESTINASI ALAM ====================
    
    /*
       [MENAMPILKAN HALAMAN AIR TERJUN JANJI]
       Fungsi ini bertugas untuk membuka halaman khusus Air Terjun Janji.
       Fungsi ini memanggil helper getGeositeData('air-terjun-janji') agar semua data galeri dan fasilitas spesifik janji ikut termuat.
       Tabel Database yang digunakan: Semua tabel yang direlasikan dengan geosite 'air-terjun-janji'
    */
    // Mendefinisikan method publik untuk menangani request rute halaman Air Terjun Janji
    public function airTerjunJanji()
    {
        // Menampilkan view geosite.air-terjun-janji dengan mengirim data yang dihasilkan oleh method getGeositeData
        return view('geosite.air-terjun-janji', $this->getGeositeData('air-terjun-janji'));
    }
    
    /*
       [MENAMPILKAN HALAMAN AEK SITIO-TIO]
       Fungsi ini bertugas untuk membuka halaman khusus Aek Sitio-Tio.
       Tabel Database yang digunakan: Semua tabel yang direlasikan dengan geosite 'aek-sitio-tio'
    */
    // Mendefinisikan method publik untuk rute halaman Aek Sitio-tio
    public function aekSitioTio()
    {
        // Mengembalikan tampilan untuk geosite.aek-sitio-tio dan memuat data dari geosite tersebut
        return view('geosite.aek-sitio-tio', $this->getGeositeData('aek-sitio-tio'));
    }
    
    /*
       [MENAMPILKAN HALAMAN DESA WISATA TIPANG]
       Fungsi ini bertugas untuk membuka halaman khusus Desa Wisata Tipang.
       Tabel Database yang digunakan: Semua tabel yang direlasikan dengan geosite 'desa-wisata-tipang'
    */
    // Mendefinisikan method publik untuk rute halaman Desa Wisata Tipang
    public function desaWisataTipang()
    {
        // Menampilkan view geosite.desa-wisata-tipang dengan data geosite spesifik
        return view('geosite.desa-wisata-tipang', $this->getGeositeData('desa-wisata-tipang'));
    }
    
    // ==================== DESTINASI BUATAN ====================
    
    /*
       [MENAMPILKAN HALAMAN PANATAPAN BAKARA]
       Fungsi ini bertugas untuk membuka halaman khusus Panatapan Bakara.
       Tabel Database yang digunakan: Semua tabel yang direlasikan dengan geosite 'panatapan-bakara'
    */
    // Mendefinisikan method publik untuk rute halaman Panatapan Bakara
    public function panatapanBakara()
    {
        // Menampilkan view geosite.panatapan-bakara beserta dengan data khusus untuk geosite ini
        return view('geosite.panatapan-bakara', $this->getGeositeData('panatapan-bakara'));
    }
    
    /*
       [MENAMPILKAN HALAMAN GONTING]
       Fungsi ini bertugas untuk membuka halaman khusus Gonting.
       Tabel Database yang digunakan: Semua tabel yang direlasikan dengan geosite 'gonting'
    */
    // Mendefinisikan method publik untuk rute halaman Gonting
    public function gonting()
    {
        // Mengembalikan tampilan view geosite.gonting lengkap dengan datanya
        return view('geosite.gonting', $this->getGeositeData('gonting'));
    }
    
    // ==================== DESTINASI BUDAYA ====================
    
    /*
       [MENAMPILKAN HALAMAN ISTANA SISINGAMANGARAJA]
       Fungsi ini bertugas untuk membuka halaman khusus Istana Sisingamangaraja.
       Tabel Database yang digunakan: Semua tabel yang direlasikan dengan geosite 'istana-sisingamangaraja'
    */
    // Mendefinisikan method publik untuk rute halaman Istana Sisingamangaraja
    public function istanaSisingamangaraja()
    {
        // Memuat view geosite.istana-sisingamangaraja dan memparsing data gosite tersebut
        return view('geosite.istana-sisingamangaraja', $this->getGeositeData('istana-sisingamangaraja'));
    }
    
    /*
       [MENAMPILKAN HALAMAN TOMBAK SULU-SULU]
       Fungsi ini bertugas untuk membuka halaman khusus Tombak Sulu-Sulu.
       Tabel Database yang digunakan: Semua tabel yang direlasikan dengan geosite 'tombak-sulu-sulu'
    */
    // Mendefinisikan method publik untuk rute halaman Tombak Sulu-Sulu
    public function tombakSuluSulu()
    {
        // Mengembalikan view geosite.tombak-sulu-sulu sekaligus passing data geosite
        return view('geosite.tombak-sulu-sulu', $this->getGeositeData('tombak-sulu-sulu'));
    }
    
    /*
       [MENAMPILKAN HALAMAN AEK SIPANGOLU]
       Fungsi ini bertugas untuk membuka halaman khusus Aek Sipangolu.
       Tabel Database yang digunakan: Semua tabel yang direlasikan dengan geosite 'aek-sipangolu'
    */
    // Mendefinisikan method publik untuk rute halaman Aek Sipangolu
    public function aekSipangolu()
    {
        // Menampilkan view geosite.aek-sipangolu dan mengisi datanya menggunakan method getGeositeData
        return view('geosite.aek-sipangolu', $this->getGeositeData('aek-sipangolu'));
    }
}
