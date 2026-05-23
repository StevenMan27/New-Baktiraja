<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KoleksiFoto extends Model
{
    protected $table = 'koleksi_fotos';
    
    protected $fillable = [
        'nama_foto',
        'file_foto',
        'keterangan'
    ];
}