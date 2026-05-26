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
        'info_lokasi',
        'info_jam',
        'info_harga',
        'tags',
    ];

    protected $casts = [
        'tags' => 'array',
        'bg_hero' => 'array',
        'deskripsi_2_gambar' => 'array',
    ];
}
