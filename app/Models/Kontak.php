<?php

// Deklarasi namespace untuk model-model di aplikasi
namespace App\Models;

// Impor parent class Model dari namespace Eloquent
use Illuminate\Database\Eloquent\Model;
// Impor trait HasFactory
use Illuminate\Database\Eloquent\Factories\HasFactory;

// Deklarasi class Kontak yang mewarisi class Model
class Kontak extends Model {
    // Menggunakan trait HasFactory
    use HasFactory;

    // Mengatur nama tabel database yang digunakan secara manual yaitu 'kontaks'
    protected $table = 'kontaks';
    // Menentukan daftar atribut yang dapat diisi melalui mekanisme mass assignment
    protected $fillable = [
        // Kolom alamat
        'alamat', 
        // Kolom telepon
        'telepon', 
        // Kolom email
        'email', 
        // Kolom map_iframe
        'map_iframe', 
        // Kolom map_lokasi
        'map_lokasi', 
        // Kolom jam_operasional
        'jam_operasional', 
        // Kolom lokasi_bawah
        'lokasi_bawah', 
        // Kolom social_fb
        'social_fb', 
        // Kolom social_ig
        'social_ig', 
        // Kolom social_twitter
        'social_twitter', 
        // Kolom social_youtube
        'social_youtube', 
        // Kolom social_tiktok
        'social_tiktok'
    ];
}
