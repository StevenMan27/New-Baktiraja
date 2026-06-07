<?php

// Menentukan namespace untuk memisahkan pengorganisasian kode dalam project
namespace App\Http\Controllers;

// Mengimpor kelas Request agar bisa mengelola inputan request HTTP dari user
use Illuminate\Http\Request;

// Deklarasi kelas DestinasiController yang mewarisi sifat class Controller bawaan Laravel
class DestinasiController extends Controller {
    /*
       [CONTROLLER DestinasiController]
       File ini bertugas mengontrol logika aplikasi untuk bagian publik dari DestinasiController.
       Berfungsi mengambil data dari Model dan melemparkannya ke file View yang sesuai.
       Tabel Database yang digunakan: menyesuaikan dengan fungsi yang dipanggil.
    */
    // ==================== HALAMAN UTAMA DESTINASI ====================
    // Method index untuk mengatur rute utama pada menu destinasi
    public function index()
    {
        // Mengembalikan view 'destinasi.index' ke browser pengguna
        return view('destinasi.index');
    }
    
    // ==================== DESTINASI ALAM ====================
    // Method alam untuk memuat daftar seluruh destinasi wisata kategori alam
    public function alam()
    {
        // Mendeklarasikan variabel string kategori bernilai 'Alam'
        $kategori = 'Alam';
        // Menyimpan teks deskripsi singkat untuk halaman kategori destinasi alam
        $deskripsi = 'Destinasi wisata alam di kawasan Bakara, Tipang, dan Baktiraja yang menampilkan keindahan air terjun, mata air jernih, dan desa wisata yang asri.';
        
        // Membuka pendefinisian array destinasi alam
        $destinasi = [
            // Membuat elemen array pertama berupa objek standar berisi data destinasi
            (object)[
                // Menyimpan ID unik
                'id' => 1,
                // Menyimpan slug unik untuk link URL
                'slug' => 'air-terjun-janji',
                // Menyimpan kategori secara spesifik
                'kategori' => 'alam',
                // Menyimpan nama destinasi
                'nama' => 'Air Terjun Janji',
                // Menyimpan lokasi destinasi
                'lokasi' => 'Baktiraja, Kab. Humbang Hasundutan',
                // Menyimpan deskripsi lengkap destinasi
                'deskripsi' => 'Air terjun deras dengan kolam alami kebiruan. Terdapat mitos lokal tentang "janji alam" bagi yang berenang di kolamnya.',
                // Menyimpan path gambar destinasi
                'gambar' => 'image/bakara/air-terjun-janji.jpg',
                // Menyimpan tag array untuk destinasi ini
                'tags' => ['Air Terjun', 'Mitos Lokal', 'Kolam Alami', 'Refreshing'],
                // Menyimpan URL absolut internal aplikasi
                'url' => '/destinasi/alam/air-terjun-janji'
            ],
            // Membuat elemen array kedua berupa objek standar
            (object)[
                // Menyimpan ID unik
                'id' => 2,
                // Menyimpan slug destinasi
                'slug' => 'aek-sitio-tio',
                // Menyimpan string kategori
                'kategori' => 'alam',
                // Menyimpan nama destinasi
                'nama' => 'Aek Sitio-tio',
                // Menyimpan lokasi spesifik destinasi
                'lokasi' => 'Tipang, Kecamatan Baktiraja',
                // Menyimpan detail deskripsi destinasi
                'deskripsi' => 'Mata air pegunungan yang jernih dan tidak pernah surut. Airnya sangat segar dan konon membawa keberuntungan.',
                // Menyimpan gambar cover
                'gambar' => 'image/bakara/aek-sitio-tio.jpg',
                // Menyimpan tag array terkait
                'tags' => ['Mata Air', 'Air Jernih', 'Penyegaran', 'Alam'],
                // Menyimpan string path URL terkait
                'url' => '/destinasi/alam/aek-sitio-tio'
            ],
            // Membuat elemen array ketiga berupa objek standar
            (object)[
                // Menyimpan nilai identitas ID unik
                'id' => 3,
                // Menyimpan string slug untuk URL parameternya
                'slug' => 'desa-wisata-tipang',
                // Menyimpan tipe kategori destinasi
                'kategori' => 'alam',
                // Menyimpan nama dari destinasi tersebut
                'nama' => 'Desa Wisata Tipang',
                // Menyimpan nama daerah lokasi destinasi
                'lokasi' => 'Tipang, Kecamatan Baktiraja',
                // Menyimpan deskripsi destinasi selengkapnya
                'deskripsi' => 'Desa wisata yang menawarkan pengalaman hidup bersama masyarakat Batak dengan pemandangan Danau Toba yang indah.',
                // Menyimpan direktori asset gambarnya
                'gambar' => 'image/bakara/desa-tipang.jpg',
                // Menyimpan koleksi tags destinasi sebagai array
                'tags' => ['Desa Wisata', 'Budaya Batak', 'Homestay', 'Panorama Danau'],
                // Menyimpan string URL routing ke detil destinasi
                'url' => '/destinasi/alam/desa-wisata-tipang'
            ]
        ];
        
        // Mengembalikan halaman view 'destinasi.kategori' serta meneruskan data yang dikemas dalam fungsi compact
        return view('destinasi.kategori', compact('kategori', 'deskripsi', 'destinasi'));
    }
    
