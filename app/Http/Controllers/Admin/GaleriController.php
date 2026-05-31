<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
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
        $request->validate([
            'judul'       => 'required|string|max:255',
            'deskripsi'   => 'nullable|string',
            'gambar'      => 'required|image|mimes:jpeg,png,jpg,webp|max:4096',
            'lokasi'      => 'nullable|string',
            'tanggal_foto'=> 'nullable|date',
            'geosite'     => 'required|string',
        ], [
            'judul.required'    => 'Judul galeri wajib diisi.',
            'judul.max'         => 'Judul galeri tidak boleh melebihi 255 karakter.',
            'gambar.required'   => 'Gambar galeri wajib diunggah.',
            'gambar.image'      => 'File yang diunggah harus berupa gambar (bukan PDF, Word, atau file lainnya).',
            'gambar.mimes'      => 'Format gambar tidak didukung. Gunakan format JPG, PNG, atau WEBP.',
            'gambar.max'        => 'Ukuran gambar terlalu besar. Maksimal yang diizinkan adalah 4MB.',
            'geosite.required'  => 'Lokasi geosite wajib dipilih.',
            'tanggal_foto.date' => 'Format tanggal foto tidak valid.',
        ]);

        // Penjelasan: Menyimpan sebagai single file.
        $path = $request->file('gambar')->store('galeri', 'public');
        $paths = [$path];

        Galeri::create([
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'gambar' => json_encode($paths),
            'lokasi' => $request->lokasi,
            'tanggal_foto' => $request->tanggal_foto,
            'geosite' => $request->geosite,
        ]);

        return redirect()->route('admin.galeri.index')
            ->with('success', 'Galeri berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $galeri = Galeri::findOrFail($id);
        $geositeList = $this->geositeList;
        return view('admin.galeri.edit', compact('galeri', 'geositeList'));
    }

    public function update(Request $request, $id)
    {
        $galeri = Galeri::findOrFail($id);

        $request->validate([
            'judul'       => 'required|string|max:255',
            'deskripsi'   => 'nullable|string',
            'gambar'      => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'lokasi'      => 'nullable|string',
            'tanggal_foto'=> 'nullable|date',
            'geosite'     => 'required|string',
        ], [
            'judul.required'    => 'Judul galeri wajib diisi.',
            'judul.max'         => 'Judul galeri tidak boleh melebihi 255 karakter.',
            'gambar.image'      => 'File yang diunggah harus berupa gambar (bukan PDF, Word, atau file lainnya).',
            'gambar.mimes'      => 'Format gambar tidak didukung. Gunakan format JPG, PNG, atau WEBP.',
            'gambar.max'        => 'Ukuran gambar terlalu besar. Maksimal yang diizinkan adalah 4MB.',
            'geosite.required'  => 'Lokasi geosite wajib dipilih.',
            'tanggal_foto.date' => 'Format tanggal foto tidak valid.',
        ]);

        $data = [
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'lokasi' => $request->lokasi,
            'tanggal_foto' => $request->tanggal_foto,
            'geosite' => $request->geosite,
        ];

        if ($request->hasFile('gambar')) {
            // Delete old files from storage
            $oldGambar = json_decode($galeri->gambar, true);
            if (is_array($oldGambar)) {
                foreach ($oldGambar as $oldPath) {
                    if ($oldPath && !str_starts_with($oldPath, 'data:')) {
                        Storage::disk('public')->delete($oldPath);
                    }
                }
            }

            // Penjelasan: Menyimpan sebagai single file.
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

        // Delete all image files from storage
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




