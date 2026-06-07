<?php

// Tanda awal mulai dokumen bahasa pemrograman PHP
// Pemberian deklarasi namespace menentukan posisi file class kontroler 
namespace App\Http\Controllers\Admin;

// Import deklarasi Parent Class framework laravel
use App\Http\Controllers\Controller;
// Import API Model dari entitas tabel Informasi 
use App\Models\Informasi;
// Import Model API profilgeosite buat urusan integrity foreign keys mapping dependencies tabel
use App\Models\ProfilGeosite;
// Memanggil use Http Request milik laravel guna menangkap body forms
use Illuminate\Http\Request;
// Panggil kelas Facade Storage guna urusan penyimpanan gambar attachment file di server
use Illuminate\Support\Facades\Storage;

// Buat deklarasi definisi class InformasiController yang mewariskan kelas controller admin utama
class InformasiController extends Controller {
    /*
       [CONTROLLER ADMIN InformasiController]
       File ini bertugas mengontrol logika untuk bagian admin dari InformasiController.
       Berfungsi mengatur operasi CRUD (Create, Read, Update, Delete) pada database.
       Tabel Database yang digunakan: berhubungan erat dengan entitas InformasiController.
    */
    // Sediakan list definisi dictionary array pemetaan private mapping values
    private array $geositeList = [
        // Assign value pemetaan map 'Aek Sipangolu'
        'aek-sipangolu' => 'Aek Sipangolu',
        // Assign value pemetaan map 'Aek Sitio-tio'
        'aek-sitio-tio' => 'Aek Sitio-tio',
        // Assign map value 'Air Terjun Janji'
        'air-terjun-janji' => 'Air Terjun Janji',
        // Assign value string desa wisata tipang mapping
        'desa-wisata-tipang' => 'Desa Tipang',
        // Binding keys gonting values definitions
        'gonting' => 'Gonting',
        // Key pair values Istana sisingamangaraja bindings
        'istana-sisingamangaraja' => 'Istana Sisingamangaraja',
        // Nilai pair pemetaan keys untuk panatapan bakara 
        'panatapan-bakara' => 'Panatapan Bakara',
        // Set referensi string key dan string values array untuk tombak-sulu-sulu
        'tombak-sulu-sulu' => 'Tombak Sulu-sulu'
    // Akhiri definisi scope penempatan nilai variable mappings dictionary
    ];

    // Method publik index dipanggil oleh routing sistem framework pas halaman listing admin dibuka
    public function index()
    {
        // Jalankan function Query Model Eloquent pada entity tabel lalu paginasi urutan limit data 10 records per pages
        $informasi = Informasi::latest()->paginate(10);
        // Direct ke admin folder view, terus lewatkan object collection informasi via compact variables mapping argument
        return view('admin.informasi.index', compact('informasi'));
    // Tutup definisi scope method HTTP HTTP index handler functions
    }

    // Method publik create dijalankan untuk rute form Create admin
    public function create()
    {
        // Sediakan bindings variabel dropdown options lokal diambil dari dictionary referensi geositeList 
        $geositeList = $this->geositeList;
        // Buka form UI HTML dan lempar property dictionary keys geosite untuk di looping sebagai elemen dropdown option form rendering template 
        return view('admin.informasi.create', compact('geositeList'));
    // Tutup definitions block logic forms routing HTTP actions view renders
    }

