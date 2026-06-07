<?php

// Penempatan namespace di App\Models
namespace App\Models;

// Impor class dasar Model
use Illuminate\Database\Eloquent\Model;

// Deklarasi class Umkm yang mengeksekusi fitur ORM
class Umkm extends Model {
    // Pengaturan nama tabel yang terkait yaitu 'umkm'
    protected $table = 'umkm';
    // Penentuan kolom-kolom untuk mass assignment
    protected $fillable = ['nama', 'deskripsi', 'gambar', 'lokasi', 'kontak', 'geosite'];

    // Method pembentuk relasi bernama profilGeosite
    public function profilGeosite()
    {
        // Mereturn status bahwa satu Umkm dimiliki oleh satu ProfilGeosite (belongsTo)
        return $this->belongsTo(ProfilGeosite::class, 'geosite', 'geosite');
    }
}
