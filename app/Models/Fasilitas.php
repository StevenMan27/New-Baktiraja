<?php

// Mendeklarasikan namespace model ini ke dalam folder App\Models
namespace App\Models;

// Mengimpor class Model dasar dari sistem Eloquent ORM Laravel
use Illuminate\Database\Eloquent\Model;

// Mendeklarasikan class Fasilitas yang merupakan sebuah turunan dari Model Eloquent
class Fasilitas extends Model {
    // Mendefinisikan bahwa model ini akan menggunakan tabel bernama 'fasilitas' di database
    protected $table = 'fasilitas';
    // Menentukan kolom apa saja yang diizinkan untuk diisi secara massal (mass assignment)
    protected $fillable = ['nama', 'deskripsi', 'gambar', 'harga', 'geosite'];

    // Mendefinisikan method relasi bernama profilGeosite
    public function profilGeosite()
    {
        // Mengembalikan relasi belongsTo yang menandakan Fasilitas ini milik satu ProfilGeosite (dihubungkan via 'geosite')
        return $this->belongsTo(ProfilGeosite::class, 'geosite', 'geosite');
    }
}
