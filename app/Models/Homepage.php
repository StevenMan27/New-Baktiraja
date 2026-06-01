<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Homepage extends Model
{
    use HasFactory;
    
    // Allow mass assignment
    protected $guarded = [];
    // Relasi ke Destinasi Homepage
    public function destinasis()
    {
        return $this->hasMany(HomepageDestinasi::class)->orderBy('id', 'asc');
    }
}
