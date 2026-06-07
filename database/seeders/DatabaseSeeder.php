<?php

/*
   [SEEDER DatabaseSeeder.php]
   File ini bertugas memasukkan data awal (dummy/default) ke dalam tabel database secara otomatis saat perintah seed dijalankan.
*/

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            InformasiSeeder::class,
        ]);
    }
}