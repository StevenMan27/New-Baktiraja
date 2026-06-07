<?php

// Deklarasi namespace agar sistem bisa mengenali letak file model ini
namespace App\Models;

// Impor kelas inti Model dari framework Laravel
use Illuminate\Database\Eloquent\Model;

// Mendeklarasikan class ProfilGeosite yang diturunkan dari kelas Model
class ProfilGeosite extends Model {
    // Mendefinisikan nama tabel yang digunakan di database, yaitu 'profil_geosites'
    protected $table = 'profil_geosites';

    // Membuat array kolom apa saja yang diizinkan untuk proses mass assignment (pengisian massal)
    protected $fillable = [
        // Mengizinkan pengisian kolom geosite
        'geosite',
        // Mengizinkan pengisian kolom judul_utama
        'judul_utama',
        // Mengizinkan pengisian kolom sub_judul
        'sub_judul',
        // Mengizinkan pengisian kolom bg_hero
        'bg_hero',
        // Mengizinkan pengisian kolom deskripsi_1_judul
        'deskripsi_1_judul',
        // Mengizinkan pengisian kolom deskripsi_1_teks
        'deskripsi_1_teks',
        // Mengizinkan pengisian kolom deskripsi_2_judul
        'deskripsi_2_judul',
        // Mengizinkan pengisian kolom deskripsi_2_teks
        'deskripsi_2_teks',
        // Mengizinkan pengisian kolom deskripsi_2_gambar
        'deskripsi_2_gambar',
        // Mengizinkan pengisian kolom deskripsi_3_judul
        'deskripsi_3_judul',
        // Mengizinkan pengisian kolom deskripsi_3_teks
        'deskripsi_3_teks',
        // Mengizinkan pengisian kolom deskripsi_3_gambar
        'deskripsi_3_gambar',
        // Mengizinkan pengisian kolom deskripsi_4_judul
        'deskripsi_4_judul',
        // Mengizinkan pengisian kolom deskripsi_4_teks
        'deskripsi_4_teks',
        // Mengizinkan pengisian kolom deskripsi_4_gambar
        'deskripsi_4_gambar',
        // Mengizinkan pengisian kolom deskripsi_5_judul
        'deskripsi_5_judul',
        // Mengizinkan pengisian kolom deskripsi_5_teks
        'deskripsi_5_teks',
        // Mengizinkan pengisian kolom deskripsi_5_gambar
        'deskripsi_5_gambar',
        // Mengizinkan pengisian kolom info_lokasi
        'info_lokasi',
        // Mengizinkan pengisian kolom info_jam
        'info_jam',
        // Mengizinkan pengisian kolom info_harga
        'info_harga',
        // Mengizinkan pengisian kolom tags
        'tags',
        // Mengizinkan pengisian kolom maps_link
        'maps_link',
    ];

    // Mendefinisikan aturan casting untuk mengubah nilai dari database menjadi bentuk tipe data yang sesuai
    protected $casts = [
        // Mengubah teks JSON di database dari kolom 'tags' menjadi array
        'tags' => 'array',
        // Mengubah teks JSON di database dari kolom 'bg_hero' menjadi array
        'bg_hero' => 'array',
        // Mengubah teks JSON di database dari kolom 'deskripsi_2_gambar' menjadi array
        'deskripsi_2_gambar' => 'array',
        // Mengubah teks JSON di database dari kolom 'deskripsi_3_gambar' menjadi array
        'deskripsi_3_gambar' => 'array',
        // Mengubah teks JSON di database dari kolom 'deskripsi_4_gambar' menjadi array
        'deskripsi_4_gambar' => 'array',
        // Mengubah teks JSON di database dari kolom 'deskripsi_5_gambar' menjadi array
        'deskripsi_5_gambar' => 'array',
    ];

    // Membuat fungsi relasi ke entitas Galeri
    public function galeri()
    {
        // Mengembalikan relasi One-to-Many ke model Galeri berdasarkan atribut 'geosite'
        return $this->hasMany(Galeri::class, 'geosite', 'geosite');
    }

    // Membuat fungsi relasi ke entitas Berita
    public function berita()
    {
        // Mengembalikan relasi One-to-Many ke model Berita berdasarkan atribut 'geosite'
        return $this->hasMany(Berita::class, 'geosite', 'geosite');
    }

    // Membuat fungsi relasi ke entitas Informasi
    public function informasi()
    {
        // Mengembalikan relasi One-to-Many ke model Informasi berdasarkan atribut 'geosite'
        return $this->hasMany(Informasi::class, 'geosite', 'geosite');
    }

    // Membuat fungsi relasi ke entitas Umkm
    public function umkm()
    {
        // Mengembalikan relasi One-to-Many ke model Umkm berdasarkan atribut 'geosite'
        return $this->hasMany(Umkm::class, 'geosite', 'geosite');
    }

    // Membuat fungsi relasi ke entitas Fasilitas
    public function fasilitas()
    {
        // Mengembalikan relasi One-to-Many ke model Fasilitas berdasarkan atribut 'geosite'
        return $this->hasMany(Fasilitas::class, 'geosite', 'geosite');
    }

    // Membuat fungsi relasi ke entitas Penginapan
    public function penginapan()
    {
        // Mengembalikan relasi One-to-Many ke model Penginapan berdasarkan atribut 'geosite'
        return $this->hasMany(Penginapan::class, 'geosite', 'geosite');
    }
}
