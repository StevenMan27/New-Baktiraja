<?php

// Mendefinisikan namespace untuk AuthController agar di-load secara otomatis
namespace App\Http\Controllers;

// Mengimpor kelas Model Admin untuk interaksi dengan tabel admin
use App\Models\Admin;
// Mengimpor kelas Mailable OtpResetPasswordMail untuk mengirim email OTP
use App\Mail\OtpResetPasswordMail;
// Mengimpor kelas Request untuk membaca data input HTTP
use Illuminate\Http\Request;
// Mengimpor fasad Auth untuk mengelola autentikasi user
use Illuminate\Support\Facades\Auth;
// Mengimpor fasad Hash untuk hashing dan verifikasi password
use Illuminate\Support\Facades\Hash;
// Mengimpor fasad Str untuk operasi manipulasi string
use Illuminate\Support\Str;
// Mengimpor fasad DB untuk menjalankan Query Builder
use Illuminate\Support\Facades\DB;
// Mengimpor fasad Mail untuk fasilitas pengiriman email Laravel
use Illuminate\Support\Facades\Mail;
// Mengimpor library Carbon untuk memanipulasi waktu dan tanggal
use Carbon\Carbon;

// Deklarasi kelas AuthController turunan Controller
class AuthController extends Controller {
    /*
       [CONTROLLER AuthController]
       File ini bertugas mengontrol logika aplikasi untuk bagian publik dari AuthController.
       Berfungsi mengambil data dari Model dan melemparkannya ke file View yang sesuai.
       Tabel Database yang digunakan: menyesuaikan dengan fungsi yang dipanggil.
    */
    // Show login form
    // Method showLogin berfungsi untuk merender tampilan antarmuka login
    public function showLogin()
    {
        // Memanggil helper view() untuk me-render file blade auth/login
        return view('auth.login');
    }

    // Proses login
    // Method login berfungsi untuk memproses data dari form login
    public function login(Request $request)
    {
        // Validasi data input form email dan password
        $credentials = $request->validate([
            // Email diperlukan dan formatnya harus valid
            'email' => 'required|email',
            // Password diperlukan dan tidak boleh kosong
            'password' => 'required',
        ], [
            // Pesan error kustom untuk kolom email wajib diisi
            'email.required' => 'Email atau password belum diisi.',
            // Pesan error kustom untuk kolom password wajib diisi
            'password.required' => 'Email atau password belum diisi.',
            // Pesan error kustom jika format email tidak sesuai standar email
            'email.email' => 'Email atau password salah.',
        ]);

        // Melakukan percobaan autentikasi login dengan kredensial yang divalidasi
        if (Auth::attempt($credentials)) {
            // Memperbarui session ID untuk mencegah serangan session fixation
            $request->session()->regenerate();
            // Melakukan redirect ke halaman tujuan (/admin) jika berhasil login
            return redirect()->intended('/admin');
        }

        // Jika login gagal, maka redirect kembali ke halaman login membawa pesan error
        return back()->withErrors([
            // Meneruskan pesan error spesifik jika kredensial tidak cocok
            'email' => 'Email atau password salah.',
        ]);
    }

    // Logout
    // Method logout berfungsi untuk membersihkan sesi dan mencabut hak akses user
    public function logout(Request $request)
    {
        // Menjalankan fungsi logout pada fasad Auth untuk menghapus informasi pengguna yang login
        Auth::logout();
        // Membatalkan semua data session user yang aktif
        $request->session()->invalidate();
        // Membangkitkan ulang CSRF Token agar sesi yang lama tidak dapat digunakan untuk serangan CSRF
        $request->session()->regenerateToken();
        // Mengalihkan pengunjung menuju halaman depan / beranda root
        return redirect('/');
    }

    // Tampilkan form lupa password
    // Method showForgotForm berfungsi me-render antarmuka input lupa password
    public function showForgotForm()
    {
        // Menampilkan file blade forgot-password dari folder auth
        return view('auth.forgot-password');
    }

