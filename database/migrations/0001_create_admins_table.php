<?php

/*
   [MIGRATION 0001_create_admins_table.php]
   File ini bertugas mendefinisikan struktur, kolom, dan tipe data dari tabel database sebelum dieksekusi (migrate) ke server database sesungguhnya.
*/

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ====================================================================================
        // [PENJELASAN TABEL ADMINS (AUTENTIKASI)]
        // Dipanggil oleh: File ini hanya dieksekusi sekali oleh perintah 'php artisan migrate' di Terminal.
        // Fungsi: Membangun fondasi (tabel 'admins') di database MySQL untuk menyimpan data kredensial login.
        // Digunakan di: Aplikasi menggunakan tabel ini saat memproses fitur Login. Saat Anda mengetikkan email & password, Controller Auth akan mencocokkannya dengan baris di tabel ini.
        // ====================================================================================
        // Membuka pendefinisian skema untuk membuat tabel 'admins'
        Schema::create('admins', function (Blueprint $table) {
            // Membuat kolom 'id' sebagai Primary Key yang otomatis bertambah nilainya (Auto Increment)
            $table->id();
            // Membuat kolom 'name' bertipe String (Varchar) untuk menyimpan nama admin
            $table->string('name');
            // Membuat kolom 'email' bertipe String yang bersifat Unik agar tidak ada email ganda
            $table->string('email')->unique();
            // Membuat kolom 'email_verified_at' bertipe Timestamp yang boleh kosong (Nullable) untuk menyimpan waktu verifikasi email
            $table->timestamp('email_verified_at')->nullable();
            // Membuat kolom 'password' bertipe String untuk menyimpan kata sandi yang telah di-hash (enkripsi)
            $table->string('password');
            // Membuat kolom 'remember_token' bertipe String untuk mendukung fitur 'Ingat Saya' (Remember Me) saat login
            $table->rememberToken();
            // Membuat dua kolom otomatis 'created_at' dan 'updated_at' bertipe Timestamp untuk mencatat waktu data dibuat dan diubah
            $table->timestamps();
        // Menutup pendefinisian skema tabel 'admins'
        });

        // Tabel sesi login
        // Membuka pendefinisian skema untuk membuat tabel 'sessions'
        Schema::create('sessions', function (Blueprint $table) {
            // Membuat kolom 'id' bertipe String sebagai Primary Key untuk ID Sesi
            $table->string('id')->primary();
            // Membuat kolom 'user_id' sebagai Foreign Key yang boleh kosong dan di-index, merujuk ke tabel pengguna/admin
            $table->foreignId('user_id')->nullable()->index();
            // Membuat kolom 'ip_address' bertipe String dengan panjang maksimum 45 karakter yang boleh kosong untuk alamat IP
            $table->string('ip_address', 45)->nullable();
            // Membuat kolom 'user_agent' bertipe Text yang boleh kosong untuk menyimpan informasi browser yang digunakan
            $table->text('user_agent')->nullable();
            // Membuat kolom 'payload' bertipe Long Text untuk menampung data sesi yang dikodekan (serialize)
            $table->longText('payload');
            // Membuat kolom 'last_activity' bertipe Integer dan di-index untuk mencatat stempel waktu aktivitas terakhir pengguna
            $table->integer('last_activity')->index();
        // Menutup pendefinisian skema tabel 'sessions'
        });

        // Tabel reset password
        // Membuka pendefinisian skema untuk membuat tabel 'password_resets'
        Schema::create('password_resets', function (Blueprint $table) {
            // Membuat kolom 'email' bertipe String dan di-index untuk pencarian cepat alamat email
            $table->string('email')->index();
            // Membuat kolom 'token' bertipe String untuk menyimpan kode rahasia (token) reset kata sandi
            $table->string('token');
            // Membuat kolom 'created_at' bertipe Timestamp yang boleh kosong untuk mencatat kapan token reset dibuat
            $table->timestamp('created_at')->nullable();
        // Menutup pendefinisian skema tabel 'password_resets'
        });
    }

    public function down(): void
    {
        // Menghapus tabel 'password_resets' jika tabel tersebut ada di database (fungsi rollback)
        Schema::dropIfExists('password_resets');
        // Menghapus tabel 'sessions' jika tabel tersebut ada di database (fungsi rollback)
        Schema::dropIfExists('sessions');
        // Menghapus tabel 'admins' jika tabel tersebut ada di database (fungsi rollback)
        Schema::dropIfExists('admins');
    }
};
