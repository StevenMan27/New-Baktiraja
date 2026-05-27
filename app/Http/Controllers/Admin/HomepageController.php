<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Homepage;
use Illuminate\Support\Facades\Storage;

class HomepageController extends Controller
{
    // Menampilkan halaman form edit untuk konfigurasi Homepage
    public function edit()
    {
        // Mengambil data homepage pertama atau membuat row baru secara otomatis jika kosong
        $homepage = Homepage::firstOrCreate([]);
        
        // Mengecek dan membuat otomatis 8 slot destinasi jika belum lengkap
        if ($homepage->destinasis()->count() < 8) {
            $currentCount = $homepage->destinasis()->count();
            for ($i = $currentCount + 1; $i <= 8; $i++) {
                $homepage->destinasis()->create(['urutan' => $i]);
            }
        }
        
        // Memanggil ulang data destinasi agar slot yang baru dibuat masuk ke objek
        $homepage->load('destinasis');

        return view('admin.homepage.edit', compact('homepage'));
    }

    // Memproses data teks dan file yang dikirim dari form admin
    public function update(Request $request)
    {
        // Menangkap objek homepage yang pertama di database
        $homepage = Homepage::first();
        
        // Memisahkan data file dan destinasi dari data teks agar bisa diproses terpisah
        $data = $request->except(['_token', '_method', 'hero_slide_1', 'hero_slide_2', 'hero_slide_3', 'hero_slide_4', 'hero_slide_5', 'about_video', 'destinasi', 'destinasi_gambar']);

        // Melakukan perulangan untuk memproses lima slot gambar slide hero
        for ($i = 1; $i <= 5; $i++) {
            $field = 'hero_slide_' . $i;
            if ($request->hasFile($field)) {
                // Menghapus file gambar yang lama dari storage server jika sudah ada
                if ($homepage->$field) {
                    Storage::disk('public')->delete($homepage->$field);
                }
                // Menyimpan gambar yang baru ke folder homepage di public storage
                $data[$field] = $request->file($field)->store('homepage', 'public');
            }
        }

        // Memproses file video untuk bagian about jika dikirimkan oleh admin
        if ($request->hasFile('about_video')) {
            // Menghapus file video lama dari server agar tidak memenuhi penyimpanan
            if ($homepage->about_video) {
                Storage::disk('public')->delete($homepage->about_video);
            }
            // Menyimpan file video yang baru
            $data['about_video'] = $request->file('about_video')->store('homepage', 'public');
        }

        // Memasukkan seluruh array data yang sudah diperbarui ke dalam database
        $homepage->update($data);

        // Memproses data array 8 destinasi yang dikirimkan oleh form
        if ($request->has('destinasi')) {
            foreach ($request->destinasi as $id => $destData) {
                $destinasi = \App\Models\HomepageDestinasi::find($id);
                if ($destinasi) {
                    // Mengecek jika ada file gambar khusus untuk destinasi ini
                    if ($request->hasFile("destinasi_gambar.{$id}")) {
                        // Menghapus file lama agar hemat server
                        if ($destinasi->gambar) {
                            Storage::disk('public')->delete($destinasi->gambar);
                        }
                        // Menyimpan file baru
                        $destData['gambar'] = $request->file("destinasi_gambar.{$id}")->store('homepage/destinasi', 'public');
                    }
                    // Memperbarui row destinasi ini di database
                    $destinasi->update($destData);
                }
            }
        }

        // Mengembalikan layar admin dengan notifikasi keberhasilan
        return redirect()->back()->with('success', 'Konfigurasi Homepage berhasil diperbarui.');
    }
}
