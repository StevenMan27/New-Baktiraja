<?php

namespace App\Http\Controllers;

use App\Models\Informasi;

class InformasiController extends Controller
{
    public function index()
    {
        $informasiList = Informasi::orderBy('id', 'asc')
            ->get();
        
        return view('pages.informasi', compact('informasiList'));
    }
}



