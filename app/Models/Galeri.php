<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

// Model Galeri
// Mengelola data galeri foto dan pembuatan slug unik otomatis.
class Galeri extends Model {
    use HasFactory;

    protected $table = 'galeris';

    protected $fillable = [
        'judul',
        'slug',
        'deskripsi',
        'gambar',
        'kategori',
        'lokasi',
        'tanggal_foto',
        'geosite',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($galeri) {
            $baseSlug = Str::slug($galeri->judul);
            $slug = $baseSlug;
            $count = 1;
            while (static::where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $count++;
            }
            $galeri->slug = $slug;
        });

        static::updating(function ($galeri) {
            $baseSlug = Str::slug($galeri->judul);
            $slug = $baseSlug;
            $count = 1;
            while (static::where('slug', $slug)->where('id', '!=', $galeri->id)->exists()) {
                $slug = $baseSlug . '-' . $count++;
            }
            $galeri->slug = $slug;
        });
    }

    // Relasi ProfilGeosite
    // Menghubungkan galeri dengan profil geosite.
    public function profilGeosite()
    {
        return $this->belongsTo(ProfilGeosite::class, 'geosite', 'geosite');
    }
}
