<?php

// Memulai file PHP
// Deklarasikan namespace untuk kelas kontroler yang bertempat di folder Admin
namespace App\Http\Controllers\Admin;

// Import kelas dasar Controller agar bisa di-extend
use App\Http\Controllers\Controller;
// Import kelas Request milik Illuminate Http untuk menghandle HTTP variables/parameters
use Illuminate\Http\Request;
// Import Model Homepage untuk akses relasi dan tabel database Homepage
use App\Models\Homepage;
// Import Facade Storage untuk manipulasi file-file server
use Illuminate\Support\Facades\Storage;

// Deklarasi class HomepageController yang mewarisi class Controller utama 
class HomepageController extends Controller {
    /*
       [CONTROLLER ADMIN HomepageController]
       File ini bertugas mengontrol logika untuk bagian admin dari HomepageController.
       Berfungsi mengatur operasi CRUD (Create, Read, Update, Delete) pada database.
       Tabel Database yang digunakan: berhubungan erat dengan entitas HomepageController.
    */
    
    // Method edit untuk menghandle HTTP Request menuju halaman edit configurasi homepage
    public function edit()
    {
        // Mencoba mendapatkan record configurasi homepage pertama dari database, kalau belum ada akan otomatis dibikinkan instance record kosong baru
        $homepage = Homepage::firstOrCreate([]);

        // Lakukan perhitungan pengecekan slot relasi anak (destinasi) dari model homepage, apakah kurang dari 8 slot?
        if ($homepage->destinasis()->count() < 8) {
            // Jika kurang dari 8, tampung jumlah slot destinasi eksisting saat ini ke dalam variabel local currentCount
            $currentCount = $homepage->destinasis()->count();
            // Lakukan iterasi perulangan for loop untuk mengisi kekurangan slot dari slot saat ini sampai ke-8
            for ($i = $currentCount + 1; $i <= 8; $i++) {
                // Di tiap iterasinya, panggil API model relasi untuk create slot destinasi kosong yang baru di DB
                $homepage->destinasis()->create([]);
            // Akhiri iterasi loop pembuatan slot 
            }
        // Akhiri percabangan guard count slot pengecekan
        }

        // Panggil dan eksekusi instruksi eager-loading via relasi destinasis supaya objek-objek destinasi tersimpan dalam array properties homepage siap disajikan tanpa query ulang N+1 problem
        $homepage->load('destinasis');

        // Buka proses render dan kirim lemparan instruksi ke routing template blade view edit yang letaknya ada pada folder admin/homepage, bawa data object mapping $homepage
        return view('admin.homepage.edit', compact('homepage'));
    // Akhiri body fungsi kontrol edit rendering views
    }

