<?php

// Mendeklarasikan namespace pada direktori App\Models
namespace App\Models;

// Mengimpor class dasar Model
use Illuminate\Database\Eloquent\Model;
// Mengimpor HasFactory untuk mendukung fitur factory
use Illuminate\Database\Eloquent\Factories\HasFactory;

// Mendeklarasikan class Homepage sebagai turunan dari Model
class Homepage extends Model {
    // Memanggil trait HasFactory agar model ini bisa menggunakan fitur factory
    use HasFactory;
    
    // Mendefinisikan guarded sebagai array kosong, artinya mengizinkan mass assignment untuk semua kolom
    protected $guarded = [];
    
    // Mendefinisikan method destinasis sebagai representasi relasi
    public function destinasis()
    {
        // Mengembalikan relasi hasMany ke model HomepageDestinasi dan mengurutkannya secara ascending berdasarkan id
        return $this->hasMany(HomepageDestinasi::class)->orderBy('id', 'asc');
    }
}
