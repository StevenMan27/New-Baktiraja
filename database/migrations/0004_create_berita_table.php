<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel berita — artikel berita dengan penulis, views, dan geosite
        Schema::create('berita', function (Blueprint $table) {
            $table->id();
            $table->string('judul', 255);
            $table->string('slug', 255)->unique();
            $table->longText('konten');
            $table->longText('gambar')->nullable(); // JSON array path gambar
            $table->string('penulis', 100)->nullable();
            $table->integer('views')->default(0);
            $table->string('geosite')->nullable();
            $table->timestamps();

            // Foreign Key ke profil_geosites
            $table->foreign('geosite')
                  ->references('geosite')->on('profil_geosites')
                  ->onUpdate('cascade')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('berita');
    }
};
