<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Model Umkm
// Mengelola data UMKM yang terhubung dengan geosite.
class Umkm extends Model {
    protected $table = 'umkm';
    
    protected $fillable = ['nama', 'deskripsi', 'gambar', 'lokasi', 'kontak', 'geosite'];

    // Relasi ProfilGeosite
    // Menghubungkan UMKM dengan profil geosite terkait.
    public function profilGeosite()
    {
        return $this->belongsTo(ProfilGeosite::class, 'geosite', 'geosite');
    }
}
