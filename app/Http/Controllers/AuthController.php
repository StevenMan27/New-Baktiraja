<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Mail\OtpResetPasswordMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

// Menangani seluruh alur autentikasi admin: login, logout, dan reset password via OTP.
// Data masuk dari form request; data keluar ke session, redirect, atau email admin.
class AuthController extends Controller {
    
    // Menampilkan halaman antarmuka login admin.
    // Tidak ada input; mengembalikan view 'auth.login'.
    public function showLogin()
    {
        return view('auth.login');
    }

    // Memvalidasi kredensial dari form login dan mengotentikasi admin.
    // Input dari $request (email, password); output redirect ke '/admin' atau kembali dengan error.
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Email atau password belum diisi.',
            'password.required' => 'Email atau password belum diisi.',
            'email.email' => 'Email atau password salah.',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/admin');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    // Menghapus sesi aktif dan mencabut autentikasi admin yang sedang login.
    // Input dari $request (session); output redirect ke halaman utama '/'.
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    // Menampilkan halaman form lupa password untuk memulai proses reset.
    // Tidak ada input; mengembalikan view 'auth.forgot-password'.
    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    // Men-generate kode OTP 6 digit dan mengirimkannya ke email admin yang terdaftar.
    // Input email dari $request; OTP disimpan ke tabel 'password_resets' dan dikirim via Mail.
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:admins,email',
        ], [
            'email.required' => 'Alamat email tidak boleh kosong.',
            'email.email'    => 'Format email tidak valid. Contoh yang benar: nama@gmail.com',
            'email.exists'   => 'Email yang Anda masukkan tidak terdaftar. Periksa kembali alamat email Anda.',
        ]);

        $user = Admin::where('email', $request->email)->first();
        
        if (!$user) {
            return back()->withErrors(['email' => 'Email tidak ditemukan.']);
        }

        $otp = (string) random_int(100000, 999999);
        
        DB::table('password_resets')->where('email', $request->email)->delete();
        
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $otp,
            'created_at' => Carbon::now()
        ]);
        
        try {
            Mail::to($request->email)->send(new \App\Mail\OtpResetPasswordMail($otp, $request->email));
            
            session(['otp_email' => $request->email]);

            return redirect()->route('password.verify-otp')->with('success', 'Kode OTP telah dikirim ke ' . $request->email . '. Silakan cek inbox atau folder spam Anda.');
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Gagal mengirim email. Error: ' . $e->getMessage()]);
        }
    }

    // Menampilkan halaman input kode OTP setelah email dikirim.
    // Mengecek keberadaan session 'otp_email'; mengembalikan view 'auth.verify-otp' atau redirect.
    public function showVerifyOtp()
    {
        if (!session('otp_email')) {
            return redirect()->route('password.request');
        }

        return view('auth.verify-otp');
    }

    // Memverifikasi kode OTP yang dimasukkan admin dengan token di database dan memeriksa masa berlakunya.
    // Input OTP dari $request dan email dari session; output redirect ke form reset atau kembali dengan error.
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric|digits:6',
        ], [
            'otp.required' => 'Kode OTP tidak boleh kosong. Silakan masukkan kode yang dikirim ke email Anda.',
            'otp.numeric'  => 'Kode OTP hanya boleh berisi angka.',
            'otp.digits'   => 'Kode OTP harus terdiri dari 6 angka.',
        ]);

        $email = session('otp_email');

        if (!$email) {
            return redirect()->route('password.request')->withErrors(['email' => 'Sesi berakhir, silakan request ulang OTP.']);
        }

        $resetData = DB::table('password_resets')
            ->where('email', $email)
            ->where('token', $request->otp)
            ->first();

        if (!$resetData) {
            return back()->withErrors(['otp' => 'Kode OTP salah.']);
        }

        $createdAt = Carbon::parse($resetData->created_at);
        if (Carbon::now()->diffInMinutes($createdAt) > 10) {
            DB::table('password_resets')->where('email', $email)->delete();
            return redirect()->route('password.request')->withErrors(['email' => 'Kode OTP sudah kadaluarsa. Silakan request ulang.']);
        }

        session(['otp_verified' => true]);

        return redirect()->route('password.reset-form');
    }

    // Menampilkan form input password baru setelah OTP berhasil diverifikasi.
    // Mengecek session 'otp_verified' dan 'otp_email'; mengembalikan view 'auth.reset-password' atau redirect.
    public function showResetForm()
    {
        if (!session('otp_verified') || !session('otp_email')) {
            return redirect()->route('password.request');
        }
        
        return view('auth.reset-password');
    }

    // Memperbarui password admin di database dan membersihkan token OTP serta session terkait.
    // Input password baru dari $request dan email dari session; output redirect ke halaman login dengan pesan sukses.
    public function resetPassword(Request $request)
    {
        $request->validate([
            'password'              => 'required|min:6|confirmed',
            'password_confirmation' => 'required',
        ], [
            'password.required'              => 'Password baru tidak boleh kosong.',
            'password.min'                   => 'Password terlalu pendek. Minimal harus 6 karakter.',
            'password.confirmed'             => 'Password baru dan konfirmasi password tidak sama. Ketik ulang kedua password dengan benar.',
            'password_confirmation.required' => 'Konfirmasi password tidak boleh kosong.',
        ]);
        
        $email = session('otp_email');

        if (!$email || !session('otp_verified')) {
            return redirect()->route('password.request')->withErrors(['email' => 'Sesi tidak valid.']);
        }
        
        Admin::where('email', $email)->update([
            'password' => Hash::make($request->password)
        ]);
        
        DB::table('password_resets')->where('email', $email)->delete();
        session()->forget(['otp_email', 'otp_verified']);
        
        return redirect()->route('login')
            ->with('success', 'Password berhasil direset! Silakan login dengan password baru Anda.');
    }
}