    // Method fungsi untuk memproses endpoint HTTP PUT/PATCH simpan settingan update Homepage parameter 
    public function update(Request $request)
    {
        // Panggil dan fetch record item homepage dari DB, atau jalankan create record placeholder kalau memang belum ada di DB 
        $homepage = Homepage::firstOrCreate([]);

        // Panggil API Validasi pada objek Requests untuk melakukan filter pembersihan masukan form input 
        $request->validate([
            // Limitasi upload maksimum array slide heroes sampai maksimal 6 form array parameter inputs
            'hero_slides'              => 'nullable|array|max:6',
            // Ketatkan filter input file stream ke semua child list element array, pastikan harus merupakan tipe MIME file gambar, ukuran maksimal tidak lewat 10Mb
            'hero_slides.*'            => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            // Lakukan limit filter pada tipe video untuk mime mp4/webm dengan ukuran limit 200 Megabytes limit restrictions
            'about_video'              => 'nullable|mimetypes:video/mp4,video/webm|max:204800',
            // Proses validasi child array file attachment destinasi_gambar dengan aturan MIME tipe picture file extensions max 10 mb limits limits validations constraints
            'destinasi_gambar.*'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            // Field URL strings maps link diperbolehkan kosong namun punya limit string max 2000 character length sizes
            'maps_link'                => 'nullable|string|max:2000',
            // Terapkan batasan jumlah element button maps arrays paling banyak cuman bisa nampung 5 tombol buttons
            'maps_buttons'             => 'nullable|array|max:5',
            // Cek setiap button pada loop item untuk text label nama property limit string
            'maps_buttons.*.nama'      => 'nullable|string|max:100',
            // Limit string url link buttons string check params list strings values 
            'maps_buttons.*.link'      => 'nullable|string|max:2000',
        // Terapkan argumen arrays param list pesanan terjemahan string errors custom saat return false validate methods
        ], [
            // Pesan error warning terjemahan manakala total slide lampiran lewat batas 6 limits max
            'hero_slides.max'              => 'Maksimal gambar slide yang dapat diunggah adalah 6.',
            // Fallback pesanan warning jika item individual di slides list berukuran membengkak 
            'hero_slides.*.max'            => 'Ukuran gambar slide maksimal adalah 10MB.',
            // Error exception params check saat ada mime files upload yang melenceng diluar image files format extensions
            'hero_slides.*.image'          => 'Format file slide harus berupa gambar.',
            // Peringatan buat parameter validasi about_video string rules check limits uploads size limits 
            'about_video.max'              => 'Ukuran video maksimal adalah 200MB.',
            // Warning types mimes saat lampiran bukan format yang disupport yakni wemb/mp4
            'about_video.mimetypes'        => 'Format video harus berupa MP4 atau WEBM.',
            // Limit attachments picture map loop message error 
            'destinasi_gambar.*.max'       => 'Ukuran gambar destinasi maksimal adalah 10MB.',
            // Destinasi file images files strings exceptions limits checks message translations 
            'destinasi_gambar.*.image'     => 'Format file destinasi harus berupa gambar.',
            // Warning messages validation array bounds bounds sizes errors lists translation strings
            'maps_buttons.max'             => 'Maksimal tombol lokasi yang dapat ditambahkan adalah 5.',
            // Fallback sizes validations params options translations checks rules parameters names translations arrays sizes validation 
            'maps_buttons.*.nama.max'      => 'Nama tombol maksimal 100 karakter.',
        // Keluar blok pendelegasian args rules validations filter sanitization arrays options
        ]);

        // Ciptakan variable $data untuk menampung properties body request tapi disaring (except) membuang meta-variable csrf params sama meta HTTP inputs params
        $data = $request->except(['_token', '_method', 'hero_slides', 'about_video', 'destinasi', 'destinasi_gambar', 'maps_buttons']);

        // Periksa kondisi nilai keberadaan maps_link input payload variables mappings options dari request user
        if ($request->filled('maps_link')) {
            // Bila ada, override input maps_link dengan output convertGoogleMapsToEmbed method local setelah di trim clean up white spaces strings mapping value params   
            $data['maps_link'] = $this->convertGoogleMapsToEmbed(trim($request->input('maps_link')));
        // Alternatif block rules untuk skenario apabila maps input dibiarkan kosong blank  
        } else {
            // Reset dan netralkan isi value var attributes ke null kosong
            $data['maps_link'] = null;
        // Penutup check conditions input maps rules logic
        }

        // Mulai pemprosesan bila HTTP forms submit params berisi kumpulan object arrays maps_buttons params 
        if ($request->has('maps_buttons')) {
            // Sediakan kontainer arrays sementara bernama buttons
            $buttons = [];
            // Buka loop perulangan setiap baris elemen buttons parameters dari input form admin
            foreach ($request->input('maps_buttons', []) as $btn) {
                // Filter elemen button menggunakan logic operator guard check jika isi value property 'nama' button tersebut benar benar ada exist dan tidak kosong whitespace   
                if (!empty(trim($btn['nama'] ?? ''))) {
                    // Masukkan map elemen array dictionary JSON dengan properti struct nama dan tautan link values mappings
                    $buttons[] = [
                        // Bind trim strings input field value nama mappings 
                        'nama' => trim($btn['nama']),
                        // Bind trim strings input field variables links params checks 
                        'link' => trim($btn['link'] ?? ''),
                    // Tutup item assignment lists append operations
                    ];
                // Akhiri scope validasi check string nama exist values limits restrictions
                }
            // Akhiri scope perulangan arrays button check rules iterations loop mapping validations  
            }
            // Serasikan daftar elemen string map ke dalam string properti data JSON UNESCAPED_UNICODE format conversion assignment variables params mapping 
            $data['maps_buttons'] = json_encode($buttons, JSON_UNESCAPED_UNICODE);
        // Terapkan cabang else check guard saat variables inputs list option parameter kosong atau belum tersedia saat submit HTTP methods
        } else {
            // Netralkan state variabel assignments arrays menjadi tipe object null pointer null values params 
            $data['maps_buttons'] = null;
        // Keluar logika cabang buttons parameters checks validations 
        }

        // Lakukan cek apabila array forms parameters mengangkut upload attachments body parameter array file uploads  
        if ($request->hasFile('hero_slides')) {
            // Tampung sekumpulan objek instances multipart streams file di variable buffer $files
            $files = $request->file('hero_slides');

            // Buka loop iterasi for limits batasan 1 sampai max 6 slot elements fields
            for ($i = 1; $i <= 6; $i++) {
                // Konkatenasi strings fields names rules references names mapping rules field definitions loops counter parameters variables rules 
                $field = 'hero_slide_' . $i;
                // Guard properties check kondisi bila property columns attributes record database lama eksis dan isinya non-kosong null pointers
                if ($homepage->$field) {
                    // Hubungi Facade storage library OS functions system API disk commands delete parameter properties delete execution
                    Storage::disk('public')->delete($homepage->$field);
                // Selesaikan guard exception checks delete loops rules validation guards  
                }
                // Netralkan pointer references arrays properties bindings rules values variables 
                $data[$field] = null;
            // Akhiri batas counter for loop limit fields names 
            }

            // Deklarasi initialization index loop limits rules bindings iterations bindings rules counts arrays
            $index = 1;
            // Iterate collections map limits loops variables pointers iterations variables lists parameters mappings limits elements validations values variables expressions maps   
            foreach ($files as $file) {
                // Guard restrictions checks exceptions arrays limits iterations counts mappings break exclusions breaks rules logic 
                if ($index > 6) break;
                // Bindings strings parameter properties definitions maps structures variables mapping definitions validations 
                $field = 'hero_slide_' . $index;
                // Operasi assignment dan execution storage library file store I/O stream commands parameters return limits values variables URLs map strings 
                $data[$field] = $file->store('homepage', 'public');
                // Increment counter loops limit validations conditions 
                $index++;
            // Tutup loops perulangan files items properties limits conditions iterations 
            }
        // Keluar kondisi logika forms uploads hero checks loops files guards restrictions bindings limits validations
        }

        // Cek kembali ketersediaan stream attachments untuk input field about_video values
        if ($request->hasFile('about_video')) {
            // Guard limit check apabila column record lama exist references parameter URL limit validation
            if ($homepage->about_video) {
                // Panggil OS Facade storage library functions parameter limits system calls rules exceptions bounds limit unlink files limits properties mapping URLs validations conditions 
                Storage::disk('public')->delete($homepage->about_video);
            // Tutup blok exception check
            }
            // Bind properties URL string limits mappings URL return assignments variables validations parameters checks methods API URLs exceptions storage options arrays 
            $data['about_video'] = $request->file('about_video')->store('homepage', 'public');
        // Selesaikan body block pengecekan tentang limit exception video mappings  
        }

        // Commit execution parameters bindings mappings variables objects array updates queries mappings attributes records models  
        $homepage->update($data);

        // Operasi filter pengecekan ada tidaknya HTTP Forms object arrays bernama destinasi inputs
        if ($request->has('destinasi')) {
            // Urai masing-masing iterasi mappings properties values parameters validations mappings
            foreach ($request->destinasi as $id => $destData) {
                // Lakukan fetch referensi queries model bindings database menggunakan pointer IDs exceptions 
                $destinasi = \App\Models\HomepageDestinasi::find($id);
                // Guard validations exception values rules mappings conditions properties records exceptions logic conditions 
                if ($destinasi) {
                    // Validasi cek apabila specific keys array files attachments uploads params mappings rules conditions mappings parameters strings options 
                    if ($request->hasFile("destinasi_gambar.{$id}")) {
                        // Guard check old references exception mappings arrays strings options pointers URLs  
                        if ($destinasi->gambar) {
                            // Disk I/O storage commands calls APIs exception mappings paths properties deletions paths options 
                            Storage::disk('public')->delete($destinasi->gambar);
                        // End checks validations files mappings expressions guards rules conditionals blocks  
                        }
                        // Lakukan assignment values overrides map strings properties records limits definitions URLs mappings validations params expressions API parameters calls expressions 
                        $destData['gambar'] = $request->file("destinasi_gambar.{$id}")->store('homepage/destinasi', 'public');
                    // Selesaikan scopes validations constraints conditionals exceptions logic structures guards  
                    }
                    // Commit update changes rules params values records instances bindings queries parameters limits 
                    $destinasi->update($destData);
                // Selesaikan conditions guards limitations exceptions blocks structures rules checks parameters exceptions logic blocks limits conditionals limitations  
                }
            // End loops iterasi arrays destinasi items bindings values logic mappings conditionals exceptions constraints parameters limits blocks exceptions  
            }
        // End if arrays limits mappings constraints conditionals exceptions bounds lists validations parameters checks  
        }

        // Alihkan halaman flow routes HTTP response redirects methods calls routes bounds parameters exceptions views callbacks options limits notifications feedbacks exceptions logic
        return redirect()->back()->with('success', 'Konfigurasi Homepage berhasil diperbarui.');
    // Penutup scopes procedures function handler API controllers logics rules exceptions  
    }

