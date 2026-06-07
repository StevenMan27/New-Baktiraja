<?php

// Membuka tag PHP
namespace App\Http\Controllers;

// Mengimpor model Galeri agar dapat mengambil data dari tabel galeris
use App\Models\Galeri;

// Mendeklarasikan class HomeController yang merupakan turunan dari Controller utama
class HomeController extends Controller {
    /*
       [CONTROLLER HomeController]
       File ini bertugas mengontrol logika aplikasi untuk bagian publik dari HomeController.
       Berfungsi mengambil data dari Model dan melemparkannya ke file View yang sesuai.
       Tabel Database yang digunakan: menyesuaikan dengan fungsi yang dipanggil.
    */
    /*
       [FUNGSI MENAMPILKAN HALAMAN BERANDA / HOME]
       Fungsi ini bertugas untuk memuat semua data yang dibutuhkan saat pengunjung pertama kali membuka website (Halaman Beranda). 
       Logikanya adalah:
       1. Mengambil 6 foto terbaru dari database galeri untuk ditampilkan di bagian 'Gallery Highlight'.
       2. Mengambil data teks dinamis (seperti judul Hero) dan daftar destinasi yang diatur oleh Admin dari database.
       3. Mengirimkan data-data tersebut ke file tampilan (view) 'pages.home'.
       Tabel Database yang digunakan: 'galeris', 'homepages', 'homepage_destinasis'
    */
    // Mendefinisikan method index yang dapat diakses secara publik
    public function index()
    {
        /*
           [MENGAMBIL DATA GALERI TERBARU]
           Melakukan query ke tabel galeris, mengurutkan data berdasarkan tanggal pembuatan paling baru (descending),
           lalu membatasi (take) hanya 6 data teratas saja yang diambil menggunakan get().
        */
        // Mengambil data galeri dari model Galeri
        $galeri = Galeri::orderBy('created_at', 'desc')
            // Membatasi pengambilan data hanya 6 entri
            ->take(6)
            // Mengeksekusi query dan mendapatkan hasilnya
            ->get();
            
        /*
           [MENGAMBIL PENGATURAN HOMEPAGE]
           Mengambil baris pertama (first) dari tabel homepages.
           with('destinasis') digunakan untuk mengambil relasi data destinasi secara bersamaan (Eager Loading) 
           agar performa website tetap cepat tanpa query berulang.
        */
        // Mengambil data homepage beserta relasi destinasis menggunakan metode Eager Loading
        $homepage = \App\Models\Homepage::with('destinasis')->first();
        
        /*
           [MENAMPILKAN HALAMAN VIEW]
           Mengembalikan response berupa file HTML yang ada di 'resources/views/pages/home.blade.php'.
           Fungsi compact() digunakan untuk membungkus variabel $galeri dan $homepage agar bisa dibaca di dalam file HTML tersebut.
        */
        // Mengembalikan view 'pages.home' dengan meneruskan data galeri dan homepage
        return view('pages.home', compact('galeri', 'homepage'));
    }
}
