<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Informasi;
use App\Models\ProfilGeosite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

// Kontroler Admin Informasi
// Mengontrol dan mengatur operasi CRUD entitas Informasi melalui antarmuka admin.
class InformasiController extends Controller {
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

    // Menampilkan Daftar Informasi
    // Mengambil seluruh data informasi secara descending dan menampilkannya di halaman index.
    public function index()
    {
        $informasi = Informasi::latest()->paginate(10);
        return view('admin.informasi.index', compact('informasi'));
    }

    // Menampilkan Form Tambah Informasi
    // Merender tampilan form penambahan informasi dan melampirkan daftar geosite.
    public function create()
    {
        $geositeList = $this->geositeList;
        return view('admin.informasi.create', compact('geositeList'));
    }

    // Menyimpan Informasi Baru
    // Memvalidasi parameter yang diberikan, menyimpan upload file gambar jika ada, dan menyimpannya ke database.
    public function store(Request $request)
    {
        $validGeosites = implode(',', array_keys($this->geositeList));
        $request->validate([
            'judul'   => 'required|string|max:255',
            'konten'  => 'required|string',
            'gambar'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
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
            'geosite' => $request->geosite,
        ];

        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('informasi', 'public');
            $data['gambar'] = json_encode([$path]);
        }

        Informasi::create($data);

        return redirect()->route('admin.informasi.index')
            ->with('success', 'Informasi berhasil ditambahkan!');
    }

    // Menampilkan Form Edit Informasi
    // Mendapatkan instance informasi melalui ID-nya lalu menampilkannya pada form edit.
    public function edit($id)
    {
        $informasi   = Informasi::findOrFail($id);
        $geositeList = $this->geositeList;
        return view('admin.informasi.edit', compact('informasi', 'geositeList'));
    }

    // Memperbarui Data Informasi
    // Memvalidasi update, memproses penambahan atau pergantian gambar, dan memodifikasi data pada database.
    public function update(Request $request, $id)
    {
        $informasi = Informasi::findOrFail($id);

        $validGeosites = implode(',', array_keys($this->geositeList));
        $request->validate([
            'judul'   => 'required|string|max:255',
            'konten'  => 'required|string',
            'gambar'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
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
            'geosite' => $request->geosite,
        ];

        if ($request->hasFile('gambar')) {
            $oldGambar = json_decode($informasi->gambar, true);
            if (is_array($oldGambar)) {
                foreach ($oldGambar as $oldPath) {
                    if ($oldPath && !str_starts_with($oldPath, 'data:')) {
                        Storage::disk('public')->delete($oldPath);
                    }
                }
            }

            $path = $request->file('gambar')->store('informasi', 'public');
            $data['gambar'] = json_encode([$path]);
        }

        $informasi->update($data);

        return redirect()->route('admin.informasi.index')
            ->with('success', 'Informasi berhasil diupdate!');
    }

    // Menghapus Data Informasi
    // Melakukan penghapusan data informasi terkait dari database berserta menghapus file gambar pada server.
    public function destroy($id)
    {
        $informasi = Informasi::findOrFail($id);

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
