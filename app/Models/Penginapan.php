<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penginapan extends Model
{
    protected $table = 'penginapan';
    protected $fillable = ['nama', 'deskripsi', 'gambar', 'harga', 'kontak', 'urutan', 'status'];
}