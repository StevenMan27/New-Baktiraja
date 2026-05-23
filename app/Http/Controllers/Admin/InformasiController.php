<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Informasi;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InformasiController extends Controller
{
    public function index()
    {
        $informasi = Informasi::orderBy('urutan', 'asc')->paginate(10);
        return view('admin.informasi.index', compact('informasi'));
    }

    public function create()
    {
        return view('admin.informasi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:4096', // 4MB
            'urutan' => 'required|integer|unique:informasi,urutan',
            'status' => 'nullable|boolean'
        ]);

        $data = [
            'judul' => $request->judul,
            'konten' => $request->konten,
            'urutan' => $request->urutan,
            'status' => $request->has('status') ? 1 : 0
        ];

        if ($request->hasFile('gambar')) {
            $image = $request->file('gambar');
            $imageData = file_get_contents($image->getRealPath());
            $base64 = base64_encode($imageData);
            $mimeType = $image->getMimeType();
            $data['gambar'] = 'data:' . $mimeType . ';base64,' . $base64;
        }

        Informasi::create($data);

        return redirect()->route('admin.informasi.index')
            ->with('success', 'Informasi berhasil ditambahkan! (Gambar max 4MB)');
    }

    public function edit($id)
    {
        $informasi = Informasi::findOrFail($id);
        return view('admin.informasi.edit', compact('informasi'));
    }

    public function update(Request $request, $id)
    {
        $informasi = Informasi::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:4096', // 4MB
            'urutan' => 'required|integer|unique:informasi,urutan,' . $id,
            'status' => 'nullable|boolean'
        ]);

        $data = [
            'judul' => $request->judul,
            'konten' => $request->konten,
            'urutan' => $request->urutan,
            'status' => $request->has('status') ? 1 : 0
        ];

        if ($request->hasFile('gambar')) {
            $image = $request->file('gambar');
            $imageData = file_get_contents($image->getRealPath());
            $base64 = base64_encode($imageData);
            $mimeType = $image->getMimeType();
            $data['gambar'] = 'data:' . $mimeType . ';base64,' . $base64;
        }

        $informasi->update($data);

        return redirect()->route('admin.informasi.index')
            ->with('success', 'Informasi berhasil diupdate!');
    }

    public function destroy($id)
    {
        $informasi = Informasi::findOrFail($id);
        $informasi->delete();

        return redirect()->route('admin.informasi.index')
            ->with('success', 'Informasi berhasil dihapus!');
    }

    public function toggleStatus($id)
    {
        $informasi = Informasi::findOrFail($id);
        $informasi->status = !$informasi->status;
        $informasi->save();

        return response()->json(['success' => true, 'status' => $informasi->status]);
    }
}