<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fasilitas;
use App\Models\ProfilGeosite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

// Kontroler Admin Fasilitas
// Mengelola logika operasi CRUD untuk data Fasilitas di sisi admin.
class FasilitasController extends Controller {
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

    // Menampilkan Daftar Fasilitas
    // Mengambil dan menampilkan data fasilitas dengan urutan per geosite dan paginasi.
    public function index()
    {
        $data = Fasilitas::orderBy('geosite')->paginate(10);
        return view('admin.fasilitas.index', compact('data'));
    }

    // Menampilkan Form Tambah Fasilitas
    // Merender halaman form untuk menambahkan data fasilitas baru beserta pilihan geosite.
    public function create()
    {
        $geositeList = $this->geositeList;
        return view('admin.fasilitas.create', compact('geositeList'));
    }

    // Menyimpan Fasilitas Baru
    // Melakukan validasi request, menyimpan upload gambar jika ada, dan mencatat data fasilitas ke database.
    public function store(Request $request)
    {
        $validGeosites = implode(',', array_keys($this->geositeList));
        $request->validate([
            'nama'      => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'gambar'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'harga'     => 'nullable|string|max:100',
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
            'harga'     => $request->harga,
            'geosite'   => $request->geosite,
        ];

        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('fasilitas', 'public');
            $data['gambar'] = json_encode([$path]);
        }

        Fasilitas::create($data);

        return redirect()->route('admin.fasilitas.index')
            ->with('success', 'Fasilitas berhasil ditambahkan!');
    }

    // Menampilkan Form Edit Fasilitas
    // Mengambil record fasilitas berdasarkan ID dan menampilkannya pada form edit.
    public function edit($id)
    {
        $data        = Fasilitas::findOrFail($id);
        $geositeList = $this->geositeList;
        return view('admin.fasilitas.edit', compact('data', 'geositeList'));
    }

    // Memperbarui Data Fasilitas
    // Memvalidasi input dari form edit, mengganti file gambar jika ada yang baru, lalu mengupdate database.
    public function update(Request $request, $id)
    {
        $data = Fasilitas::findOrFail($id);

        $validGeosites = implode(',', array_keys($this->geositeList));
        $request->validate([
            'nama'      => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'gambar'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'harga'     => 'nullable|string|max:100',
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
            'harga'     => $request->harga,
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

            $path = $request->file('gambar')->store('fasilitas', 'public');
            $input['gambar'] = json_encode([$path]);
        }

        $data->update($input);

        return redirect()->route('admin.fasilitas.index')
            ->with('success', 'Fasilitas berhasil diupdate!');
    }

    // Menghapus Data Fasilitas
    // Menghapus record fasilitas beserta lampiran file gambarnya dari server dan database.
    public function destroy($id)
    {
        $data = Fasilitas::findOrFail($id);

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

        return redirect()->route('admin.fasilitas.index')
            ->with('success', 'Fasilitas berhasil dihapus!');
    }
}
