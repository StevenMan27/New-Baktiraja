<?php

// Mulai deklarasi PHP
// Set namespace untuk menentukan direktori virtual controller admin
namespace App\Http\Controllers\Admin;

// Import class Controller parent bawaan framework Laravel
use App\Http\Controllers\Controller;
// Import Model Galeri untuk akses query builder ke tabel galeri
use App\Models\Galeri;
// Import Model ProfilGeosite untuk query tabel terkait geosite parent table mapping
use App\Models\ProfilGeosite;
// Import Class Request untuk menghandle tangkapan parameter HTTP Request
use Illuminate\Http\Request;
// Import Facade Storage untuk manipulasi sistem direktori server penyimpanan gambar
use Illuminate\Support\Facades\Storage;

// Deklarasi kelas GaleriController yang menurunkan sifat Controller utama
class GaleriController extends Controller {
    /*
       [CONTROLLER ADMIN GaleriController]
       File ini bertugas mengontrol logika untuk bagian admin dari GaleriController.
       Berfungsi mengatur operasi CRUD (Create, Read, Update, Delete) pada database.
       Tabel Database yang digunakan: berhubungan erat dengan entitas GaleriController.
    */
    // Definisikan array string privat untuk menyimpan whitelist slug daftar geosite valid
    private array $geositeList = [
        // Mapping opsi Aek Sipangolu
        'aek-sipangolu' => 'Aek Sipangolu',
        // Mapping opsi Aek Sitio-tio
        'aek-sitio-tio' => 'Aek Sitio-tio',
        // Mapping opsi Air Terjun Janji
        'air-terjun-janji' => 'Air Terjun Janji',
        // Mapping opsi Desa Wisata Tipang
        'desa-wisata-tipang' => 'Desa Tipang',
        // Mapping opsi Gonting
        'gonting' => 'Gonting',
        // Mapping opsi Istana Sisingamangaraja
        'istana-sisingamangaraja' => 'Istana Sisingamangaraja',
        // Mapping opsi Panatapan Bakara
        'panatapan-bakara' => 'Panatapan Bakara',
        // Mapping opsi Tombak Sulu-sulu
        'tombak-sulu-sulu' => 'Tombak Sulu-sulu'
    // Penutup struktur deklarasi array property class
    ];

    // Method controller yang dipanggil router untuk halaman index utama
    public function index()
    {
        // Query database via Eloquent model untuk ambil entitas Galeri yang di sort dari paling terbaru, lalu paginasi 10 per load
        $galeris = Galeri::latest()->paginate(10);
        // Mengarahkan flow UI return halaman view index yang berada di admin/galeri dan menyertakan variables array galeris tersebut via compact helper
        return view('admin.galeri.index', compact('galeris'));
    // Penutup fungsi return method index
    }

    // Method controller yang berguna untuk merender HTTP GET Form Create
    public function create()
    {
        // Assignment class array property $geositeList local references binding untuk lempar variables view 
        $geositeList = $this->geositeList;
        // Me-render page Form Create Galeri yang dikirimkan beserta pre-defined variabel pilihan list drop-down Select 
        return view('admin.galeri.create', compact('geositeList'));
    // Tutup method create
    }