    // Method prosedural khusus eksekusi HTTP POST dari user yang men-submit forms insert database row 
    public function store(Request $request)
    {
        // Concatenation string pisahkan memakai tanda comma dari list semua keys valid parameters
        $validGeosites = implode(',', array_keys($this->geositeList));
        // Lakukan Filter constraint menggunakan validations forms API rules methods 
        $request->validate([
            // Input nama form kolom 'judul' wajib, berukuran gak boleh lewat dari batas 255 teks
            'judul'   => 'required|string|max:255',
            // Wajib mengisi teks html pada bagian deskripsi body 'konten'
            'konten'  => 'required|string',
            // Files input 'gambar' opsional/boleh ditinggal, harus files jenis image mimes jpeg png webp limits ukurannya 10Mb max options mappings restrictions  
            'gambar'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            // Syarat valid field form dropdown 'geosite' must ada dan termaktub di dalam valid string daftar kunci limits
            'geosite' => "required|string|in:{$validGeosites}",
        // Sediakan terjemahan message translations array parameters
        ], [
            // Pesan string limits fallback types validation failed 
            'gambar.image' => 'Format file yang diunggah harus berupa gambar.',
            // Translation formats fallback error message constraints 
            'gambar.mimes' => 'Gambar harus memiliki format: jpeg, png, jpg, webp.',
            // Feedback error saat attachment filesize melebih limit bounds exceptions
            'gambar.max'   => 'Ukuran gambar maksimal adalah 10MB.',
            // String default parameters translations validations untuk null forms body rules errors limits
            'required'     => 'Kolom :attribute wajib diisi.',
            // Kustom teks saat data list dropdown yang di POST is illegal limits exceptions options bindings
            'geosite.in'   => 'Geosite yang dipilih tidak valid.'
        // Akhiri scope constraints validator params mapping definitions checks logic
        ]);

        // Jaga agar database foreign keys relation references mapping di DB tetep ada dan utuh di parent entities maps tables options validations 
        // Force bikin records entities referensi geosite mapping references
        ProfilGeosite::firstOrCreate(['geosite' => $request->geosite]);

        // Rakit data dictionary JSON attributes map assignments mappings values assignments parameters exceptions options variables
        $data = [
            // Assignment input form value data kolom text value mapping limits rules strings
            'judul'   => $request->judul,
            // Binding body text values string limits forms mappings variables string
            'konten'  => $request->konten,
            // Tentukan pilihan selector maps form parameters bindings data list option constraints options limits arrays strings params 
            'geosite' => $request->geosite,
        // Tutup dictionary mappings definitions arrays variables initialization
        ];

        // Lakukan guard check limits parameter options files parameter variables bounds 
        if ($request->hasFile('gambar')) {
            // Operasikan commands HTTP stream file limits bindings options OS directory files API executions return paths 
            $path = $request->file('gambar')->store('informasi', 'public');
            // Encode map path return bindings parameters strings variables values limits properties definitions records assignments 
            $data['gambar'] = json_encode([$path]);
        // Tutup scopes checks boundaries expressions limits logic conditions logic options bounds limits
        }

        // Commit perintah model method query create rows SQL limits bindings values options API execution procedures limits executions
        Informasi::create($data);

        // Operasi navigations control views mappings URLs routes callbacks options URLs restrictions UI navigations routes definitions options
        return redirect()->route('admin.informasi.index')
            // Serahkan Session Flash variable rules status notifications bindings messages limitations UI exceptions parameters mappings translations strings
            ->with('success', 'Informasi berhasil ditambahkan!');
    // Akhiri definisi scope function store rules API callbacks handlers
    }

    // Blok Method fungsi HTTP API handler proses HTTP Edit Form GET action rujukan $id item row
    public function edit($id)
    {
        // Eksekusi API Database parameters constraints bindings fetch instances item DB 
        $informasi   = Informasi::findOrFail($id);
        // Hubungkan list options definitions parameters mappings arrays dictionaries exceptions options variables maps limits conditions arrays rules
        $geositeList = $this->geositeList;
        // Kembali panggil view bindings callbacks definitions properties rendering templates options params values arrays routes UI logics exceptions
        return view('admin.informasi.edit', compact('informasi', 'geositeList'));
    // Tutup definisi method edit API logic exceptions limits properties 
    }

