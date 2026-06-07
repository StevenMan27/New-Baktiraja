<?php

// Menetapkan namespace untuk controller agar sesuai dengan struktur direktori aplikasi
namespace App\Http\Controllers;

// Mengimpor kelas Request untuk menangani HTTP request yang masuk
use Illuminate\Http\Request;
// Mengimpor fasad Mail untuk dapat menggunakan fungsionalitas pengiriman email
use Illuminate\Support\Facades\Mail;
// Mengimpor Mailable KontakMail untuk format email yang akan dikirim
use App\Mail\KontakMail;

// Mendeklarasikan class KontakController yang diturunkan dari class Controller bawaan
class KontakController extends Controller {
    /*
       [CONTROLLER KontakController]
       File ini bertugas mengontrol logika aplikasi untuk bagian publik dari KontakController.
       Berfungsi mengambil data dari Model dan melemparkannya ke file View yang sesuai.
       Tabel Database yang digunakan: menyesuaikan dengan fungsi yang dipanggil.
    */
    /**
     * Tampilkan halaman kontak.
     */
    // Mendefinisikan fungsi index untuk menangani permintaan halaman kontak
    public function index()
    {
        // Mengambil data (record) pertama dari tabel kontak melalui Model
        $kontak = \App\Models\Kontak::first();
        // Mengecek apakah data kontak tidak ditemukan (null)
        if (!$kontak) {
            // Jika tidak ada data, inisialisasi objek Kontak baru agar tidak error di view
            $kontak = new \App\Models\Kontak();
        }
        // Mengembalikan tampilan (view) 'pages.kontak' dengan membawa variabel kontak
        return view('pages.kontak', compact('kontak'));
    }

    /**
     * Proses pengiriman pesan dari form kontak.
     */
    // Mendefinisikan fungsi kirim untuk memproses data dari form kontak
    public function kirim(Request $request)
    {
        // Melakukan validasi pada data request berdasarkan aturan yang ditetapkan
        $request->validate([
            // Memastikan kolom nama harus diisi
            'nama'    => 'required',
            // Memastikan kolom email harus diisi dan harus berupa email yang valid
            'email'   => 'required|email',
            // Memastikan kolom subjek harus diisi
            'subjek'  => 'required',
            // Memastikan kolom pesan harus diisi
            'pesan'   => 'required',
        ]);

        // Mengirimkan email ke alamat admin tujuan dengan Mailable KontakMail
        Mail::to('ambaritatuktuktomokadmingeosit@gmail.com')->send(
            // Membuat instansi KontakMail baru dengan data-data request form
            new KontakMail(
                // Meneruskan data nama pengguna dari request
                $request->nama,
                // Meneruskan data email pengguna dari request
                $request->email,
                // Meneruskan data telepon pengguna dari request (jika ada)
                $request->telepon,
                // Meneruskan data subjek dari request
                $request->subjek,
                // Meneruskan data isi pesan dari request
                $request->pesan
            )
        );

        // Mengarahkan kembali ke halaman sebelumnya dengan membawa pesan 'success'
        return back()->with('success', 'Pesan berhasil dikirim!');
    }
}
