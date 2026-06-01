<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Baris Bahasa Validasi
    |--------------------------------------------------------------------------
    |
    | Baris bahasa berikut ini berisi standar pesan kesalahan yang digunakan oleh
    | kelas validasi. Beberapa aturan mempunyai banyak versi seperti aturan 'size'.
    | Jangan ragu untuk mengoptimalkan setiap pesan di sini.
    |
    */

    'accepted'             => ':attribute harus diterima.',
    'accepted_if'          => ':attribute harus diterima ketika :other adalah :value.',
    'active_url'           => ':attribute bukan URL yang valid.',
    'after'                => ':attribute harus berisi tanggal setelah :date.',
    'after_or_equal'       => ':attribute harus berisi tanggal setelah atau sama dengan :date.',
    'alpha'                => ':attribute hanya boleh berisi huruf.',
    'alpha_dash'           => ':attribute hanya boleh berisi huruf, angka, strip, dan garis bawah.',
    'alpha_num'            => ':attribute hanya boleh berisi huruf dan angka.',
    'array'                => ':attribute harus berisi sebuah array.',
    'ascii'                => ':attribute hanya boleh berisi karakter alfanumerik dan simbol single-byte.',
    'before'               => ':attribute harus berisi tanggal sebelum :date.',
    'before_or_equal'      => ':attribute harus berisi tanggal sebelum atau sama dengan :date.',
    'between'              => [
        'array'   => ':attribute harus memiliki :min sampai :max anggota.',
        'file'    => ':attribute harus berukuran antara :min sampai :max kilobita.',
        'numeric' => ':attribute harus bernilai antara :min sampai :max.',
        'string'  => ':attribute harus berisi antara :min sampai :max karakter.',
    ],
    'boolean'              => ':attribute harus bernilai true atau false',
    'can'                  => 'Kolom :attribute memuat nilai yang tidak sah.',
    'confirmed'            => 'Konfirmasi :attribute tidak cocok.',
    'contains'             => 'Kolom :attribute kekurangan nilai wajib.',
    'current_password'     => 'Kata sandi salah.',
    'date'                 => ':attribute bukan tanggal yang valid.',
    'date_equals'          => ':attribute harus berisi tanggal yang sama dengan :date.',
    'date_format'          => ':attribute tidak cocok dengan format :format.',
    'decimal'              => ':attribute harus memiliki :decimal tempat desimal.',
    'declined'             => ':attribute harus ditolak.',
    'declined_if'          => ':attribute harus ditolak ketika :other adalah :value.',
    'different'            => ':attribute dan :other harus berbeda.',
    'digits'               => ':attribute harus terdiri dari :digits angka.',
    'digits_between'       => ':attribute harus terdiri dari :min sampai :max angka.',
    'dimensions'           => ':attribute tidak memiliki dimensi gambar yang valid.',
    'distinct'             => ':attribute memiliki nilai yang duplikat.',
    'doesnt_end_with'      => ':attribute tidak boleh diakhiri dengan salah satu dari berikut ini: :values.',
    'doesnt_start_with'    => ':attribute tidak boleh dimulai dengan salah satu dari berikut ini: :values.',
    'email'                => ':attribute harus berupa alamat surel yang valid.',
    'ends_with'            => ':attribute harus diakhiri salah satu dari berikut: :values',
    'enum'                 => ':attribute yang dipilih tidak valid.',
    'exists'               => ':attribute yang dipilih tidak valid.',
    'extensions'           => 'Kolom :attribute harus memiliki salah satu ekstensi berikut: :values.',
    'file'                 => ':attribute harus berupa sebuah berkas.',
    'filled'               => ':attribute harus memiliki nilai.',
    'gt'                   => [
        'array'   => ':attribute harus memiliki lebih dari :value anggota.',
        'file'    => ':attribute harus berukuran lebih besar dari :value kilobita.',
        'numeric' => ':attribute harus bernilai lebih besar dari :value.',
        'string'  => ':attribute harus berisi lebih besar dari :value karakter.',
    ],
    'gte'                  => [
        'array'   => ':attribute harus terdiri dari :value anggota atau lebih.',
        'file'    => ':attribute harus berukuran lebih besar dari atau sama dengan :value kilobita.',
        'numeric' => ':attribute harus bernilai lebih besar dari atau sama dengan :value.',
        'string'  => ':attribute harus berisi lebih besar dari atau sama dengan :value karakter.',
    ],
    'hex_color'            => 'Kolom :attribute harus berupa warna heksadesimal yang valid.',
    'image'                => 'Format file :attribute salah, harus berupa gambar.',
    'in'                   => ':attribute yang dipilih tidak valid.',
    'in_array'             => ':attribute tidak ada di dalam :other.',
    'integer'              => ':attribute harus berupa bilangan bulat.',
    'ip'                   => ':attribute harus berupa alamat IP yang valid.',
    'ipv4'                 => ':attribute harus berupa alamat IPv4 yang valid.',
    'ipv6'                 => ':attribute harus berupa alamat IPv6 yang valid.',
    'json'                 => ':attribute harus berupa string JSON yang valid.',
    'list'                 => 'Kolom :attribute harus berupa daftar.',
    'lowercase'            => ':attribute harus berupa huruf kecil.',
    'lt'                   => [
        'array'   => ':attribute harus memiliki kurang dari :value anggota.',
        'file'    => ':attribute harus berukuran kurang dari :value kilobita.',
        'numeric' => ':attribute harus bernilai kurang dari :value.',
        'string'  => ':attribute harus berisi kurang dari :value karakter.',
    ],
    'lte'                  => [
        'array'   => ':attribute harus tidak lebih dari :value anggota.',
        'file'    => ':attribute harus berukuran kurang dari atau sama dengan :value kilobita.',
        'numeric' => ':attribute harus bernilai kurang dari atau sama dengan :value.',
        'string'  => ':attribute harus berisi kurang dari atau sama dengan :value karakter.',
    ],
    'mac_address'          => ':attribute harus berupa alamat MAC yang valid.',
    'max'                  => [
        'array'   => ':attribute maksimal terdiri dari :max anggota.',
        'file'    => 'Ukuran :attribute maksimal :max kilobyte.',
        'numeric' => ':attribute maksimal bernilai :max.',
        'string'  => ':attribute maksimal berisi :max karakter.',
    ],
    'max_digits'           => ':attribute tidak boleh memiliki lebih dari :max digit.',
    'mimes'                => 'Format :attribute harus berupa file dengan tipe: :values.',
    'mimetypes'            => ':attribute harus berupa berkas berjenis: :values.',
    'min'                  => [
        'array'   => ':attribute minimal terdiri dari :min anggota.',
        'file'    => ':attribute minimal berukuran :min kilobita.',
        'numeric' => ':attribute minimal bernilai :min.',
        'string'  => ':attribute minimal berisi :min karakter.',
    ],
    'min_digits'           => ':attribute tidak boleh memiliki kurang dari :min digit.',
    'missing'              => 'Kolom :attribute harus hilang.',
    'missing_if'           => 'Kolom :attribute harus hilang saat :other bernilai :value.',
    'missing_unless'       => 'Kolom :attribute harus hilang kecuali :other bernilai :value.',
    'missing_with'         => 'Kolom :attribute harus hilang saat terdapat :values.',
    'missing_with_all'     => 'Kolom :attribute harus hilang saat terdapat :values.',
    'multiple_of'          => ':attribute harus merupakan kelipatan dari :value',
    'not_in'               => ':attribute yang dipilih tidak valid.',
    'not_regex'            => 'Format :attribute tidak valid.',
    'numeric'              => ':attribute harus berupa angka.',
    'password'             => [
        'letters'       => ':attribute ini harus memiliki setidaknya satu karakter.',
        'mixed'         => ':attribute ini harus memiliki setidaknya satu huruf kapital dan satu huruf kecil.',
        'numbers'       => ':attribute ini harus memiliki setidaknya satu angka.',
        'symbols'       => ':attribute ini harus memiliki setidaknya satu simbol.',
        'uncompromised' => ':attribute ini telah muncul di kebocoran data. Tolong pilih :attribute yang berbeda.',
    ],
    'present'              => ':attribute wajib ada.',
    'present_if'           => 'Kolom :attribute wajib ada bila :other adalah :value.',
    'present_unless'       => 'Kolom :attribute wajib ada kecuali :other adalah :value.',
    'present_with'         => 'Kolom :attribute wajib ada bila ada :values.',
    'present_with_all'     => 'Kolom :attribute wajib ada bila ada :values.',
    'prohibited'           => ':attribute tidak boleh ada.',
    'prohibited_if'        => ':attribute tidak boleh ada bila :other adalah :value.',
    'prohibited_unless'    => ':attribute tidak boleh ada kecuali :other memiliki nilai :values.',
    'prohibits'            => ':attribute melarang :other untuk hadir.',
    'regex'                => 'Format :attribute tidak valid.',
    'required'             => 'Kolom :attribute wajib diisi.',
    'required_array_keys'  => ':attribute wajib berisi entri untuk: :values.',
    'required_if'          => 'Kolom :attribute wajib diisi bila :other adalah :value.',
    'required_if_accepted' => 'Kolom :attribute wajib diisi bila :other diterima.',
    'required_if_declined' => 'Kolom :attribute wajib diisi ketika :other ditolak.',
    'required_unless'      => 'Kolom :attribute wajib diisi kecuali :other memiliki nilai :values.',
    'required_with'        => 'Kolom :attribute wajib diisi bila terdapat :values.',
    'required_with_all'    => 'Kolom :attribute wajib diisi bila terdapat :values.',
    'required_without'     => 'Kolom :attribute wajib diisi bila tidak terdapat :values.',
    'required_without_all' => 'Kolom :attribute wajib diisi bila sama sekali tidak terdapat :values.',
    'same'                 => ':attribute dan :other harus sama.',
    'size'                 => [
        'array'   => ':attribute harus mengandung :size anggota.',
        'file'    => ':attribute harus berukuran :size kilobyte.',
        'numeric' => ':attribute harus berukuran :size.',
        'string'  => ':attribute harus berukuran :size karakter.',
    ],
    'starts_with'          => ':attribute harus diawali salah satu dari berikut: :values',
    'string'               => ':attribute harus berupa string.',
    'timezone'             => ':attribute harus berisi zona waktu yang valid.',
    'unique'               => ':attribute sudah ada sebelumnya.',
    'uploaded'             => ':attribute gagal diunggah.',
    'uppercase'            => ':attribute harus berupa huruf kapital.',
    'url'                  => 'Format :attribute tidak valid.',
    'ulid'                 => ':attribute harus merupakan ULID yang valid.',
    'uuid'                 => ':attribute harus merupakan UUID yang valid.',

    /*
    |--------------------------------------------------------------------------
    | Baris Bahasa Validasi Kustom
    |--------------------------------------------------------------------------
    |
    | Di sini Anda dapat menentukan pesan validasi kustom untuk atribut dengan menggunakan
    | konvensi "attribute.rule" untuk memberi nama baris. Ini mempercepat penentuan
    | baris bahasa kustom yang spesifik untuk aturan atribut yang diberikan.
    |
    */

    'custom' => [
        'gambar' => [
            'image' => 'Format file yang diunggah harus berupa gambar (JPG, PNG, WEBP).',
            'mimes' => 'Gambar harus memiliki salah satu format berikut: jpeg, png, jpg, webp.',
            'max'   => 'Ukuran gambar maksimal adalah 10MB (10240 KB).',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Atribut Validasi Kustom
    |--------------------------------------------------------------------------
    |
    | Baris bahasa berikut digunakan untuk menukar placeholder atribut kami
    | dengan sesuatu yang lebih ramah pembaca seperti "Alamat Surel" sebagai
    | ganti "email". Ini hanya membantu kita membuat pesan sedikit lebih bersih.
    |
    */

    'attributes' => [
        'nama' => 'Nama',
        'judul' => 'Judul',
        'deskripsi' => 'Deskripsi',
        'gambar' => 'Gambar',
        'lokasi' => 'Lokasi',
        'tanggal' => 'Tanggal',
        'geosite' => 'Geosite',
        'harga' => 'Harga',
        'kontak' => 'Kontak',
    ],

];
