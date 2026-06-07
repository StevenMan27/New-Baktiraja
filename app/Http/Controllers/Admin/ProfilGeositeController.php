<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProfilGeosite;
use Illuminate\Support\Facades\Storage;

// Kontroler Admin Profil Geosite
// Mengelola operasi CRUD profil dan konfigurasi khusus dari setiap geosite di panel admin.
class ProfilGeositeController extends Controller {
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

    // Menampilkan Daftar Profil Geosite
    // Memuat seluruh daftar profil geosite dan menampilkannya pada halaman index profil.
    public function index()
    {
        $profiles = ProfilGeosite::all()->keyBy('geosite');
        return view('admin.profil.index', [
            'geosites' => $this->geosites,
            'profiles' => $profiles
        ]);
    }

    // Menampilkan Form Edit Profil Geosite
    // Mengambil data profil geosite berdasarkan slug dan merender form edit. Membuat objek baru jika profil belum ada.
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

    // Memperbarui Profil Geosite
    // Memvalidasi parameter yang diberikan, memproses unggahan file hero & deskripsi gambar, kemudian memperbarui record profil di database.
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
            'maps_link'           => 'nullable|string|max:2000',
        ]);

        $data = $request->except(['_token', '_method', 'bg_hero', 'deskripsi_2_gambar', 'deskripsi_3_gambar', 'deskripsi_4_gambar', 'deskripsi_5_gambar', 'tags']);

        if ($request->filled('maps_link')) {
            $data['maps_link'] = $this->convertGoogleMapsToEmbed(trim($request->input('maps_link')));
        } else {
            $data['maps_link'] = null;
        }

        if ($request->filled('tags')) {
            $tagsArray = array_map('trim', explode(',', $request->tags));
            $data['tags'] = $tagsArray;
        } else {
            $data['tags'] = [];
        }

        $profil = ProfilGeosite::where('geosite', $geosite)->first();

        if ($request->hasFile('bg_hero')) {
            if ($profil && $profil->bg_hero) {
                $oldBg = is_array($profil->bg_hero) ? ($profil->bg_hero[0] ?? null) : null;
                if ($oldBg && !str_starts_with($oldBg, 'data:')) {
                    Storage::disk('public')->delete($oldBg);
                }
            }
            $path = $request->file('bg_hero')->store('profil', 'public');
            $data['bg_hero'] = [$path];
        }

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

    // Konversi Link Maps
    // Mengubah berbagai format tautan Google Maps menjadi format embed yang valid untuk digunakan pada frame peta.
    private function convertGoogleMapsToEmbed(?string $url): ?string
    {
        if (empty($url)) {
            return null;
        }

        if (str_contains($url, '/maps/embed') || str_contains($url, 'output=embed')) {
            return $url;
        }

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

            if (!empty($resolvedUrl) && $resolvedUrl !== $url) {
                $url = $resolvedUrl;
            }
        }

        if (preg_match('/@([-\d.]+),([-\d.]+),([\d.]+)z/', $url, $matches)) {
            $lat  = $matches[1];
            $lng  = $matches[2];
            $zoom = intval($matches[3]);
            $zoom = max($zoom, 18);
            return "https://maps.google.com/maps?q={$lat},{$lng}&z={$zoom}&output=embed";
        }

        if (preg_match('/place\/([^\/@?&#]+)/', $url, $matches)) {
            $placeName = rawurldecode(str_replace('+', ' ', $matches[1]));
            return 'https://maps.google.com/maps?q=' . rawurlencode($placeName) . '&z=18&output=embed';
        }

        if (str_contains($url, 'google.com/maps') || str_contains($url, 'maps.google.com')) {
            $separator = str_contains($url, '?') ? '&' : '?';
            return $url . $separator . 'output=embed';
        }

        return $url;
    }
}
