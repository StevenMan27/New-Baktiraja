<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BeritaController extends Controller
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
        $berita = Berita::latest()->paginate(10);
        return view('admin.berita.index', compact('berita'));
    }

    public function create()
    {
        $geositeList = $this->geositeList;
        return view('admin.berita.create', compact('geositeList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            // Penjelasan: Validasi diubah dari array ke single file karena form hanya mengirimkan satu file.
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'penulis' => 'nullable|string|max:100',
            'geosite' => 'required|string',
            'status' => 'nullable|boolean'
        ]);

        $data = [
            'judul' => $request->judul,
            'konten' => $request->konten,
            'penulis' => $request->penulis ?? 'Admin',
            'geosite' => $request->geosite,
            'status' => $request->has('status') ? 1 : 0
        ];

        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('berita', 'public');
            $data['gambar'] = json_encode([$path]);
        }

        Berita::create($data);

        return redirect()->route('admin.berita.index')
            ->with('success', 'Berita berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $berita = Berita::findOrFail($id);
        $geositeList = $this->geositeList;
        return view('admin.berita.edit', compact('berita', 'geositeList'));
    }

    public function update(Request $request, $id)
    {
        $berita = Berita::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            // Penjelasan: Validasi diubah dari array ke single file karena form hanya mengirimkan satu file.
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'penulis' => 'nullable|string|max:100',
            'geosite' => 'required|string',
            'status' => 'nullable|boolean'
        ]);

        $data = [
            'judul' => $request->judul,
            'konten' => $request->konten,
            'penulis' => $request->penulis ?? 'Admin',
            'geosite' => $request->geosite,
            'status' => $request->has('status') ? 1 : 0
        ];

        if ($request->hasFile('gambar')) {
            // Delete old files from storage
            $oldGambar = json_decode($berita->gambar, true);
            if (is_array($oldGambar)) {
                foreach ($oldGambar as $oldPath) {
                    if ($oldPath && !str_starts_with($oldPath, 'data:')) {
                        Storage::disk('public')->delete($oldPath);
                    }
                }
            }

            // Store new files
            $path = $request->file('gambar')->store('berita', 'public');
            $data['gambar'] = json_encode([$path]);
        }

        $berita->update($data);

        return redirect()->route('admin.berita.index')
            ->with('success', 'Berita berhasil diupdate!');
    }

    public function destroy($id)
    {
        $berita = Berita::findOrFail($id);

        // Delete all image files from storage
        $oldGambar = json_decode($berita->gambar, true);
        if (is_array($oldGambar)) {
            foreach ($oldGambar as $oldPath) {
                if ($oldPath && !str_starts_with($oldPath, 'data:')) {
                    Storage::disk('public')->delete($oldPath);
                }
            }
        }

        $berita->delete();

        return redirect()->route('admin.berita.index')
            ->with('success', 'Berita berhasil dihapus!');
    }

    public function toggleStatus($id)
    {
        $berita = Berita::findOrFail($id);
        $berita->status = !$berita->status;
        $berita->save();

        return response()->json(['success' => true, 'status' => $berita->status]);
    }
}