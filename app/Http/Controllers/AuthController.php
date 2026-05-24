<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\OtpResetPasswordMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class AuthController extends Controller
{
    // Show login form
    public function showLogin()
    {
        return view('auth.login');
    }

    // Proses login
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

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    // Tampilkan form lupa password
    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    // Kirim OTP ke email
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);

        $user = User::where('email', $request->email)->first();
        
        if (!$user) {
            return back()->withErrors(['email' => 'Email tidak ditemukan.']);
        }

        // Generate OTP 6 digit
        $otp = (string) random_int(100000, 999999);
        
        // Hapus token lama jika ada
        DB::table('password_resets')->where('email', $request->email)->delete();
        
        // Simpan OTP baru (disimpan di kolom token)
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $otp,
            'created_at' => Carbon::now()
        ]);
        
        // Kirim email
        try {
            Mail::to($request->email)->send(new \App\Mail\OtpResetPasswordMail($otp, $request->email));
            
            // Simpan email ke session untuk langkah selanjutnya
            session(['otp_email' => $request->email]);

            return redirect()->route('password.verify-otp')->with('success', 'Kode OTP telah dikirim ke ' . $request->email . '. Silakan cek inbox atau folder spam Anda.');
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Gagal mengirim email. Error: ' . $e->getMessage()]);
        }
    }

    // Tampilkan form verifikasi OTP
    public function showVerifyOtp()
    {
        if (!session('otp_email')) {
            return redirect()->route('password.request');
        }

        return view('auth.verify-otp');
    }

    // Proses verifikasi OTP
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric|digits:6'
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
        if (Carbon::now()->diffInMinutes($createdAt) > 10) { // Kadaluarsa 10 menit
            DB::table('password_resets')->where('email', $email)->delete();
            return redirect()->route('password.request')->withErrors(['email' => 'Kode OTP sudah kadaluarsa. Silakan request ulang.']);
        }

        // OTP Valid, izinkan akses reset password
        session(['otp_verified' => true]);

        return redirect()->route('password.reset-form');
    }

    // Tampilkan form reset password
    public function showResetForm()
    {
        if (!session('otp_verified') || !session('otp_email')) {
            return redirect()->route('password.request');
        }
        
        return view('auth.reset-password');
    }

    // Proses reset password
    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed',
        ]);
        
        $email = session('otp_email');

        if (!$email || !session('otp_verified')) {
            return redirect()->route('password.request')->withErrors(['email' => 'Sesi tidak valid.']);
        }
        
        User::where('email', $email)->update([
            'password' => Hash::make($request->password)
        ]);
        
        // Bersihkan token & session
        DB::table('password_resets')->where('email', $email)->delete();
        session()->forget(['otp_email', 'otp_verified']);
        
        return redirect()->route('login')
            ->with('success', 'Password berhasil direset! Silakan login dengan password baru Anda.');
    }
}