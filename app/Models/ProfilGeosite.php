<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilGeosite extends Model
{
    protected $table = 'profil_geosites';

    protected $fillable = [
        'geosite',
        'judul_utama',
        'sub_judul',
        'bg_hero',
        'deskripsi_1_judul',
        'deskripsi_1_teks',
        'deskripsi_2_judul',
        'deskripsi_2_teks',
        'deskripsi_2_gambar',
        'deskripsi_3_judul',
        'deskripsi_3_teks',
        'deskripsi_3_gambar',
        'deskripsi_4_judul',
        'deskripsi_4_teks',
        'deskripsi_4_gambar',
        'deskripsi_5_judul',
        'deskripsi_5_teks',
        'deskripsi_5_gambar',
        'info_lokasi',
        'info_jam',
        'info_harga',
        'tags',
    ];

    protected $casts = [
        'tags' => 'array',
        'bg_hero' => 'array',
        'deskripsi_2_gambar' => 'array',
        'deskripsi_3_gambar' => 'array',
        'deskripsi_4_gambar' => 'array',
        'deskripsi_5_gambar' => 'array',
    ];
}