    // Method HTTP POST store dipanggil bila form submit diserahkan dari page Create Galeri 
    public function store(Request $request)
    {
        // Gabungkan seluruh key dari Array object List kedalam seuntai string dengan koma guna filter parameter IN saat validation
        $validGeosites = implode(',', array_keys($this->geositeList));
        // Validasi dan sanitize inputs Payload dari request header body HTTP sesuai rule array list berikut
        $request->validate([
            // Input property judul bersifat mandatory/wajib dan berupa teks (string), tidak boleh lebih panjang dari 255 character length size
            'judul'        => 'required|string|max:255',
            // Deskripsi string adalah optional tidak wajb disi
            'deskripsi'    => 'nullable|string',
            // Gambar mutlak harus diset/uploaded dan berbentuk array files dengan limit 10 batch images per submit
            'gambar'       => 'required|array|max:10',
            // Semua ekstensi image/gambar dalam array parameter di-scan secara granular: format hanya boleh yg tercantum, filetype berupa image dan per item limit upload maksimum ukuran 10Megabyte
            'gambar.*'     => 'image|mimes:jpeg,png,jpg,webp|max:10240',
            // Input lokasi boleh dikosongkan opsional berupa string ukuran maximal string length 255 bytes character text
            'lokasi'       => 'nullable|string|max:255',
            // Param field tanggal_foto bersifat tambahan string date format
            'tanggal_foto' => 'nullable|date',
            // Pilihan attribute geosite wajib di select string matching valid values mapping options 
            'geosite'      => "required|string|in:{$validGeosites}",
        // Daftar string pesan parameter custom fail messages yang lebih informatif untuk diterjemahkan dan dipass ke object redirect View
        ], [
            // Apabila required rule pada images fail, beri message pesan mandatory
            'gambar.required' => 'Minimal satu gambar wajib diunggah.',
            // Apabila total attachments upload limit exceed max size maka alert message
            'gambar.max'      => 'Maksimal gambar yang dapat diunggah adalah 10 gambar sekaligus.',
            // Pesan warning ketika lampiran bukan merupakan format visual mime image
            'gambar.*.image'  => 'Format file yang diunggah harus berupa gambar.',
            // Pesan warning khusus jika mime type files upload diluar kategori jpg jpeg webp png extension format support 
            'gambar.*.mimes'  => 'Gambar harus memiliki format: jpeg, png, jpg, webp.',
            // Fallback pesanan warning error string apabila individual sub images upload melanggar 10 MB limit file sizes 
            'gambar.*.max'    => 'Ukuran gambar maksimal adalah 10MB.',
            // Default universal mandatory messages jika attribute form dibiarkan kosong 
            'required'        => 'Kolom :attribute wajib diisi.',
            // Alert user message klo parameter select options melenceng
            'geosite.in'      => 'Geosite yang dipilih tidak valid.'
        // Keluar argumen block validasi
        ]);

        // Jamin Integritas data pada database profil_geosites supaya mapping parent column dari relasi relation tetap eksis
        // Menggunakan static function ORM eloquent firstOrCreate mengecek apabila null record create data menggunakan query mapping arguments payload 
        ProfilGeosite::firstOrCreate(['geosite' => $request->geosite]);

        // Sediakan variabel scope array penampung link public directory locations string 
        $paths = [];
        // Apabila parameter requests body berisi HTTP file attachment field payload 'gambar' dipenuhi maka
        if ($request->hasFile('gambar')) {
            // Lakukan pengulangan sub items multiple attachments HTTP File objects 
            foreach ($request->file('gambar') as $file) {
                // Simpan copy file stream binary di folder root app/storage/app/public/galeri dan tangkap string pointer map address lokasi lalu append push di element array $paths
                $paths[] = $file->store('galeri', 'public');
            // Akhiri internal sub process perulangan
            }
        // Akhiri pengecekan kondisi unggah file 
        }

        // Commit transaksi penambahan tuple row data baru memakai facade API Create pada ORM Class model Galeri Eloquent  
        Galeri::create([
            // Tetapkan value object property model record 'judul' sama persis ke form post attribute text judul
            'judul'        => $request->judul,
            // Assignment input properties text area value map deskripsi untuk disimpan DB
            'deskripsi'    => $request->deskripsi,
            // Lakukan enkripsi Encode associative arrays variable letak files images list menjadi sebaris Text JSON String column schema untuk integrasi DB
            'gambar'       => json_encode($paths),
            // Bind reference lokasi text inputs
            'lokasi'       => $request->lokasi,
            // Bind value metadata form param tanggal_foto 
            'tanggal_foto' => $request->tanggal_foto,
            // Hubungkan properti value selector reference geosite dropdown parent list form values
            'geosite'      => $request->geosite,
        // Akhiri method API commit invocation command record insert row params
        ]);

        // Kembali kembalikan route navigasi arah browser user panel dashboard kembali via function index
        return redirect()->route('admin.galeri.index')
            // Seratkan tambahan Flash Message bag state success buat memberikan report text indicator status keberhasilan event pada system 
            ->with('success', 'Galeri berhasil ditambahkan!');
    // Akhiri body scope class store parameter definition method
    }

    // Method Handler Endpoint GET view edit yang mengharuskan 1 variable reference binding row data ID number parameters URL Route 
    public function edit($id)
    {
        // Select fetch retrieve dari DB data baris menggunakan Model API query pencarian id key, abort with fail error bila NotFound record items database server system
        $galeri      = Galeri::findOrFail($id);
        // Sinkronisasi dan bind memory array whitelist variables ke scope variables internal methods procedure parameter local array arguments mapping 
        $geositeList = $this->geositeList;
        // Buka blade View HTML forms rendering route template edit, passing argument dependencies variable properties model references 
        return view('admin.galeri.edit', compact('galeri', 'geositeList'));
    // Tutup definisi scope method HTTP edit handler get forms rendering UI callback function procedure definition method view return routing logic 
    }

