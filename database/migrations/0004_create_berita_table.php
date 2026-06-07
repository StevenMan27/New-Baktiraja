<?php

/*
   [MIGRATION 0004_create_berita_table.php]
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
        // [PENJELASAN TABEL BERITA]
        // Dipanggil oleh: Dieksekusi sekali oleh perintah 'php artisan migrate' di Terminal.
        // Fungsi: Menyediakan ruang database untuk artikel/berita (seperti judul, isi konten, penulis, dan jumlah views).
        // Kolom 'slug' digunakan agar URL berita menjadi ramah SEO (misal: /berita/festival-danau-toba).
        // Digunakan di: Halaman Berita (/berita) yang dikontrol oleh BeritaController.
        // ====================================================================================
        // Membuka pendefinisian skema untuk membuat tabel 'berita'
        Schema::create('berita', function (Blueprint $table) {
            // Membuat kolom 'id' sebagai Primary Key yang otomatis bertambah
            $table->id();
            // Membuat kolom 'judul' bertipe String dengan panjang maksimum 255 karakter
            $table->string('judul', 255);
            // Membuat kolom 'slug' bertipe String (maks 255 karakter) yang bersifat Unik
            $table->string('slug', 255)->unique();
            // Membuat kolom 'konten' bertipe Long Text untuk menampung isi berita secara lengkap
            $table->longText('konten');
            // Membuat kolom 'gambar' bertipe Long Text yang boleh kosong untuk JSON array path gambar
            $table->longText('gambar')->nullable(); 
            // Membuat kolom 'penulis' bertipe String (maks 100 karakter) yang boleh kosong
            $table->string('penulis', 100)->nullable();
            // Membuat kolom 'views' bertipe Integer dengan nilai awal default 0
            $table->integer('views')->default(0);
            // Membuat kolom 'geosite' bertipe String yang boleh kosong untuk relasi ke geosite
            $table->string('geosite')->nullable();
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
        // Menutup pendefinisian skema tabel 'berita'
        });
    }

    public function down(): void
    {
        // Menghapus tabel 'berita' jika ada saat proses rollback (migrasi mundur)
        Schema::dropIfExists('berita');
    }
};
