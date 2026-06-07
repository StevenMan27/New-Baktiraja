<?php

/*
   [MIGRATION 0005_create_informasi_table.php]
   File ini bertugas mendefinisikan struktur, kolom, dan tipe data dari tabel database sebelum dieksekusi (migrate) ke server database sesungguhnya.
*/

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Menjalankan migrasi untuk tabel informasi.
    // Penjelasan detail: Menyiapkan tabel untuk pengumuman atau info penting layanan publik terkait geosite.
    public function up(): void
    {
        // Membuat tabel informasi.
        // Penjelasan detail: Mendefinisikan kolom judul, konten, dan gambar untuk informasi layanan.
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

    // Membatalkan migrasi informasi.
    // Penjelasan detail: Menghapus tabel informasi dari database.
    public function down(): void
    {
        Schema::dropIfExists('informasi');
    }
};
