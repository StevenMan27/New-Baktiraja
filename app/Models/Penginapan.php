<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Model Penginapan
// Mengelola data penginapan untuk geosite tertentu.
class Penginapan extends Model {
    protected $table = 'penginapan';
    
    protected $fillable = ['nama', 'deskripsi', 'gambar', 'harga', 'kontak', 'geosite'];

    // Relasi ProfilGeosite
    // Menghubungkan data penginapan dengan profil geosite.
    public function profilGeosite()
    {
        return $this->belongsTo(ProfilGeosite::class, 'geosite', 'geosite');
    }
}
