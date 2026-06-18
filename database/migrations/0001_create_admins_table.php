<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Membuat tabel autentikasi admin, sesi, dan reset password
    // Menyiapkan infrastruktur login dan manajemen sesi pengguna
    public function up(): void
    {
        // Membuat tabel admins
        // Menyimpan kredensial login admin: nama, email, dan password
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        // Membuat tabel sessions
        // Menyimpan data sesi login beserta informasi IP dan browser pengguna
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        // Membuat tabel password_resets
        // Menyimpan token sementara untuk fitur lupa kata sandi
        Schema::create('password_resets', function (Blueprint $table) {
            $table->string('email')->index();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
    }

    // Membatalkan migrasi autentikasi
    // Menghapus tabel password_resets, sessions, dan admins dari database
    public function down(): void
    {
        Schema::dropIfExists('password_resets');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('admins');
    }
};
