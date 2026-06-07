<?php

/*
   [MIGRATION 0006_create_umkm_fasilitas_penginapan_table.php]
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
        // [PENJELASAN TABEL UMKM]
        // Dipanggil oleh: Terminal ('php artisan migrate') 1 kali saja.
        // Fungsi: Membuat tabel 'umkm' untuk menyimpan daftar usaha warga lokal (seperti toko suvenir atau kuliner).
        // Relasi: Kolom 'geosite' dikaitkan dengan tabel profil_geosites. Jika profil geosite dihapus, data UMKM terkait akan otomatis menjadi 'null' (set null).
        // Digunakan di: GeositeController, dimunculkan pada Tab UMKM di halaman detail Geosite.
        // ====================================================================================
        // Membuka pendefinisian skema untuk membuat tabel 'umkm'
        Schema::create('umkm', function (Blueprint $table) {
            // Membuat kolom 'id' sebagai Primary Key yang otomatis bertambah
            $table->id();
            // Membuat kolom 'nama' bertipe String dengan panjang maksimal 255 karakter untuk nama UMKM
            $table->string('nama', 255);
            // Membuat kolom 'deskripsi' bertipe Text untuk penjelasan detail tentang UMKM
            $table->text('deskripsi');
            // Membuat kolom 'gambar' bertipe Long Text yang boleh kosong untuk menyimpan path/URL gambar
            $table->longText('gambar')->nullable();
            // Membuat kolom 'lokasi' bertipe String dengan panjang maksimal 255 karakter yang boleh kosong
            $table->string('lokasi', 255)->nullable();
            // Membuat kolom 'kontak' bertipe String dengan panjang maksimal 255 karakter yang boleh kosong
            $table->string('kontak', 255)->nullable();
            // Membuat kolom 'geosite' bertipe String yang boleh kosong untuk relasi ke geosite
            $table->string('geosite')->nullable();
            // Membuat kolom 'created_at' dan 'updated_at' bertipe Timestamp
            $table->timestamps();

            // Mendefinisikan kolom 'geosite' sebagai Foreign Key
            $table->foreign('geosite')
            // Merujuk ke kolom 'geosite' pada tabel 'profil_geosites'
                  ->references('geosite')->on('profil_geosites')
            // Mengatur aturan jika data induk diubah (Cascade)
                  ->onUpdate('cascade')
            // Mengatur aturan jika data induk dihapus (Set Null)
                  ->onDelete('set null');
        // Menutup pendefinisian skema tabel 'umkm'
        });

        // ====================================================================================
        // [PENJELASAN TABEL FASILITAS]
        // Fungsi: Menyimpan daftar fasilitas penunjang wisata (seperti Toilet Umum, Area Parkir, Mushola).
        // Terdapat kolom 'harga' jika fasilitas tersebut berbayar.
        // Digunakan di: GeositeController, dimunculkan pada Tab Fasilitas di halaman detail Geosite.
        // ====================================================================================
        // Membuka pendefinisian skema untuk membuat tabel 'fasilitas'
        Schema::create('fasilitas', function (Blueprint $table) {
            // Membuat kolom 'id' sebagai Primary Key yang otomatis bertambah
            $table->id();
            // Membuat kolom 'nama' bertipe String dengan panjang maksimal 255 karakter untuk nama fasilitas
            $table->string('nama', 255);
            // Membuat kolom 'deskripsi' bertipe Text untuk mendeskripsikan fasilitas tersebut
            $table->text('deskripsi');
            // Membuat kolom 'gambar' bertipe Long Text yang boleh kosong untuk menyimpan path/URL gambar fasilitas
            $table->longText('gambar')->nullable();
            // Membuat kolom 'harga' bertipe String yang boleh kosong untuk menyimpan informasi tarif/harga fasilitas
            $table->string('harga')->nullable();
            // Membuat kolom 'geosite' bertipe String yang boleh kosong untuk relasi ke geosite terkait
            $table->string('geosite')->nullable();
            // Membuat kolom 'created_at' dan 'updated_at' bertipe Timestamp
            $table->timestamps();

            // Mendefinisikan kolom 'geosite' sebagai Foreign Key
            $table->foreign('geosite')
            // Merujuk ke kolom 'geosite' pada tabel 'profil_geosites'
                  ->references('geosite')->on('profil_geosites')
            // Mengatur aturan pembaruan mengikuti data induk (Cascade)
                  ->onUpdate('cascade')
            // Mengatur aturan penghapusan menjadi Null jika data induk terhapus (Set Null)
                  ->onDelete('set null');
        // Menutup pendefinisian skema tabel 'fasilitas'
        });

        // ====================================================================================
        // [PENJELASAN TABEL PENGINAPAN]
        // Fungsi: Mengelola daftar tempat menginap (Hotel, Homestay) di sekitar kawasan.
        // Terdapat kolom 'harga' (estimasi tarif) dan 'kontak' (nomor telepon pemilik penginapan).
        // Digunakan di: GeositeController, dimunculkan pada Tab Penginapan di halaman detail Geosite.
        // ====================================================================================
        // Membuka pendefinisian skema untuk membuat tabel 'penginapan'
        Schema::create('penginapan', function (Blueprint $table) {
            // Membuat kolom 'id' sebagai Primary Key yang otomatis bertambah
            $table->id();
            // Membuat kolom 'nama' bertipe String (maks 255 karakter) untuk nama penginapan
            $table->string('nama', 255);
            // Membuat kolom 'deskripsi' bertipe Text untuk mendeskripsikan detail penginapan
            $table->text('deskripsi');
            // Membuat kolom 'gambar' bertipe Long Text yang boleh kosong untuk menyimpan gambar penginapan
            $table->longText('gambar')->nullable();
            // Membuat kolom 'harga' bertipe String (maks 255 karakter) yang boleh kosong untuk tarif per malam
            $table->string('harga', 255)->nullable();
            // Membuat kolom 'kontak' bertipe String (maks 255 karakter) yang boleh kosong untuk info kontak/telepon
            $table->string('kontak', 255)->nullable();
            // Membuat kolom 'geosite' bertipe String yang boleh kosong untuk relasi lokasi geosite
            $table->string('geosite')->nullable();
            // Membuat kolom 'created_at' dan 'updated_at' bertipe Timestamp
            $table->timestamps();

            // Mendefinisikan kolom 'geosite' sebagai Foreign Key
            $table->foreign('geosite')
            // Merujuk ke kolom 'geosite' pada tabel 'profil_geosites'
                  ->references('geosite')->on('profil_geosites')
            // Memperbarui secara Cascade jika data induk berubah
                  ->onUpdate('cascade')
            // Mengubah menjadi Null secara otomatis jika data induk dihapus
                  ->onDelete('set null');
        // Menutup pendefinisian skema tabel 'penginapan'
        });
    }

    public function down(): void
    {
        // Menghapus tabel 'penginapan' jika ada saat proses rollback
        Schema::dropIfExists('penginapan');
        // Menghapus tabel 'fasilitas' jika ada saat proses rollback
        Schema::dropIfExists('fasilitas');
        // Menghapus tabel 'umkm' jika ada saat proses rollback
        Schema::dropIfExists('umkm');
    }
};
