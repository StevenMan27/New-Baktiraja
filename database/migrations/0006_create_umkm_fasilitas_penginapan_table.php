<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Membuat tabel umkm, fasilitas, dan penginapan
    // Menyimpan data penunjang wisata yang berelasi ke profil geosite
    public function up(): void
    {
        // Membuat tabel umkm
        // Menyimpan daftar usaha lokal beserta deskripsi, lokasi, dan kontak
        Schema::create('umkm', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 255);
            $table->text('deskripsi');
            $table->longText('gambar')->nullable();
            $table->string('lokasi', 255)->nullable();
            $table->string('kontak', 255)->nullable();
            $table->string('geosite')->nullable();
            $table->timestamps();

            $table->foreign('geosite')
                  ->references('geosite')->on('profil_geosites')
                  ->onUpdate('cascade')
                  ->onDelete('set null');
        });

        // Membuat tabel fasilitas
        // Menyimpan daftar fasilitas wisata beserta informasi tarif jika ada
        Schema::create('fasilitas', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 255);
            $table->text('deskripsi');
            $table->longText('gambar')->nullable();
            $table->string('harga')->nullable();
            $table->string('geosite')->nullable();
            $table->timestamps();

            $table->foreign('geosite')
                  ->references('geosite')->on('profil_geosites')
                  ->onUpdate('cascade')
                  ->onDelete('set null');
        });

        // Membuat tabel penginapan
        // Menyimpan daftar tempat menginap, estimasi tarif, dan kontak pengelola
        Schema::create('penginapan', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 255);
            $table->text('deskripsi');
            $table->longText('gambar')->nullable();
            $table->string('harga', 255)->nullable();
            $table->string('kontak', 255)->nullable();
            $table->string('geosite')->nullable();
            $table->timestamps();

            $table->foreign('geosite')
                  ->references('geosite')->on('profil_geosites')
                  ->onUpdate('cascade')
                  ->onDelete('set null');
        });
    }

    // Membatalkan migrasi tabel penunjang wisata
    // Menghapus tabel penginapan, fasilitas, dan umkm secara berurutan
    public function down(): void
    {
        Schema::dropIfExists('penginapan');
        Schema::dropIfExists('fasilitas');
        Schema::dropIfExists('umkm');
    }
};
