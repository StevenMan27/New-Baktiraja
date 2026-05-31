<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel UMKM — usaha mikro kecil menengah di kawasan geosite
        Schema::create('umkm', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 255);
            $table->text('deskripsi');
            $table->longText('gambar')->nullable();
            $table->string('lokasi', 255)->nullable();
            $table->string('kontak', 255)->nullable();
            $table->string('geosite')->nullable();
            $table->timestamps();
        });

        // Tabel fasilitas — fasilitas wisata yang tersedia di geosite
        Schema::create('fasilitas', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 255);
            $table->text('deskripsi');
            $table->longText('gambar')->nullable();
            $table->string('harga')->nullable();
            $table->string('geosite')->nullable();
            $table->timestamps();
        });

        // Tabel penginapan — pilihan akomodasi di kawasan geosite
        Schema::create('penginapan', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 255);
            $table->text('deskripsi');
            $table->longText('gambar')->nullable();
            $table->string('harga', 255)->nullable();
            $table->string('kontak', 255)->nullable();
            $table->string('geosite')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penginapan');
        Schema::dropIfExists('fasilitas');
        Schema::dropIfExists('umkm');
    }
};
