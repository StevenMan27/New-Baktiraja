<?php
$dir = __DIR__ . '/resources/views/geosite';
$files = glob($dir . '/*.blade.php');

$search1 = 'alt="Bendera"';
$replace1 = 'alt="Bank Indonesia"';

$search2 = 'alt="Del"';
$replace2 = 'alt="Logo Del"';

foreach ($files as $file) {
    $content = file_get_contents($file);
    $content = str_replace($search1, $replace1, $content);
    $content = str_replace($search2, $replace2, $content);
    file_put_contents($file, $content);
}
echo "Alt texts updated.\n";
