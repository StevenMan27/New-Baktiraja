<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kontak;
use Illuminate\Http\Request;

// Kontroler Admin Kontak
// Mengatur operasi modifikasi data Kontak di panel admin.
class KontakController extends Controller {

    // Menampilkan Form Edit Kontak
    // Mengambil data kontak pertama dari database atau membuat instance baru jika kosong, untuk ditampilkan.
    public function edit()
    {
        $kontak = Kontak::first();
        if (!$kontak) {
            $kontak = new Kontak();
        }
        return view('admin.kontak.edit', compact('kontak'));
    }

    // Memperbarui Data Kontak
    // Memvalidasi input dan menyimpan pembaruan kontak ke database.
    public function update(Request $request)
    {
        $request->validate([
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string',
            'email' => 'nullable|string',
            'map_iframe' => 'nullable|string',
            'map_lokasi' => 'nullable|string',
            'jam_operasional' => 'nullable|string',
            'lokasi_bawah' => 'nullable|string',
            'social_fb' => 'nullable|string',
            'social_ig' => 'nullable|string',
            'social_twitter' => 'nullable|string',
            'social_youtube' => 'nullable|string',
            'social_tiktok' => 'nullable|string',
        ]);

        $kontak = Kontak::first();
        if (!$kontak) {
            $kontak = new Kontak();
        }

        $kontak->alamat = $request->alamat;
        $kontak->telepon = $request->telepon;
        $kontak->email = $request->email;
        $kontak->map_iframe = $request->map_iframe;
        $kontak->map_lokasi = $request->map_lokasi;
        $kontak->jam_operasional = $request->jam_operasional;
        $kontak->lokasi_bawah = $request->lokasi_bawah;
        $kontak->social_fb = $request->social_fb;
        $kontak->social_ig = $request->social_ig;
        $kontak->social_twitter = $request->social_twitter;
        $kontak->social_youtube = $request->social_youtube;
        $kontak->social_tiktok = $request->social_tiktok;
        $kontak->save();

        return redirect()->back()->with('success', 'Pengaturan Kontak berhasil diperbarui!');
    }
}
