<?php

// Memulai tag PHP
// Mendeklarasikan namespace untuk struktur folder Controller Admin
namespace App\Http\Controllers\Admin;

// Mengimpor kelas Controller bawaan Laravel
use App\Http\Controllers\Controller;
// Mengimpor model Fasilitas untuk akses ke tabel fasilitas di database
use App\Models\Fasilitas;
// Mengimpor model ProfilGeosite untuk relasi profil_geosites
use App\Models\ProfilGeosite;
// Mengimpor objek Request untuk mengolah data HTTP request
use Illuminate\Http\Request;
// Mengimpor class Storage untuk manipulasi file-file di storage
use Illuminate\Support\Facades\Storage;

// Membuat class FasilitasController yang mewarisi class Controller
class FasilitasController extends Controller {
    /*
       [CONTROLLER ADMIN FasilitasController]
       File ini bertugas mengontrol logika untuk bagian admin dari FasilitasController.
       Berfungsi mengatur operasi CRUD (Create, Read, Update, Delete) pada database.
       Tabel Database yang digunakan: berhubungan erat dengan entitas FasilitasController.
    */
    // Mendeklarasikan array privat bernama $geositeList berisi pemetaan slug geosite ke namanya
    private array $geositeList = [
        // Pemetaan untuk Aek Sipangolu
        'aek-sipangolu' => 'Aek Sipangolu',
        // Pemetaan untuk Aek Sitio-tio
        'aek-sitio-tio' => 'Aek Sitio-tio',
        // Pemetaan untuk Air Terjun Janji
        'air-terjun-janji' => 'Air Terjun Janji',
        // Pemetaan untuk Desa Tipang
        'desa-wisata-tipang' => 'Desa Tipang',
        // Pemetaan untuk Gonting
        'gonting' => 'Gonting',
        // Pemetaan untuk Istana Sisingamangaraja
        'istana-sisingamangaraja' => 'Istana Sisingamangaraja',
        // Pemetaan untuk Panatapan Bakara
        'panatapan-bakara' => 'Panatapan Bakara',
        // Pemetaan untuk Tombak Sulu-sulu
        'tombak-sulu-sulu' => 'Tombak Sulu-sulu'
    // Mengakhiri inisialisasi array
    ];

    // Mendefinisikan function index untuk menangani rute tampil data utama
    public function index()
    {
        // Mengambil data dari tabel Fasilitas dengan urutan berdasarkan kolom geosite, dibatasi 10 baris per halaman
        $data = Fasilitas::orderBy('geosite')->paginate(10);
        // Mengembalikan view admin.fasilitas.index dan mengirimkan variabel $data
        return view('admin.fasilitas.index', compact('data'));
    // Mengakhiri function index
    }

    // Mendefinisikan function create untuk menampilkan halaman formulir tambah fasilitas
    public function create()
    {
        // Mengambil daftar geosite dari properti class untuk dilempar ke view
        $geositeList = $this->geositeList;
        // Mengembalikan view admin.fasilitas.create serta passing daftar $geositeList
        return view('admin.fasilitas.create', compact('geositeList'));
    // Mengakhiri function create
    }