    // Deklarasi scopes functions helper privat local untuk proses strings convertion maps parameters 
    private function convertGoogleMapsToEmbed(?string $url): ?string
    {
        // Validasi apabila strings null exceptions rules boundaries limitations conditions logic guards validations 
        if (empty($url)) {
            // Netralkan returns methods boundaries variables APIs mappings callbacks results exceptions boundaries params 
            return null;
        // Tutup guards if
        }

        // Filter strings limitations contains methods queries exceptions rules embeddings patterns mappings strings  
        if (str_contains($url, '/maps/embed') || str_contains($url, 'output=embed')) {
            // Passthrough URL bypass patterns embeddings mappings references values validations checks conditions guards parameters limits rules 
            return $url;
        // Tutup logic exclusions 
        }

        // Inspeksi strings parameter conditions check apabila format memakai rules goo.gl strings patterns maps mappings 
        if (str_contains($url, 'goo.gl') || str_contains($url, 'maps.app')) {
            // Inisialisasi system bindings curl library handles patterns bindings executions definitions APIs 
            $ch = curl_init($url);
            // Tambahkan ops options HTTP cURLs handles executions redirections limits rules options limits 
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            // Limitasi options HTTP APIs returns exceptions formats validations limits rules mappings 
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            // Ops limits exclusions bodies variables headers limits options definitions HTTP APIs configs validations 
            curl_setopt($ch, CURLOPT_NOBODY, true);
            // Timeout limits variables restrictions limits timeouts parameters mappings options limits configs params options APIs definitions params executions configs boundaries 
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            // Fake useragent assignments configurations definitions configurations boundaries HTTP constraints parameters validations APIs calls mappings configurations limitations strings  
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36');
            // Eksekusi trigger cURL executions requests parameters limitations APIs bindings values outputs limitations 
            curl_exec($ch);
            // Binding assignment params mappings effective URLs patterns values return limits definitions strings formats mappings APIs limits configs params boundaries references URLs values mappings restrictions
            $resolvedUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
            // Hentikan dan garbage collect curl instances memories parameters definitions limitations executions instances restrictions  
            curl_close($ch);

            // Periksa output hasil variables exclusions restrictions boundaries conditions validations mappings strings conditions constraints rules limitations options references values 
            if (!empty($resolvedUrl) && $resolvedUrl !== $url) {
                // Timpa dan re-assign references URL mappings boundaries strings limitations strings exceptions bounds params limits mappings constraints values validations 
                $url = $resolvedUrl;
            // Akhiri cabang options validations constraints params logics bounds exceptions logic 
            }
        // Keluar scopes checks exceptions definitions limitations bounds URLs strings patterns  
        }

        // Inspeksi regex patterns strings bounds conditions mappings exceptions parameters limit validations strings options limits expressions maps references strings URLs bindings 
        if (preg_match('/@([-\d.]+),([-\d.]+),([\d.]+)z/', $url, $matches)) {
            // Bindings array matches regex indices boundaries variables definitions strings limits mapping bounds options variables values variables options properties definitions exclusions strings  
            $lat  = $matches[1];
            // Limits checks strings regex formats limits rules properties exceptions bindings maps strings references parameters validations constraints URLs arrays bounds bindings limits values checks arrays
            $lng  = $matches[2];
            // Format conversions integer bounds limits parameters exceptions parameters boundaries mappings bounds rules limits variables mappings URLs constraints rules mappings strings lists constraints 
            $zoom = intval($matches[3]);
            // Filter max parameters constraints values bounds exceptions bounds mappings zoom validations limits boundaries variables definitions conditions mappings 
            $zoom = max($zoom, 18);
            // Format URL mappings embed variables values assignments strings templates properties mappings bindings return logics formats values boundaries exceptions references limits configurations URLs params properties strings
            return "https://maps.google.com/maps?q={$lat},{$lng}&z={$zoom}&output=embed";
        // End of regex logic boundaries checks exceptions parameters bindings params
        }

        // Guard strings restrictions regex checks conditions bindings parameters exceptions values URLs variables limitations arrays mappings limits conditionals parameters maps strings values limits validations strings limits validations bindings lists 
        if (preg_match('/place\/([^\/@?&#]+)/', $url, $matches)) {
            // Bersihkan strings formats limits exceptions strings configurations mappings limits bounds maps variables strings formats constraints limitations values mappings parameters limits validations URLs names boundaries
            $placeName = rawurldecode(str_replace('+', ' ', $matches[1]));
            // Return values strings templates URLs bindings params boundaries references configurations limits assignments formats restrictions rules limitations exceptions logic checks URLs parameters mappings options strings boundaries limits params 
            return 'https://maps.google.com/maps?q=' . rawurlencode($placeName) . '&z=18&output=embed';
        // End condition regex place limits params exceptions bindings logic strings bounds validations maps 
        }

        // Check format options google maps limits parameters configurations parameters URLs substrings exclusions boundaries strings conditionals checks strings variables URLs options 
        if (str_contains($url, 'google.com/maps') || str_contains($url, 'maps.google.com')) {
            // Tentukan operator concat string variables maps URLs options configurations strings limits params arrays conditions bounds exceptions URLs query checks validations parameters bindings mappings parameters limits params values
            $separator = str_contains($url, '?') ? '&' : '?';
            // Output returns URLs params boundaries parameters templates URLs variables bindings mappings restrictions strings exceptions values strings mappings 
            return $url . $separator . 'output=embed';
        // Akhiri bounds strings conditions logics constraints configurations validations 
        }

        // Default constraints returns parameters exceptions callbacks URLs validations strings URLs values mappings bindings references params configurations URLs restrictions mappings bounds mappings options validations 
        return $url;
    // Penutup function convertGoogleMaps bindings scopes APIs limits restrictions validations exceptions mappings procedures 
    }
// Tutup class controller scopes definitions procedures APIs limits validations 
}
