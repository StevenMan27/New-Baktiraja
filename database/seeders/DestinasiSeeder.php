<?php

/*
   [SEEDER DestinasiSeeder.php]
   File ini bertugas memasukkan data awal (dummy/default) ke dalam tabel database secara otomatis saat perintah seed dijalankan.
*/


namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Destinasi;

class DestinasiSeeder extends Seeder
{
    public function run()
    {
        Destinasi::insert([
            // ==================== DESTINASI ALAM ====================
            [
                'nama' => 'Air Terjun Janji',
                'slug' => 'air-terjun-janji',
                'gambar' => 'air-terjun-janji.jpg',
                'deskripsi' => 'Air terjun deras dengan kolam alami kebiruan. Terdapat mitos lokal tentang "janji alam" bagi yang berenang di kolamnya.'
            ],
            [
                'nama' => 'Aek Sitio-tio',
                'slug' => 'aek-sitio-tio',
                'gambar' => 'aek-sitio-tio.jpg',
                'deskripsi' => 'Mata air pegunungan yang jernih dan tidak pernah surut. Airnya sangat segar dan konon membawa keberuntungan.'
            ],
            [
                'nama' => 'Desa Wisata Tipang',
                'slug' => 'desa-wisata-tipang',
                'gambar' => 'desa-tipang.jpg',
                'deskripsi' => 'Desa wisata yang menawarkan pengalaman hidup bersama masyarakat Batak dengan pemandangan Danau Toba yang indah.'
            ],
            
            // ==================== DESTINASI BUATAN ====================
            [
                'nama' => 'Panatapan Bakara',
                'slug' => 'panatapan-bakara',
                'gambar' => 'panatapan-bakara.jpg',
                'deskripsi' => 'Area pandang dengan panorama spektakuler Danau Toba dari ketinggian. Spot favorit untuk sunrise dan sunset.'
            ],
            [
                'nama' => 'Gonting',
                'slug' => 'gonting',
                'gambar' => 'gonting.jpg',
                'deskripsi' => 'Bukit dengan jalur trekking yang dilengkapi fasilitas pendukung, melewati kebun kopi dan hutan pinus.'
            ],
            
            // ==================== DESTINASI BUDAYA ====================
            [
                'nama' => 'Istana Sisingamangaraja',
                'slug' => 'istana-sisingamangaraja',
                'gambar' => 'istana-sisingamangaraja.jpg',
                'deskripsi' => 'Pusat spiritual dan pemerintahan raja-raja Batak. Belajar sejarah perlawanan terhadap kolonial dan ritual adat.'
            ],
            [
                'nama' => 'Tombak Sulu-sulu',
                'slug' => 'tombak-sulu-sulu',
                'gambar' => 'tombak-sulu-sulu.jpg',
                'deskripsi' => 'Hutan larangan dengan legenda tombak pusaka Raja Sisingamangaraja. Tempat wisata spiritual dan sejarah.'
            ],
            [
                'nama' => 'Aek Sipangolu',
                'slug' => 'aek-sipangolu',
                'gambar' => 'aek-sipangolu.jpg',
                'deskripsi' => 'Mata air panas alami yang dipercaya memiliki khasiat menyembuhkan penyakit dan menghilangkan rasa lelah.'
            ],
        ]);
    }
}