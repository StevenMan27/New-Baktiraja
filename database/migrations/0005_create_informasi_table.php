<?php

/*
   [MIGRATION 0005_create_informasi_table.php]
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
        // [PENJELASAN TABEL INFORMASI]
        // Dipanggil oleh: Dieksekusi sekali oleh perintah 'php artisan migrate' di Terminal.
        // Fungsi: Membangun tabel 'informasi' untuk pengumuman atau info penting (contoh: harga tiket masuk, pengumuman penutupan jalan).
        // Strukturnya mirip berita, namun khusus untuk informasi layanan publik.
        // Digunakan di: Halaman Informasi (/informasi) via InformasiController.
        // ====================================================================================
        // Membuka pendefinisian skema untuk membuat tabel 'informasi'
        Schema::create('informasi', function (Blueprint $table) {
            // Membuat kolom 'id' sebagai Primary Key yang otomatis bertambah
            $table->id();
            // Membuat kolom 'judul' bertipe String dengan panjang maksimum 255 karakter
            $table->string('judul', 255);
            // Membuat kolom 'slug' bertipe String (maks 255 karakter) yang bersifat Unik
            $table->string('slug', 255)->unique();
            // Membuat kolom 'konten' bertipe Long Text untuk menampung isi informasi secara lengkap
            $table->longText('konten');
            // Membuat kolom 'gambar' bertipe Long Text yang boleh kosong untuk JSON array path gambar
            $table->longText('gambar')->nullable(); 
            // Membuat kolom 'geosite' bertipe String yang boleh kosong untuk relasi ke geosite
            $table->string('geosite')->nullable();
            // Membuat kolom 'views' bertipe Unsigned Big Integer dengan nilai awal default 0
            $table->unsignedBigInteger('views')->default(0);
            // Membuat dua kolom otomatis 'created_at' dan 'updated_at' bertipe Timestamp
            $table->timestamps();

            // Foreign Key ke profil_geosites
            // Mendefinisikan kolom 'geosite' sebagai Foreign Key
            $table->foreign('geosite')
            // Merujuk ke kolom 'geosite' pada tabel 'profil_geosites'
                  ->references('geosite')->on('profil_geosites')
            // Mengatur efek ubah pada tabel referensi agar memperbarui tabel ini (cascade)
                  ->onUpdate('cascade')
            // Mengatur efek hapus pada tabel referensi agar menjadikan kolom ini null (set null)
                  ->onDelete('set null');
        // Menutup pendefinisian skema tabel 'informasi'
        });
    }

    public function down(): void
    {
        // Menghapus tabel 'informasi' jika ada saat proses rollback
        Schema::dropIfExists('informasi');
    }
};
