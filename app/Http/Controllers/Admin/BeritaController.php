<?php

// Memulai tag PHP
// Mendeklarasikan namespace untuk kelas kontroler ini
namespace App\Http\Controllers\Admin;

// Mengimpor kelas Controller dasar dari framework Laravel
use App\Http\Controllers\Controller;
// Mengimpor model Berita untuk berinteraksi dengan tabel berita di database
use App\Models\Berita;
// Mengimpor model ProfilGeosite untuk berinteraksi dengan profil_geosites
use App\Models\ProfilGeosite;
// Mengimpor kelas Request untuk menangani input HTTP dari pengguna
use Illuminate\Http\Request;
// Mengimpor fasad Storage untuk menangani operasi file pada media penyimpanan
use Illuminate\Support\Facades\Storage;

// Mendefinisikan kelas BeritaController yang mewarisi Controller dasar
class BeritaController extends Controller {
    /*
       [CONTROLLER ADMIN BeritaController]
       File ini bertugas mengontrol logika untuk bagian admin dari BeritaController.
       Berfungsi mengatur operasi CRUD (Create, Read, Update, Delete) pada database.
       Tabel Database yang digunakan: berhubungan erat dengan entitas BeritaController.
    */
    // Mendeklarasikan properti private geositeList sebagai array yang berisi daftar geosite
    private array $geositeList = [
        // Menetapkan kunci 'aek-sipangolu' untuk geosite 'Aek Sipangolu'
        'aek-sipangolu' => 'Aek Sipangolu',
        // Menetapkan kunci 'aek-sitio-tio' untuk geosite 'Aek Sitio-tio'
        'aek-sitio-tio' => 'Aek Sitio-tio',
        // Menetapkan kunci 'air-terjun-janji' untuk geosite 'Air Terjun Janji'
        'air-terjun-janji' => 'Air Terjun Janji',
        // Menetapkan kunci 'desa-wisata-tipang' untuk geosite 'Desa Tipang'
        'desa-wisata-tipang' => 'Desa Tipang',
        // Menetapkan kunci 'gonting' untuk geosite 'Gonting'
        'gonting' => 'Gonting',
        // Menetapkan kunci 'istana-sisingamangaraja' untuk geosite 'Istana Sisingamangaraja'
        'istana-sisingamangaraja' => 'Istana Sisingamangaraja',
        // Menetapkan kunci 'panatapan-bakara' untuk geosite 'Panatapan Bakara'
        'panatapan-bakara' => 'Panatapan Bakara',
        // Menetapkan kunci 'tombak-sulu-sulu' untuk geosite 'Tombak Sulu-sulu'
        'tombak-sulu-sulu' => 'Tombak Sulu-sulu'
    // Menutup definisi array geositeList
    ];

    // Mendefinisikan metode index untuk menampilkan daftar berita
    public function index()
    {
        // Mengambil data berita dari model Berita, diurutkan dari yang terbaru, lalu dipaginasi sebanyak 10 item per halaman
        $berita = Berita::latest()->paginate(10);
        // Mengembalikan tampilan view 'admin.berita.index' beserta data 'berita' yang telah diambil
        return view('admin.berita.index', compact('berita'));
    // Menutup metode index
    }

    // Mendefinisikan metode create untuk menampilkan formulir pembuatan berita baru
    public function create()
    {
        // Menyimpan properti geositeList milik kelas ini ke dalam variabel lokal $geositeList
        $geositeList = $this->geositeList;
        // Mengembalikan tampilan view 'admin.berita.create' beserta data 'geositeList' untuk dipilih pengguna
        return view('admin.berita.create', compact('geositeList'));
    // Menutup metode create
    }

