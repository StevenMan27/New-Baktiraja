<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Informasi;
use App\Models\ProfilGeosite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InformasiController extends Controller
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
        $informasi = Informasi::latest()->paginate(10);
        return view('admin.informasi.index', compact('informasi'));
    }

    public function create()
    {
        $geositeList = $this->geositeList;
        return view('admin.informasi.create', compact('geositeList'));
    }

    public function store(Request $request)
    {
        $validGeosites = implode(',', array_keys($this->geositeList));
        $request->validate([
            'judul'   => 'required|string|max:255',
            'konten'  => 'required|string',
            'gambar'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'geosite' => "required|string|in:{$validGeosites}",
        ], [
            'gambar.image' => 'Format file yang diunggah harus berupa gambar.',
            'gambar.mimes' => 'Gambar harus memiliki format: jpeg, png, jpg, webp.',
            'gambar.max'   => 'Ukuran gambar maksimal adalah 10MB.',
            'required'     => 'Kolom :attribute wajib diisi.',
            'geosite.in'   => 'Geosite yang dipilih tidak valid.'
        ]);

        // Pastikan geosite ada di database profil_geosites untuk mencegah foreign key error
        ProfilGeosite::firstOrCreate(['geosite' => $request->geosite]);

        $data = [
            'judul'   => $request->judul,
            'konten'  => $request->konten,
            'geosite' => $request->geosite,
        ];

        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('informasi', 'public');
            $data['gambar'] = json_encode([$path]);
        }

        Informasi::create($data);

        return redirect()->route('admin.informasi.index')
            ->with('success', 'Informasi berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $informasi   = Informasi::findOrFail($id);
        $geositeList = $this->geositeList;
        return view('admin.informasi.edit', compact('informasi', 'geositeList'));
    }

    public function update(Request $request, $id)
    {
        $informasi = Informasi::findOrFail($id);

        $validGeosites = implode(',', array_keys($this->geositeList));
        $request->validate([
            'judul'   => 'required|string|max:255',
            'konten'  => 'required|string',
            'gambar'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'geosite' => "required|string|in:{$validGeosites}",
        ], [
            'gambar.image' => 'Format file yang diunggah harus berupa gambar.',
            'gambar.mimes' => 'Gambar harus memiliki format: jpeg, png, jpg, webp.',
            'gambar.max'   => 'Ukuran gambar maksimal adalah 10MB.',
            'required'     => 'Kolom :attribute wajib diisi.',
            'geosite.in'   => 'Geosite yang dipilih tidak valid.'
        ]);

        // Pastikan geosite ada di database profil_geosites untuk mencegah foreign key error
        ProfilGeosite::firstOrCreate(['geosite' => $request->geosite]);

        $data = [
            'judul'   => $request->judul,
            'konten'  => $request->konten,
            'geosite' => $request->geosite,
        ];

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama dari storage
            $oldGambar = json_decode($informasi->gambar, true);
            if (is_array($oldGambar)) {
                foreach ($oldGambar as $oldPath) {
                    if ($oldPath && !str_starts_with($oldPath, 'data:')) {
                        Storage::disk('public')->delete($oldPath);
                    }
                }
            }

            $path = $request->file('gambar')->store('informasi', 'public');
            $data['gambar'] = json_encode([$path]);
        }

        $informasi->update($data);

        return redirect()->route('admin.informasi.index')
            ->with('success', 'Informasi berhasil diupdate!');
    }

    public function destroy($id)
    {
        $informasi = Informasi::findOrFail($id);

        // Hapus semua file gambar dari storage
        $oldGambar = json_decode($informasi->gambar, true);
        if (is_array($oldGambar)) {
            foreach ($oldGambar as $oldPath) {
                if ($oldPath && !str_starts_with($oldPath, 'data:')) {
                    Storage::disk('public')->delete($oldPath);
                }
            }
        }

        $informasi->delete();

        return redirect()->route('admin.informasi.index')
            ->with('success', 'Informasi berhasil dihapus!');
    }
}
