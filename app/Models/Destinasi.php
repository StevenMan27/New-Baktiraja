<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destinasi extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika berbeda (opsional, jika tabelmu bernama 'destinasis')
    protected $table = 'destinasis'; 

    protected $fillable = [
        'nama', 
        'slug', 
        'lokasi', 
        'deskripsi', 
        'gambar_utama', 
        'tags'
    ];

    // Penting: Agar tags otomatis jadi array saat dipanggil di view
    protected $casts = [
        'tags' => 'array'
    ];
}