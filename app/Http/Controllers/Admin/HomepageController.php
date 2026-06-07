<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Homepage;
use Illuminate\Support\Facades\Storage;

// Kontroler Admin Homepage
// Mengelola logika dan konfigurasi untuk tampilan Homepage melalui panel admin.
class HomepageController extends Controller {

    // Menampilkan Form Edit Homepage
    // Mengambil konfigurasi homepage atau membuat baru jika belum ada, serta menyiapkan slot destinasi.
    public function edit()
    {
        $homepage = Homepage::firstOrCreate([]);

        if ($homepage->destinasis()->count() < 8) {
            $currentCount = $homepage->destinasis()->count();
            for ($i = $currentCount + 1; $i <= 8; $i++) {
                $homepage->destinasis()->create([]);
            }
        }

        $homepage->load('destinasis');

        return view('admin.homepage.edit', compact('homepage'));
    }

    // Memperbarui Data Homepage
    // Memvalidasi input konfigurasi, memproses file media yang diunggah, dan menyimpan perubahan konfigurasi ke database.
    public function update(Request $request)
    {
        $homepage = Homepage::firstOrCreate([]);

        $request->validate([
            'hero_slides'              => 'nullable|array|max:6',
            'hero_slides.*'            => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'about_video'              => 'nullable|mimetypes:video/mp4,video/webm|max:204800',
            'destinasi_gambar.*'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'maps_link'                => 'nullable|string|max:2000',
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

        $data = $request->except(['_token', '_method', 'hero_slides', 'about_video', 'destinasi', 'destinasi_gambar', 'maps_buttons']);

        if ($request->filled('maps_link')) {
            $data['maps_link'] = $this->convertGoogleMapsToEmbed(trim($request->input('maps_link')));
        } else {
            $data['maps_link'] = null;
        }

        if ($request->has('maps_buttons')) {
            $buttons = [];
            foreach ($request->input('maps_buttons', []) as $btn) {
                if (!empty(trim($btn['nama'] ?? ''))) {
                    $buttons[] = [
                        'nama' => trim($btn['nama']),
                        'link' => trim($btn['link'] ?? ''),
                    ];
                }
            }
            $data['maps_buttons'] = json_encode($buttons, JSON_UNESCAPED_UNICODE);
        } else {
            $data['maps_buttons'] = null;
        }

        if ($request->hasFile('hero_slides')) {
            $files = $request->file('hero_slides');

            for ($i = 1; $i <= 6; $i++) {
                $field = 'hero_slide_' . $i;
                if ($homepage->$field) {
                    Storage::disk('public')->delete($homepage->$field);
                }
                $data[$field] = null;
            }

            $index = 1;
            foreach ($files as $file) {
                if ($index > 6) break;
                $field = 'hero_slide_' . $index;
                $data[$field] = $file->store('homepage', 'public');
                $index++;
            }
        }

        if ($request->hasFile('about_video')) {
            if ($homepage->about_video) {
                Storage::disk('public')->delete($homepage->about_video);
            }
            $data['about_video'] = $request->file('about_video')->store('homepage', 'public');
        }

        $homepage->update($data);

        if ($request->has('destinasi')) {
            foreach ($request->destinasi as $id => $destData) {
                $destinasi = \App\Models\HomepageDestinasi::find($id);
                if ($destinasi) {
                    if ($request->hasFile("destinasi_gambar.{$id}")) {
                        if ($destinasi->gambar) {
                            Storage::disk('public')->delete($destinasi->gambar);
                        }
                        $destData['gambar'] = $request->file("destinasi_gambar.{$id}")->store('homepage/destinasi', 'public');
                    }
                    $destinasi->update($destData);
                }
            }
        }

        return redirect()->back()->with('success', 'Konfigurasi Homepage berhasil diperbarui.');
    }

    // Konversi Link Maps
    // Mengubah format URL Google Maps biasa menjadi format embed untuk ditampilkan di dalam iframe.
    private function convertGoogleMapsToEmbed(?string $url): ?string
    {
        if (empty($url)) {
            return null;
        }

        if (str_contains($url, '/maps/embed') || str_contains($url, 'output=embed')) {
            return $url;
        }

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

            if (!empty($resolvedUrl) && $resolvedUrl !== $url) {
                $url = $resolvedUrl;
            }
        }

        if (preg_match('/@([-\d.]+),([-\d.]+),([\d.]+)z/', $url, $matches)) {
            $lat  = $matches[1];
            $lng  = $matches[2];
            $zoom = intval($matches[3]);
            $zoom = max($zoom, 18);
            return "https://maps.google.com/maps?q={$lat},{$lng}&z={$zoom}&output=embed";
        }

        if (preg_match('/place\/([^\/@?&#]+)/', $url, $matches)) {
            $placeName = rawurldecode(str_replace('+', ' ', $matches[1]));
            return 'https://maps.google.com/maps?q=' . rawurlencode($placeName) . '&z=18&output=embed';
        }

        if (str_contains($url, 'google.com/maps') || str_contains($url, 'maps.google.com')) {
            $separator = str_contains($url, '?') ? '&' : '?';
            return $url . $separator . 'output=embed';
        }

        return $url;
    }
}
