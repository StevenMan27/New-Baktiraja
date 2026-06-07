<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

// Model Kontak
// Mengelola data kontak seperti alamat, telepon, dan sosial media.
class Kontak extends Model {
    use HasFactory;

    protected $table = 'kontaks';
    
    protected $fillable = [
        'alamat', 
        'telepon', 
        'email', 
        'map_iframe', 
        'map_lokasi', 
        'jam_operasional', 
        'lokasi_bawah', 
        'social_fb', 
        'social_ig', 
        'social_twitter', 
        'social_youtube', 
        'social_tiktok'
    ];
}
