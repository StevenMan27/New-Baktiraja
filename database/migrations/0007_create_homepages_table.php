<?php

/*
   [MIGRATION 0007_create_homepages_table.php]
   File ini bertugas mendefinisikan struktur, kolom, dan tipe data dari tabel database sebelum dieksekusi (migrate) ke server database sesungguhnya.
*/

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Menjalankan migrasi untuk konten beranda.
    // Penjelasan detail: Menyiapkan tabel homepages dan homepage_destinasis untuk mengatur tampilan halaman utama.
    public function up(): void
    {
        // Membuat tabel homepages.
        // Penjelasan detail: Menyimpan konten hero section, statistik, tentang kami, dan peta untuk halaman utama.
        Schema::create('homepages', function (Blueprint $table) {
            $table->id();

            $table->string('hero_subtitle')->nullable();
            $table->string('hero_title')->nullable();
            $table->string('hero_slide_1')->nullable();
            $table->string('hero_slide_2')->nullable();
            $table->string('hero_slide_3')->nullable();
            $table->string('hero_slide_4')->nullable();
            $table->string('hero_slide_5')->nullable();
            $table->string('hero_slide_6')->nullable();

            $table->string('stat_1_num')->nullable();
            $table->string('stat_1_label')->nullable();
            $table->string('stat_2_num')->nullable();
            $table->string('stat_2_label')->nullable();
            $table->string('stat_3_num')->nullable();
            $table->string('stat_3_label')->nullable();
            $table->string('stat_4_num')->nullable();
            $table->string('stat_4_label')->nullable();

            $table->string('about_title')->nullable();
            $table->text('about_text_1')->nullable();
            $table->text('about_text_2')->nullable();
            $table->string('about_video')->nullable();

            $table->string('destinasi_title')->nullable();
            $table->string('destinasi_subtitle')->nullable();
            $table->string('maps_title')->nullable();
            $table->string('maps_subtitle')->nullable();

            $table->string('cta_title')->nullable();
            $table->text('cta_text')->nullable();
            $table->string('button_link')->nullable();

            $table->text('maps_link')->nullable();
            $table->longText('maps_buttons')->nullable();

            $table->timestamps();
        });

        // Membuat tabel homepage_destinasis.
        // Penjelasan detail: Menyimpan kartu rekomendasi destinasi khusus yang akan muncul di halaman utama.
        Schema::create('homepage_destinasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('homepage_id')->constrained()->onDelete('cascade');

            $table->string('gambar')->nullable();
            $table->string('nomor_teks')->nullable();
            $table->string('judul')->nullable();
            $table->string('lokasi')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('tags')->nullable();
            $table->string('link')->nullable();
            $table->timestamps();
        });
    }

    // Membatalkan migrasi konten beranda.
    // Penjelasan detail: Menghapus tabel homepage_destinasis dan homepages dari database.
    public function down(): void
    {
        Schema::dropIfExists('homepage_destinasis');
        Schema::dropIfExists('homepages');
    }
};
