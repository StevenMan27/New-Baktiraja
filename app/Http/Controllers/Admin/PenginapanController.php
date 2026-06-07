<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penginapan;
use App\Models\ProfilGeosite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

// Kontroler Admin Penginapan
// Mengelola logika operasi CRUD untuk data Penginapan di panel admin.
class PenginapanController extends Controller {
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

    // Menampilkan Daftar Penginapan
    // Mengambil dan menampilkan data penginapan dengan urutan per geosite beserta paginasi.
    public function index()
    {
        $data = Penginapan::orderBy('geosite')->paginate(10);
        return view('admin.penginapan.index', compact('data'));
    }

    // Menampilkan Form Tambah Penginapan
    // Merender form untuk menambah penginapan baru dan mengirimkan daftar pilihan geosite.
    public function create()
    {
        $geositeList = $this->geositeList;
        return view('admin.penginapan.create', compact('geositeList'));
    }

    // Menyimpan Data Penginapan Baru
    // Memvalidasi data input, memproses unggahan gambar, dan menyimpan record penginapan ke database.
    public function store(Request $request)
    {
        $validGeosites = implode(',', array_keys($this->geositeList));
        $request->validate([
            'nama'      => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'gambar'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'harga'     => 'nullable|string|max:100',
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
            'harga'     => $request->harga,
            'kontak'    => $request->kontak,
            'geosite'   => $request->geosite,
        ];

        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('penginapan', 'public');
            $data['gambar'] = json_encode([$path]);
        }

        Penginapan::create($data);

        return redirect()->route('admin.penginapan.index')
            ->with('success', 'Penginapan berhasil ditambahkan!');
    }

    // Menampilkan Form Edit Penginapan
    // Memuat record penginapan yang spesifik dan menampilkannya pada form edit.
    public function edit($id)
    {
        $data        = Penginapan::findOrFail($id);
        $geositeList = $this->geositeList;
        return view('admin.penginapan.edit', compact('data', 'geositeList'));
    }

    // Memperbarui Data Penginapan
    // Memvalidasi input dari request, menghapus gambar lama jika diganti, lalu mengupdate data di database.
    public function update(Request $request, $id)
    {
        $data = Penginapan::findOrFail($id);

        $validGeosites = implode(',', array_keys($this->geositeList));
        $request->validate([
            'nama'      => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'gambar'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'harga'     => 'nullable|string|max:100',
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
            'harga'     => $request->harga,
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

            $path = $request->file('gambar')->store('penginapan', 'public');
            $input['gambar'] = json_encode([$path]);
        }

        $data->update($input);

        return redirect()->route('admin.penginapan.index')
            ->with('success', 'Penginapan berhasil diupdate!');
    }

    // Menghapus Data Penginapan
    // Menghapus baris record penginapan dan file gambar fisik yang terkait dari media penyimpanan.
    public function destroy($id)
    {
        $data = Penginapan::findOrFail($id);

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

        return redirect()->route('admin.penginapan.index')
            ->with('success', 'Penginapan berhasil dihapus!');
    }
}
