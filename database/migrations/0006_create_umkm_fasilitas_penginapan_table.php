<?php

/*
   [MIGRATION 0006_create_umkm_fasilitas_penginapan_table.php]
   File ini bertugas mendefinisikan struktur, kolom, dan tipe data dari tabel database sebelum dieksekusi (migrate) ke server database sesungguhnya.
*/

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Menjalankan migrasi untuk data penunjang wisata.
    // Penjelasan detail: Membuat tabel umkm, fasilitas, dan penginapan yang berelasi dengan geosite terkait.
    public function up(): void
    {
        // Membuat tabel umkm.
        // Penjelasan detail: Menyimpan daftar usaha warga lokal beserta deskripsi dan kontaknya.
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

        // Membuat tabel fasilitas.
        // Penjelasan detail: Menyimpan daftar fasilitas penunjang wisata beserta informasi tarifnya jika ada.
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

        // Membuat tabel penginapan.
        // Penjelasan detail: Mengelola daftar tempat menginap, estimasi tarif, dan kontak pengelola.
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

    // Membatalkan migrasi tabel penunjang.
    // Penjelasan detail: Menghapus tabel penginapan, fasilitas, dan umkm jika migrasi dibatalkan.
    public function down(): void
    {
        Schema::dropIfExists('penginapan');
        Schema::dropIfExists('fasilitas');
        Schema::dropIfExists('umkm');
    }
};
