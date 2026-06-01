<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use App\Models\ProfilGeosite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GaleriController extends Controller
{
    private array $geositeList = [
        'aek-sipangolu' => 'Aek Sipangolu',
        'aek-sitio-tio' => 'Aek Sitio-tio',
        'air-terjun-janji' => 'Air Terjun Janji',
        'desa-wisata-tipang' => 'Desa Tipang',
        'gonting' => 'Gonting',
        'istana-sisingamangaraja' => 'Istana Sisingamangaraja',
        'panatapan-bakara' => 'Panatapan Bakara',
        'tombak-sulu-sulu' => 'Tombak Sulu-sulu'
    ];

    public function index()
    {
        $galeris = Galeri::latest()->paginate(10);
        return view('admin.galeri.index', compact('galeris'));
    }

    public function create()
    {
        $geositeList = $this->geositeList;
        return view('admin.galeri.create', compact('geositeList'));
    }

    public function store(Request $request)
    {
        $validGeosites = implode(',', array_keys($this->geositeList));
        $request->validate([
            'judul'        => 'required|string|max:255',
            'deskripsi'    => 'nullable|string',
            'gambar'       => 'required|image|mimes:jpeg,png,jpg,webp|max:4096',
            'lokasi'       => 'nullable|string|max:255',
            'tanggal_foto' => 'nullable|date',
            'geosite'      => "required|string|in:{$validGeosites}",
        ]);

        // Pastikan geosite ada di database profil_geosites untuk mencegah foreign key error
        ProfilGeosite::firstOrCreate(['geosite' => $request->geosite]);

        $path = $request->file('gambar')->store('galeri', 'public');

        Galeri::create([
            'judul'        => $request->judul,
            'deskripsi'    => $request->deskripsi,
            'gambar'       => json_encode([$path]),
            'lokasi'       => $request->lokasi,
            'tanggal_foto' => $request->tanggal_foto,
            'geosite'      => $request->geosite,
        ]);

        return redirect()->route('admin.galeri.index')
            ->with('success', 'Galeri berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $galeri      = Galeri::findOrFail($id);
        $geositeList = $this->geositeList;
        return view('admin.galeri.edit', compact('galeri', 'geositeList'));
    }

    public function update(Request $request, $id)
    {
        $galeri = Galeri::findOrFail($id);

        $validGeosites = implode(',', array_keys($this->geositeList));
        $request->validate([
            'judul'        => 'required|string|max:255',
            'deskripsi'    => 'nullable|string',
            'gambar'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'lokasi'       => 'nullable|string|max:255',
            'tanggal_foto' => 'nullable|date',
            'geosite'      => "required|string|in:{$validGeosites}",
        ]);

        // Pastikan geosite ada di database profil_geosites untuk mencegah foreign key error
        ProfilGeosite::firstOrCreate(['geosite' => $request->geosite]);

        $data = [
            'judul'        => $request->judul,
            'deskripsi'    => $request->deskripsi,
            'lokasi'       => $request->lokasi,
            'tanggal_foto' => $request->tanggal_foto,
            'geosite'      => $request->geosite,
        ];

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama dari storage
            $oldGambar = json_decode($galeri->gambar, true);
            if (is_array($oldGambar)) {
                foreach ($oldGambar as $oldPath) {
                    if ($oldPath && !str_starts_with($oldPath, 'data:')) {
                        Storage::disk('public')->delete($oldPath);
                    }
                }
            }

            $path = $request->file('gambar')->store('galeri', 'public');
            $data['gambar'] = json_encode([$path]);
        }

        $galeri->update($data);

        return redirect()->route('admin.galeri.index')
            ->with('success', 'Galeri berhasil diupdate!');
    }

    public function destroy($id)
    {
        $galeri = Galeri::findOrFail($id);

        // Hapus semua file gambar dari storage
        $oldGambar = json_decode($galeri->gambar, true);
        if (is_array($oldGambar)) {
            foreach ($oldGambar as $oldPath) {
                if ($oldPath && !str_starts_with($oldPath, 'data:')) {
                    Storage::disk('public')->delete($oldPath);
                }
            }
        }

        $galeri->delete();

        return redirect()->route('admin.galeri.index')
            ->with('success', 'Galeri berhasil dihapus!');
    }
}
