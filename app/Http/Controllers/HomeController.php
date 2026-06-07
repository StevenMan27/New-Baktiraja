<?php

namespace App\Http\Controllers;

use App\Models\Galeri;

/*
   [CONTROLLER HomeController]
   File ini bertugas mengontrol logika untuk menampilkan halaman beranda (home) publik.
*/
class HomeController extends Controller {

    /*
       [FUNGSI INDEX HOME]
       Method ini memuat data galeri terbaru dan pengaturan homepage untuk ditampilkan di halaman beranda.
    */
    public function index()
    {
        $galeri = Galeri::orderBy('created_at', 'desc')
            ->take(6)
            ->get();
            
        $homepage = \App\Models\Homepage::with('destinasis')->first();
        
        return view('pages.home', compact('galeri', 'homepage'));
    }
}
