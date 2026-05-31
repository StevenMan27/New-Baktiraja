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
        $tables = ['galeris', 'berita', 'informasi', 'umkm', 'fasilitas', 'penginapan'];
        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $t) {
                if (Schema::hasColumn($t->getTable(), 'status')) {
                    $t->dropColumn('status');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tables = ['galeris', 'berita', 'informasi', 'umkm', 'fasilitas', 'penginapan'];
        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $t) {
                if (!Schema::hasColumn($t->getTable(), 'status')) {
                    $t->boolean('status')->default(true);
                }
            });
        }
    }
};
