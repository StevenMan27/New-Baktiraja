<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Membuat tabel profil_geosites
    // Menampung konten profil detail tiap geosite: hero, deskripsi, info praktis, dan peta
    public function up(): void
    {
        Schema::create('profil_geosites', function (Blueprint $table) {
            $table->id();
            $table->string('geosite')->unique(); 

            $table->string('judul_utama')->nullable();
            $table->string('sub_judul')->nullable();
            $table->longText('bg_hero')->nullable(); 

            $table->string('deskripsi_1_judul')->nullable();
            $table->text('deskripsi_1_teks')->nullable();

            $table->string('deskripsi_2_judul')->nullable();
            $table->text('deskripsi_2_teks')->nullable();
            $table->longText('deskripsi_2_gambar')->nullable(); 

            $table->string('deskripsi_3_judul')->nullable();
            $table->text('deskripsi_3_teks')->nullable();
            $table->longText('deskripsi_3_gambar')->nullable();

            $table->string('deskripsi_4_judul')->nullable();
            $table->text('deskripsi_4_teks')->nullable();
            $table->longText('deskripsi_4_gambar')->nullable();

            $table->string('deskripsi_5_judul')->nullable();
            $table->text('deskripsi_5_teks')->nullable();
            $table->longText('deskripsi_5_gambar')->nullable();

            $table->string('info_lokasi')->nullable();
            $table->string('info_jam')->nullable();
            $table->string('info_harga')->nullable();
            $table->json('tags')->nullable(); 
            $table->text('maps_link')->nullable(); 

            $table->timestamps();
        });
    }

    // Membatalkan migrasi profil geosites
    // Menghapus tabel profil_geosites beserta seluruh datanya
    public function down(): void
    {
        Schema::dropIfExists('profil_geosites');
    }
};
