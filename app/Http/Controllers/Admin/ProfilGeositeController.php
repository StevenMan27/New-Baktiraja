<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProfilGeosite;
use Illuminate\Support\Facades\Storage;

class ProfilGeositeController extends Controller
{
    private $geosites = [
        'air-terjun-janji' => 'Air Terjun Janji',
        'aek-sitio-tio' => 'Aek Sitio-tio',
        'desa-wisata-tipang' => 'Desa Wisata Tipang',
        'panatapan-bakara' => 'Panatapan Bakara',
        'gonting' => 'Gonting',
        'istana-sisingamangaraja' => 'Istana Sisingamangaraja',
        'tombak-sulu-sulu' => 'Tombak Sulu-sulu',
        'aek-sipangolu' => 'Aek Sipangolu'
    ];

    public function index()
    {
        $profiles = ProfilGeosite::all()->keyBy('geosite');
        return view('admin.profil.index', [
            'geosites' => $this->geosites,
            'profiles' => $profiles
        ]);
    }

    public function edit($geosite)
    {
        if (!array_key_exists($geosite, $this->geosites)) {
            abort(404);
        }

        $profil = ProfilGeosite::where('geosite', $geosite)->first();
        if (!$profil) {
            $profil = new ProfilGeosite(['geosite' => $geosite]);
        }

        return view('admin.profil.edit', [
            'profil' => $profil,
            'nama_geosite' => $this->geosites[$geosite]
        ]);
    }

    public function update(Request $request, $geosite)
    {
        if (!array_key_exists($geosite, $this->geosites)) {
            abort(404);
        }

        $request->validate([
            'judul_utama'         => 'nullable|string|max:255',
            'sub_judul'           => 'nullable|string|max:255',
            'bg_hero'             => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'deskripsi_1_judul'   => 'nullable|string|max:255',
            'deskripsi_1_teks'    => 'nullable|string',
            'deskripsi_2_judul'   => 'nullable|string|max:255',
            'deskripsi_2_teks'    => 'nullable|string',
            'deskripsi_2_gambar.*'=> 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'deskripsi_3_judul'   => 'nullable|string|max:255',
            'deskripsi_3_teks'    => 'nullable|string',
            'deskripsi_3_gambar.*'=> 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'deskripsi_4_judul'   => 'nullable|string|max:255',
            'deskripsi_4_teks'    => 'nullable|string',
            'deskripsi_4_gambar.*'=> 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'deskripsi_5_judul'   => 'nullable|string|max:255',
            'deskripsi_5_teks'    => 'nullable|string',
            'deskripsi_5_gambar.*'=> 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'info_lokasi'         => 'nullable|string|max:255',
            'info_jam'            => 'nullable|string|max:255',
            'info_harga'          => 'nullable|string|max:255',
            'tags'                => 'nullable|string',
            // Menerima URL Google Maps dalam format apapun: link pendek (maps.app.goo.gl),
            // link share panjang, maupun URL embed yang sudah jadi
            'maps_link'           => 'nullable|string|max:2000',
        ]);

        // Mengambil semua field teks dari request kecuali token CSRF, method override, dan field file
        // karena file gambar diproses secara terpisah di bawah menggunakan Storage::disk
        $data = $request->except(['_token', '_method', 'bg_hero', 'deskripsi_2_gambar', 'deskripsi_3_gambar', 'deskripsi_4_gambar', 'deskripsi_5_gambar', 'tags']);

        // Konversi URL Google Maps yang dimasukkan admin menjadi URL embed yang siap ditampilkan
        // di dalam iframe. Admin cukup menempel link Google Maps apapun tanpa perlu tahu format embed.
        if ($request->filled('maps_link')) {
            $data['maps_link'] = $this->convertGoogleMapsToEmbed(trim($request->input('maps_link')));
        } else {
            $data['maps_link'] = null;
        }

        // Handle Tags (Convert comma separated to array)
        if ($request->filled('tags')) {
            $tagsArray = array_map('trim', explode(',', $request->tags));
            $data['tags'] = $tagsArray; // Model will cast to array/json
        } else {
            $data['tags'] = [];
        }

        $profil = ProfilGeosite::where('geosite', $geosite)->first();

        // Handle Background Hero Upload
        if ($request->hasFile('bg_hero')) {
            // Delete old file
            if ($profil && $profil->bg_hero) {
                $oldBg = is_array($profil->bg_hero) ? ($profil->bg_hero[0] ?? null) : null;
                if ($oldBg && !str_starts_with($oldBg, 'data:')) {
                    Storage::disk('public')->delete($oldBg);
                }
            }
            $path = $request->file('bg_hero')->store('profil', 'public');
            $data['bg_hero'] = [$path]; // Store as JSON array for consistency with ImageHelper
        }

        // Handle Deskripsi 2 Gambar Upload
        if ($request->hasFile('deskripsi_2_gambar')) {
            if ($profil && is_array($profil->deskripsi_2_gambar)) {
                foreach ($profil->deskripsi_2_gambar as $oldPath) {
                    if ($oldPath && !str_starts_with($oldPath, 'data:')) Storage::disk('public')->delete($oldPath);
                }
            }
            $paths = [];
            foreach ($request->file('deskripsi_2_gambar') as $image) $paths[] = $image->store('profil', 'public');
            $data['deskripsi_2_gambar'] = $paths;
        }

        if ($request->hasFile('deskripsi_3_gambar')) {
            if ($profil && is_array($profil->deskripsi_3_gambar)) {
                foreach ($profil->deskripsi_3_gambar as $oldPath) {
                    if ($oldPath && !str_starts_with($oldPath, 'data:')) Storage::disk('public')->delete($oldPath);
                }
            }
            $paths = [];
            foreach ($request->file('deskripsi_3_gambar') as $image) $paths[] = $image->store('profil', 'public');
            $data['deskripsi_3_gambar'] = $paths;
        }

        if ($request->hasFile('deskripsi_4_gambar')) {
            if ($profil && is_array($profil->deskripsi_4_gambar)) {
                foreach ($profil->deskripsi_4_gambar as $oldPath) {
                    if ($oldPath && !str_starts_with($oldPath, 'data:')) Storage::disk('public')->delete($oldPath);
                }
            }
            $paths = [];
            foreach ($request->file('deskripsi_4_gambar') as $image) $paths[] = $image->store('profil', 'public');
            $data['deskripsi_4_gambar'] = $paths;
        }

        if ($request->hasFile('deskripsi_5_gambar')) {
            if ($profil && is_array($profil->deskripsi_5_gambar)) {
                foreach ($profil->deskripsi_5_gambar as $oldPath) {
                    if ($oldPath && !str_starts_with($oldPath, 'data:')) Storage::disk('public')->delete($oldPath);
                }
            }
            $paths = [];
            foreach ($request->file('deskripsi_5_gambar') as $image) $paths[] = $image->store('profil', 'public');
            $data['deskripsi_5_gambar'] = $paths;
        }

        if ($profil) {
            $profil->update($data);
        } else {
            $data['geosite'] = $geosite;
            ProfilGeosite::create($data);
        }

        return redirect()->route('admin.profil.index')
            ->with('success', "Profil {$this->geosites[$geosite]} berhasil diupdate!");
    }

