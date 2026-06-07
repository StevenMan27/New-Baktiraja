<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use Illuminate\Http\Request;

class GaleriController extends Controller {
    /*
       [CONTROLLER GaleriController]
       File ini bertugas mengontrol logika aplikasi untuk bagian publik dari GaleriController.
       Berfungsi mengambil data dari Model dan melemparkannya ke file View yang sesuai.
       Tabel Database yang digunakan: menyesuaikan dengan fungsi yang dipanggil.
    */
    /*
       [FUNGSI MENAMPILKAN HALAMAN GALERI PUBLIK]
       Fungsi ini bertugas untuk mengambil seluruh data foto dari database dan menampilkannya di halaman galeri depan pengunjung.
       Logikanya adalah:
       1. Mengambil semua data dari tabel galeris dan mengurutkannya dari yang paling baru diupload (descending).
       2. Mengelompokkan (groupBy) kumpulan foto-foto tersebut berdasarkan kolom 'geosite'.
       3. Mengirimkan data yang sudah dikelompokkan tersebut ke tampilan 'pages.galeri'.
       Tabel Database yang digunakan: 'galeris'
    */
    public function index()
    {
        $allGaleri = Galeri::orderBy('created_at', 'desc')
            ->get();

        $galeriByKategori = $allGaleri->groupBy('geosite');

        return view('pages.galeri', compact('galeriByKategori'));
    }

    /*
       [FUNGSI MENYIMPAN FOTO BARU (STORE)]
       Fungsi ini bertugas untuk memproses data dari form tambah foto yang diisi oleh Admin, lalu menyimpannya secara fisik (biner) ke database.
       Logikanya adalah:
       1. Memvalidasi (validate) inputan admin, memastikan judul diisi dan file berupa gambar (jpeg/png/jpg) max 2MB.
       2. Jika ada file gambar, kode akan membaca wujud fisik file tersebut menggunakan file_get_contents().
       3. Menyimpan data teks beserta data binary gambar (sebagai LONGBLOB) ke database.
       Tabel Database yang digunakan: 'galeris'
    */
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


