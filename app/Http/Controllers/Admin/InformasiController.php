<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Informasi;
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
        // Penjelasan: Mengubah pengurutan data dari 'urutan' menjadi berdasarkan waktu pembuatan terbaru (latest) karena fitur urutan manual dihapus.
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
        $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'gambar' => 'nullable|array|max:10',
            'gambar.*' => 'image|mimes:jpeg,png,jpg,webp|max:4096',
            // Penjelasan: Validasi 'urutan' telah dihapus dari sini
            'geosite' => 'required|string',
        ]);

        $data = [
            'judul' => $request->judul,
            'konten' => $request->konten,
            // Penjelasan: 'urutan' di-set secara otomatis menggunakan nilai max dari database agar tidak menyebabkan error di level database
            'urutan' => Informasi::max('urutan') + 1,
            'geosite' => $request->geosite,
            'status' => $request->has('status') ? 1 : 0
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
        $informasi = Informasi::findOrFail($id);
        $geositeList = $this->geositeList;
        return view('admin.informasi.edit', compact('informasi', 'geositeList'));
    }

    public function update(Request $request, $id)
    {
        $informasi = Informasi::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'gambar' => 'nullable|array|max:10',
            'gambar.*' => 'image|mimes:jpeg,png,jpg,webp|max:4096',
            // Penjelasan: Validasi 'urutan' telah dihapus untuk form edit
            'geosite' => 'required|string',
        ]);

        $data = [
            'judul' => $request->judul,
            'konten' => $request->konten,
            // Penjelasan: 'urutan' tidak lagi di-update dari form
            'geosite' => $request->geosite,
            'status' => $request->has('status') ? 1 : 0
        ];

        if ($request->hasFile('gambar')) {
            // Delete old files from storage
            $oldGambar = json_decode($informasi->gambar, true);
            if (is_array($oldGambar)) {
                foreach ($oldGambar as $oldPath) {
                    if ($oldPath && !str_starts_with($oldPath, 'data:')) {
                        Storage::disk('public')->delete($oldPath);
                    }
                }
            }

            // Store new files
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

        // Delete all image files from storage
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



