<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fasilitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FasilitasController extends Controller
{
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
        $data = Fasilitas::orderBy('geosite')->paginate(10);
        return view('admin.fasilitas.index', compact('data'));
    }

    public function create()
    {
        $geositeList = $this->geositeList;
        return view('admin.fasilitas.create', compact('geositeList'));
    }

    public function store(Request $request)
    {
        // Validasi input form tambah fasilitas
        $request->validate([
            'nama'      => 'required|string|max:255',
            'deskripsi' => 'required|string',
            // Penjelasan: Validasi diubah dari array ke single file karena form hanya mengirimkan satu file.
            'gambar'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
'harga'     => 'nullable|string|max:100',
            'geosite'   => 'required|string',
        ]);

        $data = [
            'nama'      => $request->nama,
            'deskripsi' => $request->deskripsi,
            'harga'     => $request->harga,

            'geosite'   => $request->geosite,
        ];

        // Simpan file gambar ke storage/app/public/fasilitas
        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('fasilitas', 'public');
            $data['gambar'] = json_encode([$path]);
        }

        Fasilitas::create($data);

        return redirect()->route('admin.fasilitas.index')
            ->with('success', 'Fasilitas berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $data        = Fasilitas::findOrFail($id);
        $geositeList = $this->geositeList;
        return view('admin.fasilitas.edit', compact('data', 'geositeList'));
    }

    public function update(Request $request, $id)
    {
        $data = Fasilitas::findOrFail($id);

        // Validasi input form edit fasilitas
        $request->validate([
            'nama'      => 'required|string|max:255',
            'deskripsi' => 'required|string',
            // Penjelasan: Validasi diubah dari array ke single file karena form hanya mengirimkan satu file.
            'gambar'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
'harga'     => 'nullable|string|max:100',
            'geosite'   => 'required|string',
        ]);

        $input = [
            'nama'      => $request->nama,
            'deskripsi' => $request->deskripsi,
            'harga'     => $request->harga,

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

            // Penjelasan: Menyimpan sebagai single file.
            $path = $request->file('gambar')->store('fasilitas', 'public');
            $input['gambar'] = json_encode([$path]);
        }

        $data->update($input);

        return redirect()->route('admin.fasilitas.index')
            ->with('success', 'Fasilitas berhasil diupdate!');
    }

    public function destroy($id)
    {
        $data = Fasilitas::findOrFail($id);

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

        return redirect()->route('admin.fasilitas.index')
            ->with('success', 'Fasilitas berhasil dihapus!');
    }
}





