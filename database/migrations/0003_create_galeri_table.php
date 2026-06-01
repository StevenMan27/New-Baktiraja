<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel galeris — menyimpan foto beserta kategori, lokasi, dan geosite
        Schema::create('galeris', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('slug')->unique();
            $table->text('deskripsi')->nullable();
            $table->longText('gambar')->nullable(); // JSON array path gambar
            $table->string('kategori')->nullable();
            $table->string('lokasi')->nullable();
            $table->date('tanggal_foto')->nullable();
            $table->string('geosite')->nullable();
            $table->integer('views')->default(0);
            $table->timestamps();

            // Foreign Key ke profil_geosites
            $table->foreign('geosite')
                  ->references('geosite')->on('profil_geosites')
                  ->onUpdate('cascade')
                  ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('galeris');
    }
};
