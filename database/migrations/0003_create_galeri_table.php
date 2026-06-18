<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    // Membuat tabel galeris
    // Menampung data gambar/foto geosite: judul, slug unik, kategori, lokasi, dan relasi geosite
    public function up(): void
    {
        Schema::create('galeris', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('slug')->unique();
            $table->text('deskripsi')->nullable();
            $table->longText('gambar')->nullable(); 
            $table->string('kategori')->nullable();
            $table->string('lokasi')->nullable();
            $table->date('tanggal_foto')->nullable();
            $table->string('geosite')->nullable();
            $table->integer('views')->default(0);
            $table->timestamps();

            $table->foreign('geosite')
                  ->references('geosite')->on('profil_geosites')
                  ->onUpdate('cascade')
                  ->onDelete('set null');
        });
    }

    // Membatalkan migrasi galeri
    // Menghapus tabel galeris dari database
    public function down(): void
    {
        Schema::dropIfExists('galeris');
    }
};
