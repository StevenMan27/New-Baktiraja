<?php

/*
   [SEEDER GaleriSeeder.php]
   File ini bertugas memasukkan data awal (dummy/default) ke dalam tabel database secara otomatis saat perintah seed dijalankan.
*/

// database/seeders/GaleriSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Galeri;

class GaleriSeeder extends Seeder
{
    public function run(): void
    {
        // ==================== DESTINASI ALAM ====================
        
        // 1. Air Terjun Janji
        Galeri::create([
            'judul' => 'Air Terjun Janji',
            'kategori' => 'Air Terjun Janji',
            'deskripsi' => 'Keindahan air terjun dengan kolam alami kebiruan di Baktiraja',
            'gambar' => '/image/bakara/air-terjun-janji.jpg',
            'lokasi' => 'Baktiraja, Kab. Humbang Hasundutan',
            'tanggal_foto' => '2024-01-15',
            'status' => true,
        ]);
        
        Galeri::create([
            'judul' => 'Kolam Alami Air Terjun Janji',
            'kategori' => 'Air Terjun Janji',
            'deskripsi' => 'Kolam alami yang konon memiliki mitos "janji alam"',
            'gambar' => '/image/bakara/air-terjun-janji-detail.jpg',
            'lokasi' => 'Baktiraja',
            'tanggal_foto' => '2024-01-20',
            'status' => true,
        ]);
        
        // 2. Aek Sitio-tio
        Galeri::create([
            'judul' => 'Aek Sitio-tio',
            'kategori' => 'Aek Sitio-tio',
            'deskripsi' => 'Mata air pegunungan yang jernih dan tidak pernah surut',
            'gambar' => '/image/bakara/aek-sitio-tio.jpg',
            'lokasi' => 'Tipang, Kec. Baktiraja',
            'tanggal_foto' => '2024-02-10',
            'status' => true,
        ]);
        
        Galeri::create([
            'judul' => 'Kesegaran Aek Sitio-tio',
            'kategori' => 'Aek Sitio-tio',
            'deskripsi' => 'Air sangat segar dan konon membawa keberuntungan',
            'gambar' => '/image/bakara/aek-sitio-tio-detail.jpg',
            'lokasi' => 'Tipang',
            'tanggal_foto' => '2024-02-15',
            'status' => true,
        ]);
        
        // 3. Desa Wisata Tipang
        Galeri::create([
            'judul' => 'Desa Wisata Tipang',
            'kategori' => 'Desa Wisata Tipang',
            'deskripsi' => 'Pemandangan desa wisata tipang di tepi Danau Toba',
            'gambar' => '/image/bakara/desa-tipang.jpg',
            'lokasi' => 'Tipang, Kec. Baktiraja',
            'tanggal_foto' => '2024-03-05',
            'status' => true,
        ]);
        
        Galeri::create([
            'judul' => 'Homestay Desa Tipang',
            'kategori' => 'Desa Wisata Tipang',
            'deskripsi' => 'Pengalaman menginap bersama masyarakat Batak',
            'gambar' => '/image/bakara/penginapan/homestay-tipang.jpg',
            'lokasi' => 'Desa Tipang',
            'tanggal_foto' => '2024-03-10',
            'status' => true,
        ]);
        
        // ==================== DESTINASI BUATAN ====================
        
        // 4. Panatapan Bakara
        Galeri::create([
            'judul' => 'Panatapan Bakara',
            'kategori' => 'Panatapan Bakara',
            'deskripsi' => 'Panorama spektakuler Danau Toba dari ketinggian',
            'gambar' => '/image/bakara/panatapan-bakara.jpg',
            'lokasi' => 'Desa Bakara, Kec. Baktiraja',
            'tanggal_foto' => '2024-01-25',
            'status' => true,
        ]);
        
        Galeri::create([
            'judul' => 'Sunset di Panatapan Bakara',
            'kategori' => 'Panatapan Bakara',
            'deskripsi' => 'Spot favorit untuk menikmati sunset dengan latar Pulau Samosir',
            'gambar' => '/image/bakara/panatapan-bakara-sunset.jpg',
            'lokasi' => 'Bakara',
            'tanggal_foto' => '2024-01-30',
            'status' => true,
        ]);
        
        // 5. Gonting
        Galeri::create([
            'judul' => 'Bukit Gonting',
            'kategori' => 'Gonting',
            'deskripsi' => 'Bukit dengan jalur trekking melewati kebun kopi dan hutan pinus',
            'gambar' => '/image/bakara/gonting.jpg',
            'lokasi' => 'Tipang, Kec. Baktiraja',
            'tanggal_foto' => '2024-02-20',
            'status' => true,
        ]);
        
        Galeri::create([
            'judul' => 'Trekking Bukit Gonting',
            'kategori' => 'Gonting',
            'deskripsi' => 'Jalur trekking menantang dengan pemandangan Danau Toba dari sisi timur',
            'gambar' => '/image/bakara/gonting-trekking.jpg',
            'lokasi' => 'Bukit Gonting, Tipang',
            'tanggal_foto' => '2024-02-25',
            'status' => true,
        ]);
        
        // ==================== DESTINASI BUDAYA ====================
        
        // 6. Istana Sisingamangaraja
        Galeri::create([
            'judul' => 'Istana Sisingamangaraja',
            'kategori' => 'Istana Sisingamangaraja',
            'deskripsi' => 'Pusat spiritual dan pemerintahan raja-raja Batak',
            'gambar' => '/image/bakara/istana-sisingamangaraja.jpg',
            'lokasi' => 'Tipang, Kec. Baktiraja',
            'tanggal_foto' => '2024-03-15',
            'status' => true,
        ]);
        
        Galeri::create([
            'judul' => 'Arsitektur Istana Sisingamangaraja',
            'kategori' => 'Istana Sisingamangaraja',
            'deskripsi' => 'Arsitektur tradisional Batak yang masih terjaga',
            'gambar' => '/image/bakara/istana-sisingamangaraja-detail.jpg',
            'lokasi' => 'Tipang',
            'tanggal_foto' => '2024-03-20',
            'status' => true,
        ]);
        
        // 7. Tombak Sulu-sulu
        Galeri::create([
            'judul' => 'Hutan Sakral Tombak Sulu-sulu',
            'kategori' => 'Tombak Sulu-sulu',
            'deskripsi' => 'Hutan larangan dengan legenda tombak pusaka Raja Sisingamangaraja',
            'gambar' => '/image/bakara/tombak-sulu-sulu.jpg',
            'lokasi' => 'Kawasan Bakara',
            'tanggal_foto' => '2024-04-05',
            'status' => true,
        ]);
        
        Galeri::create([
            'judul' => 'Suasana Mistis Tombak Sulu-sulu',
            'kategori' => 'Tombak Sulu-sulu',
            'deskripsi' => 'Suasana hening dan mistis di hutan sakral',
            'gambar' => '/image/bakara/tombak-sulu-sulu-forest.jpg',
            'lokasi' => 'Bakara',
            'tanggal_foto' => '2024-04-10',
            'status' => true,
        ]);
        
        // 8. Aek Sipangolu
        Galeri::create([
            'judul' => 'Aek Sipangolu',
            'kategori' => 'Aek Sipangolu',
            'deskripsi' => 'Mata air panas alami yang dipercaya memiliki khasiat penyembuhan',
            'gambar' => '/image/bakara/aek-sipangolu.jpg',
            'lokasi' => 'Baktiraja',
            'tanggal_foto' => '2024-04-20',
            'status' => true,
        ]);
        
        Galeri::create([
            'judul' => 'Berendam di Aek Sipangolu',
            'kategori' => 'Aek Sipangolu',
            'deskripsi' => '"Air pereda penat" yang hangat alami dengan kandungan belerang rendah',
            'gambar' => '/image/bakara/aek-sipangolu-detail.jpg',
            'lokasi' => 'Baktiraja',
            'tanggal_foto' => '2024-04-25',
            'status' => true,
        ]);
    }
}