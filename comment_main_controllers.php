<?php

$controllers = glob('a:/PA111/real/New folder/Proyek akhir 1 Real/app/Http/Controllers/*.php');
foreach ($controllers as $m) {
    $c = file_get_contents($m);
    $name = basename($m, '.php');
    if (!str_contains($c, '[CONTROLLER ')) {
        $comment = "\n    /*\n       [CONTROLLER $name]\n       File ini bertugas mengontrol logika aplikasi untuk bagian publik dari $name.\n       Berfungsi mengambil data dari Model dan melemparkannya ke file View yang sesuai.\n       Tabel Database yang digunakan: menyesuaikan dengan fungsi yang dipanggil.\n    */";
        $c = preg_replace('/class\s+'.$name.'\s+extends\s+Controller\s*\{/s', 'class '.$name.' extends Controller {'.$comment, $c);
        file_put_contents($m, $c);
        echo "Updated Controller $name\n";
    }
}
