<?php
$dir = __DIR__ . '/resources/views/geosite';
$files = glob($dir . '/*.blade.php');

$search1 = "asset('image/Logo/bendera.png')";
$replace1 = "asset('image/Logo/logobankindonesia.jpg')";

$search2 = "asset('image/Logo/del.png')";
$replace2 = "asset('image/Logo/del.jpg')";

$count = 0;
foreach ($files as $file) {
    $content = file_get_contents($file);
    $changed = false;
    
    if (strpos($content, $search1) !== false) {
        $content = str_replace($search1, $replace1, $content);
        $changed = true;
    }
    
    if (strpos($content, $search2) !== false) {
        $content = str_replace($search2, $replace2, $content);
        $changed = true;
    }
    
    if ($changed) {
        file_put_contents($file, $content);
        echo "Patched logo in: " . basename($file) . "\n";
        $count++;
    }
}
echo "Total patched: $count files.\n";
