<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HomepageDestinasi extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    // Relasi kembali ke Homepage
    public function homepage()
    {
        return $this->belongsTo(Homepage::class);
    }
}
