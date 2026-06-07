<?php

namespace App\Http\Controllers;

use App\Models\Informasi;

class InformasiController extends Controller {
    /*
       [CONTROLLER InformasiController]
       File ini bertugas mengontrol logika aplikasi untuk bagian publik dari InformasiController.
       Berfungsi mengambil data dari Model dan melemparkannya ke file View yang sesuai.
       Tabel Database yang digunakan: menyesuaikan dengan fungsi yang dipanggil.
    */
    /*
       [FUNGSI MENAMPILKAN HALAMAN INFORMASI PUBLIK]
       Fungsi ini bertugas untuk mengambil semua data pengumuman/informasi wisata dari database dan menampilkannya di halaman web pengunjung.
       Logikanya adalah:
       1. Melakukan query ke tabel informasi dan mengurutkannya berdasarkan 'id' secara Ascending (dari yang paling lama ke terbaru).
       2. Menyimpan seluruh data tersebut ke dalam variabel $informasiList.
       3. Mengirimkan variabel $informasiList ke file tampilan HTML (view) 'pages.informasi' agar bisa dilooping dan dirender ke layar.
       Tabel Database yang digunakan: 'informasi'
    */
    public function index()
    {
        $informasiList = Informasi::orderBy('id', 'asc')
            ->get();
        
        return view('pages.informasi', compact('informasiList'));
    }
}

