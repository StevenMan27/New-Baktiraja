<?php

// Mendeklarasikan namespace App\Models
namespace App\Models;

// Mengimpor class Model Eloquent
use Illuminate\Database\Eloquent\Model;
// Mengimpor helper string dari Laravel
use Illuminate\Support\Str;

// Mendeklarasikan class Informasi yang diextends dari Model
class Informasi extends Model {
    // Menentukan nama tabel yang terkait dengan model ini yaitu 'informasi'
    protected $table = 'informasi';

    // Menetapkan array properti fillable agar kolom-kolom ini dapat diisi dengan fungsi mass assignment
    protected $fillable = [
        // Mengizinkan kolom judul
        'judul',
        // Mengizinkan kolom slug
        'slug',
        // Mengizinkan kolom konten
        'konten',
        // Mengizinkan kolom gambar
        'gambar',
        // Mengizinkan kolom geosite
        'geosite',
        // Mengizinkan kolom views
        'views',
    ];

    // Method untuk relasi ke ProfilGeosite
    public function profilGeosite()
    {
        // Mengembalikan relasi bahwa Informasi ini milik (belongsTo) sebuah ProfilGeosite
        return $this->belongsTo(ProfilGeosite::class, 'geosite', 'geosite');
    }

    // Mendefinisikan properti casts sebagai array kosong (belum ada konversi tipe data khusus)
    protected $casts = [];

    // Meng-override static method boot untuk menangani event siklus hidup model
    protected static function boot()
    {
        // Memastikan method boot pada parent tetap dijalankan
        parent::boot();
        
        // Mendaftarkan closure pada event creating
        static::creating(function ($informasi) {
            // Otomatis membentuk slug dari judul menggunakan Str::slug
            $informasi->slug = Str::slug($informasi->judul);
        });
        
        // Mendaftarkan closure pada event updating
        static::updating(function ($informasi) {
            // Otomatis memperbarui slug dari judul menggunakan Str::slug
            $informasi->slug = Str::slug($informasi->judul);
        });
    }
}
