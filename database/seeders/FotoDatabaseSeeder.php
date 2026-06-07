<?php

/*
   [SEEDER FotoDatabaseSeeder.php]
   File ini bertugas memasukkan data awal (dummy/default) ke dalam tabel database secara otomatis saat perintah seed dijalankan.
*/

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class FotoDatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $path = public_path('image');

        if (File::exists($path)) {
            $files = File::allFiles($path);

            foreach ($files as $file) {
                $extension = strtolower($file->getExtension());
                if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                    
                    DB::table('koleksi_fotos')->insert([
                        'nama_foto' => $file->getFilename(),
                        'file_foto' => file_get_contents($file->getRealPath()),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
            $this->command->info('Mantap! Semua foto dari berbagai folder sudah masuk ke database.');
        } else {
            $this->command->error('Folder public/image tidak ditemukan!');
        }
    }
}