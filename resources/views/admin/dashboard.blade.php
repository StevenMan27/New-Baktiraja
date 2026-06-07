@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

{{--
   ======================================================================================
   [PENJELASAN LENGKAP FILE: a:/PA111/real/New folder/Proyek akhir 1 Real/resources/views/admin/dashboard.blade.php]

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
   [TAMPILAN KARTU STATISTIK DASBOR]
   Bagian ini bertugas mencetak kotak-kotak ringkasan jumlah data (Galeri, Berita, Informasi, dll) di halaman utama Admin.
   Data dikirim dari metode AdminController@dashboard.
--}}
<!-- STATISTIK -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-number">{{ $totalGaleri ?? 0 }}</div>
        <div class="stat-label">Galeri</div>
    </div>
    <div class="stat-card">
        <div class="stat-number">{{ $totalBerita ?? 0 }}</div>
        <div class="stat-label">Berita</div>
    </div>
    <div class="stat-card">
        <div class="stat-number">{{ $totalInformasi ?? 0 }}</div>
        <div class="stat-label">Informasi</div>
    </div>
    <div class="stat-card">
        <div class="stat-number">{{ $totalUmkm ?? 0 }}</div>
        <div class="stat-label">UMKM</div>
    </div>
    <div class="stat-card">
        <div class="stat-number">{{ $totalFasilitas ?? 0 }}</div>
        <div class="stat-label">Fasilitas</div>
    </div>
    <div class="stat-card">
        <div class="stat-number">{{ $totalPenginapan ?? 0 }}</div>
        <div class="stat-label">Penginapan</div>
    </div>
</div>


@endsection 


