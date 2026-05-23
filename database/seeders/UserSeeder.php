<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Cek apakah sudah ada, jika belum buat
        User::firstOrCreate(
            ['email' => 'adminbaktiraja@gmail.com'],
            [
                'name' => 'Admin GeoToba',
                'password' => Hash::make('admin123'),
            ]
        );
    }
}