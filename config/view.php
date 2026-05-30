<?php

use Illuminate\Support\Facades\Env;

return [
    /*
    |--------------------------------------------------------------------------
    | View Storage Paths
    |--------------------------------------------------------------------------
    |
    | Paths that should be checked for your views. Typically you will only
    | have one view path, but the framework supports an array of paths.
    |
    */
    'paths' => [
        resource_path('views'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Compiled View Path
    |--------------------------------------------------------------------------
    |
    | This option determines where all the compiled Blade templates will be
    | stored for your application. Make sure this directory exists and is
    | writable by the web server so Blade can write compiled templates.
    |
    */
    'compiled' => env('VIEW_COMPILED_PATH', realpath(storage_path('framework/views'))),

    'relative_hash' => false,

    'cache' => true,

    'compiled_extension' => 'php',

    'check_cache_timestamps' => true,
];
