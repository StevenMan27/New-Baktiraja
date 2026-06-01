<?php
$dir = __DIR__ . '/resources/views/geosite';
$files = glob($dir . '/*.blade.php');

$search = 'src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d255193.1325813422!2d98.69644291915316!3d2.470043988424604!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x302e0057d16c05ff%3A0xee8ecfd05118386e!2sBakara%2C%20Kec.%20Baktiraja%2C%20Kabupaten%20Humbang%20Hasundutan%2C%20Sumatera%20Utara!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid"';

$replace = 'src="{{ $profil->maps_link ?? \'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d255193.1325813422!2d98.69644291915316!3d2.470043988424604!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x302e0057d16c05ff%3A0xee8ecfd05118386e!2sBakara%2C%20Kec.%20Baktiraja%2C%20Kabupaten%20Humbang%20Hasundutan%2C%20Sumatera%20Utara!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid\' }}"';

$count = 0;
foreach ($files as $file) {
    $content = file_get_contents($file);
    if (strpos($content, $search) !== false) {
        $newContent = str_replace($search, $replace, $content);
        file_put_contents($file, $newContent);
        echo "Patched: " . basename($file) . "\n";
        $count++;
    }
}
echo "Total patched: $count files.\n";
