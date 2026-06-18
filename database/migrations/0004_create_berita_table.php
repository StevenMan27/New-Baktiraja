<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Membuat tabel berita
    // Menyimpan artikel berita: judul, slug, konten, gambar, penulis, views, dan relasi geosite
    public function up(): void
    {
        Schema::create('berita', function (Blueprint $table) {
            $table->id();
            $table->string('judul', 255);
            $table->string('slug', 255)->unique();
            $table->longText('konten');
            $table->longText('gambar')->nullable(); 
            $table->string('penulis', 100)->nullable();
            $table->integer('views')->default(0);
            $table->string('geosite')->nullable();
            $table->timestamps();

            $table->foreign('geosite')
                  ->references('geosite')->on('profil_geosites')
                  ->onUpdate('cascade')
                  ->onDelete('set null');
        });
    }

    // Membatalkan migrasi berita
    // Menghapus tabel berita dari database
    public function down(): void
    {
        Schema::dropIfExists('berita');
    }
};
