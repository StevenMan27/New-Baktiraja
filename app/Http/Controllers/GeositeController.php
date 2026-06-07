<?php

namespace App\Http\Controllers;

use App\Models\Umkm;
use App\Models\Fasilitas;
use App\Models\Penginapan;
use App\Models\Berita;
use App\Models\Galeri;

/*
   [CONTROLLER GeositeController]
   File ini bertugas mengontrol logika untuk menampilkan halaman setiap geosite beserta seluruh data relasinya.
*/
class GeositeController extends Controller {

    /*
       [FUNGSI GET GEOSITE DATA]
       Method ini mengambil seluruh data terkait sebuah geosite (UMKM, fasilitas, penginapan, dll) berdasarkan slug.
    */
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
    
    /*
       [FUNGSI HALAMAN AIR TERJUN JANJI]
       Method ini memuat tampilan halaman khusus destinasi alam Air Terjun Janji.
    */
    public function airTerjunJanji()
    {
        return view('geosite.air-terjun-janji', $this->getGeositeData('air-terjun-janji'));
    }
    
    /*
       [FUNGSI HALAMAN AEK SITIO-TIO]
       Method ini memuat tampilan halaman khusus destinasi alam Aek Sitio-Tio.
    */
    public function aekSitioTio()
    {
        return view('geosite.aek-sitio-tio', $this->getGeositeData('aek-sitio-tio'));
    }
    
    /*
       [FUNGSI HALAMAN DESA WISATA TIPANG]
       Method ini memuat tampilan halaman khusus destinasi alam Desa Wisata Tipang.
    */
    public function desaWisataTipang()
    {
        return view('geosite.desa-wisata-tipang', $this->getGeositeData('desa-wisata-tipang'));
    }
    
    /*
       [FUNGSI HALAMAN PANATAPAN BAKARA]
       Method ini memuat tampilan halaman khusus destinasi buatan Panatapan Bakara.
    */
    public function panatapanBakara()
    {
        return view('geosite.panatapan-bakara', $this->getGeositeData('panatapan-bakara'));
    }
    
    /*
       [FUNGSI HALAMAN GONTING]
       Method ini memuat tampilan halaman khusus destinasi buatan Gonting.
    */
    public function gonting()
    {
        return view('geosite.gonting', $this->getGeositeData('gonting'));
    }
    
    /*
       [FUNGSI HALAMAN ISTANA SISINGAMANGARAJA]
       Method ini memuat tampilan halaman khusus destinasi budaya Istana Sisingamangaraja.
    */
    public function istanaSisingamangaraja()
    {
        return view('geosite.istana-sisingamangaraja', $this->getGeositeData('istana-sisingamangaraja'));
    }
    
    /*
       [FUNGSI HALAMAN TOMBAK SULU-SULU]
       Method ini memuat tampilan halaman khusus destinasi budaya Tombak Sulu-Sulu.
    */
    public function tombakSuluSulu()
    {
        return view('geosite.tombak-sulu-sulu', $this->getGeositeData('tombak-sulu-sulu'));
    }
    
    /*
       [FUNGSI HALAMAN AEK SIPANGOLU]
       Method ini memuat tampilan halaman khusus destinasi budaya Aek Sipangolu.
    */
    public function aekSipangolu()
    {
        return view('geosite.aek-sipangolu', $this->getGeositeData('aek-sipangolu'));
    }
}
