<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HomepageDestinasi extends Model {
    /*
       [MODEL HomepageDestinasi]
       File ini bertugas sebagai representasi dan penghubung antara aplikasi dengan tabel database.
       Tabel Database yang digunakan: secara otomatis menyesuaikan nama dari class (plural), atau ditentukan pada properti table.
    */
    use HasFactory;
    
    protected $guarded = [];

    // Relasi kembali ke Homepage
    public function homepage()
    {
        return $this->belongsTo(Homepage::class);
    }
}
