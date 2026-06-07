<?php

// Mendeklarasikan namespace untuk model-model di dalam aplikasi
namespace App\Models;

// Mengimpor class UserFactory (walaupun tidak dipakai secara eksplisit)
use Database\Factories\UserFactory;
// Mengimpor trait HasFactory untuk fitur pembuatan data dummy model
use Illuminate\Database\Eloquent\Factories\HasFactory;
// Mengimpor class Authenticatable bawaan Laravel untuk sistem otentikasi
use Illuminate\Foundation\Auth\User as Authenticatable;
// Mengimpor trait Notifiable untuk kemampuan pengiriman notifikasi
use Illuminate\Notifications\Notifiable;

// Mendeklarasikan class Admin yang extends Authenticatable agar bisa digunakan untuk proses login
class Admin extends Authenticatable
{
    // Memasukkan fitur HasFactory dan Notifiable ke dalam class Admin
    use HasFactory, Notifiable;

    // Menentukan secara eksplisit bahwa model ini menggunakan tabel bernama 'admins'
    protected $table = 'admins';

    // Mendefinisikan properti fillable yang berisi array nama kolom yang boleh diisi secara massal
    protected $fillable = [
        // Mengizinkan kolom 'name' untuk diisi
        'name',
        // Mengizinkan kolom 'email' untuk diisi
        'email',
        // Mengizinkan kolom 'password' untuk diisi
        'password',
    ];

    // Mendefinisikan properti hidden untuk menyembunyikan data sensitif saat model di-serialize (misal ke JSON)
    protected $hidden = [
        // Menyembunyikan kolom 'password'
        'password',
        // Menyembunyikan kolom 'remember_token'
        'remember_token',
    ];

    // Mendefinisikan method casts untuk mengubah tipe data kolom tertentu
    protected function casts(): array
    {
        // Mengembalikan array berisikan aturan konversi (casting)
        return [
            // Mengubah kolom 'email_verified_at' menjadi object datetime
            'email_verified_at' => 'datetime',
            // Mengatur casting untuk 'password' agar dikenali sebagai hashed
            'password' => 'hashed',
        ];
    }
}
