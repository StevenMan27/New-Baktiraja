<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fasilitas extends Model
{
    protected $table = 'fasilitas';
    protected $fillable = ['nama', 'deskripsi', 'gambar', 'harga', 'geosite'];

    /**
     * Relasi ke ProfilGeosite
     */
    public function profilGeosite()
    {
        return $this->belongsTo(ProfilGeosite::class, 'geosite', 'geosite');
    }
}

