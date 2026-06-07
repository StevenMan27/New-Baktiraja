<?php

/*
   [MIGRATION 0002_create_profil_geosites_table.php]
   File ini bertugas mendefinisikan struktur, kolom, dan tipe data dari tabel database sebelum dieksekusi (migrate) ke server database sesungguhnya.
*/

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel profil geosite — menyimpan konten halaman tiap geosite (Bakara, Tipang, Baktiraja)
        // Membuka pendefinisian skema untuk membuat tabel 'profil_geosites'
        Schema::create('profil_geosites', function (Blueprint $table) {
            // Membuat kolom 'id' sebagai Primary Key yang otomatis bertambah
            $table->id();
            // Membuat kolom 'geosite' bertipe String yang bersifat Unik (contoh: panatapan-bakara)
            $table->string('geosite')->unique(); 

            // ====================================================================================
            // [PENJELASAN HERO SECTION PROFIL]
            // Dipanggil oleh: Dieksekusi oleh perintah 'php artisan migrate'.
            // Fungsi: Menyiapkan laci di database untuk menyimpan Judul Utama dan kumpulan Gambar Latar Belakang (Slider).
            // Digunakan di: Controller Admin (untuk menyimpan gambar) dan GeositeController (untuk menampilkan di halaman detail geosite masing-masing lokasi).
            // ====================================================================================
            // Hero Section
            // Membuat kolom 'judul_utama' bertipe String yang boleh kosong
            $table->string('judul_utama')->nullable();
            // Membuat kolom 'sub_judul' bertipe String yang boleh kosong
            $table->string('sub_judul')->nullable();
            // Membuat kolom 'bg_hero' bertipe Long Text yang boleh kosong untuk JSON array gambar latar hero
            $table->longText('bg_hero')->nullable(); 

            // ====================================================================================
            // [PENJELASAN DESKRIPSI SECTION (1 SAMPAI 5)]
            // Dipanggil oleh: Dieksekusi oleh perintah 'php artisan migrate'.
            // Fungsi: Membentuk kerangka ruang teks (Text) dan gambar (longText) untuk menampung cerita, legenda, atau panduan wisata yang panjang per geosite. 
            // Tipe data 'longText' dipilih untuk gambar karena gambar akan dikodekan menjadi teks panjang (Base64/JSON Array) agar bisa menampung lebih dari 1 gambar per paragraf.
            // Digunakan di: Dirender sebagai paragraf-paragraf panjang (artikel) di dalam file view 'geosite.blade.php'.
            // ====================================================================================
            // Deskripsi Section 1 (teks saja)
            // Membuat kolom 'deskripsi_1_judul' bertipe String yang boleh kosong
            $table->string('deskripsi_1_judul')->nullable();
            // Membuat kolom 'deskripsi_1_teks' bertipe Text yang boleh kosong
            $table->text('deskripsi_1_teks')->nullable();

            // Deskripsi Section 2 (teks + gambar)
            // Membuat kolom 'deskripsi_2_judul' bertipe String yang boleh kosong
            $table->string('deskripsi_2_judul')->nullable();
            // Membuat kolom 'deskripsi_2_teks' bertipe Text yang boleh kosong
            $table->text('deskripsi_2_teks')->nullable();
            // Membuat kolom 'deskripsi_2_gambar' bertipe Long Text yang boleh kosong (JSON)
            $table->longText('deskripsi_2_gambar')->nullable(); 

            // Deskripsi Section 3
            // Membuat kolom 'deskripsi_3_judul' bertipe String yang boleh kosong
            $table->string('deskripsi_3_judul')->nullable();
            // Membuat kolom 'deskripsi_3_teks' bertipe Text yang boleh kosong
            $table->text('deskripsi_3_teks')->nullable();
            // Membuat kolom 'deskripsi_3_gambar' bertipe Long Text yang boleh kosong
            $table->longText('deskripsi_3_gambar')->nullable();

            // Deskripsi Section 4
            // Membuat kolom 'deskripsi_4_judul' bertipe String yang boleh kosong
            $table->string('deskripsi_4_judul')->nullable();
            // Membuat kolom 'deskripsi_4_teks' bertipe Text yang boleh kosong
            $table->text('deskripsi_4_teks')->nullable();
            // Membuat kolom 'deskripsi_4_gambar' bertipe Long Text yang boleh kosong
            $table->longText('deskripsi_4_gambar')->nullable();

            // Deskripsi Section 5
            // Membuat kolom 'deskripsi_5_judul' bertipe String yang boleh kosong
            $table->string('deskripsi_5_judul')->nullable();
            // Membuat kolom 'deskripsi_5_teks' bertipe Text yang boleh kosong
            $table->text('deskripsi_5_teks')->nullable();
            // Membuat kolom 'deskripsi_5_gambar' bertipe Long Text yang boleh kosong
            $table->longText('deskripsi_5_gambar')->nullable();

            // ====================================================================================
            // [PENJELASAN INFORMASI PRAKTIS & MAPS]
            // Dipanggil oleh: Dieksekusi oleh perintah 'php artisan migrate'.
            // Fungsi: Memisahkan data praktis (seperti Harga Tiket, Jam Buka, URL Google Maps) dari paragraf cerita agar lebih mudah ditampilkan secara khusus (misalnya dalam bentuk kotak info).
            // Digunakan di: Bagian paling bawah atau *sidebar* di tampilan halaman profil Geosite.
            // ====================================================================================
            // Informasi Praktis
            // Membuat kolom 'info_lokasi' bertipe String yang boleh kosong
            $table->string('info_lokasi')->nullable();
            // Membuat kolom 'info_jam' bertipe String yang boleh kosong
            $table->string('info_jam')->nullable();
            // Membuat kolom 'info_harga' bertipe String yang boleh kosong
            $table->string('info_harga')->nullable();
            // Membuat kolom 'tags' bertipe JSON yang boleh kosong untuk array tag seperti ["Sunrise", "Sunset"]
            $table->json('tags')->nullable(); 
            // Membuat kolom 'maps_link' bertipe Text yang boleh kosong untuk URL/Iframe Google Maps
            $table->text('maps_link')->nullable(); 

            // Membuat dua kolom otomatis 'created_at' dan 'updated_at' bertipe Timestamp
            $table->timestamps();
        // Menutup pendefinisian skema tabel 'profil_geosites'
        });
    }

    public function down(): void
    {
        // Menghapus tabel 'profil_geosites' jika ada saat proses rollback
        Schema::dropIfExists('profil_geosites');
    }
};
