<?php

namespace App\Http\Controllers;

use App\Models\Informasi;

// Menangani logika tampilan halaman informasi/pengumuman wisata untuk pengunjung publik.
// Data diambil dari tabel 'informasi' diurutkan ascending, lalu dikirim ke view 'pages.informasi'.
class InformasiController extends Controller {

    // Mengambil semua data informasi wisata dari database diurutkan dari yang paling lama.
    // Data berasal dari model Informasi; output ke view 'pages.informasi' via compact.
    public function index()
    {
        $informasiList = Informasi::orderBy('id', 'asc')
            ->get();
        
        return view('pages.informasi', compact('informasiList'));
    }
}
