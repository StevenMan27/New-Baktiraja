<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\ProfilGeosite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

// Kontroler Admin Berita
// Mengelola operasi CRUD (Create, Read, Update, Delete) untuk entitas Berita.
class BeritaController extends Controller {
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

    // Menampilkan Daftar Berita
    // Mengambil data berita dengan urutan terbaru dan menampilkannya menggunakan paginasi.
    public function index()
    {
        $berita = Berita::latest()->paginate(10);
        return view('admin.berita.index', compact('berita'));
    }

    // Menampilkan Form Tambah Berita
    // Menyiapkan daftar geosite dan menampilkan halaman form untuk membuat berita baru.
    public function create()
    {
        $geositeList = $this->geositeList;
        return view('admin.berita.create', compact('geositeList'));
    }

    // Menyimpan Berita Baru
    // Memvalidasi input dari form, menyimpan gambar jika ada, dan menambahkan data berita ke database.
    public function store(Request $request)
    {
        $validGeosites = implode(',', array_keys($this->geositeList));
        $request->validate([
            'judul'   => 'required|string|max:255',
            'konten'  => 'required|string',
            'gambar'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'penulis' => 'nullable|string|max:100',
            'geosite' => "required|string|in:{$validGeosites}",
        ], [
            'gambar.image' => 'Format file yang diunggah harus berupa gambar.',
            'gambar.mimes' => 'Gambar harus memiliki format: jpeg, png, jpg, webp.',
            'gambar.max'   => 'Ukuran gambar maksimal adalah 10MB.',
            'required'     => 'Kolom :attribute wajib diisi.',
            'geosite.in'   => 'Geosite yang dipilih tidak valid.'
        ]);

        ProfilGeosite::firstOrCreate(['geosite' => $request->geosite]);

        $data = [
            'judul'   => $request->judul,
            'konten'  => $request->konten,
            'penulis' => $request->penulis ?? 'Admin',
            'geosite' => $request->geosite,
        ];

        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('berita', 'public');
            $data['gambar'] = json_encode([$path]);
        }

        Berita::create($data);

        return redirect()->route('admin.berita.index')
            ->with('success', 'Berita berhasil ditambahkan!');
    }

    // Menampilkan Form Edit Berita
    // Mengambil data berita berdasarkan ID dan menampilkannya di form edit beserta daftar geosite.
    public function edit($id)
    {
        $berita      = Berita::findOrFail($id);
        $geositeList = $this->geositeList;
        return view('admin.berita.edit', compact('berita', 'geositeList'));
    }

    // Memperbarui Data Berita
    // Memvalidasi input, memproses penggantian gambar jika diunggah, dan menyimpan perubahan ke database.
    public function update(Request $request, $id)
    {
        $berita = Berita::findOrFail($id);

        $validGeosites = implode(',', array_keys($this->geositeList));
        $request->validate([
            'judul'   => 'required|string|max:255',
            'konten'  => 'required|string',
            'gambar'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'penulis' => 'nullable|string|max:100',
            'geosite' => "required|string|in:{$validGeosites}",
        ], [
            'gambar.image' => 'Format file yang diunggah harus berupa gambar.',
            'gambar.mimes' => 'Gambar harus memiliki format: jpeg, png, jpg, webp.',
            'gambar.max'   => 'Ukuran gambar maksimal adalah 10MB.',
            'required'     => 'Kolom :attribute wajib diisi.',
            'geosite.in'   => 'Geosite yang dipilih tidak valid.'
        ]);

        ProfilGeosite::firstOrCreate(['geosite' => $request->geosite]);

        $data = [
            'judul'   => $request->judul,
            'konten'  => $request->konten,
            'penulis' => $request->penulis ?? 'Admin',
            'geosite' => $request->geosite,
        ];

        if ($request->hasFile('gambar')) {
            $oldGambar = json_decode($berita->gambar, true);
            if (is_array($oldGambar)) {
                foreach ($oldGambar as $oldPath) {
                    if ($oldPath && !str_starts_with($oldPath, 'data:')) {
                        Storage::disk('public')->delete($oldPath);
                    }
                }
            }

            $path = $request->file('gambar')->store('berita', 'public');
            $data['gambar'] = json_encode([$path]);
        }

        $berita->update($data);

        return redirect()->route('admin.berita.index')
            ->with('success', 'Berita berhasil diupdate!');
    }

    // Menghapus Data Berita
    // Menghapus data berita beserta file gambar yang terkait dari penyimpanan fisik dan database.
    public function destroy($id)
    {
        $berita = Berita::findOrFail($id);

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
}
