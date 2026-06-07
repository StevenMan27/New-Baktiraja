<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Model Fasilitas
// Mengelola data fasilitas yang ada pada geosite tertentu.
class Fasilitas extends Model {
    protected $table = 'fasilitas';
    
    protected $fillable = ['nama', 'deskripsi', 'gambar', 'harga', 'geosite'];

    // Relasi ProfilGeosite
    // Menghubungkan fasilitas dengan profil geosite.
    public function profilGeosite()
    {
        return $this->belongsTo(ProfilGeosite::class, 'geosite', 'geosite');
    }
}
