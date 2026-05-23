<?php

namespace App\Http\Controllers;

use App\Models\Umkm;
use App\Models\Fasilitas;
use App\Models\Penginapan;

class GeositeController extends Controller
{
    // ==================== DESTINASI ALAM ====================
    
    // 1. Air Terjun Janji
    public function airTerjunJanji()
    {
        $umkm = Umkm::where('status', 1)->orderBy('urutan')->get();
        $fasilitas = Fasilitas::where('status', 1)->orderBy('urutan')->get();
        $penginapan = Penginapan::where('status', 1)->orderBy('urutan')->get();
        
        return view('geosite.air-terjun-janji', compact('umkm', 'fasilitas', 'penginapan'));
    }
    
    // 2. Aek Sitio-tio
    public function aekSitioTio()
    {
        $umkm = Umkm::where('status', 1)->orderBy('urutan')->get();
        $fasilitas = Fasilitas::where('status', 1)->orderBy('urutan')->get();
        $penginapan = Penginapan::where('status', 1)->orderBy('urutan')->get();
        
        return view('geosite.aek-sitio-tio', compact('umkm', 'fasilitas', 'penginapan'));
    }
    
    // 3. Desa Wisata Tipang
    public function desaWisataTipang()
    {
        $umkm = Umkm::where('status', 1)->orderBy('urutan')->get();
        $fasilitas = Fasilitas::where('status', 1)->orderBy('urutan')->get();
        $penginapan = Penginapan::where('status', 1)->orderBy('urutan')->get();
        
        return view('geosite.desa-wisata-tipang', compact('umkm', 'fasilitas', 'penginapan'));
    }
    
    // ==================== DESTINASI BUATAN ====================
    
    // 4. Panatapan Bakara
    public function panatapanBakara()
    {
        $umkm = Umkm::where('status', 1)->orderBy('urutan')->get();
        $fasilitas = Fasilitas::where('status', 1)->orderBy('urutan')->get();
        $penginapan = Penginapan::where('status', 1)->orderBy('urutan')->get();
        
        return view('geosite.panatapan-bakara', compact('umkm', 'fasilitas', 'penginapan'));
    }
    
    // 5. Gonting
    public function gonting()
    {
        $umkm = Umkm::where('status', 1)->orderBy('urutan')->get();
        $fasilitas = Fasilitas::where('status', 1)->orderBy('urutan')->get();
        $penginapan = Penginapan::where('status', 1)->orderBy('urutan')->get();
        
        return view('geosite.gonting', compact('umkm', 'fasilitas', 'penginapan'));
    }
    
    // ==================== DESTINASI BUDAYA ====================
    
    // 6. Istana Sisingamangaraja
    public function istanaSisingamangaraja()
    {
        $umkm = Umkm::where('status', 1)->orderBy('urutan')->get();
        $fasilitas = Fasilitas::where('status', 1)->orderBy('urutan')->get();
        $penginapan = Penginapan::where('status', 1)->orderBy('urutan')->get();
        
        return view('geosite.istana-sisingamangaraja', compact('umkm', 'fasilitas', 'penginapan'));
    }
    
    // 7. Tombak Sulu-sulu
    public function tombakSuluSulu()
    {
        $umkm = Umkm::where('status', 1)->orderBy('urutan')->get();
        $fasilitas = Fasilitas::where('status', 1)->orderBy('urutan')->get();
        $penginapan = Penginapan::where('status', 1)->orderBy('urutan')->get();
        
        return view('geosite.tombak-sulu-sulu', compact('umkm', 'fasilitas', 'penginapan'));
    }
    
    // 8. Aek Sipangolu
    public function aekSipangolu()
    {
        $umkm = Umkm::where('status', 1)->orderBy('urutan')->get();
        $fasilitas = Fasilitas::where('status', 1)->orderBy('urutan')->get();
        $penginapan = Penginapan::where('status', 1)->orderBy('urutan')->get();
        
        return view('geosite.aek-sipangolu', compact('umkm', 'fasilitas', 'penginapan'));
    }
}