    // Kirim OTP ke email
    // Method sendOtp berfungsi mengenerate dan mengirim kode OTP ke email
    public function sendOtp(Request $request)
    {
        // Validasi input email dengan pesan yang mudah dipahami
        // Validasi input email dari user yang lupa password
        $request->validate([
            // Email wajib diisi, format valid, dan harus terdaftar di tabel admins pada kolom email
            'email' => 'required|email|exists:admins,email',
        ], [
            // Pesan custom jika tidak ada teks di kolom email
            'email.required' => 'Alamat email tidak boleh kosong.',
            // Pesan custom jika format penulisan email salah
            'email.email'    => 'Format email tidak valid. Contoh yang benar: nama@gmail.com',
            // Pesan custom jika email tidak ditemukan dalam database tabel admin
            'email.exists'   => 'Email yang Anda masukkan tidak terdaftar. Periksa kembali alamat email Anda.',
        ]);

        // Mengeksekusi Query Builder untuk mencari baris data Admin berdasarkan email
        $user = Admin::where('email', $request->email)->first();
        
        // Memeriksa jika user admin tersebut benar-benar tidak ditemukan (meskipun harusnya sudah tervalidasi)
        if (!$user) {
            // Mengembalikan ke halaman sebelumnya dengan menumpuk pesan error pada session
            return back()->withErrors(['email' => 'Email tidak ditemukan.']);
        }

        // Generate OTP 6 digit
        // Menghasilkan string acak sepanjang 6 digit dengan menggunakan fungsi bawaan PHP
        $otp = (string) random_int(100000, 999999);
        
        // Hapus token lama jika ada
        // Menggunakan Query Builder DB untuk langsung menghapus semua record pada tabel password_resets dengan email tersebut
        DB::table('password_resets')->where('email', $request->email)->delete();
        
        // Simpan OTP baru (disimpan di kolom token)
        // Melakukan insert baris data token OTP yang baru ter-generate ke tabel password_resets
        DB::table('password_resets')->insert([
            // Memasukkan input email pada record
            'email' => $request->email,
            // Memasukkan string OTP pada kolom token
            'token' => $otp,
            // Mencatat waktu pembuatan token OTP ini dengan library Carbon
            'created_at' => Carbon::now()
        ]);
        
        // Kirim email
        // Menggunakan try-catch block untuk menangani masalah SMTP jika gagal mengirim email
        try {
            // Menggunakan Mail Facade untuk mengirim instance mailable ke alamat email yang diminta
            Mail::to($request->email)->send(new \App\Mail\OtpResetPasswordMail($otp, $request->email));
            
            // Simpan email ke session untuk langkah selanjutnya
            // Menyimpan alamat email terkait OTP ke dalam variable Session dengan key 'otp_email'
            session(['otp_email' => $request->email]);

            // Mengalihkan rute url menuju halaman verifikasi OTP dan flash session bertanda 'success'
            return redirect()->route('password.verify-otp')->with('success', 'Kode OTP telah dikirim ke ' . $request->email . '. Silakan cek inbox atau folder spam Anda.');
        // Menangkap blok kesalahan / Exception apabila sistem email bermasalah
        } catch (\Exception $e) {
            // Meredirect user ke halaman sebelumnya dan mencetak pesan exception yang menyebabkan error
            return back()->withErrors(['email' => 'Gagal mengirim email. Error: ' . $e->getMessage()]);
        }
    }

    // Tampilkan form verifikasi OTP
    // Method showVerifyOtp berfungsi menampilkan input field OTP
    public function showVerifyOtp()
    {
        // Memeriksa keberadaan string email pada variabel session
        if (!session('otp_email')) {
            // Mengembalikan user ke form awal / request password jika session tak ada
            return redirect()->route('password.request');
        }

        // Menampilkan antarmuka formulir verifikasi input OTP
        return view('auth.verify-otp');
    }

