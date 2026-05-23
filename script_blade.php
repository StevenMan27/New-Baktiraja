<?php
$ref = file_get_contents('A:/PA111/real/Proyek akhir 1 Real/resources/views/geosite/istana-sisingamangaraja.blade.php');

// Extract CSS
preg_match('/(\.card-location.*?)\.rekomendasi-grid/s', $ref, $m1);
$css = $m1[1];

// Extract Nav desktop
preg_match('/(<a href="#fasilitas".*?<a href="#berita".*?<\/a>\s*)/s', $ref, $m2);
$nav_desktop = $m2[1];

// Extract Nav mobile
preg_match('/(<a href="#fasilitas" class="mobile-link">.*?<a href="#berita" class="mobile-link">.*?<\/a>\s*)/s', $ref, $m3);
$nav_mobile = $m3[1];

// Extract sections
preg_match('/(<!-- UMKM — CRUD Read.*?<!-- BERITA — CRUD Read.*?<\/section>)\s*<section id="rekomendasi"/s', $ref, $m4);
$crud_sections = $m4[1];

$files = [
    'aek-sipangolu.blade.php',
    'aek-sitio-tio.blade.php',
    'air-terjun-janji.blade.php',
    'desa-wisata-tipang.blade.php',
    'gonting.blade.php',
    'panatapan-bakara.blade.php',
    'tombak-sulu-sulu.blade.php'
];

foreach ($files as $f) {
    $p = 'A:/PA111/real/Proyek akhir 1 Real/resources/views/geosite/' . $f;
    if (!file_exists($p)) continue;
    $c = file_get_contents($p);
    
    // Check if already updated
    if (strpos($c, '<!-- UMKM — CRUD Read') !== false) {
        echo "Already updated $f\n";
        continue;
    }
    
    // 1. Inject CSS
    $c = preg_replace('/(\.rekomendasi-grid \{ display: grid)/', $css . "$1", $c);
    
    // 2. Add to media query 992px
    $c = preg_replace('/(\.umkm-grid, \.penginapan-grid)( \{ grid-template-columns: repeat\(2, 1fr\); \})/', "$1, .fasilitas-grid, .berita-grid$2", $c);
    
    // 3. Add to media query 768px
    $c = preg_replace('/(\.umkm-grid, \.penginapan-grid)( \{ grid-template-columns: 1fr; \})/', "$1, .fasilitas-grid, .berita-grid$2\n            .fasilitas-item { flex-direction: column; } .fasilitas-img { width: 100%; height: 180px; }", $c);
    
    // 4. Inject Nav desktop
    $c = preg_replace('/(<a href="#penginapan" class="nav-link">Penginapan<\/a>\s*)/', "$1" . $nav_desktop, $c);
    
    // 5. Inject Nav mobile
    $c = preg_replace('/(<a href="#penginapan" class="mobile-link">Penginapan<\/a>\s*)/', "$1" . $nav_mobile, $c);
    
    // 6. Replace UMKM & Penginapan static with all CRUD sections
    $c = preg_replace('/<section id="umkm".*?<\/section>\s*<section id="penginapan".*?<\/section>\s*(?=<section id="rekomendasi")/s', $crud_sections, $c);
    
    file_put_contents($p, $c);
    echo "Updated $f\n";
}
