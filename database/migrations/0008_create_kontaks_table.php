<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel kontaks — informasi kontak dan media sosial yang dapat dikelola admin
        Schema::create('kontaks', function (Blueprint $table) {
            $table->id();
            $table->text('alamat')->nullable();
            $table->text('telepon')->nullable();
            $table->text('email')->nullable();
            $table->text('map_iframe')->nullable();
            $table->text('map_lokasi')->nullable();
            $table->text('jam_operasional')->nullable();
            $table->text('lokasi_bawah')->nullable();
            $table->string('social_fb')->nullable();
            $table->string('social_ig')->nullable();
            $table->string('social_twitter')->nullable();
            $table->string('social_youtube')->nullable();
            $table->string('social_tiktok')->nullable();
            $table->timestamps();
        });

        // Data default agar halaman kontak tidak kosong saat pertama dijalankan
        DB::table('kontaks')->insert([
            'alamat'           => "Kawasan Wisata Bakara - Tipang - Baktiraja\nKabupaten Humbang Hasundutan\nSumatera Utara, Indonesia",
            'telepon'          => "+62 812 3456 7890\n+62 813 9876 5432",
            'email'            => "info@geotoba.com\nwisata@bakara-tipang.com",
            'map_iframe'       => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d255193.1325813422!2d98.69644291915316!3d2.470043988424604!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x302e0057d16c05ff%3A0xee8ecfd05118386e!2sBakara%2C%20Kec.%20Baktiraja%2C%20Kabupaten%20Humbang%20Hasundutan%2C%20Sumatera%20Utara!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid" allowfullscreen="" loading="lazy"></iframe>',
            'map_lokasi'       => "Bakara – Tipang – Baktiraja\nKabupaten Humbang Hasundutan, Sumatera Utara",
            'jam_operasional'  => "Senin - Jumat: 08:00 - 17:00 WIB\nSabtu - Minggu: 08:00 - 18:00 WIB",
            'lokasi_bawah'     => "Bakara – Tipang – Baktiraja\nKabupaten Humbang Hasundutan",
            'social_fb'        => '#',
            'social_ig'        => '#',
            'social_twitter'   => '#',
            'social_youtube'   => '#',
            'social_tiktok'    => '#',
            'created_at'       => now(),
            'updated_at'       => now(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('kontaks');
    }
};
