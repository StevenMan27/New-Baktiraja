<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class GaleriDatabaseSeeder extends Seeder
{
    public function run()
    {
        $basePath = public_path('image');
        
        if (!File::exists($basePath)) {
            $this->command->error("Folder image tidak ditemukan!");
            return;
        }
        
        // Kosongkan tabel dulu (opsional)
        DB::table('galeris')->truncate();
        
        $allData = [];
        
        // ==================== 1. FOTO DI FOLDER UTAMA (Kawasan Bakara-Tipang-Baktiraja) ====================
        $mainFiles = [
            ['file' => 'about-bakara.jpg', 'judul' => 'About Kawasan Bakara', 'kategori' => 'about'],
            ['file' => 'panatapan-bakara-hero.jpg', 'judul' => 'Panatapan Bakara Hero', 'kategori' => 'panatapan-bakara'],
            ['file' => 'istana-sisingamangaraja.jpg', 'judul' => 'Istana Sisingamangaraja', 'kategori' => 'istana-sisingamangaraja'],
            ['file' => 'berita-bakara.jpg', 'judul' => 'Berita Bakara Tipang Baktiraja', 'kategori' => 'berita'],
            ['file' => 'galeri-bakara.jpg', 'judul' => 'Galeri Bakara Tipang Baktiraja', 'kategori' => 'galeri'],
            ['file' => 'aek-sipangolu-hero.jpg', 'judul' => 'Aek Sipangolu Hero', 'kategori' => 'aek-sipangolu'],
            ['file' => 'gonting-hero.jpg', 'judul' => 'Bukit Gonting Hero', 'kategori' => 'gonting'],
        ];
        
        foreach ($mainFiles as $data) {
            $fullPath = $basePath . '/' . $data['file'];
            if (File::exists($fullPath)) {
                $allData[] = [
                    'judul' => $data['judul'],
                    'deskripsi' => 'Foto ' . $data['kategori'] . ' - Kawasan Wisata Bakara Tipang Baktiraja',
                    'gambar' => 'image/' . $data['file'],
                    'kategori' => $data['kategori'],
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }
        
        // ==================== 2. FOTO DI FOLDER galerihome (Hero Slider Home) ====================
        $galeriHomePath = $basePath . '/galerihome';
        if (File::exists($galeriHomePath)) {
            $galeriHomeFiles = File::files($galeriHomePath);
            foreach ($galeriHomeFiles as $index => $file) {
                $allData[] = [
                    'judul' => 'Hero Slider Bakara ' . ($index + 1),
                    'deskripsi' => 'Foto hero slider untuk halaman home - Kawasan Bakara Tipang Baktiraja',
                    'gambar' => 'image/galerihome/' . $file->getFilename(),
                    'kategori' => 'hero_slider',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }
        
        // ==================== 3. FOTO DI FOLDER bakara (Destinasi Unggulan) ====================
        $bakaraPath = $basePath . '/bakara';
        if (File::exists($bakaraPath)) {
            $destinasiFiles = [
                // Alam
                ['file' => 'air-terjun-janji.jpg', 'judul' => 'Air Terjun Janji', 'kategori' => 'air-terjun-janji'],
                ['file' => 'aek-sitio-tio.jpg', 'judul' => 'Aek Sitio-tio', 'kategori' => 'aek-sitio-tio'],
                ['file' => 'desa-tipang.jpg', 'judul' => 'Desa Wisata Tipang', 'kategori' => 'desa-tipang'],
                // Buatan
                ['file' => 'panatapan-bakara.jpg', 'judul' => 'Panatapan Bakara', 'kategori' => 'panatapan-bakara'],
                ['file' => 'gonting.jpg', 'judul' => 'Bukit Gonting', 'kategori' => 'gonting'],
                // Budaya
                ['file' => 'istana-sisingamangaraja.jpg', 'judul' => 'Istana Sisingamangaraja', 'kategori' => 'istana-sisingamangaraja'],
                ['file' => 'tombak-sulu-sulu.jpg', 'judul' => 'Tombak Sulu-sulu', 'kategori' => 'tombak-sulu-sulu'],
                ['file' => 'aek-sipangolu.jpg', 'judul' => 'Aek Sipangolu', 'kategori' => 'aek-sipangolu'],
                // Detail & Tambahan
                ['file' => 'air-terjun-janji-detail.jpg', 'judul' => 'Detail Air Terjun Janji', 'kategori' => 'air-terjun-janji'],
                ['file' => 'aek-sitio-tio-detail.jpg', 'judul' => 'Detail Aek Sitio-tio', 'kategori' => 'aek-sitio-tio'],
                ['file' => 'panatapan-bakara-sunset.jpg', 'judul' => 'Sunset Panatapan Bakara', 'kategori' => 'panatapan-bakara'],
                ['file' => 'gonting-trekking.jpg', 'judul' => 'Trekking Bukit Gonting', 'kategori' => 'gonting'],
                ['file' => 'istana-sisingamangaraja-detail.jpg', 'judul' => 'Detail Istana Sisingamangaraja', 'kategori' => 'istana-sisingamangaraja'],
                ['file' => 'tombak-sulu-sulu-forest.jpg', 'judul' => 'Hutan Sakral Tombak Sulu-sulu', 'kategori' => 'tombak-sulu-sulu'],
                ['file' => 'aek-sipangolu-detail.jpg', 'judul' => 'Detail Aek Sipangolu', 'kategori' => 'aek-sipangolu'],
                // Hero Slides
                ['file' => 'bakara-slide1.jpg', 'judul' => 'Slide Bakara 1', 'kategori' => 'hero_slider'],
                ['file' => 'bakara-slide2.jpg', 'judul' => 'Slide Bakara 2', 'kategori' => 'hero_slider'],
                ['file' => 'bakara-slide3.jpg', 'judul' => 'Slide Bakara 3', 'kategori' => 'hero_slider'],
                ['file' => 'bakara-slide4.jpg', 'judul' => 'Slide Bakara 4', 'kategori' => 'hero_slider'],
                ['file' => 'bakara-slide5.jpg', 'judul' => 'Slide Bakara 5', 'kategori' => 'hero_slider'],
            ];
            
            foreach ($destinasiFiles as $data) {
                $fullPath = $bakaraPath . '/' . $data['file'];
                if (File::exists($fullPath)) {
                    $allData[] = [
                        'judul' => $data['judul'],
                        'deskripsi' => 'Foto ' . $data['kategori'] . ' - Kawasan Wisata Bakara Tipang Baktiraja',
                        'gambar' => 'image/bakara/' . $data['file'],
                        'kategori' => $data['kategori'],
                        'status' => 1,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
        }
        
        // ==================== 4. FOTO DI FOLDER bakara/galeri (Galeri Tambahan) ====================
        $galeriBakaraPath = $basePath . '/bakara/galeri';
        if (File::exists($galeriBakaraPath)) {
            $galeriBakaraFiles = File::files($galeriBakaraPath);
            foreach ($galeriBakaraFiles as $index => $file) {
                $allData[] = [
                    'judul' => 'Galeri Bakara Tipang Baktiraja ' . ($index + 1),
                    'deskripsi' => 'Dokumentasi wisata kawasan Bakara Tipang Baktiraja ' . ($index + 1),
                    'gambar' => 'image/bakara/galeri/' . $file->getFilename(),
                    'kategori' => 'galeri_bakara',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }
        
        // ==================== 5. FOTO DI FOLDER bakara/penginapan (Homestay & Penginapan) ====================
        $penginapanPath = $basePath . '/bakara/penginapan';
        if (File::exists($penginapanPath)) {
            $penginapanFiles = File::files($penginapanPath);
            foreach ($penginapanFiles as $index => $file) {
                $allData[] = [
                    'judul' => 'Homestay Bakara Tipang ' . ($index + 1),
                    'deskripsi' => 'Akomodasi wisata di kawasan Bakara Tipang Baktiraja',
                    'gambar' => 'image/bakara/penginapan/' . $file->getFilename(),
                    'kategori' => 'penginapan',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }
        
        // ==================== 6. LOGO (Tetap Sama) ====================
        $logoPath = $basePath . '/Logo';
        if (File::exists($logoPath)) {
            $logoFiles = File::files($logoPath);
            foreach ($logoFiles as $index => $file) {
                $allData[] = [
                    'judul' => ($index == 0 ? 'Logo Bank Indonesia' : 'Logo IT Del'),
                    'deskripsi' => 'Logo instansi pendukung',
                    'gambar' => 'image/Logo/' . $file->getFilename(),
                    'kategori' => 'logo',
                    'status' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }
        
        // Masukkan semua data ke database
        foreach ($allData as $data) {
            DB::table('galeris')->insert($data);
        }
        
        $this->command->info("");
        $this->command->info("📊 STATISTIK:");
        $this->command->info("   - Total foto masuk database: " . count($allData));
        $this->command->info("");
        $this->command->info("✅ SELESAI! Galeri untuk kawasan BAKARA – TIPANG – BAKTIRAJA berhasil diimport.");
        
        // Tampilkan rincian per kategori
        $this->command->info("");
        $this->command->info("📁 RINCIAN PER KATEGORI:");
        
        $kategoris = DB::table('galeris')->select('kategori', DB::raw('count(*) as total'))->groupBy('kategori')->get();
        foreach ($kategoris as $kat) {
            $this->command->info("   - " . $kat->kategori . ": " . $kat->total . " foto");
        }
    }
}