    /**
     * Mengubah URL Google Maps dalam format apapun menjadi URL embed yang dapat ditampilkan
     * di dalam tag iframe di halaman publik.
     *
     * Fungsi ini menangani tiga jenis URL yang mungkin dimasukkan admin:
     * 1. URL pendek (maps.app.goo.gl atau goo.gl) — diselesaikan dulu via cURL lalu dikonversi
     * 2. URL share panjang (google.com/maps/place/...) — diambil koordinat atau nama tempatnya
     * 3. URL embed (sudah mengandung /maps/embed atau output=embed) — dikembalikan apa adanya
     *
     * Jika semua pola gagal, URL asli dikembalikan sebagai fallback tanpa modifikasi.
     */
    private function convertGoogleMapsToEmbed(?string $url): ?string
    {
        if (empty($url)) {
            return null;
        }

        // Jika URL sudah berformat embed yang siap pakai, langsung kembalikan tanpa perubahan
        if (str_contains($url, '/maps/embed') || str_contains($url, 'output=embed')) {
            return $url;
        }

        // Selesaikan URL pendek seperti maps.app.goo.gl dengan mengikuti redirect menggunakan cURL.
        // cURL akan mengikuti semua redirect hingga mendapat URL akhir yang lengkap dari Google Maps.
        if (str_contains($url, 'goo.gl') || str_contains($url, 'maps.app')) {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_NOBODY, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36');
            curl_exec($ch);
            $resolvedUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
            curl_close($ch);

            // Gunakan URL yang sudah diselesaikan jika hasilnya berbeda dari URL awal
            if (!empty($resolvedUrl) && $resolvedUrl !== $url) {
                $url = $resolvedUrl;
            }
        }

        // Coba ambil koordinat latitude, longitude, dan zoom dari URL Google Maps lengkap.
        // Pola @lat,lng,zoomz adalah standar yang ada di URL Google Maps saat melihat lokasi.
        if (preg_match('/@([-\d.]+),([-\d.]+),([\d.]+)z/', $url, $matches)) {
            $lat  = $matches[1];
            $lng  = $matches[2];
            $zoom = intval($matches[3]);
            // Pastikan minimal zoom 18 agar tampilannya langsung memperbesar titik lokasi
            $zoom = max($zoom, 18);
            return "https://maps.google.com/maps?q={$lat},{$lng}&z={$zoom}&output=embed";
        }

        // Jika koordinat tidak ditemukan, coba ambil nama tempat dari segmen URL /place/NAMA/
        // lalu jadikan sebagai query pencarian dalam URL embed dengan zoom default 18
        if (preg_match('/place\/([^\/@?&#]+)/', $url, $matches)) {
            $placeName = rawurldecode(str_replace('+', ' ', $matches[1]));
            return 'https://maps.google.com/maps?q=' . rawurlencode($placeName) . '&z=18&output=embed';
        }

        // Jika URL adalah Google Maps namun tidak memiliki parameter output=embed, tambahkan
        if (str_contains($url, 'google.com/maps') || str_contains($url, 'maps.google.com')) {
            $separator = str_contains($url, '?') ? '&' : '?';
            return $url . $separator . 'output=embed';
        }

        // Fallback: kembalikan URL asli jika tidak ada pola yang cocok
        return $url;
    }
}




