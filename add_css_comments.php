<?php

/**
 * Script to clean up and add comments to CSS files and internal <style> blocks.
 */

$cssComment = "/* Mengatur gaya tampilan halaman */\n/* Memberikan styling visual untuk antarmuka pengguna */\n";

// 1. Process CSS files
$cssDirs = [
    __DIR__ . '/public/css',
    __DIR__ . '/resources/css'
];

foreach ($cssDirs as $dir) {
    if (!is_dir($dir)) continue;
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
    foreach ($iterator as $file) {
        if ($file->getExtension() === 'css') {
            $path = $file->getPathname();
            $content = file_get_contents($path);
            
            // Remove existing block comments /* ... */
            // Using a simple regex, but careful with URLs or strings.
            // A standard regex for removing C-style comments:
            $content = preg_replace('!/\*.*?\*/!s', '', $content);
            
            // Clean up multiple empty lines
            $content = preg_replace('/(\r?\n){3,}/', "\n\n", trim($content));
            
            // Add the new comment at the top
            $newContent = $cssComment . "\n" . $content;
            
            file_put_contents($path, $newContent);
            echo "Updated CSS: " . basename($path) . "\n";
        }
    }
}

// 2. Process Blade files for <style> tags
$bladeDir = __DIR__ . '/resources/views';
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($bladeDir));
foreach ($iterator as $file) {
    if (strpos($file->getPathname(), '.blade.php') !== false) {
        $path = $file->getPathname();
        $content = file_get_contents($path);
        
        $changed = false;
        
        // Find <style> tags
        $content = preg_replace_callback('/(<style[^>]*>)(.*?)(<\/style>)/is', function($matches) use ($cssComment) {
            $openTag = $matches[1];
            $innerStyle = $matches[2];
            $closeTag = $matches[3];
            
            // Remove existing block comments /* ... */
            $innerStyle = preg_replace('!/\*.*?\*/!s', '', $innerStyle);
            
            // Clean up whitespace
            $innerStyle = preg_replace('/(\r?\n){3,}/', "\n\n", trim($innerStyle));
            
            // Put everything back together with the comment right after the <style> tag
            return $openTag . "\n" . "    " . str_replace("\n", "\n    ", $cssComment) . "\n    " . $innerStyle . "\n" . $closeTag;
        }, $content, -1, $count);
        
        if ($count > 0) {
            file_put_contents($path, $content);
            echo "Updated Internal CSS in: " . basename($path) . "\n";
        }
    }
}

echo "Selesai memperbarui CSS.\n";