    // Mendefinisikan function store untuk memproses pengiriman data form penambahan fasilitas
    public function store(Request $request)
    {
        // Menggabungkan semua keys array geositeList dengan pembatas koma menjadi sebuah string utuh untuk keperluan validasi 'in'
        $validGeosites = implode(',', array_keys($this->geositeList));
        // Melakukan validasi request yang masuk menggunakan parameter aturan validasi array pertama dan array kedua (custom message)
        $request->validate([
            // Aturan untuk input 'nama', tipe datanya string, harus diisi dan maksmimum panjangnya 255
            'nama'      => 'required|string|max:255',
            // Aturan untuk input 'deskripsi', harus diisi dan berformat string
            'deskripsi' => 'required|string',
            // Aturan untuk input 'gambar', boleh kosong, harus image, berformat mimes tertentu, maksimum 10MB
            'gambar'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            // Aturan untuk input 'harga', boleh kosong, string dengan maksimal 100 huruf
            'harga'     => 'nullable|string|max:100',
            // Aturan untuk input 'geosite', string wajib diisi sesuai dalam daftar validGeosites
            'geosite'   => "required|string|in:{$validGeosites}",
        // Array pesan kustom (argumen ke-2 method validate)
        ], [
            // Kustomisasi pesan untuk validasi gagal format file (harus gambar)
            'gambar.image' => 'Format file yang diunggah harus berupa gambar.',
            // Kustomisasi pesan untuk validasi ekstensi gambar mimes
            'gambar.mimes' => 'Gambar harus memiliki format: jpeg, png, jpg, webp.',
            // Kustomisasi pesan untuk validasi max size pada input gambar
            'gambar.max'   => 'Ukuran gambar maksimal adalah 10MB.',
            // Kustomisasi general untuk kegagalan input form pada attribute required
            'required'     => 'Kolom :attribute wajib diisi.',
            // Kustomisasi pesan kalau rule 'in' untuk input geosite gagal
            'geosite.in'   => 'Geosite yang dipilih tidak valid.'
        // Menutup metode validate()
        ]);

        // Mencegah error kunci asing (foreign key constraint) dengan memastikan record geosite yang dipilih eksis pada tabel profil_geosites
        // Jika tidak ditemukan, method firstOrCreate akan membuat data entitas geosite baru menggunakan slug yg disubmit
        ProfilGeosite::firstOrCreate(['geosite' => $request->geosite]);


        // Mendefinisikan array bernama data dengan keys bersesuaian dengan nama kolom dan isi adalah dari Request form input user
        $data = [
            // Memasukkan isian formulir "nama"
            'nama'      => $request->nama,
            // Memasukkan isian formulir "deskripsi"
            'deskripsi' => $request->deskripsi,
            // Memasukkan isian formulir "harga"
            'harga'     => $request->harga,

            // Memasukkan input select "geosite"
            'geosite'   => $request->geosite,
        // Menutup definisi array associative
        ];

        // Mengecek apakah terdapat payload file yang diunggah pada field 'gambar'
        if ($request->hasFile('gambar')) {
            // Melakukan penyimpanan (store) di disk 'public' pada folder 'fasilitas' dan menangkap relative path-nya
            $path = $request->file('gambar')->store('fasilitas', 'public');
            // Menjadikan path string tersebut menjadi format array JSON sebelum ditambahkan ke payload database
            $data['gambar'] = json_encode([$path]);
        // Menutup if
        }

        // Menyimpan array final $data sebagai sebaris record baru menggunakan eloquent Model create
        Fasilitas::create($data);

        // Setelah sukses menyimpan record, alihkan navigasi browser untuk index route terkait
        return redirect()->route('admin.fasilitas.index')
            // Sisipkan flash session berisi success message untuk feedback ke end-user
            ->with('success', 'Fasilitas berhasil ditambahkan!');
    // Menutup block function store
    }

    // Mendefinisikan fungsi edit yang bertugas menampilkan form pengeditan. Akan menerima ID dari Route
    public function edit($id)
    {
        // Temukan record berdasarkan $id, apabila record tersebut tidak ada maka akan di-abort secara otomatis dengan 404 ModelNotFoundException
        $data        = Fasilitas::findOrFail($id);
        // Mengambil array daftar semua nama geosite untuk dicetak ke tag option pada view form
        $geositeList = $this->geositeList;
        // Melempar control ke view berserta objek $data untuk pre-fill value form dan $geositeList untuk pre-select element option
        return view('admin.fasilitas.edit', compact('data', 'geositeList'));
    // Menutup fungsi edit
    }

