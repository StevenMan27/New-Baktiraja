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
        Schema::table('galeris', function (Blueprint $table) {
            // SQLite tidak mendukung dropColumn via ALTER TABLE — lewati jika bukan MySQL
            if (Schema::hasColumn('galeris', 'kategori') && \DB::getDriverName() === 'mysql') {
                $table->dropColumn('kategori');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('galeris', function (Blueprint $table) {
            $table->string('kategori', 100)->nullable();
        });
    }
};
