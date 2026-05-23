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
        Schema::create('koleksi_fotos', function (Blueprint $table) {
            $table->id();
            $table->string('nama_foto');
            // Gunakan binary() karena longBinary() tidak ada di Laravel
            $table->binary('file_foto'); 
            $table->timestamps();
        });

        // Paksa kolom menjadi LONGBLOB lewat SQL mentah agar bisa menampung foto besar
        DB::statement("ALTER TABLE koleksi_fotos MODIFY file_foto LONGBLOB");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('koleksi_fotos');
    }
};