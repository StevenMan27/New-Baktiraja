<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

// Model HomepageDestinasi
// Mengelola data destinasi yang akan ditampilkan pada homepage.
class HomepageDestinasi extends Model {
    use HasFactory;
    
    protected $guarded = [];

    // Relasi Homepage
    // Menghubungkan data destinasi kembali ke homepage induknya.
    public function homepage()
    {
        return $this->belongsTo(Homepage::class);
    }
}
