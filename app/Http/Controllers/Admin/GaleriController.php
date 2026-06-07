<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use App\Models\ProfilGeosite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

// Kontroler Admin Galeri
// Mengatur operasi CRUD pada entitas Galeri di bagian panel admin.
class GaleriController extends Controller {
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

    // Menampilkan Daftar Galeri
    // Memuat list item galeri yang diurutkan terbaru dan dipaginasi untuk halaman index.
    public function index()
    {
        $galeris = Galeri::latest()->paginate(10);
        return view('admin.galeri.index', compact('galeris'));
    }

    // Menampilkan Form Tambah Galeri
    // Mempersiapkan daftar pilihan geosite dan merender halaman form create galeri.
    public function create()
    {
        $geositeList = $this->geositeList;
        return view('admin.galeri.create', compact('geositeList'));
    }

    // Menyimpan Data Galeri Baru
    // Memvalidasi payload request, mengunggah multi-gambar, dan mencatat data ke database.
    public function store(Request $request)
    {
        $validGeosites = implode(',', array_keys($this->geositeList));
        $request->validate([
            'judul'        => 'required|string|max:255',
            'deskripsi'    => 'nullable|string',
            'gambar'       => 'required|array|max:10',
            'gambar.*'     => 'image|mimes:jpeg,png,jpg,webp|max:10240',
            'lokasi'       => 'nullable|string|max:255',
            'tanggal_foto' => 'nullable|date',
            'geosite'      => "required|string|in:{$validGeosites}",
        ], [
            'gambar.required' => 'Minimal satu gambar wajib diunggah.',
            'gambar.max'      => 'Maksimal gambar yang dapat diunggah adalah 10 gambar sekaligus.',
            'gambar.*.image'  => 'Format file yang diunggah harus berupa gambar.',
            'gambar.*.mimes'  => 'Gambar harus memiliki format: jpeg, png, jpg, webp.',
            'gambar.*.max'    => 'Ukuran gambar maksimal adalah 10MB.',
            'required'        => 'Kolom :attribute wajib diisi.',
            'geosite.in'      => 'Geosite yang dipilih tidak valid.'
        ]);

        ProfilGeosite::firstOrCreate(['geosite' => $request->geosite]);

        $paths = [];
        if ($request->hasFile('gambar')) {
            foreach ($request->file('gambar') as $file) {
                $paths[] = $file->store('galeri', 'public');
            }
        }

        Galeri::create([
            'judul'        => $request->judul,
            'deskripsi'    => $request->deskripsi,
            'gambar'       => json_encode($paths),
            'lokasi'       => $request->lokasi,
            'tanggal_foto' => $request->tanggal_foto,
            'geosite'      => $request->geosite,
        ]);

        return redirect()->route('admin.galeri.index')
            ->with('success', 'Galeri berhasil ditambahkan!');
    }

    // Menampilkan Form Edit Galeri
    // Mencari data spesifik berdasarkan ID dan menampilkannya pada form edit.
    public function edit($id)
    {
        $galeri      = Galeri::findOrFail($id);
        $geositeList = $this->geositeList;
        return view('admin.galeri.edit', compact('galeri', 'geositeList'));
    }

    // Memperbarui Data Galeri
    // Memvalidasi parameter update, menghapus file lama jika ada upload baru, dan mengupdate baris terkait di database.
    public function update(Request $request, $id)
    {
        $galeri = Galeri::findOrFail($id);

        $validGeosites = implode(',', array_keys($this->geositeList));
        $request->validate([
            'judul'        => 'required|string|max:255',
            'deskripsi'    => 'nullable|string',
            'gambar'       => 'nullable|array|max:10',
            'gambar.*'     => 'image|mimes:jpeg,png,jpg,webp|max:10240',
            'lokasi'       => 'nullable|string|max:255',
            'tanggal_foto' => 'nullable|date',
            'geosite'      => "required|string|in:{$validGeosites}",
        ], [
            'gambar.max'     => 'Maksimal gambar yang dapat diunggah adalah 10 gambar sekaligus.',
            'gambar.*.image' => 'Format file yang diunggah harus berupa gambar.',
            'gambar.*.mimes' => 'Gambar harus memiliki format: jpeg, png, jpg, webp.',
            'gambar.*.max'   => 'Ukuran gambar maksimal adalah 10MB.',
            'required'       => 'Kolom :attribute wajib diisi.',
            'geosite.in'     => 'Geosite yang dipilih tidak valid.'
        ]);

        ProfilGeosite::firstOrCreate(['geosite' => $request->geosite]);

        $data = [
            'judul'        => $request->judul,
            'deskripsi'    => $request->deskripsi,
            'lokasi'       => $request->lokasi,
            'tanggal_foto' => $request->tanggal_foto,
            'geosite'      => $request->geosite,
        ];

        if ($request->hasFile('gambar')) {
            $oldGambar = json_decode($galeri->gambar, true);
            if (is_array($oldGambar)) {
                foreach ($oldGambar as $oldPath) {
                    if ($oldPath && !str_starts_with($oldPath, 'data:')) {
                        Storage::disk('public')->delete($oldPath);
                    }
                }
            }

            $paths = [];
            foreach ($request->file('gambar') as $file) {
                $paths[] = $file->store('galeri', 'public');
            }
            $data['gambar'] = json_encode($paths);
        }

        $galeri->update($data);

        return redirect()->route('admin.galeri.index')
            ->with('success', 'Galeri berhasil diupdate!');
    }

    // Menghapus Data Galeri
    // Menghapus baris rekaman galeri dari database berikut semua array file gambar fisiknya dari server.
    public function destroy($id)
    {
        $galeri = Galeri::findOrFail($id);

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
