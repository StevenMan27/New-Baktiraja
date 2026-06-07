<?php

// Mendeklarasikan namespace untuk model ini yaitu App\Models
namespace App\Models;

// Mengimpor class dasar Model dari Eloquent Laravel
use Illuminate\Database\Eloquent\Model;
// Mengimpor class helper Str untuk manipulasi string (seperti membuat slug)
use Illuminate\Support\Str;

// Mendeklarasikan class Berita yang mewarisi class Model bawaan Laravel
class Berita extends Model {
    // Menentukan secara eksplisit nama tabel di database yaitu 'berita'
    protected $table = 'berita';

    // Menentukan properti fillable untuk melindungi dari serangan mass assignment, mengizinkan kolom-kolom tertentu
    protected $fillable = [
        // Mengizinkan pengisian kolom 'judul'
        'judul',
        // Mengizinkan pengisian kolom 'slug'
        'slug',
        // Mengizinkan pengisian kolom 'konten'
        'konten',
        // Mengizinkan pengisian kolom 'gambar'
        'gambar',
        // Mengizinkan pengisian kolom 'penulis'
        'penulis',
        // Mengizinkan pengisian kolom 'views'
        'views',
        // Mengizinkan pengisian kolom 'geosite'
        'geosite'
    ];

    // Mendefinisikan fungsi profilGeosite untuk relasi ke model ProfilGeosite
    public function profilGeosite()
    {
        // Mengembalikan relasi belongsTo (banyak berita dimiliki oleh satu ProfilGeosite) berdasarkan kolom 'geosite'
        return $this->belongsTo(ProfilGeosite::class, 'geosite', 'geosite');
    }

    // Menentukan casting tipe data untuk kolom-kolom tertentu
    protected $casts = [
        // Memastikan kolom 'views' selalu diubah menjadi tipe data integer
        'views' => 'integer'
    ];

    // Mendefinisikan method boot yang dieksekusi saat model pertama kali dimuat
    protected static function boot()
    {
        // Memanggil method boot dari parent class Model
        parent::boot();
        
        // Mendaftarkan event 'creating' yang berjalan sesaat sebelum data baru disimpan ke database
        static::creating(function ($berita) {
            // Mengisi properti 'slug' secara otomatis dengan mengkonversi 'judul' menggunakan helper Str::slug
            $berita->slug = Str::slug($berita->judul);
        });
        
        // Mendaftarkan event 'updating' yang berjalan sesaat sebelum data yang ada diperbarui di database
        static::updating(function ($berita) {
            // Memperbarui properti 'slug' secara otomatis berdasarkan 'judul' yang baru
            $berita->slug = Str::slug($berita->judul);
        });
    }
}