    // HTTP PATCH / PUT Submit router API handler updates record model item references
    public function update(Request $request, $id)
    {
        // Proses validasi dan periksa existensi model resource data via params query builder untuk modifikasi object model bindings 
        $galeri = Galeri::findOrFail($id);

        // Map and extract key strings string whitelist rules params list options binding for internal use logic filter check validation param rules in 
        $validGeosites = implode(',', array_keys($this->geositeList));
        // Operasi Filter Check Data Inputs Validation System menggunakan Facades Request attributes HTTP body variables params lists constraint conditions params options 
        $request->validate([
            // Persyaratan limit filter untuk var attribute string length constraints limit max characters size param field rule judul input requirement checks valid condition arguments options 
            'judul'        => 'required|string|max:255',
            // Persyaratan params deskripsi opsional bisa dikosongin  
            'deskripsi'    => 'nullable|string',
            // File gambar dibolehkan kosong saat melakukan proses modifikasi data record DB
            'gambar'       => 'nullable|array|max:10',
            // Jika ada maka rule limit size attachments array dan mimes di berlakukan ketat secara individual loop item param 
            'gambar.*'     => 'image|mimes:jpeg,png,jpg,webp|max:10240',
            // Field optional batas character 255 length rules checks constraints 
            'lokasi'       => 'nullable|string|max:255',
            // Format param checks tanggal opsional rules checks constraints date checks valid formats param
            'tanggal_foto' => 'nullable|date',
            // Pastikan select values form params input option tidak melenceng diluar whitelist array options in param bounds map constraints valid in rules array list valid check 
            'geosite'      => "required|string|in:{$validGeosites}",
        // Custom message rules check fallback translation messages localization feedback notifications
        ], [
            // Max attachments upload limits message
            'gambar.max'     => 'Maksimal gambar yang dapat diunggah adalah 10 gambar sekaligus.',
            // Type warning message format
            'gambar.*.image' => 'Format file yang diunggah harus berupa gambar.',
            // Rule params extensions message  
            'gambar.*.mimes' => 'Gambar harus memiliki format: jpeg, png, jpg, webp.',
            // Limit files sizes upload limit warning params strings limits error warning exception params constraints validations 
            'gambar.*.max'   => 'Ukuran gambar maksimal adalah 10MB.',
            // Required general text message params rules fallback error messages exceptions localization 
            'required'       => 'Kolom :attribute wajib diisi.',
            // Rules exceptions for whitelist custom option errors params errors bindings mapping localization fallback errors translations params options messages warning message 
            'geosite.in'     => 'Geosite yang dipilih tidak valid.'
        // End array rules validation methods wrapper execution block rules constraint binding array mapping arguments definition validation checks
        ]);

        // Cek kembali ketersediaan profil_geosites relasi foreign dependencies data references row constraint rule DB untuk mencegah fatal exception 
        // Auto create placeholder entitas jika data relasi profil_geosites target tidak ditemukan 
        ProfilGeosite::firstOrCreate(['geosite' => $request->geosite]);

        // Susun parameter list attribute object map JSON value assignment persiapan eksekusi pembaruan API
        $data = [
            // Ambil dari payload input judul
            'judul'        => $request->judul,
            // Ambil dari payload input text body area
            'deskripsi'    => $request->deskripsi,
            // Payload lokasi attributes variables mapping params request values mappings params references assignment 
            'lokasi'       => $request->lokasi,
            // Payload dates references property model property values bindings params variables assignment references binding options mapping data parameters map values updates rules binding param 
            'tanggal_foto' => $request->tanggal_foto,
            // Pilihan param geosite request bindings values mappings properties rules constraints value mappings 
            'geosite'      => $request->geosite,
        // Selesaikan block rules assignment array objects mapping data parameters
        ];

        // Jalankan condition apabila user menggunggah batch attachments gambar modifikasi list pengganti properties files yang usang 
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama dari storage
            // Urai file string column records text dari query instance records lawas menggunakan PHP parse decoder library format options
            $oldGambar = json_decode($galeri->gambar, true);
            // Bypass null check guard statement array mapping jika memang format data valid objects parameters 
            if (is_array($oldGambar)) {
                // Loop pada list server directory addresses yang ditinggalkan file data images items variables reference string URL options paths variables pointers records 
                foreach ($oldGambar as $oldPath) {
                    // Prevent URL files string exceptions variables guard checking rules constraints conditions bindings rules checks exceptions checks pointers mappings URLs values
                    if ($oldPath && !str_starts_with($oldPath, 'data:')) {
                        // Perintah facade unlink files path pointer parameters references strings variables data disk properties files delete server commands procedures 
                        Storage::disk('public')->delete($oldPath);
                    // Akhiri exceptions URL rules block guard constraints conditions expressions pointers mappings limits restrictions rules guards validations paths pointers strings definitions pointers exceptions rules restrictions exceptions strings definitions pointers conditions rules restrictions guards logic block sub procedure  
                    }
                // Akhiri iterasi procedure loop rules list array paths URLs pointers references validations logic map
                }
            // Penutup IF filter guard validations format strings URL paths references
            }

            // Definisikan wadah penampungan lokasi directories params server mappings variables arrays string
            $paths = [];
            // Lakukan perulangan data arrays HTTP upload objects bindings files parameters params arrays list 
            foreach ($request->file('gambar') as $file) {
                // Jalankan proses store dan copy I/O stream ke public server directory untuk tiap attachments objects payload file
                $paths[] = $file->store('galeri', 'public');
            // Akhiri looping items array
            }
            // Convert list direktori server paths kembali jadi JSON column text format records map param
            $data['gambar'] = json_encode($paths);
        // Penutup check attachment rules conditions methods
        }

