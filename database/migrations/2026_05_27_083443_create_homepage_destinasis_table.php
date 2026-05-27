<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('homepage_destinasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('homepage_id')->constrained()->onDelete('cascade');
            $table->integer('urutan');
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

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('homepage_destinasis');
    }
};
