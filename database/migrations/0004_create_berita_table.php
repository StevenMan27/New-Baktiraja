<?php

/*
   [MIGRATION 0004_create_berita_table.php]
   File ini bertugas mendefinisikan struktur, kolom, dan tipe data dari tabel database sebelum dieksekusi (migrate) ke server database sesungguhnya.
*/

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Menjalankan migrasi untuk tabel berita.
    // Penjelasan detail: Menyiapkan database untuk menyimpan konten artikel dan berita seputar kawasan.
    public function up(): void
    {
        // Membuat tabel berita.
        // Penjelasan detail: Mendefinisikan kolom judul, konten, gambar, penulis, serta relasi geosite.
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

    // Membatalkan migrasi berita.
    // Penjelasan detail: Menghapus tabel berita dari database.
    public function down(): void
    {
        Schema::dropIfExists('berita');
    }
};
