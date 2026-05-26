<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('profil_geosites', function (Blueprint $table) {
            $table->id();
            $table->string('geosite')->unique(); // cth: panatapan-bakara
            
            // Hero Section
            $table->string('judul_utama')->nullable(); 
            $table->string('sub_judul')->nullable();
            $table->longText('bg_hero')->nullable(); // Gambar latar belakang hero (JSON)
            
            // Sejarah / Deskripsi Section 1
            $table->string('deskripsi_1_judul')->nullable();
            $table->text('deskripsi_1_teks')->nullable();
            
            // Sejarah / Deskripsi Section 2 (Terdapat gambar di sampingnya)
            $table->string('deskripsi_2_judul')->nullable();
            $table->text('deskripsi_2_teks')->nullable();
            $table->longText('deskripsi_2_gambar')->nullable(); // JSON
            
            // Informasi Praktis
            $table->string('info_lokasi')->nullable();
            $table->string('info_jam')->nullable();
            $table->string('info_harga')->nullable();
            $table->json('tags')->nullable(); // Array tags (cth: ["Sunrise", "Sunset"])
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profil_geosites');
    }
};
