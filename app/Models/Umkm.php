<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Umkm extends Model
{
    protected $table = 'umkm';
    protected $fillable = ['nama', 'deskripsi', 'gambar', 'lokasi', 'kontak', 'urutan', 'status'];
}