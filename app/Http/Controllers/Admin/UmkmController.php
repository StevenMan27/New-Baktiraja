<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Umkm;
use App\Models\ProfilGeosite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

// Kontroler Admin UMKM
// Mengelola logika operasi CRUD untuk rekaman UMKM di dashboard admin.
class UmkmController extends Controller {
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

    // Menampilkan Daftar UMKM
    // Mendapatkan dan menampilkan daftar data UMKM dengan urutan berdasarkan geosite serta paginasi.
    public function index()
    {
        $data = Umkm::orderBy('geosite')->paginate(10);
        return view('admin.umkm.index', compact('data'));
    }

    // Menampilkan Form Tambah UMKM
    // Mengirimkan daftar geosite yang tersedia dan merender halaman form untuk menambahkan data UMKM baru.
    public function create()
    {
        $geositeList = $this->geositeList;
        return view('admin.umkm.create', compact('geositeList'));
    }

    // Menyimpan UMKM Baru
    // Menjalankan validasi form, mengurus unggahan foto, dan mencatat UMKM ke dalam database.
    public function store(Request $request)
    {
        $validGeosites = implode(',', array_keys($this->geositeList));
        $request->validate([
            'nama'      => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'gambar'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'lokasi'    => 'nullable|string|max:255',
            'kontak'    => 'nullable|string|max:255',
            'geosite'   => "required|string|in:{$validGeosites}",
        ], [
            'gambar.image' => 'Format file yang diunggah harus berupa gambar.',
            'gambar.mimes' => 'Gambar harus memiliki format: jpeg, png, jpg, webp.',
            'gambar.max'   => 'Ukuran gambar maksimal adalah 10MB.',
            'required'     => 'Kolom :attribute wajib diisi.',
            'geosite.in'   => 'Geosite yang dipilih tidak valid.'
        ]);

        ProfilGeosite::firstOrCreate(['geosite' => $request->geosite]);

        $data = [
            'nama'      => $request->nama,
            'deskripsi' => $request->deskripsi,
            'lokasi'    => $request->lokasi,
            'kontak'    => $request->kontak,
            'geosite'   => $request->geosite,
        ];

        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('umkm', 'public');
            $data['gambar'] = json_encode([$path]);
        }

        Umkm::create($data);

        return redirect()->route('admin.umkm.index')
            ->with('success', 'UMKM berhasil ditambahkan!');
    }

    // Menampilkan Form Edit UMKM
    // Mengambil data UMKM berdasarkan ID yang diberikan dan menampilkannya dalam form edit beserta opsi geosite.
    public function edit($id)
    {
        $data        = Umkm::findOrFail($id);
        $geositeList = $this->geositeList;
        return view('admin.umkm.edit', compact('data', 'geositeList'));
    }

    // Memperbarui Data UMKM
    // Memvalidasi parameter pembaharuan, menghapus serta menukar file gambar lama jika diperlukan, dan memperbarui basis data.
    public function update(Request $request, $id)
    {
        $data = Umkm::findOrFail($id);

        $validGeosites = implode(',', array_keys($this->geositeList));
        $request->validate([
            'nama'      => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'gambar'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'lokasi'    => 'nullable|string|max:255',
            'kontak'    => 'nullable|string|max:255',
            'geosite'   => "required|string|in:{$validGeosites}",
        ], [
            'gambar.image' => 'Format file yang diunggah harus berupa gambar.',
            'gambar.mimes' => 'Gambar harus memiliki format: jpeg, png, jpg, webp.',
            'gambar.max'   => 'Ukuran gambar maksimal adalah 10MB.',
            'required'     => 'Kolom :attribute wajib diisi.',
            'geosite.in'   => 'Geosite yang dipilih tidak valid.'
        ]);

        ProfilGeosite::firstOrCreate(['geosite' => $request->geosite]);

        $input = [
            'nama'      => $request->nama,
            'deskripsi' => $request->deskripsi,
            'lokasi'    => $request->lokasi,
            'kontak'    => $request->kontak,
            'geosite'   => $request->geosite,
        ];

        if ($request->hasFile('gambar')) {
            $oldGambar = json_decode($data->gambar, true);
            if (is_array($oldGambar)) {
                foreach ($oldGambar as $oldPath) {
                    if ($oldPath && !str_starts_with($oldPath, 'data:')) {
                        Storage::disk('public')->delete($oldPath);
                    }
                }
            } elseif ($data->gambar && !str_starts_with($data->gambar, 'data:')) {
                Storage::disk('public')->delete($data->gambar);
            }

            $path = $request->file('gambar')->store('umkm', 'public');
            $input['gambar'] = json_encode([$path]);
        }

        $data->update($input);

        return redirect()->route('admin.umkm.index')
            ->with('success', 'UMKM berhasil diupdate!');
    }

    // Menghapus Data UMKM
    // Menghapus baris entitas UMKM dari database dan membuang relasi file gambar fisik pada server penyimpanan.
    public function destroy($id)
    {
        $data = Umkm::findOrFail($id);

        $oldGambar = json_decode($data->gambar, true);
        if (is_array($oldGambar)) {
            foreach ($oldGambar as $oldPath) {
                if ($oldPath && !str_starts_with($oldPath, 'data:')) {
                    Storage::disk('public')->delete($oldPath);
                }
            }
        } elseif ($data->gambar && !str_starts_with($data->gambar, 'data:')) {
            Storage::disk('public')->delete($data->gambar);
        }

        $data->delete();

        return redirect()->route('admin.umkm.index')
            ->with('success', 'UMKM berhasil dihapus!');
    }
}