    // ==================== DESTINASI BUATAN ====================
    // Method buatan untuk menangani pengambilan data khusus wisata kategori buatan
    public function buatan()
    {
        // Mendeklarasikan nama kategori dengan nilai string 'Buatan'
        $kategori = 'Buatan';
        // Mendeklarasikan deskripsi paragraf untuk diletakkan di view
        $deskripsi = 'Destinasi buatan yang dikembangkan untuk menikmati keindahan alam Bakara, Tipang, dan Baktiraja dengan fasilitas yang nyaman.';
        
        // Membuka deklarasi array objek untuk destinasi kategori buatan
        $destinasi = [
            // Membuat objek untuk menampung data elemen pertama
            (object)[
                // Memasukkan angka ID identifikasi
                'id' => 1,
                // Memasukkan string unik sebagai slug destinasi
                'slug' => 'panatapan-bakara',
                // Menentukan nama kategori statis
                'kategori' => 'buatan',
                // Menentukan judul nama untuk tempat wisata ini
                'nama' => 'Panatapan Bakara',
                // Menentukan alamat wilayah wisata
                'lokasi' => 'Desa Bakara, Kecamatan Baktiraja',
                // Menuliskan deskripsi wisata agar mudah dimengerti user
                'deskripsi' => 'Area pandang dengan panorama spektakuler Danau Toba dari ketinggian. Spot favorit untuk sunrise dan sunset.',
                // Menetapkan nama file gambar terkait
                'gambar' => 'image/bakara/panatapan-bakara.jpg',
                // Menetapkan array dari label-label tag
                'tags' => ['Panorama Danau', 'Sunrise', 'Sunset', 'Spot Foto', 'Gazebo'],
                // Menetapkan link rute lokal destinasi
                'url' => '/destinasi/buatan/panatapan-bakara'
            ],
            // Membuat objek untuk menampung data elemen kedua
            (object)[
                // Memasukkan angka ID identifikasi yang berbeda
                'id' => 2,
                // Menyimpan slug khusus destinasi wisata
                'slug' => 'gonting',
                // Menyimpan nama identitas kategorinya
                'kategori' => 'buatan',
                // Menetapkan nama tempat wisatanya
                'nama' => 'Gonting',
                // Menetapkan letak geografis lokasi
                'lokasi' => 'Tipang, Kecamatan Baktiraja',
                // Menuliskan teks deskripsi mengenai tempatnya
                'deskripsi' => 'Bukit dengan jalur trekking yang dilengkapi fasilitas pendukung, melewati kebun kopi dan hutan pinus.',
                // Menyimpan parameter nama gambar destinasi
                'gambar' => 'image/bakara/gonting.jpg',
                // Menyimpan tag array destinasi gonting
                'tags' => ['Trekking', 'Bukit Gonting', 'Camping', 'Panorama Danau', 'Hutan Pinus'],
                // Menyimpan tujuan url halaman destinasi ini
                'url' => '/destinasi/buatan/gonting'
            ]
        ];
        
        // Melakukan render pada view destinasi.kategori beserta datanya yang dibungkus fungsi compact
        return view('destinasi.kategori', compact('kategori', 'deskripsi', 'destinasi'));
    }
    
