<?php

namespace Database\Seeders;

use App\Models\Informasi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class InformasiSeeder extends Seeder
{
    public function run()
    {
        // Hapus data lama
        Informasi::truncate();

        $data = [
            [
                'judul' => 'Letusan Supervolcano Toba',
                'konten' => '<p>Danau Toba terbentuk akibat letusan gunung berapi super (supervolcano) yang terjadi sekitar 74.000 tahun lalu. Letusan ini merupakan salah satu letusan terbesar dalam sejarah bumi yang meninggalkan kaldera raksasa yang kini dikenal sebagai Danau Toba. Material vulkanik dari letusan ini tersebar hingga ke berbagai belahan dunia, termasuk India dan Afrika.</p>',
                'urutan' => 1,
                'status' => 1,
            ],
            [
                'judul' => 'Kaldera Toba',
                'konten' => '<p>Letusan supervolcano Toba menghasilkan kaldera dengan panjang 100 km dan lebar 30 km. Setelah letusan, kaldera perlahan terisi air dan membentuk Danau Toba yang kita kenal sekarang. Proses pengangkatan kembali dasar kaldera kemudian menciptakan Pulau Samosir di tengah danau, yang menjadikan Danau Toba unik di dunia.</p>',
                'urutan' => 2,
                'status' => 1,
            ],
            [
                'judul' => 'UNESCO Global Geopark',
                'konten' => '<p>Kawasan Danau Toba kini diakui UNESCO sebagai Global Geopark pada tahun 2020. Pengakuan ini diberikan karena nilai geologi yang luar biasa, keanekaragaman hayati, serta warisan budaya Batak yang masih terjaga hingga saat ini.</p>',
                'urutan' => 3,
                'status' => 1,
            ],
        ];

        foreach ($data as $item) {
            Informasi::create([
                'judul' => $item['judul'],
                'slug' => Str::slug($item['judul']),
                'konten' => $item['konten'],
                'gambar' => null,
                'urutan' => $item['urutan'],
                'status' => $item['status'],
            ]);
        }
    }
}