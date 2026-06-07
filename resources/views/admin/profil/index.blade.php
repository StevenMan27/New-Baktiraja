@extends('layouts.admin')

@section('title', 'Profil Geosite')

@section('content')

{{--
   ======================================================================================
   [PENJELASAN LENGKAP FILE: a:/PA111/real/New folder/Proyek akhir 1 Real/resources/views/admin/profil/index.blade.php]

   1. BAGAIMANA CODE INI BEKERJA:
      Ini adalah file Blade Template (HTML yang dicampur kode PHP ala Laravel). Kode ini merender tampilan visual (UI) dengan menggunakan tata letak dasar dari layouts/admin.blade.php.

   2. UNTUK APA CODE INI:
      File komponen view pendukung untuk bagian a:.

   3. HUBUNGAN DENGAN CODE LAIN (RELASI):
      - Mewarisi Desain (Layout): layouts/admin.blade.php

   4. KEMANA ARAHNYA JIKA CODE INI MEMANGGIL:
      Dipanggil oleh controller terkait atau di-include oleh file blade lainnya.
   ======================================================================================
--}}



{{--
   [STYLE KHUSUS HALAMAN ADMIN PROFIL GEOSITE]
   Bagian CSS ini mengatur desain visual spesifik pada halaman pengelolaan Profil Geosite,
   seperti layout tabel khusus, tombol aksi kustom, dan lencana (badge) status profil.
--}}
<style>

    /* Banner header halaman dengan gradient biru gelap seperti pada referensi */
    .page-banner {
        background: linear-gradient(135deg, #003366 0%, #1a4a7a 100%);
        border-radius: 16px;
        padding: 28px 32px;
        display: flex;
        align-items: center;
        gap: 20px;
        margin-bottom: 28px;
        position: relative;
        overflow: hidden;
    }

    /* Dekorasi lingkaran besar di pojok kanan banner */
    .page-banner::before {
        content: '';
        position: absolute;
        top: -40px;
        right: -40px;
        width: 160px;
        height: 160px;
        background: rgba(255,255,255,0.05);
        border-radius: 50%;
    }

    /* Dekorasi lingkaran kecil di pojok kiri bawah banner */
    .page-banner::after {
        content: '';
        position: absolute;
        bottom: -30px;
        left: 120px;
        width: 100px;
        height: 100px;
        background: rgba(255,255,255,0.04);
        border-radius: 50%;
    }

    /* Wrapper kiri banner yang membungkus ikon dan teks bersama */
    .page-banner-left {
        display: flex;
        align-items: center;
        gap: 20px;
        position: relative;
        z-index: 1;
    }

    /* Kotak ikon di sisi kiri banner */
    .page-banner-icon {
        width: 52px;
        height: 52px;
        background: rgba(255,255,255,0.12);
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    /* Ikon font awesome di dalam kotak banner */
    .page-banner-icon i {
        color: #ffffff;
        font-size: 1.3rem;
    }

    /* Teks judul utama banner */
    .page-banner-text h1 {
        font-size: 1.35rem;
        font-weight: 700;
        color: #ffffff;
        margin: 0 0 5px;
        letter-spacing: -0.2px;
    }

    /* Teks deskripsi di bawah judul banner */
    .page-banner-text p {
        font-size: 0.8rem;
        color: rgba(255,255,255,0.7);
        margin: 0;
    }

    /* Card utama pembungkus tabel profil geosite */
    .profil-card {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.07), 0 4px 16px rgba(0,0,0,0.04);
        overflow: hidden;
    }

    /* Padding konten di dalam card */
    .profil-card-body {
        padding: 24px;
    }

    /* Alert sukses setelah aksi berhasil */
    .alert-sukses {
        display: flex;
        align-items: center;
        gap: 10px;
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        color: #15803d;
        padding: 12px 16px;
        border-radius: 10px;
        font-size: 0.82rem;
        font-weight: 500;
        margin-bottom: 20px;
    }

    /* Ikon centang di dalam alert sukses */
    .alert-sukses i {
        font-size: 0.95rem;
        color: #22c55e;
        flex-shrink: 0;
    }

    /* Wrapper tabel agar bisa scroll horizontal di layar kecil */
    .table-wrapper {
        overflow-x: auto;
    }

    /* Tabel utama data profil geosite */
    .profil-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.83rem;
    }

    /* Sel header tabel */
    .profil-table thead th {
        background: #f8fafc;
        color: #64748b;
        font-size: 0.72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        padding: 11px 14px;
        border-bottom: 1px solid #e2e8f0;
        white-space: nowrap;
    }

    /* Sel data tabel */
    .profil-table tbody td {
        padding: 13px 14px;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
        vertical-align: middle;
    }

    /* Baris terakhir tabel tidak memiliki border bawah */
    .profil-table tbody tr:last-child td {
        border-bottom: none;
    }

    /* Efek hover baris tabel */
    .profil-table tbody tr:hover td {
        background: #f8fafc;
    }

    /* Badge nomor urut di kolom pertama */
    .row-number {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 26px;
        height: 26px;
        background: #f1f5f9;
        color: #64748b;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    /* Teks nama geosite di kolom kedua */
    .geosite-name {
        font-weight: 600;
        color: #0f172a;
        font-size: 0.85rem;
    }

    /* Badge status profil tersedia berwarna hijau */
    .badge-tersedia {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: #f0fdf4;
        color: #15803d;
        border: 1px solid #bbf7d0;
        padding: 4px 11px;
        border-radius: 20px;
        font-size: 0.72rem;
        font-weight: 600;
        white-space: nowrap;
    }

    /* Titik indikator hijau di dalam badge tersedia */
    .badge-tersedia::before {
        content: '';
        width: 6px;
        height: 6px;
        background: #22c55e;
        border-radius: 50%;
        display: inline-block;
        flex-shrink: 0;
    }

    /* Badge status profil belum diisi berwarna abu */
    .badge-kosong {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: #f8fafc;
        color: #64748b;
        border: 1px solid #e2e8f0;
        padding: 4px 11px;
        border-radius: 20px;
        font-size: 0.72rem;
        font-weight: 600;
        white-space: nowrap;
    }

    /* Titik indikator abu di dalam badge belum diisi */
    .badge-kosong::before {
        content: '';
        width: 6px;
        height: 6px;
        background: #94a3b8;
        border-radius: 50%;
        display: inline-block;
        flex-shrink: 0;
    }

    /* Wrapper tombol aksi di kolom terakhir */
    .action-buttons {
        display: flex;
        align-items: center;
    }

    /* Ukuran tetap untuk kedua tombol agar seragam */
    .btn-edit,
    .btn-buat {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        width: 120px;
        padding: 7px 0;
        border-radius: 8px;
        font-size: 0.76rem;
        font-weight: 600;
        text-decoration: none;
        transition: opacity 0.2s ease, background 0.2s ease;
        white-space: nowrap;
        cursor: pointer;
    }

    /* Tombol edit profil berwarna biru muda */
    .btn-edit {
        background: #eff6ff;
        color: #003366;
        border: 1px solid #bfdbfe;
    }

    /* Efek hover tombol edit */
    .btn-edit:hover {
        background: #dbeafe;
        text-decoration: none;
        color: #003366;
    }

    /* Tombol buat profil baru berwarna gradient biru brand GeoToba */
    .btn-buat {
        background: linear-gradient(135deg, #003366, #1a4a7a);
        color: #ffffff;
        border: none;
    }

    /* Efek hover tombol buat profil */
    .btn-buat:hover {
        opacity: 0.88;
        text-decoration: none;
        color: #ffffff;
    }

</style>

{{--
   [TAMPILAN HEADER BANNER ADMIN]
   Menampilkan area visual navigasi atas dengan judul "Kelola Profil Geosite"
   tanpa tombol tambah, karena geosite sudah didefinisikan secara statis.
--}}
<div class="page-banner">
    <div class="page-banner-left">
        <div class="page-banner-icon">
            <i class="fas fa-mountain"></i>
        </div>
        <div class="page-banner-text">
            <h1>Kelola Profil Geosite</h1>
            <p>Kelola dan lengkapi profil setiap geosite yang ada di kawasan GeoToba Baktiraja.</p>
        </div>
    </div>
</div>

{{--
   [TAMPILAN TABEL DAFTAR PROFIL]
   Ini adalah wrapper utama untuk tabel yang akan me-looping daftar geosite 
   yang didaftarkan di dalam Controller (array $geosites).
   Tabel Database yang digunakan: 'profil_geosites'
--}}
<div class="profil-card">
    <div class="profil-card-body">

        {{-- Notifikasi sukses setelah operasi berhasil --}}
        @if(session('success'))
            <div class="alert-sukses">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        {{-- Wrapper scroll horizontal untuk responsivitas tabel --}}
        <div class="table-wrapper">
            <table class="profil-table">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th>Nama Geosite</th>
                        <th width="160">Status Profil</th>
                        <th width="160">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Inisialisasi counter nomor urut baris --}}
                    @php $i = 1; @endphp

                    {{--
                       [PERULANGAN DAFTAR GEOSITE (FOREACH)]
                       Melakukan pengecekan terhadap setiap geosite.
                       Jika geosite tersebut memiliki profil di database, muncul tombol Edit dan label Tersedia.
                       Jika tidak, muncul tombol Buat Profil dan label Belum Diisi.
                    --}}
                    @foreach($geosites as $slug => $nama)
                    @php
                        $profil = $profiles->get($slug);
                        $hasProfile = $profil ? true : false;
                    @endphp
                    <tr>
                        {{-- Nomor urut baris --}}
                        <td><span class="row-number">{{ $i++ }}</span></td>

                        {{-- Kolom nama geosite tanpa slug --}}
                        <td><span class="geosite-name">{{ $nama }}</span></td>

                        {{-- Kolom status profil, badge hijau bila sudah ada dan abu bila belum --}}
                        <td>
                            @if($hasProfile)
                                <span class="badge-tersedia">Tersedia</span>
                            @else
                                <span class="badge-kosong">Belum Diisi</span>
                            @endif
                        </td>

                        {{--
                           [TOMBOL AKSI: EDIT / BUAT PROFIL]
                           Tombol dinamis tergantung ketersediaan data profil di DB.
                        --}}
                        <td>
                            <div class="action-buttons">
                                @if($hasProfile)
                                    {{-- Tombol menuju halaman edit profil geosite yang sudah ada --}}
                                    <a href="{{ route('admin.profil.edit', $slug) }}" class="btn-edit">
                                        <i class="fas fa-edit"></i> Edit Profil
                                    </a>
                                @else
                                    {{-- Tombol menuju halaman pembuatan profil geosite baru --}}
                                    <a href="{{ route('admin.profil.edit', $slug) }}" class="btn-buat">
                                        <i class="fas fa-plus"></i> Buat Profil
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>

@endsection