    // ==================== DESTINASI BUDAYA ====================
    // Method budaya untuk melayani request destinasi wisata di bidang budaya
    public function budaya()
    {
        // Menentukan label kategori dengan kata 'Budaya'
        $kategori = 'Budaya';
        // Menentukan deskripsi lengkap mengenai wisata budaya
        $deskripsi = 'Destinasi wisata budaya yang menampilkan sejarah perjuangan Raja Sisingamangaraja, legenda, dan kearifan lokal masyarakat Batak di kawasan Bakara, Tipang, dan Baktiraja.';
        
        // Membuat wadah variabel array yang menyimpan serangkaian objek wisata
        $destinasi = [
            // Memulai inisialisasi objek elemen array wisata yang pertama
            (object)[
                // Menetapkan Primary ID sederhana
                'id' => 1,
                // Menetapkan string nama slug standar URL
                'slug' => 'istana-sisingamangaraja',
                // Menetapkan kategori destinasi
                'kategori' => 'budaya',
                // Menetapkan string judul nama wisata
                'nama' => 'Istana Sisingamangaraja',
                // Menetapkan tulisan teks lokasi lengkap destinasi wisata
                'lokasi' => 'Tipang, Kecamatan Baktiraja',
                // Menetapkan penjelasan lebih rinci perihal lokasi ini
                'deskripsi' => 'Pusat spiritual dan pemerintahan raja-raja Batak. Belajar sejarah perlawanan terhadap kolonial dan ritual adat.',
                // Menetapkan URL path cover thumbnail wisata ini
                'gambar' => 'image/bakara/istana-sisingamangaraja.jpg',
                // Menetapkan kumpulan array dari kata kunci/tags wisata
                'tags' => ['Istana', 'Sejarah Batak', 'Raja Sisingamangaraja', 'Ritual Adat', 'Artefak'],
                // Menetapkan url endpoint wisata secara penuh
                'url' => '/destinasi/budaya/istana-sisingamangaraja'
            ],
            // Memulai inisialisasi objek elemen array wisata yang kedua
            (object)[
                // Menetapkan Primary ID yang urut
                'id' => 2,
                // Menetapkan nilai slug identifier untuk destinasi ini
                'slug' => 'tombak-sulu-sulu',
                // Menetapkan nilai teks kategori
                'kategori' => 'budaya',
                // Menetapkan properti nama destinasi wisata
                'nama' => 'Tombak Sulu-sulu',
                // Menetapkan informasi tempat lokasi destinasi
                'lokasi' => 'Kawasan Bakara',
                // Menetapkan keterangan tulisan seputar destinasi tersebut
                'deskripsi' => 'Hutan larangan dengan legenda tombak pusaka Raja Sisingamangaraja. Tempat wisata spiritual dan sejarah.',
                // Menetapkan lokasi penyimpanan foto thumbnail destinasi
                'gambar' => 'image/bakara/tombak-sulu-sulu.jpg',
                // Menetapkan variasi tag yang mendeskripsikan lokasi ini
                'tags' => ['Hutan Sakral', 'Legenda Tombak', 'Sisingamangaraja', 'Wisata Spiritual', 'Trekking'],
                // Menetapkan tautan url menuju detail tempat
                'url' => '/destinasi/budaya/tombak-sulu-sulu'
            ],
            // Memulai inisialisasi objek elemen array wisata yang ketiga
            (object)[
                // Menetapkan Primary ID yang mengurut dari sebelumnya
                'id' => 3,
                // Menetapkan penamaan slug url untuk tempat wisata ini
                'slug' => 'aek-sipangolu',
                // Menetapkan jenis wisata yang dianut
                'kategori' => 'budaya',
                // Menetapkan field nama wisata
                'nama' => 'Aek Sipangolu',
                // Menetapkan kalimat yang menerangkan letak lokasinya
                'lokasi' => 'Baktiraja',
                // Menetapkan deskripsi profil tempat wisata ini
                'deskripsi' => 'Mata air panas alami yang dipercaya memiliki khasiat menyembuhkan penyakit dan menghilangkan rasa lelah.',
                // Menetapkan path image wisata
                'gambar' => 'image/bakara/aek-sipangolu.jpg',
                // Menetapkan serangkaian array teks tag lokasi
                'tags' => ['Mata Air Panas', 'Pengobatan Tradisional', 'Sejarah', 'Spiritual', 'Belerang'],
                // Menetapkan link menuju page rute lengkap tempat ini
                'url' => '/destinasi/budaya/aek-sipangolu'
            ]
        ];
        
        // Memparsing dan merender file tampilan dengan membawa kumpulan data untuk ditampilkan
        return view('destinasi.kategori', compact('kategori', 'deskripsi', 'destinasi'));
    }
    
    // ==================== DETAIL DESTINASI — REDIRECT TO GEOSITE ROUTE ====================
    // Method untuk mengatur pengalihan (redirect) menuju detail setiap tempat wisata dengan parameter kategori dan slug
    public function detail($kategori, $slug)
    {
        // Membuat peta map (array) yang mencocokkan slug dengan nama route di laravel
        $geositeRoutes = [
            // Alam - memetakan slug air terjun dengan route namenya
            'air-terjun-janji'        => 'geosite.air-terjun-janji',
            // Memetakan slug mata air dengan route namenya
            'aek-sitio-tio'           => 'geosite.aek-sitio-tio',
            // Memetakan slug desa wisata dengan route namenya
            'desa-wisata-tipang'      => 'geosite.desa-wisata-tipang',
            // Buatan - memetakan slug wisata buatan
            'panatapan-bakara'        => 'geosite.panatapan-bakara',
            // Memetakan slug wisata buatan gonting
            'gonting'                 => 'geosite.gonting',
            // Budaya - memetakan slug wisata istana budaya
            'istana-sisingamangaraja' => 'geosite.istana-sisingamangaraja',
            // Memetakan slug wisata budaya hutan sakral
            'tombak-sulu-sulu'        => 'geosite.tombak-sulu-sulu',
            // Memetakan slug wisata budaya pemandian
            'aek-sipangolu'           => 'geosite.aek-sipangolu',
        ];
        
        // Mengevaluasi kondisi apakah key slug yang direquest terdapat pada variabel array pemetaan kita
        if (isset($geositeRoutes[$slug])) {
            // Melakukan redirect pengunjung ke route yang bersangkutan sesuai pemetaan array di atas
            return redirect()->route($geositeRoutes[$slug]);
        }
        
        // Memberhentikan laju eksekusi aplikasi karena rute tidak ditemukan dan mengeluarkan kode status 404 (Not Found)
        abort(404, 'Destinasi tidak ditemukan');
    }
}
