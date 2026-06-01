<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

try {
    DB::statement('ALTER TABLE homepages ADD COLUMN maps_link TEXT NULL AFTER maps_subtitle');
    echo "homepages success.\n";
} catch (\Exception $e) {
    echo "homepages error: " . $e->getMessage() . "\n";
}

try {
    DB::statement('ALTER TABLE profil_geosites ADD COLUMN maps_link TEXT NULL AFTER tags');
    echo "profil_geosites success.\n";
} catch (\Exception $e) {
    echo "profil_geosites error: " . $e->getMessage() . "\n";
}
