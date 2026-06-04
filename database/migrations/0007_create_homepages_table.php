<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel homepages — konten dinamis halaman utama (hero, stats, about, CTA)
        Schema::create('homepages', function (Blueprint $table) {
            $table->id();

            // Hero Section
            $table->string('hero_subtitle')->nullable();
            $table->string('hero_title')->nullable();
            $table->string('hero_slide_1')->nullable();
            $table->string('hero_slide_2')->nullable();
            $table->string('hero_slide_3')->nullable();
            $table->string('hero_slide_4')->nullable();
            $table->string('hero_slide_5')->nullable();
            $table->string('hero_slide_6')->nullable();

            // Statistik
            $table->string('stat_1_num')->nullable();
            $table->string('stat_1_label')->nullable();
            $table->string('stat_2_num')->nullable();
            $table->string('stat_2_label')->nullable();
            $table->string('stat_3_num')->nullable();
            $table->string('stat_3_label')->nullable();
            $table->string('stat_4_num')->nullable();
            $table->string('stat_4_label')->nullable();

            // About Section
            $table->string('about_title')->nullable();
            $table->text('about_text_1')->nullable();
            $table->text('about_text_2')->nullable();
            $table->string('about_video')->nullable();

            // Section Titles
            $table->string('destinasi_title')->nullable();
            $table->string('destinasi_subtitle')->nullable();
            $table->string('maps_title')->nullable();
            $table->string('maps_subtitle')->nullable();

            // CTA Section
            $table->string('cta_title')->nullable();
            $table->text('cta_text')->nullable();
            $table->string('button_link')->nullable();

            // Maps Section
            $table->text('maps_link')->nullable();
            $table->longText('maps_buttons')->nullable();

            $table->timestamps();
        });

        // Tabel destinasi di homepage — kartu destinasi yang tampil di halaman utama
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

    public function down(): void
    {
        Schema::dropIfExists('homepage_destinasis');
        Schema::dropIfExists('homepages');
    }
};