        // Commit perubahan object data attribute payload menggunakan Eloquent Object update mapping method execution database procedure
        $galeri->update($data);

        // Lepas thread browser redirect state handler HTTP URL route rules redirection params routing dashboard control UI navigasi navigations routes paths UI flow redirect URLs views HTTP redirection route 
        return redirect()->route('admin.galeri.index')
            // Embed info success status flag params notifications flash exceptions UI feedback messages text param rules messages rules strings notifications limits exceptions rules constraints  
            ->with('success', 'Galeri berhasil diupdate!');
    // Akhiri block logic method update class
    }

    // Method HTTP API Handler prosedur prosedur hapus object row items records procedure delete database URL ID param 
    public function destroy($id)
    {
        // Check query item existence dari params parameter constraint conditions checks database pointers rules bindings ID parameter 
        $galeri = Galeri::findOrFail($id);

        // Hapus semua file gambar dari storage
        // Decode kolom images URLs records params list arrays URL paths references URLs 
        $oldGambar = json_decode($galeri->gambar, true);
        // Periksa guard constraints exceptions conditions mappings arrays limits validations URLs mappings exceptions guard checks constraints exceptions guards conditions conditions parameters limits  
        if (is_array($oldGambar)) {
            // Loop iterate list of URLs param options files links pointers limits constraints checks references variables URLs string arrays 
            foreach ($oldGambar as $oldPath) {
                // Ignore base64 format URL files params pointers values files lists arrays URLs data 
                if ($oldPath && !str_starts_with($oldPath, 'data:')) {
                    // Lakukan delete call OS API storage library params paths options references strings pointers URLs
                    Storage::disk('public')->delete($oldPath);
                // End guard conditions loop URLs paths values references exceptions checks limits options references validations conditions guard checks rules expressions limits constraints validations arrays expressions mappings strings rules restrictions conditions limits conditions paths expressions strings validations conditions mappings URLs expressions checks limits constraints bindings mappings rules guards block sub rules logic conditions strings expressions checks limits rules logic guards checks expressions bindings constraints parameters rules options blocks mappings guards  
                }
            // End iteration blocks logic guard mappings rules expressions checks rules options strings conditions rules conditions limits expressions parameters
            }
        // End array format guard conditions 
        }

        // Eksekusi trigger method ORM Eloquent drop rules checks rows definitions database deletion APIs URL
        $galeri->delete();

        // Operasi navigasi UI redirect route fallback URL HTTP response routes mappings
        return redirect()->route('admin.galeri.index')
            // Serahkan Session Flash variable untuk display UI notifications exception text string 
            ->with('success', 'Galeri berhasil dihapus!');
    // Akhiri definisi scope function blok procedure destroy method
    }
// Penutup class definisi class kontroler
}
