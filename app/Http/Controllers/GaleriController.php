<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use Illuminate\Http\Request;

// Menangani logika tampilan galeri publik dan penyimpanan foto baru oleh admin.
// Data foto diambil dari tabel 'galeris'; file gambar disimpan dalam format binary (LONGBLOB) ke database.
class GaleriController extends Controller {

    // Mengambil semua foto dari database, mengelompokkannya berdasarkan geosite, lalu menampilkan di halaman galeri pengunjung.
    // Data berasal dari model Galeri diurutkan terbaru; output ke view 'pages.galeri' via compact.
    public function index()
    {
        $allGaleri = Galeri::orderBy('created_at', 'desc')
            ->get();

        $galeriByKategori = $allGaleri->groupBy('geosite');

        return view('pages.galeri', compact('galeriByKategori'));
    }

    // Memvalidasi input admin, membaca file gambar sebagai data binary, lalu menyimpannya ke tabel 'galeris'.
    // Input judul, kategori, deskripsi, dan file gambar dari $request; output redirect kembali dengan pesan sukses.
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'kategori' => 'required',
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $imageData = file_get_contents($file->getRealPath());

            Galeri::create([
                'judul' => $request->judul,
                'kategori' => $request->kategori,
                'deskripsi' => $request->deskripsi,
                'gambar' => $imageData,
                'tanggal_foto' => now(),
            ]);
        }

        return redirect()->back()->with('success', 'Foto Berhasil Ditambahkan!');
    }
}