    // Mendefinisikan metode store untuk menyimpan data berita baru yang disubmit pengguna
    public function store(Request $request)
    {
        // Menggabungkan kunci-kunci dari array geositeList dengan koma sebagai pembatas untuk dipakai pada validasi 'in'
        $validGeosites = implode(',', array_keys($this->geositeList));
        // Melakukan validasi terhadap input yang diberikan pada request berdasarkan aturan tertentu
        $request->validate([
            // Memastikan 'judul' ada, bertipe string, dan maksimal 255 karakter
            'judul'   => 'required|string|max:255',
            // Memastikan 'konten' ada dan bertipe string
            'konten'  => 'required|string',
            // Memastikan 'gambar' boleh kosong, namun jika ada harus berupa file gambar dengan format tertentu dan maksimal 10MB
            'gambar'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            // Memastikan 'penulis' boleh kosong, namun jika ada harus bertipe string dan maksimal 100 karakter
            'penulis' => 'nullable|string|max:100',
            // Memastikan 'geosite' wajib diisi, bertipe string, dan nilainya termasuk dalam string $validGeosites
            'geosite' => "required|string|in:{$validGeosites}",
        // Array argumen kedua dari metode validate, berisi pesan error kustom untuk aturan validasi di atas
        ], [
            // Menetapkan pesan kustom ketika file gambar bukan berupa gambar
            'gambar.image' => 'Format file yang diunggah harus berupa gambar.',
            // Menetapkan pesan kustom ketika gambar tidak memenuhi tipe file yang diizinkan (mimes)
            'gambar.mimes' => 'Gambar harus memiliki format: jpeg, png, jpg, webp.',
            // Menetapkan pesan kustom ketika gambar melebihi ukuran maksimum 10MB
            'gambar.max'   => 'Ukuran gambar maksimal adalah 10MB.',
            // Menetapkan pesan kustom secara umum untuk atribut apa pun yang bersifat 'required' jika gagal diisi
            'required'     => 'Kolom :attribute wajib diisi.',
            // Menetapkan pesan kustom jika input geosite tidak termasuk di dalam pilihan (in)
            'geosite.in'   => 'Geosite yang dipilih tidak valid.'
        // Menutup panggilan metode validate
        ]);

        // Memastikan geosite ada di database profil_geosites untuk mencegah foreign key error
        // Mencari atau membuat data baru di tabel profil_geosites dengan kolom geosite sesuai input pengguna
        ProfilGeosite::firstOrCreate(['geosite' => $request->geosite]);

        // Menyusun array asosiatif $data dari input request
        $data = [
            // Memasukkan input judul dari request ke dalam array data
            'judul'   => $request->judul,
            // Memasukkan input konten dari request ke dalam array data
            'konten'  => $request->konten,
            // Memasukkan input penulis jika ada, jika tidak, gunakan string default 'Admin'
            'penulis' => $request->penulis ?? 'Admin',
            // Memasukkan input geosite dari request ke dalam array data
            'geosite' => $request->geosite,
        // Menutup penyusunan array $data
        ];

        // Memeriksa apakah request mengandung file 'gambar' yang diunggah
        if ($request->hasFile('gambar')) {
            // Jika iya, simpan file gambar tersebut ke dalam direktori 'berita' pada disk 'public'
            $path = $request->file('gambar')->store('berita', 'public');
            // Menambahkan path gambar yang sudah dienkode ke JSON ke dalam array $data
            $data['gambar'] = json_encode([$path]);
        // Menutup blok kondisi unggah gambar
        }

        // Menyimpan data berita baru ke database menggunakan metode create pada model Berita
        Berita::create($data);

        // Mengarahkan pengguna kembali ke rute admin.berita.index
        return redirect()->route('admin.berita.index')
            // Menyertakan pesan sukses dalam session ('with') dengan kunci 'success'
            ->with('success', 'Berita berhasil ditambahkan!');
    // Menutup metode store
    }

    // Mendefinisikan metode edit dengan parameter ID untuk menampilkan formulir edit berita
    public function edit($id)
    {
        // Mencari data berita berdasarkan ID, jika tidak ditemukan, sistem akan memunculkan error 404
        $berita      = Berita::findOrFail($id);
        // Menyimpan daftar geosite dari properti kelas ke variabel lokal
        $geositeList = $this->geositeList;
        // Mengembalikan tampilan view 'admin.berita.edit' dan melempar variabel 'berita' serta 'geositeList' ke view
        return view('admin.berita.edit', compact('berita', 'geositeList'));
    // Menutup metode edit
    }

