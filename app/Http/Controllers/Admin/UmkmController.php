<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Umkm;
use App\Models\ProfilGeosite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UmkmController extends Controller {
    /*
       [CONTROLLER ADMIN UmkmController]
       File ini bertugas mengontrol logika untuk bagian admin dari UmkmController.
       Berfungsi mengatur operasi CRUD (Create, Read, Update, Delete) pada database.
       Tabel Database yang digunakan: berhubungan erat dengan entitas UmkmController.
    */
    // Daftar geosite yang valid
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
        // Urutkan berdasarkan geosite
        $data = Umkm::orderBy('geosite')->paginate(10);
        return view('admin.umkm.index', compact('data'));
    }

    public function create()
    {
        $geositeList = $this->geositeList;
        return view('admin.umkm.create', compact('geositeList'));
    }

    public function store(Request $request)
    {
        // Validasi input form tambah UMKM
        $validGeosites = implode(',', array_keys($this->geositeList));
        $request->validate([
            'nama'      => 'required|string|max:255',
            'deskripsi' => 'required|string',
            // Penjelasan: Validasi diubah dari array ke single file karena form hanya mengirimkan satu file.
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

        // Pastikan geosite ada di database profil_geosites untuk mencegah foreign key error
        ProfilGeosite::firstOrCreate(['geosite' => $request->geosite]);


        $data = [
            'nama'      => $request->nama,
            'deskripsi' => $request->deskripsi,
            'lokasi'    => $request->lokasi,
            'kontak'    => $request->kontak,

            'geosite'   => $request->geosite,
        ];

        // Simpan file gambar ke storage/app/public/umkm
        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('umkm', 'public');
            $data['gambar'] = json_encode([$path]);
        }

        Umkm::create($data);

        return redirect()->route('admin.umkm.index')
            ->with('success', 'UMKM berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $data        = Umkm::findOrFail($id);
        $geositeList = $this->geositeList;
        return view('admin.umkm.edit', compact('data', 'geositeList'));
    }

    public function update(Request $request, $id)
    {
        $data = Umkm::findOrFail($id);

        // Validasi input form edit UMKM
        $validGeosites = implode(',', array_keys($this->geositeList));
        $request->validate([
            'nama'      => 'required|string|max:255',
            'deskripsi' => 'required|string',
            // Penjelasan: Validasi diubah dari array ke single file karena form hanya mengirimkan satu file.
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

        // Pastikan geosite ada di database profil_geosites untuk mencegah foreign key error
        ProfilGeosite::firstOrCreate(['geosite' => $request->geosite]);


        $input = [
            'nama'      => $request->nama,
            'deskripsi' => $request->deskripsi,
            'lokasi'    => $request->lokasi,
            'kontak'    => $request->kontak,

            'geosite'   => $request->geosite,
        ];

        // Ganti file gambar lama jika ada upload baru
        if ($request->hasFile('gambar')) {
            // Delete old files from storage
            $oldGambar = json_decode($data->gambar, true);
            if (is_array($oldGambar)) {
                foreach ($oldGambar as $oldPath) {
                    if ($oldPath && !str_starts_with($oldPath, 'data:')) {
                        Storage::disk('public')->delete($oldPath);
                    }
                }
            } elseif ($data->gambar && !str_starts_with($data->gambar, 'data:')) {
                // Legacy single file path
                Storage::disk('public')->delete($data->gambar);
            }

            // Penjelasan: Menggunakan single file object bukan array karena form input 'gambar' bukan array.
            $path = $request->file('gambar')->store('umkm', 'public');
            $input['gambar'] = json_encode([$path]);
        }

        $data->update($input);

        return redirect()->route('admin.umkm.index')
            ->with('success', 'UMKM berhasil diupdate!');
    }

    public function destroy($id)
    {
        $data = Umkm::findOrFail($id);

        // Hapus semua file gambar dari storage
        $oldGambar = json_decode($data->gambar, true);
        if (is_array($oldGambar)) {
            foreach ($oldGambar as $oldPath) {
                if ($oldPath && !str_starts_with($oldPath, 'data:')) {
                    Storage::disk('public')->delete($oldPath);
                }
            }
        } elseif ($data->gambar && !str_starts_with($data->gambar, 'data:')) {
            // Legacy single file path
            Storage::disk('public')->delete($data->gambar);
        }

        $data->delete();

        return redirect()->route('admin.umkm.index')
            ->with('success', 'UMKM berhasil dihapus!');
    }
}





