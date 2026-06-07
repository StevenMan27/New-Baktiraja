<?php

/*
   [SEEDER AdminSeeder.php]
   File ini bertugas memasukkan data awal (dummy/default) ke dalam tabel database secara otomatis saat perintah seed dijalankan.
*/


namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // Cek apakah sudah ada, jika belum buat
        Admin::firstOrCreate(
            ['email' => 'adminbaktiraja@gmail.com'],
            [
                'name' => 'Admin GeoToba',
                'password' => Hash::make('admin123'),
            ]
        );
    }
}