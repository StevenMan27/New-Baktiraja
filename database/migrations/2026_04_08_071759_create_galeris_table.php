<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // Tambahkan ini

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('galeris', function (Blueprint $table) {
            $table->id();
            $table->string('judul', 255);
            $table->string('kategori', 100);
            $table->text('deskripsi')->nullable();
            
            // GANTI BAGIAN INI:
            // Kita gunakan DB statement agar benar-benar jadi LONGBLOB di MySQL
            $table->timestamps();
            $table->string('lokasi', 255)->nullable();
            $table->date('tanggal_foto')->nullable();
            $table->boolean('status')->default(true);
            
            $table->index('kategori');
            $table->index('status');
        });

        // Tambahkan kolom gambar secara spesifik sebagai LONGBLOB
        DB::statement("ALTER TABLE galeris ADD gambar LONGBLOB AFTER deskripsi");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('galeris');
    }
};