<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use App\Models\KoleksiFoto;

class HomeController extends Controller
{
    public function index()
    {
        // Galeri untuk CRUD (6 foto terbaru) - Tetap sama, hanya konten fotonya yang diganti
        $galeri = Galeri::orderBy('created_at', 'desc')
            ->take(6)
            ->get();
            
        // Mengambil konfigurasi dinamis Homepage
        $homepage = \App\Models\Homepage::with('destinasis')->first();
        
        return view('pages.home', compact('galeri', 'homepage'));
    }
}


