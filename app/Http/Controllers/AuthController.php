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

/*
   [CONTROLLER AuthController]
   File ini bertugas mengontrol logika aplikasi untuk bagian autentikasi admin, termasuk login, logout, dan reset password.
*/
class AuthController extends Controller {
    
    /*
       [FUNGSI SHOW LOGIN]
       Method ini berfungsi untuk merender tampilan antarmuka login admin.
    */
    public function showLogin()
    {
        return view('auth.login');
    }

    /*
       [FUNGSI PROSES LOGIN]
       Method ini memproses data dari form login, memvalidasi kredensial, dan mengotentikasi admin.
    */
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

    /*
       [FUNGSI LOGOUT]
       Method ini berfungsi untuk membersihkan sesi dan mencabut hak akses admin.
    */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    /*
       [FUNGSI SHOW FORGOT PASSWORD FORM]
       Method ini berfungsi untuk merender antarmuka form lupa password.
    */
    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    /*
       [FUNGSI SEND OTP]
       Method ini berfungsi untuk men-generate OTP dan mengirimkannya ke email admin yang terdaftar.
    */
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

    /*
       [FUNGSI SHOW VERIFY OTP FORM]
       Method ini berfungsi untuk menampilkan halaman verifikasi input OTP.
    */
    public function showVerifyOtp()
    {
        if (!session('otp_email')) {
            return redirect()->route('password.request');
        }

        return view('auth.verify-otp');
    }

    /*
       [FUNGSI VERIFY OTP]
       Method ini menangani proses pengecekan kecocokan token OTP dengan yang ada di database.
    */
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

    /*
       [FUNGSI SHOW RESET PASSWORD FORM]
       Method ini menampilkan antarmuka bagi admin untuk memasukkan password baru.
    */
    public function showResetForm()
    {
        if (!session('otp_verified') || !session('otp_email')) {
            return redirect()->route('password.request');
        }
        
        return view('auth.reset-password');
    }

    /*
       [FUNGSI RESET PASSWORD]
       Method ini mengatur pembaruan password admin di database dan membersihkan token OTP.
    */
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
