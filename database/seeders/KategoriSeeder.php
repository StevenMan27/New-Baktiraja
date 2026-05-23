<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run()
    {
        $kategori = [
            ['nama' => 'Event', 'slug' => 'event', 'deskripsi' => 'Berita tentang event dan festival'],
            ['nama' => 'Prestasi', 'slug' => 'prestasi', 'deskripsi' => 'Berita tentang prestasi dan penghargaan'],
            ['nama' => 'Infrastruktur', 'slug' => 'infrastruktur', 'deskripsi' => 'Berita tentang pembangunan infrastruktur'],
            ['nama' => 'Edukasi', 'slug' => 'edukasi', 'deskripsi' => 'Berita tentang edukasi dan seminar'],
            ['nama' => 'Promosi', 'slug' => 'promosi', 'deskripsi' => 'Berita tentang promosi wisata'],
        ];
        
        foreach ($kategori as $item) {
            Kategori::create($item);
        }
    }
}