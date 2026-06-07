<?php

/*
   [MIGRATION 0003_create_galeri_table.php]
   File ini bertugas mendefinisikan struktur, kolom, dan tipe data dari tabel database sebelum dieksekusi (migrate) ke server database sesungguhnya.
*/

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // ====================================================================================
        // [PENJELASAN TABEL GALERI]
        // Dipanggil oleh: Dieksekusi sekali oleh perintah 'php artisan migrate' di Terminal.
        // Fungsi: Membuat tabel 'galeris' untuk menampung gambar-gambar dokumentasi kegiatan atau pemandangan.
        // Kolom 'kategori' memisahkan foto alam, buatan, atau budaya. Kolom 'geosite' menandakan lokasi asal foto.
        // Digunakan di: Ditampilkan di halaman utama Galeri (/galeri) menggunakan GaleriController, dan juga diselipkan di halaman detail geosite.
        // ====================================================================================
        // Membuka pendefinisian skema untuk membuat tabel 'galeris'
        Schema::create('galeris', function (Blueprint $table) {
            // Membuat kolom 'id' sebagai Primary Key yang otomatis bertambah
            $table->id();
            // Membuat kolom 'judul' bertipe String untuk judul gambar
            $table->string('judul');
            // Membuat kolom 'slug' bertipe String yang bersifat Unik untuk URL SEO-friendly
            $table->string('slug')->unique();
            // Membuat kolom 'deskripsi' bertipe Text yang boleh kosong
            $table->text('deskripsi')->nullable();
            // Membuat kolom 'gambar' bertipe Long Text yang boleh kosong untuk JSON array path gambar
            $table->longText('gambar')->nullable(); 
            // Membuat kolom 'kategori' bertipe String yang boleh kosong untuk kategori foto
            $table->string('kategori')->nullable();
            // Membuat kolom 'lokasi' bertipe String yang boleh kosong untuk detail lokasi
            $table->string('lokasi')->nullable();
            // Membuat kolom 'tanggal_foto' bertipe Date yang boleh kosong
            $table->date('tanggal_foto')->nullable();
            // Membuat kolom 'geosite' bertipe String yang boleh kosong untuk relasi ke geosite
            $table->string('geosite')->nullable();
            // Membuat kolom 'views' bertipe Integer dengan nilai default 0 untuk mencatat jumlah tayangan
            $table->integer('views')->default(0);
            // Membuat kolom 'created_at' dan 'updated_at' bertipe Timestamp
            $table->timestamps();

            // Foreign Key ke profil_geosites
            // Mendefinisikan kolom 'geosite' sebagai Foreign Key
            $table->foreign('geosite')
            // Merujuk ke kolom 'geosite' pada tabel 'profil_geosites'
                  ->references('geosite')->on('profil_geosites')
            // Memperbarui data terkait jika data master berubah (cascade)
                  ->onUpdate('cascade')
            // Mengubah menjadi null jika data master dihapus
                  ->onDelete('set null');
        // Menutup pendefinisian skema tabel 'galeris'
        });
    }

    public function down(): void
    {
        // Menghapus tabel 'galeris' jika ada saat proses rollback
        Schema::dropIfExists('galeris');
    }
};