    // Proses verifikasi OTP
    // Method verifyOtp menangani proses kecocokan token OTP dan database
    public function verifyOtp(Request $request)
    {
        // Validasi kode OTP harus 6 digit angka dengan pesan yang jelas
        // Melakukan validasi karakter yang dimasukkan
        $request->validate([
            // Input OTP wajib ada, harus berjenis numerik, dan mutlak panjangnya 6 digit
            'otp' => 'required|numeric|digits:6',
        ], [
            // Pesan jika kolom OTP kosong
            'otp.required' => 'Kode OTP tidak boleh kosong. Silakan masukkan kode yang dikirim ke email Anda.',
            // Pesan jika kolom OTP bukan berformat angka
            'otp.numeric'  => 'Kode OTP hanya boleh berisi angka.',
            // Pesan jika panjang karakter bukan bernilai 6
            'otp.digits'   => 'Kode OTP harus terdiri dari 6 angka.',
        ]);

        // Menyalin isi dari session email ke dalam lokal variabel
        $email = session('otp_email');

        // Melakukan check string $email
        if (!$email) {
            // Jika kosong/null maka langsung kembalikan user ke page awal lupa password
            return redirect()->route('password.request')->withErrors(['email' => 'Sesi berakhir, silakan request ulang OTP.']);
        }

        // Mengeksekusi Query pencarian dari tabel resets mencocokkan email serta token OTP tersebut
        $resetData = DB::table('password_resets')
            // Menyaring di mana email cocok
            ->where('email', $email)
            // Menyaring di mana token/otp cocok
            ->where('token', $request->otp)
            // Mengambil satu entri yang cocok pertama
            ->first();

        // Melakukan check if objek data tersebut berhasil diraih/ada
        if (!$resetData) {
            // Jika kosong, maka return back dengan mencetak peringatan kode tak cocok
            return back()->withErrors(['otp' => 'Kode OTP salah.']);
        }

        // Melakukan parsing pada string waktu pembuatan OTP
        $createdAt = Carbon::parse($resetData->created_at);
        // Mengecek perbedaan waktu antara sekarang dengan saat pembuatan jika sudah melebihi 10 menit
        if (Carbon::now()->diffInMinutes($createdAt) > 10) { // Kadaluarsa 10 menit
            // Menghapus data reset email tersebut pada database jika expired
            DB::table('password_resets')->where('email', $email)->delete();
            // Redirect menuju rute forget password sembari memberitahu peringatan OTP basi
            return redirect()->route('password.request')->withErrors(['email' => 'Kode OTP sudah kadaluarsa. Silakan request ulang.']);
        }

        // OTP Valid, izinkan akses reset password
        // Memberikan session akses true untuk melanjutkan ke form reset password final
        session(['otp_verified' => true]);

        // Merouting user lanjut ke halaman reset
        return redirect()->route('password.reset-form');
    }

    // Tampilkan form reset password
    // Method showResetForm adalah antarmuka user mengganti passwordnya dengan yang baru
    public function showResetForm()
    {
        // Mengecek bila session otp_verified atau session email tidak ditemukan
        if (!session('otp_verified') || !session('otp_email')) {
            // Menolak akses dan mengusir user kembali menuju rute pengajuan request password
            return redirect()->route('password.request');
        }
        
        // Membuka file UI auth/reset-password
        return view('auth.reset-password');
    }

    // Proses reset password
    // Method resetPassword yang mengatur pembaruan baris data password dalam database
    public function resetPassword(Request $request)
    {
        // Validasi password baru harus minimal 6 karakter dan sama dengan konfirmasi password
        // Melakukan evaluasi aturan penulisan password
        $request->validate([
            // Input password wajib ada, min 6 char, dan terkonfirmasi sama dengan field temannya
            'password'              => 'required|min:6|confirmed',
            // Input konfirmasi password wajib ada nilainya
            'password_confirmation' => 'required',
        ], [
            // Pesan peringatan bila password baru null
            'password.required'              => 'Password baru tidak boleh kosong.',
            // Pesan peringatan jika tidak mencapai limit minimal 6 length
            'password.min'                   => 'Password terlalu pendek. Minimal harus 6 karakter.',
            // Pesan peringatan error ketika field konfirmasi tidak berbunyi sama persis
            'password.confirmed'             => 'Password baru dan konfirmasi password tidak sama. Ketik ulang kedua password dengan benar.',
            // Pesan jika konfirmasi password null
            'password_confirmation.required' => 'Konfirmasi password tidak boleh kosong.',
        ]);
        
        // Mengambil isi string dari session
        $email = session('otp_email');

        // Melakukan pertahanan sesi agar tidak bisa ditembus bila variabel sessionnya diretas/tidak ada
        if (!$email || !session('otp_verified')) {
            // Meredirect paksa user ke rute awal jika sessionnya bolong
            return redirect()->route('password.request')->withErrors(['email' => 'Sesi tidak valid.']);
        }
        
        // Menggunakan ORM Eloquent merubah record password admin berdasarkan filter email
        Admin::where('email', $email)->update([
            // Memasukkan hasil password yang sudah dikodekan secara hash
            'password' => Hash::make($request->password)
        ]);
        
        // Bersihkan token & session
        // Membersihkan sampah token OTP bekas dalam database
        DB::table('password_resets')->where('email', $email)->delete();
        // Menghapus cache session khusus OTP untuk menghindari penggunaan ulang di kesempatan lain
        session()->forget(['otp_email', 'otp_verified']);
        
        // Meredirect user ke rute halaman Login sembari mengucapkan flash message password sukses diubah
        return redirect()->route('login')
            ->with('success', 'Password berhasil direset! Silakan login dengan password baru Anda.');
    }
}
