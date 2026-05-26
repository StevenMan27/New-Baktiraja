<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$tables = [
    'users', 'berita', 'informasi', 'galeris', 
    'fasilitas', 'penginapan', 'umkm', 'destinasis', 'kategori', 'koleksi_fotos'
];

foreach ($tables as $table) {
    if (\Illuminate\Support\Facades\Schema::hasTable($table)) {
        echo "TABLE: $table\n";
        $columns = \Illuminate\Support\Facades\Schema::getColumns($table);
        foreach ($columns as $column) {
            $pk = $column['name'] === 'id' ? ' (PK)' : '';
            echo "- {$column['name']} : {$column['type_name']}{$pk}\n";
        }
        echo "\n";
    }
}
