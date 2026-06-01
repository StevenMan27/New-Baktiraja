<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Berita extends Model
{
    protected $table = 'berita';

    protected $fillable = [
        'judul',
        'slug',
        'konten',
        'gambar',
        'penulis',
        'views',
        'geosite'
    ];

    /**
     * Relasi ke ProfilGeosite
     */
    public function profilGeosite()
    {
        return $this->belongsTo(ProfilGeosite::class, 'geosite', 'geosite');
    }

    protected $casts = [
        'views' => 'integer'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($berita) {
            $berita->slug = Str::slug($berita->judul);
        });
        
        static::updating(function ($berita) {
            $berita->slug = Str::slug($berita->judul);
        });
    }
}
