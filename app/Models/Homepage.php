<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

// Model Homepage
// Mengelola data tampilan utama (homepage).
class Homepage extends Model {
    use HasFactory;
    
    protected $guarded = [];
    
    // Relasi HomepageDestinasi
    // Menghubungkan homepage dengan berbagai destinasi yang ditampilkan.
    public function destinasis()
    {
        return $this->hasMany(HomepageDestinasi::class)->orderBy('id', 'asc');
    }
}
