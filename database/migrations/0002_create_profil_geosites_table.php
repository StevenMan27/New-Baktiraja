<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel profil geosite — menyimpan konten halaman tiap geosite (Bakara, Tipang, Baktiraja)
        Schema::create('profil_geosites', function (Blueprint $table) {
            $table->id();
            $table->string('geosite')->unique(); // contoh: panatapan-bakara

            // Hero Section
            $table->string('judul_utama')->nullable();
            $table->string('sub_judul')->nullable();
            $table->longText('bg_hero')->nullable(); // JSON array gambar latar hero

            // Deskripsi Section 1 (teks saja)
            $table->string('deskripsi_1_judul')->nullable();
            $table->text('deskripsi_1_teks')->nullable();

            // Deskripsi Section 2 (teks + gambar)
            $table->string('deskripsi_2_judul')->nullable();
            $table->text('deskripsi_2_teks')->nullable();
            $table->longText('deskripsi_2_gambar')->nullable(); // JSON

            // Deskripsi Section 3
            $table->string('deskripsi_3_judul')->nullable();
            $table->text('deskripsi_3_teks')->nullable();
            $table->longText('deskripsi_3_gambar')->nullable();

            // Deskripsi Section 4
            $table->string('deskripsi_4_judul')->nullable();
            $table->text('deskripsi_4_teks')->nullable();
            $table->longText('deskripsi_4_gambar')->nullable();

            // Deskripsi Section 5
            $table->string('deskripsi_5_judul')->nullable();
            $table->text('deskripsi_5_teks')->nullable();
            $table->longText('deskripsi_5_gambar')->nullable();

            // Informasi Praktis
            $table->string('info_lokasi')->nullable();
            $table->string('info_jam')->nullable();
            $table->string('info_harga')->nullable();
            $table->json('tags')->nullable(); // Array tag seperti ["Sunrise", "Sunset"]
            $table->text('maps_link')->nullable(); // Kolom untuk URL/Iframe Google Maps

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profil_geosites');
    }
};
