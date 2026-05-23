<?php
$files = [
    'umkm/create.blade.php',
    'umkm/edit.blade.php',
    'penginapan/create.blade.php',
    'penginapan/edit.blade.php',
    'fasilitas/create.blade.php',
    'fasilitas/edit.blade.php',
    'berita/create.blade.php',
    'berita/edit.blade.php'
];

$insert = <<<HTML

            <div class="mb-3">
                <label>Pilih Geosite</label>
                <select name="geosite" class="form-control" required>
                    <option value="">-- Pilih Geosite --</option>
                    @foreach(\$geositeList as \$slug => \$label)
                        <option value="{{ \$slug }}" {{ (isset(\$data) && \$data->geosite == \$slug) || (isset(\$berita) && \$berita->geosite == \$slug) ? 'selected' : '' }}>{{ \$label }}</option>
                    @endforeach
                </select>
            </div>
HTML;

foreach ($files as $f) {
    $p = 'A:/PA111/real/Proyek akhir 1 Real/resources/views/admin/' . $f;
    if (!file_exists($p)) continue;
    
    $c = file_get_contents($p);
    // Remove if already inserted in umkm/create
    if (strpos($c, 'name="geosite"') !== false && $f !== 'umkm/create.blade.php') {
        echo "Already in $f\n";
        continue;
    }
    
    if ($f === 'umkm/create.blade.php') {
        // I already inserted it there using tool, let me just fix the selected attribute logic just in case, though it's create so no selected needed. I'll just skip it.
        continue;
    }
    
    $c = preg_replace('/(<input type="text" name="(?:nama|judul)" class="form-control".*?>\s*<\/div>)/is', "$1$insert", $c);
    file_put_contents($p, $c);
    echo "Updated $p\n";
}
