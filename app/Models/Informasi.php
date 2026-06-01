<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Informasi extends Model
{
    protected $table = 'informasi';

    protected $fillable = [
        'judul',
        'slug',
        'konten',
        'gambar',
        'geosite',
        'views',
    ];

    /**
     * Relasi ke ProfilGeosite
     */
    public function profilGeosite()
    {
        return $this->belongsTo(ProfilGeosite::class, 'geosite', 'geosite');
    }

    protected $casts = [];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($informasi) {
            $informasi->slug = Str::slug($informasi->judul);
        });
        
        static::updating(function ($informasi) {
            $informasi->slug = Str::slug($informasi->judul);
        });
    }
}

