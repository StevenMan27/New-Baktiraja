@extends('layouts.admin')

@section('title', 'Manajemen Fasilitas')

@section('content')

{{--
   ======================================================================================
   [PENJELASAN LENGKAP FILE: a:/PA111/real/New folder/Proyek akhir 1 Real/resources/views/admin/fasilitas/index.blade.php]

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



{{-- Style khusus halaman Manajemen Fasilitas, selaras dengan design system GeoToba --}}
<style>

    /* ======================================
       STYLE UNIK HALAMAN FASILITAS
       (Style umum sudah ada di admin.blade.php)
       ====================================== */

    /* Card utama pembungkus tabel fasilitas */
    .fasilitas-card {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.07), 0 4px 16px rgba(0,0,0,0.04);
        overflow: hidden;
    }

    /* Padding konten di dalam card */
    .fasilitas-card-body {
        padding: 24px;
    }

    /* Tabel utama data fasilitas */
    .fasilitas-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.83rem;
    }

    /* Sel header tabel */
    .fasilitas-table thead th {
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
    .fasilitas-table tbody td {
        padding: 12px 14px;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
        vertical-align: middle;
    }

    /* Baris terakhir tabel tidak memiliki border bawah */
    .fasilitas-table tbody tr:last-child td {
        border-bottom: none;
    }

    /* Efek hover baris tabel */
    .fasilitas-table tbody tr:hover td {
        background: #f8fafc;
    }

    /* Pesan kosong saat tidak ada data */
    .fasilitas-table .empty-row td {
        text-align: center;
        color: #94a3b8;
        font-size: 0.82rem;
        padding: 36px 14px;
    }

    /* Gambar thumbnail fasilitas dengan object-fit cover agar proporsional */
    .fasilitas-thumb {
        width: 56px;
        height: 44px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        display: block;
    }

    /* Placeholder gambar kosong bila tidak ada foto */
    .fasilitas-thumb-empty {
        width: 56px;
        height: 44px;
        background: #f1f5f9;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #cbd5e1;
        font-size: 1.1rem;
    }

    /* Teks nama fasilitas */
    .nama-text {
        font-weight: 600;
        color: #0f172a;
    }

    /* Badge harga fasilitas - unik karena punya dua variant (gratis/berbayar) */
    .badge-harga {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 0.72rem;
        font-weight: 600;
        white-space: nowrap;
    }

    /* Variasi badge harga gratis berwarna hijau muda */
    .badge-harga.gratis {
        background: #f0fdf4;
        color: #15803d;
        border: 1px solid #bbf7d0;
    }

    /* Variasi badge harga berbayar berwarna gold muda */
    .badge-harga.berbayar {
        background: rgba(198, 164, 59, 0.1);
        color: #92650a;
        border: 1px solid rgba(198, 164, 59, 0.3);
    }

</style>

{{-- Banner header halaman dengan ikon, deskripsi, dan tombol tambah --}}
<div class="page-banner">
    <div class="page-banner-left">
        <div class="page-banner-icon">
            <i class="fas fa-tools"></i>
        </div>
        <div class="page-banner-text">
            <h1>Manajemen Fasilitas</h1>
            <p>Kelola semua data fasilitas GeoToba Baktiraja</p>
        </div>
    </div>
    {{-- Tombol navigasi ke halaman tambah fasilitas --}}
    <a href="{{ route('admin.fasilitas.create') }}" class="btn-tambah">
        <i class="fas fa-plus"></i> Tambah Fasilitas
    </a>
</div>

{{-- Card pembungkus tabel --}}
<div class="fasilitas-card">
    <div class="fasilitas-card-body">

        {{-- Notifikasi sukses setelah operasi berhasil --}}
        @if(session('success'))
            <div class="alert-sukses">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        {{-- Wrapper scroll horizontal untuk responsivitas tabel --}}
        <div class="table-wrapper">
            <table class="fasilitas-table">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th width="80">Gambar</th>
                        <th>Nama</th>
                        <th width="140">Harga</th>
                        <th width="160">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Iterasi setiap item fasilitas, tampilkan pesan kosong bila tidak ada data --}}
                    @forelse($data as $item)
                    <tr>
                        {{-- Nomor urut baris --}}
                        <td><span class="row-number">{{ $loop->iteration }}</span></td>

                        {{-- Kolom thumbnail gambar fasilitas --}}
                        <td>
                            @php $imgs = json_decode($item->gambar, true); $firstImg = is_array($imgs) ? ($imgs[0] ?? null) : $item->gambar; @endphp
                            @if($firstImg && str_starts_with($firstImg, 'data:'))
                                <img src="{{ $firstImg }}" class="fasilitas-thumb" alt="Gambar">
                            @else
                                <div class="fasilitas-thumb-empty"><i class="fas fa-tools"></i></div>
                            @endif
                        </td>

                        {{-- Kolom nama fasilitas --}}
                        <td><span class="nama-text">{{ $item->nama }}</span></td>

                        {{-- Kolom harga fasilitas dengan badge warna berbeda untuk gratis dan berbayar --}}
                        <td>
                            @if(!$item->harga || strtolower($item->harga) === 'gratis')
                                <span class="badge-harga gratis"><i class="fas fa-check" style="font-size:0.65rem;"></i> Gratis</span>
                            @else
                                <span class="badge-harga berbayar">Rp. {{ $item->harga }}</span>
                            @endif
                        </td>

                        {{-- Kolom tombol aksi edit dan hapus --}}
                        <td>
                            <div class="action-buttons">
                                {{-- Tombol menuju halaman edit fasilitas --}}
                                <a href="{{ route('admin.fasilitas.edit', $item->id) }}" class="btn-edit">
                                    <i class="fas fa-edit"></i> Edit
                                </a>

                                {{-- Form hapus fasilitas dengan konfirmasi nama sebelum submit --}}
                                <form action="{{ route('admin.fasilitas.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus fasilitas {{ $item->nama }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete">
                                        <i class="fas fa-trash-alt"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>

                    {{-- Baris pengganti saat data fasilitas kosong --}}
                    @empty
                    <tr class="empty-row">
                        <td colspan="5">
                            <i class="fas fa-tools" style="font-size:1.5rem; color:#cbd5e1; display:block; margin-bottom:8px;"></i>
                            Belum ada data Fasilitas
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination Laravel di bawah tabel --}}
        <div class="pagination-wrapper">
            {{ $data->links() }}
        </div>

    </div>
</div>

@endsection