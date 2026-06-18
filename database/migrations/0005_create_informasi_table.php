<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Membuat tabel informasi
    // Menyimpan konten informasi/pengumuman layanan publik yang terhubung ke geosite
    public function up(): void
    {
        Schema::create('informasi', function (Blueprint $table) {
            $table->id();
            $table->string('judul', 255);
            $table->string('slug', 255)->unique();
            $table->longText('konten');
            $table->longText('gambar')->nullable(); 
            $table->string('geosite')->nullable();
            $table->unsignedBigInteger('views')->default(0);
            $table->timestamps();

            $table->foreign('geosite')
                  ->references('geosite')->on('profil_geosites')
                  ->onUpdate('cascade')
                  ->onDelete('set null');
        });
    }

    // Membatalkan migrasi informasi
    // Menghapus tabel informasi dari database
    public function down(): void
    {
        Schema::dropIfExists('informasi');
    }
};