    // Mendefinisikan function update yang memiliki parameter request (menerima data update) dan ID rujukan fasilitas yang diedit
    public function update(Request $request, $id)
    {
        // Lakukan lookup query terhadap data database yang eksisting untuk objek ini menggunakan ID
        $data = Fasilitas::findOrFail($id);

        // Konversi keys properti geositeList dengan koma agar cocok dijadikan custom rule 'in:' milik Laravel validation
        $validGeosites = implode(',', array_keys($this->geositeList));
        // Proses validasi ulang setiap attribute yang masuk
        $request->validate([
            // Mensyaratkan nama ada, sebagai string, batas maksimal karakter
            'nama'      => 'required|string|max:255',
            // Mensyaratkan field deskripsi agar terisi tipe datanya adalah string
            'deskripsi' => 'required|string',
            // Mensyaratkan validasi khusus untuk gambar, mimes dan ukuran maksimum upload
            'gambar'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            // Mensyaratkan aturan opsional string max untuk attribute form harga
            'harga'     => 'nullable|string|max:100',
            // Syarat mutlak wajib pada form drop-down, sesuai whitelist keys yang diperbolehkan di sistem
            'geosite'   => "required|string|in:{$validGeosites}",
        // Array asosiatif ini berisi terjemahan error string khusus untuk menampilkan instruksi bahasa yang mudah
        ], [
            // Terjemahan pesan buat validasi gambar general rule fail
            'gambar.image' => 'Format file yang diunggah harus berupa gambar.',
            // Terjemahan pesan buat mimes rule fail pada file image upload
            'gambar.mimes' => 'Gambar harus memiliki format: jpeg, png, jpg, webp.',
            // Terjemahan pesan manakala ukuran dari request upload terlalu masif/di luar limit size rule max
            'gambar.max'   => 'Ukuran gambar maksimal adalah 10MB.',
            // Fallback failover translations pesan generik
            'required'     => 'Kolom :attribute wajib diisi.',
            // Fallback failover translation ketika custom in string tidak ditemukan
            'geosite.in'   => 'Geosite yang dipilih tidak valid.'
        // Keluar dari call static parameter list buat validasi update
        ]);

        // Cek/daftar dulu secara eksplisit Geosite pilihan via model Eloquent pada instance record agar referensinya tetap valid dan DB integrity aman
        ProfilGeosite::firstOrCreate(['geosite' => $request->geosite]);


        // Membuat variable array associative `$input` buat penampungan payload nilai properties
        $input = [
            // Tetapkan value title dari properti nama formulir request
            'nama'      => $request->nama,
            // Tetapkan nilai desc property formulir ke data property deskripsi model record 
            'deskripsi' => $request->deskripsi,
            // Tetapkan price variable model mapping menggunakan price (harga) yang berasal dari HTTP request submission values
            'harga'     => $request->harga,

            // Set referensial identifier key-string value geosite dari data HTTP body form properties value mapping referensi geosite ID ke DB records
            'geosite'   => $request->geosite,
        // Akhiri pembentukan map list penyesuaian payload variables sebelum update commit database
        ];

        // Lakukan pengondisian jika form post mengangkut sebuah file body multipart attachment pada parameter key field 'gambar'
        if ($request->hasFile('gambar')) {
            // Melakukan decode JSON data field `gambar` property eksisting yang sebelumnya di model record untuk menghapus metadata lawas
            $oldGambar = json_decode($data->gambar, true);
            // Mengecek apakah operasi konversi string decode sukses membentuk sekumpulan array valid
            if (is_array($oldGambar)) {
                // Proses perulangan foreach untuk membersihkan array image attachment model data lawas satu persatu
                foreach ($oldGambar as $oldPath) {
                    // Validasi safety check tidak menyeleksi atau attempt penghapusan file string encoding base64
                    if ($oldPath && !str_starts_with($oldPath, 'data:')) {
                        // Jalankan library Storage File Facade dengan perintah delete pointer link ke server directory
                        Storage::disk('public')->delete($oldPath);
                    // Akhiri block logic pengkondisian pengecualian delete fail safe
                    }
                // Akhiri scope blok loop delete cleanup untuk arrays files images
                }
            // Tambahkan clause condition jika struktur field bukan array (legacy / unformatted records / backward compatibility)
            } elseif ($data->gambar && !str_starts_with($data->gambar, 'data:')) {
                // Bersihkan record tunggal file yang eksis dalam server system untuk kompatibilitas versi sebelumnya
                Storage::disk('public')->delete($data->gambar);
            // Tutup blok legacy fallback clean up exception
            }

            // Simpan copy file stream yang di pass di HTTP Payload ke public directory storage folder
            $path = $request->file('gambar')->store('fasilitas', 'public');
            // Menjadikan string property referensi letak server untuk value column menjadi encoded array properties valid map 
            $input['gambar'] = json_encode([$path]);
        // Tutup filter attachment if untuk pemrosesan storage changes update method request handling procedure file
        }

        // Simpan modifikasi variabel mapped array input untuk proses write DB Commit Eloquent object instantiation Model API call
        $data->update($input);

        // Setelah selesai kembalikan client kembali ke navigasi routing awal dashboard menggunakan method return HTTP Location handler redirect routing admin root function
        return redirect()->route('admin.fasilitas.index')
            // Memberikan Flash Session Notification success variable key flash data saat memproses rendering UI redirect callback pages 
            ->with('success', 'Fasilitas berhasil diupdate!');
    // Tutup blok sub program public class action procedure handler fungsi controller edit form Update post update 
    }

