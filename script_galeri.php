<?php

$files = [
    'istana-sisingamangaraja.blade.php',
    'aek-sipangolu.blade.php',
    'aek-sitio-tio.blade.php',
    'air-terjun-janji.blade.php',
    'desa-wisata-tipang.blade.php',
    'gonting.blade.php',
    'panatapan-bakara.blade.php',
    'tombak-sulu-sulu.blade.php'
];

$insert = <<<HTML
<div class="galeri-grid" id="galeriGrid">
    @forelse(\$galeri as \$item)
    <div class="galeri-item" onclick="openLightbox('{{ \$item->gambar && !str_starts_with(\$item->gambar, 'data:') ? asset('storage/' . \$item->gambar) : \$item->gambar }}')">
        <img src="{{ \$item->gambar && !str_starts_with(\$item->gambar, 'data:') ? asset('storage/' . \$item->gambar) : \$item->gambar }}" alt="{{ \$item->judul }}">
    </div>
    @empty
    <div style="grid-column:1/-1;text-align:center;padding:2rem;color:#888;">
        <p>Belum ada foto galeri untuk geosite ini.</p>
    </div>
    @endforelse
</div>
HTML;

foreach ($files as $f) {
    $p = 'A:/PA111/real/Proyek akhir 1 Real/resources/views/geosite/' . $f;
    if (!file_exists($p)) continue;
    $c = file_get_contents($p);
    
    // Check if already updated
    if (strpos($c, '@forelse($galeri') !== false) {
        echo "Already updated $f\n";
        continue;
    }
    
    $c = preg_replace('/<div class="galeri-grid" id="galeriGrid">.*?<\/div>(\s*<\/div>\s*<\/section>)/is', $insert . "$1", $c);
    
    file_put_contents($p, $c);
    echo "Updated $f\n";
}
