<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use App\Models\KoleksiFoto;

class HomeController extends Controller
{
    public function index()
    {
        // Hero Slider (5 foto) - Ganti dengan foto kawasan Bakara-Tipang-Baktiraja
        $slide1 = KoleksiFoto::where('nama_foto', 'bakara-slide1.jpg')->first();
        $slide2 = KoleksiFoto::where('nama_foto', 'bakara-slide2.jpg')->first();
        $slide3 = KoleksiFoto::where('nama_foto', 'bakara-slide3.jpg')->first();
        $slide4 = KoleksiFoto::where('nama_foto', 'bakara-slide4.jpg')->first();
        $slide5 = KoleksiFoto::where('nama_foto', 'bakara-slide5.jpg')->first();
        
        // About Image - Ganti dengan foto ikonik kawasan
        $aboutImage = KoleksiFoto::where('nama_foto', 'panatapan-bakara-hero.jpg')->first();
        
        // Destinasi Images - Ganti dengan 3 destinasi unggulan baru
        $destinasiPanatapan = KoleksiFoto::where('nama_foto', 'panatapan-bakara.jpg')->first();
        $destinasiIstana = KoleksiFoto::where('nama_foto', 'istana-sisingamangaraja.jpg')->first();
        $destinasiAekSipangolu = KoleksiFoto::where('nama_foto', 'aek-sipangolu.jpg')->first();
        
        // Data destinasi - 3 destinasi unggulan dari kawasan Bakara-Tipang-Baktiraja
        $destinasi = [
            (object)[
                'slug' => 'panatapan-bakara',
                'nama' => 'Panatapan Bakara',
                'foto' => $destinasiPanatapan,
                'lokasi' => 'Desa Bakara, Kecamatan Baktiraja, Kabupaten Humbang Hasundutan',
                'deskripsi' => 'Panorama spektakuler Danau Toba dari ketinggian. Spot favorit untuk menyaksikan sunrise dan sunset dengan latar Pulau Samosir.',
                'tags' => ['Panorama Danau Toba', 'Sunrise Sunset', 'Spot Foto Ikonik'],
                'number' => '01'
            ],
            (object)[
                'slug' => 'istana-sisingamangaraja',
                'nama' => 'Istana Sisingamangaraja',
                'foto' => $destinasiIstana,
                'lokasi' => 'Tipang, Kecamatan Baktiraja, Kabupaten Humbang Hasundutan',
                'deskripsi' => 'Pusat spiritual dan pemerintahan raja-raja Batak. Belajar sejarah perlawanan terhadap kolonial dan ritual adat.',
                'tags' => ['Sejarah Batak', 'Raja Sisingamangaraja', 'Wisata Budaya'],
                'number' => '02'
            ],
            (object)[
                'slug' => 'aek-sipangolu',
                'nama' => 'Aek Sipangolu',
                'foto' => $destinasiAekSipangolu,
                'lokasi' => 'Baktiraja, Kabupaten Humbang Hasundutan',
                'deskripsi' => 'Mata air panas alami yang dipercaya memiliki khasiat menyembuhkan penyakit dan menghilangkan rasa lelah.',
                'tags' => ['Mata Air Panas', 'Pengobatan Tradisional', 'Wisata Spiritual'],
                'number' => '03'
            ],
        ];
        
        // Galeri untuk CRUD (6 foto terbaru) - Tetap sama, hanya konten fotonya yang diganti
        $galeri = Galeri::where('status', 1)
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();
            
        // Mengambil konfigurasi dinamis Homepage
        $homepage = \App\Models\Homepage::first();
        
        return view('pages.home', compact('slide1', 'slide2', 'slide3', 'slide4', 'slide5', 'aboutImage', 'destinasi', 'galeri', 'homepage'));
    }
}

