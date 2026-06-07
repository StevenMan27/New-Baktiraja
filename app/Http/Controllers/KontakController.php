<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\KontakMail;

/*
   [CONTROLLER KontakController]
   File ini bertugas mengontrol logika aplikasi untuk bagian halaman kontak dan pengiriman pesan email.
*/
class KontakController extends Controller {

    /*
       [FUNGSI INDEX KONTAK]
       Method ini berfungsi untuk menangani permintaan dan menampilkan halaman kontak.
    */
    public function index()
    {
        $kontak = \App\Models\Kontak::first();
        if (!$kontak) {
            $kontak = new \App\Models\Kontak();
        }
        return view('pages.kontak', compact('kontak'));
    }

    /*
       [FUNGSI KIRIM PESAN KONTAK]
       Method ini memproses data dari form kontak dan mengirimkannya via email ke admin.
    */
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