    // Mendefinisikan metode update untuk memperbarui berita di database
    public function update(Request $request, $id)
    {
        // Mencari data berita berdasarkan ID di database, lempar 404 jika tidak ketemu
        $berita = Berita::findOrFail($id);

        // Membuat string berisikan kunci dari array geosite untuk validasi, dipisahkan dengan koma
        $validGeosites = implode(',', array_keys($this->geositeList));
        // Melakukan validasi terhadap request dengan spesifikasi aturan tertentu
        $request->validate([
            // Aturan bahwa 'judul' wajib diisi, berupa string, dan maksmimal 255 karakter
            'judul'   => 'required|string|max:255',
            // Aturan bahwa 'konten' wajib diisi dan berupa string
            'konten'  => 'required|string',
            // Aturan bahwa 'gambar' bersifat opsional, harus file gambar dengan format jpeg, png, jpg, webp dan maks 10MB
            'gambar'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            // Aturan bahwa 'penulis' opsional, bertipe string, max 100 karakter
            'penulis' => 'nullable|string|max:100',
            // Aturan bahwa 'geosite' wajib diisi, string, dan ada di string $validGeosites
            'geosite' => "required|string|in:{$validGeosites}",
        // Array berisi pesan kustom untuk jika validasi gagal
        ], [
            // Menentukan pesan error untuk kegagalan validasi image pada field gambar
            'gambar.image' => 'Format file yang diunggah harus berupa gambar.',
            // Menentukan pesan error untuk kegagalan validasi tipe file (mimes) pada field gambar
            'gambar.mimes' => 'Gambar harus memiliki format: jpeg, png, jpg, webp.',
            // Menentukan pesan error jika ukuran gambar terlalu besar
            'gambar.max'   => 'Ukuran gambar maksimal adalah 10MB.',
            // Menentukan pesan error general untuk setiap field yang wajib diisi tapi dikosongkan
            'required'     => 'Kolom :attribute wajib diisi.',
            // Menentukan pesan error bila value geosite tidak valid
            'geosite.in'   => 'Geosite yang dipilih tidak valid.'
        // Menutup pemanggilan metode validate
        ]);

        // Pastikan geosite ada di database profil_geosites untuk mencegah foreign key error
        // Melakukan firstOrCreate untuk mendaftarkan geosite jika belum ada pada model ProfilGeosite
        ProfilGeosite::firstOrCreate(['geosite' => $request->geosite]);

        // Menyiapkan array asosiatif berisi data untuk mengupdate kolom-kolom terkait di database
        $data = [
            // Memasukkan judul yang baru dari request
            'judul'   => $request->judul,
            // Memasukkan konten yang baru dari request
            'konten'  => $request->konten,
            // Mengatur penulis dengan nilai yang dikirim request, atau 'Admin' bila kosong
            'penulis' => $request->penulis ?? 'Admin',
            // Mengatur geosite dari nilai yang diterima
            'geosite' => $request->geosite,
        // Menutup inisialisasi array $data
        ];

        // Mengecek bila pada pembaruan ini pengguna melampirkan sebuah file gambar baru
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama dari storage
            // Mendekode field 'gambar' dari data berita yang ada menjadi sebuah array PHP
            $oldGambar = json_decode($berita->gambar, true);
            // Mengecek apakah hasil dekode berupa array yang valid
            if (is_array($oldGambar)) {
                // Melakukan pengulangan (looping) pada setiap entri yang ada di array oldGambar
                foreach ($oldGambar as $oldPath) {
                    // Mengecek apakah oldPath terisi dan bukan string URI tipe data (seperti base64)
                    if ($oldPath && !str_starts_with($oldPath, 'data:')) {
                        // Memerintahkan disk 'public' untuk menghapus file lama tersebut dari storage
                        Storage::disk('public')->delete($oldPath);
                    // Menutup blok if kedua di dalam loop
                    }
                // Menutup blok loop foreach
                }
            // Menutup blok pengecekan jika hasil dekode array
            }

            // Menyimpan file gambar baru yang diunggah ke folder 'berita' pada disk public
            $path = $request->file('gambar')->store('berita', 'public');
            // Menambahkan entri 'gambar' ke dalam $data dengan path gambar baru, dienkode ke JSON format
            $data['gambar'] = json_encode([$path]);
        // Menutup blok kondisi hasFile
        }

        // Mengeksekusi pembaruan data pada record database menggunakan data yang sudah disusun pada variabel $data
        $berita->update($data);

        // Mengarahkan pengguna kembali ke halaman index berita di panel admin
        return redirect()->route('admin.berita.index')
            // Menyertakan pesan sukses pada flash session agar ditampilkan pada halaman baru
            ->with('success', 'Berita berhasil diupdate!');
    // Menutup metode update
    }

    // Mendefinisikan metode destroy yang digunakan untuk menghapus berita dengan ID spesifik
    public function destroy($id)
    {
        // Mencari record berita yang ingin dihapus berdasarkan ID, atau memicu exception jika tidak ditemukan
        $berita = Berita::findOrFail($id);

        // Hapus semua file gambar dari storage
        // Mengekstrak informasi path gambar yang tersimpan dengan json_decode menjadi format array
        $oldGambar = json_decode($berita->gambar, true);
        // Memastikan apakah hasil dekode ini berupa array
        if (is_array($oldGambar)) {
            // Mengiterasi seluruh path gambar yang ditemukan
            foreach ($oldGambar as $oldPath) {
                // Menghindari penghapusan terhadap string base64 dengan mengecek format url dan valuenya
                if ($oldPath && !str_starts_with($oldPath, 'data:')) {
                    // Jika lolos validasi, lakukan penghapusan file di disk penyimpanan 'public'
                    Storage::disk('public')->delete($oldPath);
                // Menutup blok IF internal
                }
            // Menutup blok foreach untuk penghapusan gambar lama
            }
        // Menutup blok pemeriksaan array gambar
        }

        // Melakukan eksekusi penghapusan (delete) record dari database
        $berita->delete();

        // Melempar kembali user ke view index setelah operasi penghapusan selesai
        return redirect()->route('admin.berita.index')
            // Menyelipkan variabel success berisi pesan sukses saat proses redirect
            ->with('success', 'Berita berhasil dihapus!');
    // Menutup metode destroy
    }
// Menutup deklarasi kelas BeritaController
}
