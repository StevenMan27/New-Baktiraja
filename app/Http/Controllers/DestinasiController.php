<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DestinasiController extends Controller
{
    // ==================== HALAMAN UTAMA DESTINASI ====================
    public function index()
    {
        return view('destinasi.index');
    }
    
    // ==================== DESTINASI ALAM ====================
    public function alam()
    {
        $kategori = 'Alam';
        $deskripsi = 'Destinasi wisata alam di kawasan Bakara, Tipang, dan Baktiraja yang menampilkan keindahan air terjun, mata air jernih, dan desa wisata yang asri.';
        
        $destinasi = [
            (object)[
                'id' => 1,
                'slug' => 'air-terjun-janji',
                'kategori' => 'alam',
                'nama' => 'Air Terjun Janji',
                'lokasi' => 'Baktiraja, Kab. Humbang Hasundutan',
                'deskripsi' => 'Air terjun deras dengan kolam alami kebiruan. Terdapat mitos lokal tentang "janji alam" bagi yang berenang di kolamnya.',
                'gambar' => 'image/bakara/air-terjun-janji.jpg',
                'tags' => ['Air Terjun', 'Mitos Lokal', 'Kolam Alami', 'Refreshing'],
                'url' => '/destinasi/alam/air-terjun-janji'
            ],
            (object)[
                'id' => 2,
                'slug' => 'aek-sitio-tio',
                'kategori' => 'alam',
                'nama' => 'Aek Sitio-tio',
                'lokasi' => 'Tipang, Kecamatan Baktiraja',
                'deskripsi' => 'Mata air pegunungan yang jernih dan tidak pernah surut. Airnya sangat segar dan konon membawa keberuntungan.',
                'gambar' => 'image/bakara/aek-sitio-tio.jpg',
                'tags' => ['Mata Air', 'Air Jernih', 'Penyegaran', 'Alam'],
                'url' => '/destinasi/alam/aek-sitio-tio'
            ],
            (object)[
                'id' => 3,
                'slug' => 'desa-wisata-tipang',
                'kategori' => 'alam',
                'nama' => 'Desa Wisata Tipang',
                'lokasi' => 'Tipang, Kecamatan Baktiraja',
                'deskripsi' => 'Desa wisata yang menawarkan pengalaman hidup bersama masyarakat Batak dengan pemandangan Danau Toba yang indah.',
                'gambar' => 'image/bakara/desa-tipang.jpg',
                'tags' => ['Desa Wisata', 'Budaya Batak', 'Homestay', 'Panorama Danau'],
                'url' => '/destinasi/alam/desa-wisata-tipang'
            ]
        ];
        
        return view('destinasi.kategori', compact('kategori', 'deskripsi', 'destinasi'));
    }
    
    // ==================== DESTINASI BUATAN ====================
    public function buatan()
    {
        $kategori = 'Buatan';
        $deskripsi = 'Destinasi buatan yang dikembangkan untuk menikmati keindahan alam Bakara, Tipang, dan Baktiraja dengan fasilitas yang nyaman.';
        
        $destinasi = [
            (object)[
                'id' => 1,
                'slug' => 'panatapan-bakara',
                'kategori' => 'buatan',
                'nama' => 'Panatapan Bakara',
                'lokasi' => 'Desa Bakara, Kecamatan Baktiraja',
                'deskripsi' => 'Area pandang dengan panorama spektakuler Danau Toba dari ketinggian. Spot favorit untuk sunrise dan sunset.',
                'gambar' => 'image/bakara/panatapan-bakara.jpg',
                'tags' => ['Panorama Danau', 'Sunrise', 'Sunset', 'Spot Foto', 'Gazebo'],
                'url' => '/destinasi/buatan/panatapan-bakara'
            ],
            (object)[
                'id' => 2,
                'slug' => 'gonting',
                'kategori' => 'buatan',
                'nama' => 'Gonting',
                'lokasi' => 'Tipang, Kecamatan Baktiraja',
                'deskripsi' => 'Bukit dengan jalur trekking yang dilengkapi fasilitas pendukung, melewati kebun kopi dan hutan pinus.',
                'gambar' => 'image/bakara/gonting.jpg',
                'tags' => ['Trekking', 'Bukit Gonting', 'Camping', 'Panorama Danau', 'Hutan Pinus'],
                'url' => '/destinasi/buatan/gonting'
            ]
        ];
        
        return view('destinasi.kategori', compact('kategori', 'deskripsi', 'destinasi'));
    }
    
    // ==================== DESTINASI BUDAYA ====================
    public function budaya()
    {
        $kategori = 'Budaya';
        $deskripsi = 'Destinasi wisata budaya yang menampilkan sejarah perjuangan Raja Sisingamangaraja, legenda, dan kearifan lokal masyarakat Batak di kawasan Bakara, Tipang, dan Baktiraja.';
        
        $destinasi = [
            (object)[
                'id' => 1,
                'slug' => 'istana-sisingamangaraja',
                'kategori' => 'budaya',
                'nama' => 'Istana Sisingamangaraja',
                'lokasi' => 'Tipang, Kecamatan Baktiraja',
                'deskripsi' => 'Pusat spiritual dan pemerintahan raja-raja Batak. Belajar sejarah perlawanan terhadap kolonial dan ritual adat.',
                'gambar' => 'image/bakara/istana-sisingamangaraja.jpg',
                'tags' => ['Istana', 'Sejarah Batak', 'Raja Sisingamangaraja', 'Ritual Adat', 'Artefak'],
                'url' => '/destinasi/budaya/istana-sisingamangaraja'
            ],
            (object)[
                'id' => 2,
                'slug' => 'tombak-sulu-sulu',
                'kategori' => 'budaya',
                'nama' => 'Tombak Sulu-sulu',
                'lokasi' => 'Kawasan Bakara',
                'deskripsi' => 'Hutan larangan dengan legenda tombak pusaka Raja Sisingamangaraja. Tempat wisata spiritual dan sejarah.',
                'gambar' => 'image/bakara/tombak-sulu-sulu.jpg',
                'tags' => ['Hutan Sakral', 'Legenda Tombak', 'Sisingamangaraja', 'Wisata Spiritual', 'Trekking'],
                'url' => '/destinasi/budaya/tombak-sulu-sulu'
            ],
            (object)[
                'id' => 3,
                'slug' => 'aek-sipangolu',
                'kategori' => 'budaya',
                'nama' => 'Aek Sipangolu',
                'lokasi' => 'Baktiraja',
                'deskripsi' => 'Mata air panas alami yang dipercaya memiliki khasiat menyembuhkan penyakit dan menghilangkan rasa lelah.',
                'gambar' => 'image/bakara/aek-sipangolu.jpg',
                'tags' => ['Mata Air Panas', 'Pengobatan Tradisional', 'Sejarah', 'Spiritual', 'Belerang'],
                'url' => '/destinasi/budaya/aek-sipangolu'
            ]
        ];
        
        return view('destinasi.kategori', compact('kategori', 'deskripsi', 'destinasi'));
    }
    
    // ==================== DETAIL DESTINASI — REDIRECT TO GEOSITE ROUTE ====================
    public function detail($kategori, $slug)
    {
        // Mapping slug ke named route geosite
        $geositeRoutes = [
            // Alam
            'air-terjun-janji'        => 'geosite.air-terjun-janji',
            'aek-sitio-tio'           => 'geosite.aek-sitio-tio',
            'desa-wisata-tipang'      => 'geosite.desa-wisata-tipang',
            // Buatan
            'panatapan-bakara'        => 'geosite.panatapan-bakara',
            'gonting'                 => 'geosite.gonting',
            // Budaya
            'istana-sisingamangaraja' => 'geosite.istana-sisingamangaraja',
            'tombak-sulu-sulu'        => 'geosite.tombak-sulu-sulu',
            'aek-sipangolu'           => 'geosite.aek-sipangolu',
        ];
        
        // Cek apakah slug ada di mapping
        if (isset($geositeRoutes[$slug])) {
            return redirect()->route($geositeRoutes[$slug]);
        }
        
        // Jika tidak ditemukan
        abort(404, 'Destinasi tidak ditemukan');
    }
}

