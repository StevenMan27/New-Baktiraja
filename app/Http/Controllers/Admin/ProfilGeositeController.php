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
            'judul_utama' => 'nullable|string|max:255',
            'sub_judul' => 'nullable|string|max:255',
            'bg_hero' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'deskripsi_1_judul' => 'nullable|string|max:255',
            'deskripsi_1_teks' => 'nullable|string',
            'deskripsi_2_judul' => 'nullable|string|max:255',
            'deskripsi_2_teks' => 'nullable|string',
            'deskripsi_2_gambar.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'info_lokasi' => 'nullable|string|max:255',
            'info_jam' => 'nullable|string|max:255',
            'info_harga' => 'nullable|string|max:255',
            'tags' => 'nullable|string'
        ]);

        $data = $request->except(['_token', '_method', 'bg_hero', 'deskripsi_2_gambar', 'tags']);

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
            // Delete old files
            if ($profil && is_array($profil->deskripsi_2_gambar)) {
                foreach ($profil->deskripsi_2_gambar as $oldPath) {
                    if ($oldPath && !str_starts_with($oldPath, 'data:')) {
                        Storage::disk('public')->delete($oldPath);
                    }
                }
            }
            $paths = [];
            foreach ($request->file('deskripsi_2_gambar') as $image) {
                $paths[] = $image->store('profil', 'public');
            }
            $data['deskripsi_2_gambar'] = $paths;
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
}
