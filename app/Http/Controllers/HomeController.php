<?php

namespace App\Http\Controllers;

use App\Models\Galeri;

// Menangani logika tampilan halaman beranda publik website.
// Data galeri terbaru dan konfigurasi homepage diambil dari database, lalu dikirim ke view 'pages.home'.
class HomeController extends Controller {

    // Mengambil 6 foto galeri terbaru dan data homepage beserta relasi destinasi untuk ditampilkan di beranda.
    // Data berasal dari model Galeri dan Homepage; output ke view 'pages.home' via compact.
    public function index()
    {
        $galeri = Galeri::orderBy('created_at', 'desc')
            ->take(6)
            ->get();
            
        $homepage = \App\Models\Homepage::with('destinasis')->first();
        
        return view('pages.home', compact('galeri', 'homepage'));
    }
}
