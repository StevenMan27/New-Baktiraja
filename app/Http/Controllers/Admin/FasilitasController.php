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
        // Urutkan berdasarkan geosite lalu urutan tampil
        $data = Fasilitas::orderBy('geosite')->orderBy('urutan')->paginate(10);
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
            'gambar'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:6144',
            'urutan'    => 'required|integer',
            'harga'     => 'nullable|string|max:100',
            'geosite'   => 'required|string',
            'status'    => 'nullable|boolean',
        ]);

        $data = [
            'nama'      => $request->nama,
            'deskripsi' => $request->deskripsi,
            'harga'     => $request->harga,
            'urutan'    => $request->urutan,
            'geosite'   => $request->geosite,
            'status'    => $request->has('status') ? 1 : 0,
        ];

        // Simpan file gambar ke storage/app/public/fasilitas
        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('fasilitas', 'public');
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
            'gambar'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:6144',
            'urutan'    => 'required|integer',
            'harga'     => 'nullable|string|max:100',
            'geosite'   => 'required|string',
            'status'    => 'nullable|boolean',
        ]);

        $input = [
            'nama'      => $request->nama,
            'deskripsi' => $request->deskripsi,
            'harga'     => $request->harga,
            'urutan'    => $request->urutan,
            'geosite'   => $request->geosite,
            'status'    => $request->has('status') ? 1 : 0,
        ];

        // Ganti file gambar lama jika ada upload baru
        if ($request->hasFile('gambar')) {
            if ($data->gambar && !str_starts_with($data->gambar, 'data:')) {
                Storage::disk('public')->delete($data->gambar);
            }
            $input['gambar'] = $request->file('gambar')->store('fasilitas', 'public');
        }

        $data->update($input);

        return redirect()->route('admin.fasilitas.index')
            ->with('success', 'Fasilitas berhasil diupdate!');
    }

    public function destroy($id)
    {
        $data = Fasilitas::findOrFail($id);

        // Hapus file gambar dari storage jika bukan base64
        if ($data->gambar && !str_starts_with($data->gambar, 'data:')) {
            Storage::disk('public')->delete($data->gambar);
        }

        $data->delete();

        return redirect()->route('admin.fasilitas.index')
            ->with('success', 'Fasilitas berhasil dihapus!');
    }
}