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
        Schema::table('profil_geosites', function (Blueprint $table) {
            $table->string('deskripsi_3_judul')->nullable()->after('deskripsi_2_gambar');
            $table->text('deskripsi_3_teks')->nullable()->after('deskripsi_3_judul');
            $table->longText('deskripsi_3_gambar')->nullable()->after('deskripsi_3_teks');
            
            $table->string('deskripsi_4_judul')->nullable()->after('deskripsi_3_gambar');
            $table->text('deskripsi_4_teks')->nullable()->after('deskripsi_4_judul');
            $table->longText('deskripsi_4_gambar')->nullable()->after('deskripsi_4_teks');
            
            $table->string('deskripsi_5_judul')->nullable()->after('deskripsi_4_gambar');
            $table->text('deskripsi_5_teks')->nullable()->after('deskripsi_5_judul');
            $table->longText('deskripsi_5_gambar')->nullable()->after('deskripsi_5_teks');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profil_geosites', function (Blueprint $table) {
            $table->dropColumn([
                'deskripsi_3_judul', 'deskripsi_3_teks', 'deskripsi_3_gambar',
                'deskripsi_4_judul', 'deskripsi_4_teks', 'deskripsi_4_gambar',
                'deskripsi_5_judul', 'deskripsi_5_teks', 'deskripsi_5_gambar'
            ]);
        });
    }
};
