<?php

/*
   [MIGRATION 0008_create_kontaks_table.php]
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
        // [PENJELASAN TABEL KONTAK]
        // Dipanggil oleh: Dieksekusi sekali melalui 'php artisan migrate' di Terminal.
        // Fungsi: Merancang satu tabel sentral untuk menampung seluruh informasi kontak, jam operasional, link sosmed, dan Peta Google Maps.
        // Karena ini pengaturan global, biasanya tabel ini hanya akan memiliki SATU baris data saja (id = 1).
        // Digunakan di: Hampir di seluruh web (Footer di app.blade.php mengambil data ini) dan Halaman Kontak (/kontak).
        // ====================================================================================
        // Membuka pendefinisian skema untuk membuat tabel 'kontaks'
        Schema::create('kontaks', function (Blueprint $table) {
            // Membuat kolom 'id' sebagai Primary Key yang otomatis bertambah nilainya
            $table->id();
            // Membuat kolom 'alamat' bertipe Text yang boleh kosong untuk menyimpan teks alamat lengkap
            $table->text('alamat')->nullable();
            // Membuat kolom 'telepon' bertipe Text yang boleh kosong untuk menyimpan nomor kontak/HP
            $table->text('telepon')->nullable();
            // Membuat kolom 'email' bertipe Text yang boleh kosong untuk menyimpan alamat surel resmi
            $table->text('email')->nullable();
            // Membuat kolom 'map_iframe' bertipe Text yang boleh kosong untuk menyimpan kode Iframe Google Maps
            $table->text('map_iframe')->nullable();
            // Membuat kolom 'map_lokasi' bertipe Text yang boleh kosong untuk menyimpan teks deskripsi lokasi di peta
            $table->text('map_lokasi')->nullable();
            // Membuat kolom 'jam_operasional' bertipe Text yang boleh kosong untuk menyimpan jadwal operasional
            $table->text('jam_operasional')->nullable();
            // Membuat kolom 'lokasi_bawah' bertipe Text yang boleh kosong untuk menyimpan teks lokasi alternatif
            $table->text('lokasi_bawah')->nullable();
            // Membuat kolom 'social_fb' bertipe String yang boleh kosong untuk menyimpan URL Facebook
            $table->string('social_fb')->nullable();
            // Membuat kolom 'social_ig' bertipe String yang boleh kosong untuk menyimpan URL Instagram
            $table->string('social_ig')->nullable();
            // Membuat kolom 'social_twitter' bertipe String yang boleh kosong untuk menyimpan URL Twitter (X)
            $table->string('social_twitter')->nullable();
            // Membuat kolom 'social_youtube' bertipe String yang boleh kosong untuk menyimpan URL YouTube
            $table->string('social_youtube')->nullable();
            // Membuat kolom 'social_tiktok' bertipe String yang boleh kosong untuk menyimpan URL TikTok
            $table->string('social_tiktok')->nullable();
            // Membuat dua kolom otomatis 'created_at' dan 'updated_at' bertipe Timestamp untuk mencatat waktu data
            $table->timestamps();
        // Menutup pendefinisian skema tabel 'kontaks'
        });

        // ====================================================================================
        // [PENJELASAN PENGISIAN DATA DEFAULT KONTAK]
        // Fungsi: Fitur DB::table('kontaks')->insert(...) ini akan langsung mengisikan data otomatis tepat setelah tabel diciptakan.
        // Tujuannya agar saat website pertama kali di-install, halaman kontak dan Footer tidak kosong melompong atau error.
        // ====================================================================================
        // Memasukkan (insert) data awal secara langsung ke tabel 'kontaks' menggunakan Query Builder DB
        DB::table('kontaks')->insert([
            // Mengisi field 'alamat' dengan data string awal (default)
            'alamat'           => "Kawasan Wisata Bakara - Tipang - Baktiraja\nKabupaten Humbang Hasundutan\nSumatera Utara, Indonesia",
            // Mengisi field 'telepon' dengan nomor dummy awal
            'telepon'          => "+62 812 3456 7890\n+62 813 9876 5432",
            // Mengisi field 'email' dengan email dummy awal
            'email'            => "info@geotoba.com\nwisata@bakara-tipang.com",
            // Mengisi field 'map_iframe' dengan kode embed iframe Google Maps default
            'map_iframe'       => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d255193.1325813422!2d98.69644291915316!3d2.470043988424604!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x302e0057d16c05ff%3A0xee8ecfd05118386e!2sBakara%2C%20Kec.%20Baktiraja%2C%20Kabupaten%20Humbang%20Hasundutan%2C%20Sumatera%20Utara!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid" allowfullscreen="" loading="lazy"></iframe>',
            // Mengisi field 'map_lokasi' dengan teks nama lokasi
            'map_lokasi'       => "Bakara – Tipang – Baktiraja\nKabupaten Humbang Hasundutan, Sumatera Utara",
            // Mengisi field 'jam_operasional' dengan waktu jam kerja default
            'jam_operasional'  => "Senin - Jumat: 08:00 - 17:00 WIB\nSabtu - Minggu: 08:00 - 18:00 WIB",
            // Mengisi field 'lokasi_bawah' dengan lokasi singkat
            'lokasi_bawah'     => "Bakara – Tipang – Baktiraja\nKabupaten Humbang Hasundutan",
            // Mengisi field 'social_fb' dengan hashtag (#) sebagai tautan kosong (placeholder)
            'social_fb'        => '#',
            // Mengisi field 'social_ig' dengan hashtag (#) sebagai tautan kosong (placeholder)
            'social_ig'        => '#',
            // Mengisi field 'social_twitter' dengan hashtag (#) sebagai tautan kosong (placeholder)
            'social_twitter'   => '#',
            // Mengisi field 'social_youtube' dengan hashtag (#) sebagai tautan kosong (placeholder)
            'social_youtube'   => '#',
            // Mengisi field 'social_tiktok' dengan hashtag (#) sebagai tautan kosong (placeholder)
            'social_tiktok'    => '#',
            // Mengisi field 'created_at' dengan timestamp saat ini menggunakan fungsi now()
            'created_at'       => now(),
            // Mengisi field 'updated_at' dengan timestamp saat ini menggunakan fungsi now()
            'updated_at'       => now(),
        // Menutup instruksi insert array
        ]);
    }

    public function down(): void
    {
        // Menghapus tabel 'kontaks' sepenuhnya jika dijalankan fungsi rollback di terminal
        Schema::dropIfExists('kontaks');
    }
};