    // Inisiasi sebuah handler endpoint function untuk mendelete record DB spesifik beserta dependency media file server disk directory
    public function destroy($id)
    {
        // Search reference database item by $id pointer query argument string params di eloquent, tampil error abort klo null pointer result HTTP NotFound Ex.
        $data = Fasilitas::findOrFail($id);

        // Uraikan nilai property meta string column untuk persiapan cleanup proses File I/O operations disk server directory
        $oldGambar = json_decode($data->gambar, true);
        // Validasi bila JSON decoding result sukses menjadi true array structure PHP object structure type untuk handling logic array foreach  
        if (is_array($oldGambar)) {
            // Lakukan iterasi setiap entri image data file dari JSON arrays untuk didelete list URL references map strings data 
            foreach ($oldGambar as $oldPath) {
                // Safety guard statement mencegah eksekusi penghapusan raw strings data seperti base64 encoded URL images yang bukan physical pointer files server
                if ($oldPath && !str_starts_with($oldPath, 'data:')) {
                    // Eksekusi System I/O untuk memanggil library Facade facade server system call unlink unmounted files delete command dari local filesystem disk 
                    Storage::disk('public')->delete($oldPath);
                // Tutup kondisional branch guard if
                }
            // Keluar dari context execution iterasi array oldGambar file loop deletion
            }
        // Jika format gambar database berbentuk flat string atau tipe lain / Legacy struktur tipe column backward compatible records mapping validation fallback
        } elseif ($data->gambar && !str_starts_with($data->gambar, 'data:')) {
            // Jalankan System OS unlink call facade Storage helper langsung tanpa foreach iteration execution command
            Storage::disk('public')->delete($data->gambar);
        // Menutup block catch fallback validation
        }

        // Perintah query builder Eloquent API untuk menjalankan Query command row wipeout atau DELETE query ke sistem database management record
        $data->delete();

        // Operasi Selesai, Redirect halaman sistem kontrol browser web klien untuk redirect index path view menu function control system flow route web request URL response callback HTTP 302 code  
        return redirect()->route('admin.fasilitas.index')
            // Append dan pass Flash Bag messages data Session untuk informasi sukses action procedure command system delete success notify client frontend ui alert rendering  
            ->with('success', 'Fasilitas berhasil dihapus!');
    // Menutup definisi block destroy scope controller execution handler
    }
// Menutup deklarasi blok global utama Class definisi controller admin controller namespace definition 
}
