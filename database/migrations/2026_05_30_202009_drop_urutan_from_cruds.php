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
        Schema::table('informasi', function (Blueprint $table) {
            $table->dropColumn('urutan');
        });
        Schema::table('umkm', function (Blueprint $table) {
            $table->dropColumn('urutan');
        });
        Schema::table('fasilitas', function (Blueprint $table) {
            $table->dropColumn('urutan');
        });
        Schema::table('penginapan', function (Blueprint $table) {
            $table->dropColumn('urutan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('informasi', function (Blueprint $table) {
            $table->integer('urutan')->default(0);
        });
        Schema::table('umkm', function (Blueprint $table) {
            $table->integer('urutan')->default(0);
        });
        Schema::table('fasilitas', function (Blueprint $table) {
            $table->integer('urutan')->default(0);
        });
        Schema::table('penginapan', function (Blueprint $table) {
            $table->integer('urutan')->default(0);
        });
    }
};
