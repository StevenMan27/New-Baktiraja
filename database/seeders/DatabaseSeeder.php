<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            InformasiSeeder::class,
            // KategoriSeeder::class,  // Hapus atau komentari
            // GaleriSeeder::class,
            // BeritaSeeder::class,
        ]);
    }
}