    // Blok Methods Handler update rules API methods procedure forms endpoints mappings mappings mappings rules validations executions limits parameters constraints
    public function update(Request $request, $id)
    {
        // Search records mappings constraints parameters executions query API instances exceptions limitations
        $informasi = Informasi::findOrFail($id);

        // Urai filter string exclusions validations options mapping references limits params constraints mappings strings formats boundaries validations 
        $validGeosites = implode(',', array_keys($this->geositeList));
        // Lakukan sanitize body request limits arrays parameters rules options bindings boundaries limitations bounds constraints mapping arrays limits checks rules 
        $request->validate([
            // Params strings options rules check definitions formats
            'judul'   => 'required|string|max:255',
            // Params limits constraints definitions parameters formats rules limits definitions constraints
            'konten'  => 'required|string',
            // Rules limit attachments exclusions params limit sizes definitions options strings
            'gambar'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            // Validations limits select drops downs params conditions mappings arrays validations 
            'geosite' => "required|string|in:{$validGeosites}",
        // Validations params limit translation messages error
        ], [
            // Teks pesanan fallback validasi error forms params
            'gambar.image' => 'Format file yang diunggah harus berupa gambar.',
            // Format exception params translations strings messages mappings options
            'gambar.mimes' => 'Gambar harus memiliki format: jpeg, png, jpg, webp.',
            // Feedback error limits parameters constraints validations bindings arrays messages
            'gambar.max'   => 'Ukuran gambar maksimal adalah 10MB.',
            // Default params limit constraints expressions mappings rules arrays parameters exceptions mappings boundaries messages
            'required'     => 'Kolom :attribute wajib diisi.',
            // Custom rules definitions exclusions strings bindings expressions messages exceptions messages limits logic validations definitions
            'geosite.in'   => 'Geosite yang dipilih tidak valid.'
        // Keluar blok guard methods validations exclusions limits
        ]);

        // Lakukan sanity checks definitions rules logic conditions arrays constraints mapping relationships foreign definitions exceptions constraints limits boundaries rules mappings exceptions relations constraints bounds checks boundaries 
        // Binding relations limits API execution parameters bounds validations relationships models queries methods relationships definitions constraints API calls rules parameters restrictions variables bindings
        ProfilGeosite::firstOrCreate(['geosite' => $request->geosite]);

        // Initialization var arrays payload inputs definitions variables structures rules validations limits configurations parameters formats boundaries  
        $data = [
            // Mapping values strings templates URLs definitions limitations validations mappings values
            'judul'   => $request->judul,
            // Assignment input references parameters rules exceptions limitations arrays
            'konten'  => $request->konten,
            // Mappings limits fields definitions values configurations
            'geosite' => $request->geosite,
        // Tutup dictionary
        ];

        // Guard validations checks exclusions bounds files formats options params conditions checks guards limits
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama dari storage
            // Urai JSON string columns references arrays limits bounds exceptions bounds 
            $oldGambar = json_decode($informasi->gambar, true);
            // Array params mappings constraints bindings loops variables limits options conditions exceptions parameters exclusions limits bounds restrictions
            if (is_array($oldGambar)) {
                // Perulangan constraints bounds limits conditions executions loops conditions exceptions limits bounds options loops constraints
                foreach ($oldGambar as $oldPath) {
                    // Cek formats rules mappings exceptions URLs definitions bindings checks params loops constraints arrays exclusions configurations definitions validations limits conditionals bindings parameters validations checks formats rules mappings bounds limitations configurations definitions parameters validations
                    if ($oldPath && !str_starts_with($oldPath, 'data:')) {
                        // Jalankan disk deletion methods procedures definitions parameters limits constraints validations APIs definitions rules limits bindings references loops params mappings APIs bounds exceptions validations constraints validations exceptions params strings
                        Storage::disk('public')->delete($oldPath);
                    // Akhiri exceptions guards conditions validations limits bindings validations limits
                    }
                // Akhiri loops exclusions conditions variables limits expressions parameters mappings expressions validations 
                }
            // Akhiri checks mappings conditions validations expressions variables limits conditions formats bounds validations restrictions expressions checks rules guards validations limits conditionals formats arrays limits validations formats conditionals guards constraints parameters limits conditionals 
            }

            // Operasi params store configurations files rules boundaries configurations exclusions parameters validations strings conditions files executions limits rules bindings definitions constraints URLs definitions mappings validations configurations strings boundaries formats 
            $path = $request->file('gambar')->store('informasi', 'public');
            // Encode json definitions values formats parameters strings rules validations properties mappings strings definitions exceptions boundaries definitions constraints limits values conditions rules definitions URLs bindings rules limitations arrays values formats limits mappings variables limitations restrictions URLs limitations validations boundaries bindings values formats bindings conditionals
            $data['gambar'] = json_encode([$path]);
        // Akhiri rules parameters bounds conditions validations conditionals logic formats validations boundaries 
        }

        // Jalankan perintah API configurations rules limitations queries SQL boundaries bindings URLs properties arrays models limitations bindings executions constraints models properties rules models constraints executions constraints exceptions variables rules mappings definitions formats constraints conditions strings
        $informasi->update($data);

        // Operasikan routing callbacks rules validations APIs properties rules bindings exceptions strings limits URLs validations exceptions expressions definitions arrays formats conditions arrays exclusions mappings definitions validations expressions
        return redirect()->route('admin.informasi.index')
            // Serahkan params mappings constraints bindings boundaries exceptions validations properties UI feedbacks 
            ->with('success', 'Informasi berhasil diupdate!');
    // Akhiri blok definitions procedures bounds conditionals formats
    }

    // Blok Methods API procedures limitations bounds exceptions mappings definitions limits APIs conditionals bounds checks boundaries exceptions mappings limits expressions validations limitations mappings definitions rules boundaries exceptions configurations mappings validations
    public function destroy($id)
    {
        // Cari bindings parameters bindings validations limits definitions URLs limits properties executions arrays parameters mappings exceptions rules limitations arrays constraints validations properties
        $informasi = Informasi::findOrFail($id);

        // Hapus semua file gambar dari storage
        // Decode kolom images URLs records params list arrays URL paths references URLs 
        $oldGambar = json_decode($informasi->gambar, true);
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
        $informasi->delete();

        // Operasi navigasi UI redirect route fallback URL HTTP response routes mappings
        return redirect()->route('admin.informasi.index')
            // Serahkan Session Flash variable untuk display UI notifications exception text string 
            ->with('success', 'Informasi berhasil dihapus!');
    // Akhiri definisi scope function blok procedure destroy method
    }
// Penutup class definisi class kontroler
}
