@extends('layouts.admin')

@section('title', 'Data Galeri')

@section('content')

{{-- Style khusus halaman Data Galeri, selaras dengan design system GeoToba --}}
<style>

    /* ======================================
       STYLE UNIK HALAMAN GALERI
       (Style umum sudah ada di admin.blade.php)
       ====================================== */

    /* Card utama pembungkus tabel galeri */
    .galeri-card {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.07), 0 4px 16px rgba(0,0,0,0.04);
        overflow: hidden;
    }

    /* Padding konten di dalam card */
    .galeri-card-body {
        padding: 24px;
    }

    /* Tabel utama data galeri */
    .galeri-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.83rem;
    }

    /* Sel header tabel */
    .galeri-table thead th {
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
    .galeri-table tbody td {
        padding: 12px 14px;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
        vertical-align: middle;
    }

    /* Baris terakhir tabel tidak memiliki border bawah */
    .galeri-table tbody tr:last-child td {
        border-bottom: none;
    }

    /* Efek hover baris tabel */
    .galeri-table tbody tr:hover td {
        background: #f8fafc;
    }

    /* Gambar thumbnail galeri - ukuran sedikit lebih besar dari halaman lain */
    .galeri-thumb {
        width: 60px;
        height: 46px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        display: block;
    }

    /* Placeholder gambar kosong bila tidak ada foto */
    .galeri-thumb-empty {
        width: 60px;
        height: 46px;
        background: #f1f5f9;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #cbd5e1;
        font-size: 1.1rem;
    }

    /* Teks judul galeri */
    .judul-text {
        font-weight: 500;
        color: #0f172a;
    }

</style>

{{-- Banner header halaman dengan ikon, deskripsi, dan tombol tambah --}}
<div class="page-banner">
    <div class="page-banner-left">
        <div class="page-banner-icon">
            <i class="fas fa-images"></i>
        </div>
        <div class="page-banner-text">
            <h1>Data Galeri</h1>
            <p>Kelola semua data foto galeri GeoToba Baktiraja</p>
        </div>
    </div>
    {{-- Tombol navigasi ke halaman tambah galeri --}}
    <a href="{{ route('admin.galeri.create') }}" class="btn-tambah">
        <i class="fas fa-plus"></i> Tambah Galeri
    </a>
</div>

{{-- Card pembungkus tabel --}}
<div class="galeri-card">
    <div class="galeri-card-body">

        {{-- Notifikasi sukses setelah operasi berhasil --}}
        @if(session('success'))
            <div class="alert-sukses">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        {{-- Wrapper scroll horizontal untuk responsivitas tabel --}}
        <div class="table-wrapper">
            <table class="galeri-table">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th width="80">Gambar</th>
                        <th>Judul</th>
                        <th width="160">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Iterasi setiap item galeri dari database --}}
                    @foreach($galeris as $i => $g)
                    <tr>
                        {{-- Nomor urut baris --}}
                        <td><span class="row-number">{{ $i+1 }}</span></td>

                        {{-- Kolom thumbnail gambar pertama dari galeri --}}
                        <td>
                            @php $imgs = json_decode($g->gambar, true); $firstImg = is_array($imgs) ? ($imgs[0] ?? null) : $g->gambar; @endphp
                            @if($firstImg)
                                <img src="{{ $firstImg && str_starts_with($firstImg, 'data:') ? $firstImg : ($firstImg ? asset('storage/' . $firstImg) : '') }}"
                                     class="galeri-thumb" alt="Gambar">
                            @else
                                <div class="galeri-thumb-empty"><i class="fas fa-image"></i></div>
                            @endif
                        </td>

                        {{-- Kolom judul galeri --}}
                        <td><span class="judul-text">{{ $g->judul }}</span></td>

                        {{-- Kolom tombol aksi edit dan hapus --}}
                        <td>
                            <div class="action-buttons">
                                {{-- Tombol menuju halaman edit galeri --}}
                                <a href="{{ route('admin.galeri.edit', $g->id) }}" class="btn-edit">
                                    <i class="fas fa-edit"></i> Edit
                                </a>

                                {{-- Form hapus galeri dengan konfirmasi sebelum submit --}}
                                <form action="{{ route('admin.galeri.destroy', $g->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete">
                                        <i class="fas fa-trash-alt"></i> Hapus
                                    </button>
                                </form>
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