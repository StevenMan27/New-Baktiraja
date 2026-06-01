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
                $homepage->destinasis()->create([]);
            }
        }

        // Memanggil ulang data destinasi agar slot yang baru dibuat masuk ke objek
        $homepage->load('destinasis');

        return view('admin.homepage.edit', compact('homepage'));
    }

    // Memproses data teks dan file yang dikirim dari form admin
    public function update(Request $request)
    {
        // Mengambil data homepage pertama atau membuat row kosong jika belum ada
        $homepage = Homepage::firstOrCreate([]);

        // Validasi semua field yang dikirim dari form admin.
        // maps_link menerima string apapun karena akan dikonversi server-side,
        // sehingga tidak perlu validasi url yang ketat di sini.
        $request->validate([
            'hero_slides'              => 'nullable|array|max:6',
            'hero_slides.*'            => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'about_video'              => 'nullable|mimetypes:video/mp4,video/webm|max:204800',
            'destinasi_gambar.*'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            // Menerima URL Google Maps dalam format apapun: link pendek, link share, atau link embed
            'maps_link'                => 'nullable|string|max:2000',
            // Validasi array tombol lokasi: maksimal 5 tombol, setiap tombol wajib punya nama
            'maps_buttons'             => 'nullable|array|max:5',
            'maps_buttons.*.nama'      => 'nullable|string|max:100',
            'maps_buttons.*.link'      => 'nullable|string|max:2000',
        ], [
            'hero_slides.max'              => 'Maksimal gambar slide yang dapat diunggah adalah 6.',
            'hero_slides.*.max'            => 'Ukuran gambar slide maksimal adalah 10MB.',
            'hero_slides.*.image'          => 'Format file slide harus berupa gambar.',
            'about_video.max'              => 'Ukuran video maksimal adalah 200MB.',
            'about_video.mimetypes'        => 'Format video harus berupa MP4 atau WEBM.',
            'destinasi_gambar.*.max'       => 'Ukuran gambar destinasi maksimal adalah 10MB.',
            'destinasi_gambar.*.image'     => 'Format file destinasi harus berupa gambar.',
            'maps_buttons.max'             => 'Maksimal tombol lokasi yang dapat ditambahkan adalah 5.',
            'maps_buttons.*.nama.max'      => 'Nama tombol maksimal 100 karakter.',
        ]);

        // Memisahkan data file, destinasi, dan maps_buttons dari data teks agar bisa diproses terpisah
        $data = $request->except(['_token', '_method', 'hero_slides', 'about_video', 'destinasi', 'destinasi_gambar', 'maps_buttons']);

        // Konversi URL Google Maps yang dimasukkan admin menjadi URL embed yang bisa ditampilkan
        // di dalam iframe. Proses ini terjadi di server sehingga admin cukup menempel link
        // apapun dari Google Maps tanpa perlu memahami format teknis embed URL.
        if ($request->filled('maps_link')) {
            $data['maps_link'] = $this->convertGoogleMapsToEmbed(trim($request->input('maps_link')));
        } else {
            $data['maps_link'] = null;
        }

        // Memproses array tombol lokasi di bawah peta menjadi JSON untuk disimpan ke database.
        // Setiap tombol memiliki dua properti: 'nama' (teks yang tampil) dan 'link' (URL tujuan).
        // Tombol yang kosong (nama kosong) akan difilter agar tidak disimpan ke database.
        if ($request->has('maps_buttons')) {
            $buttons = [];
            foreach ($request->input('maps_buttons', []) as $btn) {
                // Hanya simpan tombol yang memiliki nama yang diisi oleh admin
                if (!empty(trim($btn['nama'] ?? ''))) {
                    $buttons[] = [
                        'nama' => trim($btn['nama']),
                        'link' => trim($btn['link'] ?? ''),
                    ];
                }
            }
            // Simpan sebagai string JSON ke dalam kolom maps_buttons
            $data['maps_buttons'] = json_encode($buttons, JSON_UNESCAPED_UNICODE);
        } else {
            // Jika tidak ada data tombol dikirim, set null (semua baris tombol dihapus)
            $data['maps_buttons'] = null;
        }

        // Memproses multiple upload untuk 6 gambar slide hero
        if ($request->hasFile('hero_slides')) {
            $files = $request->file('hero_slides');

            // Menghapus semua gambar slide lama terlebih dahulu sebelum diganti batch baru
            for ($i = 1; $i <= 6; $i++) {
                $field = 'hero_slide_' . $i;
                if ($homepage->$field) {
                    Storage::disk('public')->delete($homepage->$field);
                }
                $data[$field] = null;
            }

            // Menyimpan batch gambar yang baru (maksimal 6)
            $index = 1;
            foreach ($files as $file) {
                if ($index > 6) break;
                $field = 'hero_slide_' . $index;
                $data[$field] = $file->store('homepage', 'public');
                $index++;
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

    /**
     * Mengubah URL Google Maps dalam format apapun menjadi URL embed yang dapat ditampilkan
     * di dalam tag iframe di halaman publik.
     *
     * Fungsi ini menangani tiga jenis URL yang mungkin dimasukkan admin:
     * 1. URL pendek (maps.app.goo.gl atau goo.gl) — diselesaikan dulu via cURL lalu dikonversi
     * 2. URL share panjang (google.com/maps/place/...) — diambil koordinat atau nama tempatnya
     * 3. URL embed (sudah mengandung /maps/embed atau output=embed) — dikembalikan apa adanya
     *
     * Jika semua pola gagal, URL asli dikembalikan sebagai fallback tanpa modifikasi.
     */
    private function convertGoogleMapsToEmbed(?string $url): ?string
    {
        if (empty($url)) {
            return null;
        }

        // Jika URL sudah berformat embed yang siap pakai, langsung kembalikan tanpa perubahan
        if (str_contains($url, '/maps/embed') || str_contains($url, 'output=embed')) {
            return $url;
        }

        // Selesaikan URL pendek seperti maps.app.goo.gl dengan mengikuti redirect menggunakan cURL.
        // cURL akan mengikuti semua redirect hingga mendapat URL akhir yang lengkap dari Google Maps.
        if (str_contains($url, 'goo.gl') || str_contains($url, 'maps.app')) {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_NOBODY, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36');
            curl_exec($ch);
            $resolvedUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
            curl_close($ch);

            // Gunakan URL yang sudah diselesaikan jika hasilnya berbeda dari URL awal
            if (!empty($resolvedUrl) && $resolvedUrl !== $url) {
                $url = $resolvedUrl;
            }
        }

        // Coba ambil koordinat latitude, longitude, dan zoom dari URL Google Maps lengkap.
        // Pola @lat,lng,zoomz adalah standar yang ada di URL Google Maps saat melihat lokasi.
        if (preg_match('/@([-\d.]+),([-\d.]+),([\d.]+)z/', $url, $matches)) {
            $lat  = $matches[1];
            $lng  = $matches[2];
            $zoom = intval($matches[3]);
            // Pastikan minimal zoom 18 agar tampilannya langsung memperbesar titik lokasi
            $zoom = max($zoom, 18);
            return "https://maps.google.com/maps?q={$lat},{$lng}&z={$zoom}&output=embed";
        }

        // Jika koordinat tidak ditemukan, coba ambil nama tempat dari segmen URL /place/NAMA/
        // lalu jadikan sebagai query pencarian dalam URL embed dengan zoom default 18
        if (preg_match('/place\/([^\/@?&#]+)/', $url, $matches)) {
            $placeName = rawurldecode(str_replace('+', ' ', $matches[1]));
            return 'https://maps.google.com/maps?q=' . rawurlencode($placeName) . '&z=18&output=embed';
        }

        // Jika URL adalah Google Maps namun tidak memiliki parameter output=embed, tambahkan
        if (str_contains($url, 'google.com/maps') || str_contains($url, 'maps.google.com')) {
            $separator = str_contains($url, '?') ? '&' : '?';
            return $url . $separator . 'output=embed';
        }

        // Fallback: kembalikan URL asli jika tidak ada pola yang cocok
        return $url;
    }
}
