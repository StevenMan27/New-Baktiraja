<?php

// Mendefinisikan namespace untuk semua model di aplikasi
namespace App\Models;

// Mengimpor trait HasFactory yang memungkinkan pembuatan factory untuk data palsu (dummy)
use Illuminate\Database\Eloquent\Factories\HasFactory;
// Mengimpor parent class Model bawaan dari Laravel
use Illuminate\Database\Eloquent\Model;
// Mengimpor facade Str untuk manipulasi teks, seperti pembuatan slug
use Illuminate\Support\Str;

// Mendeklarasikan class Galeri sebagai turunan dari Model Eloquent
class Galeri extends Model {
    // Mengaktifkan fitur trait HasFactory untuk class ini
    use HasFactory;

    // Mendeklarasikan secara spesifik bahwa tabel di database untuk model ini adalah 'galeris'
    protected $table = 'galeris';

    // Mengatur properti fillable yang memuat array nama kolom yang aman untuk mass assignment
    protected $fillable = [
        // Kolom judul diizinkan diisi
        'judul',
        // Kolom slug diizinkan diisi
        'slug',
        // Kolom deskripsi diizinkan diisi
        'deskripsi',
        // Kolom gambar diizinkan diisi
        'gambar',
        // Kolom kategori diizinkan diisi
        'kategori',
        // Kolom lokasi diizinkan diisi
        'lokasi',
        // Kolom tanggal_foto diizinkan diisi
        'tanggal_foto',
        // Kolom geosite diizinkan diisi
        'geosite',
    ];

    // Mendefinisikan static method boot yang dijalankan pada saat proses inisialisasi model
    protected static function boot()
    {
        // Memanggil fungsi boot pada kelas induk
        parent::boot();

        // Mendaftarkan listener untuk event 'creating' (saat sebelum record baru dibuat)
        static::creating(function ($galeri) {
            // Menghasilkan slug dasar dari judul dengan bantuan Str::slug
            $baseSlug = Str::slug($galeri->judul);
            // Menyimpan slug dasar ke dalam variabel $slug untuk dicek
            $slug = $baseSlug;
            // Menginisialisasi variabel counter dengan angka 1
            $count = 1;
            // Melakukan perulangan selama slug tersebut sudah ada di tabel database
            while (static::where('slug', $slug)->exists()) {
                // Jika sudah ada, tambahkan angka counter di belakang slug dasar
                $slug = $baseSlug . '-' . $count++;
            }
            // Meng-assign slug yang sudah dipastikan unik ke properti 'slug' pada objek galeri
            $galeri->slug = $slug;
        });

        // Mendaftarkan listener untuk event 'updating' (saat sebelum record yang sudah ada diperbarui)
        static::updating(function ($galeri) {
            // Menghasilkan slug dasar baru dari judul (yang mungkin sudah berubah) menggunakan Str::slug
            $baseSlug = Str::slug($galeri->judul);
            // Menyimpan slug dasar ke variabel temporary $slug
            $slug = $baseSlug;
            // Menginisialisasi counter dengan angka 1
            $count = 1;
            // Melakukan pengecekan apakah slug sudah ada, tetapi mengecualikan record ini sendiri (berdasarkan id)
            while (static::where('slug', $slug)->where('id', '!=', $galeri->id)->exists()) {
                // Jika ternyata sudah digunakan record lain, ubah slug dengan menambahkan angka counter di belakangnya
                $slug = $baseSlug . '-' . $count++;
            }
            // Memasukkan slug final (yang unik) ke dalam properti 'slug'
            $galeri->slug = $slug;
        });
    }

    // Mendefinisikan method profilGeosite untuk membuat relasi ke model ProfilGeosite
    public function profilGeosite()
    {
        // Menentukan bahwa Galeri ini 'belongsTo' (milik) sebuah ProfilGeosite melalui foreign key 'geosite'
        return $this->belongsTo(ProfilGeosite::class, 'geosite', 'geosite');
    }
}
