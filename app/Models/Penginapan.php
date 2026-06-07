<?php

// Namespace untuk tempat bernaungnya model-model aplikasi
namespace App\Models;

// Mengimpor parent class untuk seluruh model Eloquent
use Illuminate\Database\Eloquent\Model;

// Deklarasi class Penginapan yang menjadi representasi tabel penginapan
class Penginapan extends Model {
    // Menyatakan tabel yang terkait adalah 'penginapan'
    protected $table = 'penginapan';
    // Menentukan daftar kolom yang dapat diproses oleh operasi mass assignment
    protected $fillable = ['nama', 'deskripsi', 'gambar', 'harga', 'kontak', 'geosite'];

    // Fungsi untuk menetapkan relasi profilGeosite
    public function profilGeosite()
    {
        // Mengembalikan relasi belongsTo (banyak penginapan memiliki satu profilGeosite), terhubung di kolom 'geosite'
        return $this->belongsTo(ProfilGeosite::class, 'geosite', 'geosite');
    }
}
