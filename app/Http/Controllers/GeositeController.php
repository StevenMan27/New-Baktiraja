<?php

namespace App\Http\Controllers;

use App\Models\Umkm;
use App\Models\Fasilitas;
use App\Models\Penginapan;
use App\Models\Berita;
use App\Models\Galeri;

// Menangani logika tampilan untuk setiap halaman geosite beserta seluruh data relasinya.
// Data diambil dari berbagai model berdasarkan slug geosite, lalu diteruskan ke view yang sesuai.
class GeositeController extends Controller {

    // Mengumpulkan semua data terkait satu geosite (profil, UMKM, fasilitas, penginapan, berita, galeri, informasi).
    // Input berupa $slug string; data diambil dari beberapa tabel via Eloquent dan dikembalikan sebagai array.
    private function getGeositeData($slug)
    {
        return [
            'profil' => \App\Models\ProfilGeosite::where('geosite', $slug)->first(),
            'umkm' => Umkm::where('geosite', $slug)->get(),
            'fasilitas' => Fasilitas::where('geosite', $slug)->get(),
            'penginapan' => Penginapan::where('geosite', $slug)->get(),
            'berita' => Berita::where('geosite', $slug)->latest()->take(6)->get(),
            'galeri' => Galeri::where('geosite', $slug)->latest()->get(),
            'informasi_dinamis' => \App\Models\Informasi::where('geosite', $slug)->get(),
        ];
    }
    
    // Menampilkan halaman detail destinasi alam Air Terjun Janji.
    // Data diambil via getGeositeData('air-terjun-janji'); output ke view 'geosite.air-terjun-janji'.
    public function airTerjunJanji()
    {
        return view('geosite.air-terjun-janji', $this->getGeositeData('air-terjun-janji'));
    }
    
    // Menampilkan halaman detail destinasi alam Aek Sitio-Tio.
    // Data diambil via getGeositeData('aek-sitio-tio'); output ke view 'geosite.aek-sitio-tio'.
    public function aekSitioTio()
    {
        return view('geosite.aek-sitio-tio', $this->getGeositeData('aek-sitio-tio'));
    }
    
    // Menampilkan halaman detail destinasi alam Desa Wisata Tipang.
    // Data diambil via getGeositeData('desa-wisata-tipang'); output ke view 'geosite.desa-wisata-tipang'.
    public function desaWisataTipang()
    {
        return view('geosite.desa-wisata-tipang', $this->getGeositeData('desa-wisata-tipang'));
    }
    
    // Menampilkan halaman detail destinasi buatan Panatapan Bakara.
    // Data diambil via getGeositeData('panatapan-bakara'); output ke view 'geosite.panatapan-bakara'.
    public function panatapanBakara()
    {
        return view('geosite.panatapan-bakara', $this->getGeositeData('panatapan-bakara'));
    }
    
    // Menampilkan halaman detail destinasi buatan Gonting.
    // Data diambil via getGeositeData('gonting'); output ke view 'geosite.gonting'.
    public function gonting()
    {
        return view('geosite.gonting', $this->getGeositeData('gonting'));
    }
    
    // Menampilkan halaman detail destinasi budaya Istana Sisingamangaraja.
    // Data diambil via getGeositeData('istana-sisingamangaraja'); output ke view 'geosite.istana-sisingamangaraja'.
    public function istanaSisingamangaraja()
    {
        return view('geosite.istana-sisingamangaraja', $this->getGeositeData('istana-sisingamangaraja'));
    }
    
    // Menampilkan halaman detail destinasi budaya Tombak Sulu-Sulu.
    // Data diambil via getGeositeData('tombak-sulu-sulu'); output ke view 'geosite.tombak-sulu-sulu'.
    public function tombakSuluSulu()
    {
        return view('geosite.tombak-sulu-sulu', $this->getGeositeData('tombak-sulu-sulu'));
    }
    
    // Menampilkan halaman detail destinasi budaya Aek Sipangolu.
    // Data diambil via getGeositeData('aek-sipangolu'); output ke view 'geosite.aek-sipangolu'.
    public function aekSipangolu()
    {
        return view('geosite.aek-sipangolu', $this->getGeositeData('aek-sipangolu'));
    }
}
