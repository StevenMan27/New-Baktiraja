<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Galeri extends Model
{
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

    /**
     * Auto-generate slug dari judul saat create/update
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($galeri) {
            $baseSlug = Str::slug($galeri->judul);
            $slug = $baseSlug;
            $count = 1;
            // Pastikan slug unik
            while (static::where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $count++;
            }
            $galeri->slug = $slug;
        });

        static::updating(function ($galeri) {
            $baseSlug = Str::slug($galeri->judul);
            $slug = $baseSlug;
            $count = 1;
            // Pastikan slug unik, kecuali untuk record yang sama
            while (static::where('slug', $slug)->where('id', '!=', $galeri->id)->exists()) {
                $slug = $baseSlug . '-' . $count++;
            }
            $galeri->slug = $slug;
        });
    }

    /**
     * Relasi ke ProfilGeosite
     */
    public function profilGeosite()
    {
        return $this->belongsTo(ProfilGeosite::class, 'geosite', 'geosite');
    }
}

