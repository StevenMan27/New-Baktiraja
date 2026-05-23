<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\KontakMail;

class KontakController extends Controller
{
    /**
     * Tampilkan halaman kontak.
     */
    public function index()
    {
        return view('pages.kontak');
    }

    /**
     * Proses pengiriman pesan dari form kontak.
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