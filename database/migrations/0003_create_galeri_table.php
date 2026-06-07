<?php

/*
   [MIGRATION 0003_create_galeri_table.php]
   File ini bertugas mendefinisikan struktur, kolom, dan tipe data dari tabel database sebelum dieksekusi (migrate) ke server database sesungguhnya.
*/

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    // Menjalankan migrasi untuk tabel galeri.
    // Penjelasan detail: Menyiapkan tabel galeris guna menampung data gambar dan foto dari berbagai geosite.
    public function up(): void
    {
        // Membuat tabel galeris.
        // Penjelasan detail: Mendefinisikan kolom untuk menyimpan judul, deskripsi, path gambar, kategori, serta relasi ke profil geosite.
        Schema::create('galeris', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('slug')->unique();
            $table->text('deskripsi')->nullable();
            $table->longText('gambar')->nullable(); 
            $table->string('kategori')->nullable();
            $table->string('lokasi')->nullable();
            $table->date('tanggal_foto')->nullable();
            $table->string('geosite')->nullable();
            $table->integer('views')->default(0);
            $table->timestamps();

            $table->foreign('geosite')
                  ->references('geosite')->on('profil_geosites')
                  ->onUpdate('cascade')
                  ->onDelete('set null');
        });
    }

    // Membatalkan migrasi galeri.
    // Penjelasan detail: Menghapus tabel galeris dari database jika diperlukan.
    public function down(): void
    {
        Schema::dropIfExists('galeris');
    }
};
