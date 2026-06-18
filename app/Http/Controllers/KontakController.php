<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\KontakMail;

// Menangani tampilan halaman kontak dan pengiriman pesan dari pengunjung ke admin via email.
// Data kontak diambil dari model Kontak; pesan pengunjung dikirim menggunakan KontakMail.
class KontakController extends Controller {

    // Menampilkan halaman kontak beserta informasi kontak yang tersimpan di database.
    // Data diambil dari model Kontak; output ke view 'pages.kontak' via compact.
    public function index()
    {
        $kontak = \App\Models\Kontak::first();
        if (!$kontak) {
            $kontak = new \App\Models\Kontak();
        }
        return view('pages.kontak', compact('kontak'));
    }

    // Memvalidasi dan mengirimkan pesan dari form kontak ke email admin via Mail.
    // Input nama, email, subjek, pesan, telepon dari $request; output redirect kembali dengan pesan sukses.
    public function kirim(Request $request)
    {
        $request->validate([
            'nama'    => 'required',
            'email'   => 'required|email',
            'subjek'  => 'required',
            'pesan'   => 'required',
        ]);

        Mail::to('ambaritatuktuktomokadmingeosit@gmail.com')->send(
            new KontakMail(
                $request->nama,
                $request->email,
                $request->telepon,
                $request->subjek,
                $request->pesan
            )
        );

        return back()->with('success', 'Pesan berhasil dikirim!');
    }
}
