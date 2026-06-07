<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

// Model Berita
// Mengelola data berita dan pembuatan slug otomatis.
class Berita extends Model {
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

    // Relasi ProfilGeosite
    // Menghubungkan berita dengan profil geosite berdasarkan kolom geosite.
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
