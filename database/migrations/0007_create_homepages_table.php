<?php

/*
   [MIGRATION 0007_create_homepages_table.php]
   File ini bertugas mendefinisikan struktur, kolom, dan tipe data dari tabel database sebelum dieksekusi (migrate) ke server database sesungguhnya.
*/

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel homepages — konten dinamis halaman utama (hero, stats, about, CTA)
        // Membuka pendefinisian skema untuk membuat tabel 'homepages'
        Schema::create('homepages', function (Blueprint $table) {
            // Membuat kolom 'id' sebagai Primary Key yang otomatis bertambah
            $table->id();

            // ====================================================================================
            // [PENJELASAN HERO SECTION BERANDA]
            // Dipanggil oleh: Terminal dengan perintah 'php artisan migrate' HANYA SATU KALI.
            // Fungsi: Merancang struktur database (kolom) untuk menampung teks Subtitle, Title, dan 6 Gambar Latar (Slide 1-6). 
            // Tipe 'nullable()' berarti jika Admin belum mengunggah 6 gambar utuh, web tidak akan error (hanya menampilkan gambar yang ada).
            // Digunakan di: Model Homepage akan mengambil data ini lalu melemparnya ke HomeController, dan akhirnya dimunculkan pada banner besar beranimasi di halaman utama (Beranda).
            // ====================================================================================
            // Hero Section
            // Membuat kolom 'hero_subtitle' bertipe String yang boleh kosong untuk subjudul hero
            $table->string('hero_subtitle')->nullable();
            // Membuat kolom 'hero_title' bertipe String yang boleh kosong untuk judul utama hero
            $table->string('hero_title')->nullable();
            // Membuat kolom 'hero_slide_1' bertipe String yang boleh kosong untuk gambar slide pertama
            $table->string('hero_slide_1')->nullable();
            // Membuat kolom 'hero_slide_2' bertipe String yang boleh kosong untuk gambar slide kedua
            $table->string('hero_slide_2')->nullable();
            // Membuat kolom 'hero_slide_3' bertipe String yang boleh kosong untuk gambar slide ketiga
            $table->string('hero_slide_3')->nullable();
            // Membuat kolom 'hero_slide_4' bertipe String yang boleh kosong untuk gambar slide keempat
            $table->string('hero_slide_4')->nullable();
            // Membuat kolom 'hero_slide_5' bertipe String yang boleh kosong untuk gambar slide kelima
            $table->string('hero_slide_5')->nullable();
            // Membuat kolom 'hero_slide_6' bertipe String yang boleh kosong untuk gambar slide keenam
            $table->string('hero_slide_6')->nullable();

            // ====================================================================================
            // [PENJELASAN STATISTIK SECTION]
            // Fungsi: Menyimpan angka dan label untuk ditampilkan pada 4 kotak pencapaian (misalnya "10+ Destinasi", "1000+ Pengunjung").
            // Digunakan di: Halaman Beranda (home.blade.php) pada bagian tengah yang menonjolkan fitur/statistik kawasan GeoToba.
            // ====================================================================================
            // Statistik
            // Membuat kolom 'stat_1_num' bertipe String yang boleh kosong untuk angka statistik ke-1
            $table->string('stat_1_num')->nullable();
            // Membuat kolom 'stat_1_label' bertipe String yang boleh kosong untuk label statistik ke-1
            $table->string('stat_1_label')->nullable();
            // Membuat kolom 'stat_2_num' bertipe String yang boleh kosong untuk angka statistik ke-2
            $table->string('stat_2_num')->nullable();
            // Membuat kolom 'stat_2_label' bertipe String yang boleh kosong untuk label statistik ke-2
            $table->string('stat_2_label')->nullable();
            // Membuat kolom 'stat_3_num' bertipe String yang boleh kosong untuk angka statistik ke-3
            $table->string('stat_3_num')->nullable();
            // Membuat kolom 'stat_3_label' bertipe String yang boleh kosong untuk label statistik ke-3
            $table->string('stat_3_label')->nullable();
            // Membuat kolom 'stat_4_num' bertipe String yang boleh kosong untuk angka statistik ke-4
            $table->string('stat_4_num')->nullable();
            // Membuat kolom 'stat_4_label' bertipe String yang boleh kosong untuk label statistik ke-4
            $table->string('stat_4_label')->nullable();

            // ====================================================================================
            // [PENJELASAN ABOUT (TENTANG KAMI)]
            // Fungsi: Menyimpan paragraf "Tentang Kami" beserta link/file video YouTube jika ada.
            // Tipe data 'text' digunakan untuk teks panjang karena 'string' hanya memuat maksimal 255 karakter.
            // Digunakan di: Beranda (home.blade.php) pada segmen deskripsi singkat setelah Hero Banner.
            // ====================================================================================
            // About Section
            // Membuat kolom 'about_title' bertipe String yang boleh kosong untuk judul bagian about
            $table->string('about_title')->nullable();
            // Membuat kolom 'about_text_1' bertipe Text yang boleh kosong untuk paragraf pertama about
            $table->text('about_text_1')->nullable();
            // Membuat kolom 'about_text_2' bertipe Text yang boleh kosong untuk paragraf kedua about
            $table->text('about_text_2')->nullable();
            // Membuat kolom 'about_video' bertipe String yang boleh kosong untuk link video profil
            $table->string('about_video')->nullable();

            // Section Titles
            // Membuat kolom 'destinasi_title' bertipe String yang boleh kosong untuk judul bagian destinasi
            $table->string('destinasi_title')->nullable();
            // Membuat kolom 'destinasi_subtitle' bertipe String yang boleh kosong untuk subjudul destinasi
            $table->string('destinasi_subtitle')->nullable();
            // Membuat kolom 'maps_title' bertipe String yang boleh kosong untuk judul bagian peta
            $table->string('maps_title')->nullable();
            // Membuat kolom 'maps_subtitle' bertipe String yang boleh kosong untuk subjudul bagian peta
            $table->string('maps_subtitle')->nullable();

            // CTA Section
            // Membuat kolom 'cta_title' bertipe String yang boleh kosong untuk judul Call to Action (CTA)
            $table->string('cta_title')->nullable();
            // Membuat kolom 'cta_text' bertipe Text yang boleh kosong untuk teks CTA
            $table->text('cta_text')->nullable();
            // Membuat kolom 'button_link' bertipe String yang boleh kosong untuk URL tombol CTA
            $table->string('button_link')->nullable();

            // Maps Section
            // Membuat kolom 'maps_link' bertipe Text yang boleh kosong untuk menampung iframe peta/URL
            $table->text('maps_link')->nullable();
            // Membuat kolom 'maps_buttons' bertipe Long Text yang boleh kosong untuk menampung kode tombol navigasi peta
            $table->longText('maps_buttons')->nullable();

            // Membuat dua kolom otomatis 'created_at' dan 'updated_at' bertipe Timestamp
            $table->timestamps();
        // Menutup pendefinisian skema tabel 'homepages'
        });

        // ====================================================================================
        // [PENJELASAN TABEL DESTINASI HIGHLIGHT BERANDA]
        // Dipanggil oleh: Terminal ('php artisan migrate').
        // Fungsi: Membuat tabel terpisah bernama 'homepage_destinasis'. Tabel ini berfungsi untuk menyimpan rekomendasi destinasi khusus yang dimunculkan di Beranda.
        // Relasi: foreignId('homepage_id') mengikat data destinasi ini dengan data Homepage utama.
        // Digunakan di: Ditampilkan sebagai barisan kartu (Card) destinasi unggulan di bagian bawah halaman Beranda.
        // ====================================================================================
        // Tabel destinasi di homepage — kartu destinasi yang tampil di halaman utama
        // Membuka pendefinisian skema untuk membuat tabel 'homepage_destinasis'
        Schema::create('homepage_destinasis', function (Blueprint $table) {
            // Membuat kolom 'id' sebagai Primary Key yang otomatis bertambah
            $table->id();
            // Membuat kolom 'homepage_id' sebagai Foreign Key yang terhubung ke tabel homepages dengan aturan hapus beruntun (Cascade)
            $table->foreignId('homepage_id')->constrained()->onDelete('cascade');

            // Membuat kolom 'gambar' bertipe String yang boleh kosong untuk menyimpan nama/path gambar destinasi
            $table->string('gambar')->nullable();
            // Membuat kolom 'nomor_teks' bertipe String yang boleh kosong untuk menampung teks penomoran
            $table->string('nomor_teks')->nullable();
            // Membuat kolom 'judul' bertipe String yang boleh kosong untuk menampung nama/judul destinasi
            $table->string('judul')->nullable();
            // Membuat kolom 'lokasi' bertipe String yang boleh kosong untuk menampung informasi area destinasi
            $table->string('lokasi')->nullable();
            // Membuat kolom 'deskripsi' bertipe Text yang boleh kosong untuk menampung teks penjabaran destinasi
            $table->text('deskripsi')->nullable();
            // Membuat kolom 'tags' bertipe String yang boleh kosong untuk menyimpan kategori/tag (misalnya: #Alam)
            $table->string('tags')->nullable();
            // Membuat kolom 'link' bertipe String yang boleh kosong untuk URL tautan jika di-klik
            $table->string('link')->nullable();
            // Membuat dua kolom otomatis 'created_at' dan 'updated_at' bertipe Timestamp
            $table->timestamps();
        // Menutup pendefinisian skema tabel 'homepage_destinasis'
        });
    }

    public function down(): void
    {
        // Menghapus tabel 'homepage_destinasis' jika ada saat proses rollback (migrasi mundur)
        Schema::dropIfExists('homepage_destinasis');
        // Menghapus tabel 'homepages' jika ada saat proses rollback (migrasi mundur)
        Schema::dropIfExists('homepages');
    }
};
