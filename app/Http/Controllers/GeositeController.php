<?php

namespace App\Http\Controllers;

use App\Models\Umkm;
use App\Models\Fasilitas;
use App\Models\Penginapan;
use App\Models\Berita;
use App\Models\Galeri;

class GeositeController extends Controller
{
    // Helper: ambil semua data CRUD untuk geosite
    private function getGeositeData($slug)
    {
        return [
            'umkm' => Umkm::where('status', 1)->where('geosite', $slug)->orderBy('urutan')->get(),
            'fasilitas' => Fasilitas::where('status', 1)->where('geosite', $slug)->orderBy('urutan')->get(),
            'penginapan' => Penginapan::where('status', 1)->where('geosite', $slug)->orderBy('urutan')->get(),
            'berita' => Berita::where('status', true)->where('geosite', $slug)->latest()->take(6)->get(),
            'galeri' => Galeri::where('status', 1)->where('geosite', $slug)->latest()->get(),
            'informasi_dinamis' => \App\Models\Informasi::where('status', 1)->where('geosite', $slug)->orderBy('urutan')->get(),
        ];
    }

    // ==================== DESTINASI ALAM ====================
    
    // 1. Air Terjun Janji
    public function airTerjunJanji()
    {
        return view('geosite.air-terjun-janji', $this->getGeositeData('air-terjun-janji'));
    }
    
    // 2. Aek Sitio-tio
    public function aekSitioTio()
    {
        return view('geosite.aek-sitio-tio', $this->getGeositeData('aek-sitio-tio'));
    }
    
    // 3. Desa Wisata Tipang
    public function desaWisataTipang()
    {
        return view('geosite.desa-wisata-tipang', $this->getGeositeData('desa-wisata-tipang'));
    }
    
    // ==================== DESTINASI BUATAN ====================
    
    // 4. Panatapan Bakara
    public function panatapanBakara()
    {
        return view('geosite.panatapan-bakara', $this->getGeositeData('panatapan-bakara'));
    }
    
    // 5. Gonting
    public function gonting()
    {
        return view('geosite.gonting', $this->getGeositeData('gonting'));
    }
    
    // ==================== DESTINASI BUDAYA ====================
    
    // 6. Istana Sisingamangaraja
    public function istanaSisingamangaraja()
    {
        return view('geosite.istana-sisingamangaraja', $this->getGeositeData('istana-sisingamangaraja'));
    }
    
    // 7. Tombak Sulu-sulu
    public function tombakSuluSulu()
    {
        return view('geosite.tombak-sulu-sulu', $this->getGeositeData('tombak-sulu-sulu'));
    }
    
    // 8. Aek Sipangolu
    public function aekSipangolu()
    {
        return view('geosite.aek-sipangolu', $this->getGeositeData('aek-sipangolu'));
    }
}