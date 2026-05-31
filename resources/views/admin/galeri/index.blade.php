@extends('layouts.admin')

@section('title', 'Data Galeri')

@section('content')

{{-- Style khusus halaman Data Galeri, selaras dengan design system GeoToba --}}
<style>

    /* Banner header halaman dengan gradient biru gelap */
    .page-banner {
        background: linear-gradient(135deg, #003366 0%, #1a4a7a 100%);
        border-radius: 16px;
        padding: 28px 32px;
        display: flex;
        align-items: center;
        justify-content: space-between;
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

    /* Wrapper ikon dan teks di sisi kiri banner */
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

    /* Tombol tambah di dalam banner, warna putih transparan */
    .btn-tambah {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: rgba(255,255,255,0.15);
        color: #ffffff;
        padding: 9px 18px;
        border-radius: 10px;
        font-size: 0.82rem;
        font-weight: 600;
        text-decoration: none;
        transition: background 0.2s ease, transform 0.2s ease;
        border: 1px solid rgba(255,255,255,0.25);
        cursor: pointer;
        position: relative;
        z-index: 1;
        white-space: nowrap;
        flex-shrink: 0;
    }

    /* Efek hover tombol tambah di dalam banner */
    .btn-tambah:hover {
        background: rgba(255,255,255,0.25);
        transform: translateY(-1px);
        color: #ffffff;
        text-decoration: none;
    }

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
    }

    /* Wrapper tabel agar bisa scroll horizontal di layar kecil */
    .table-wrapper {
        overflow-x: auto;
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

    /* Gambar thumbnail galeri dengan object-fit cover agar proporsional */
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

    /* Wrapper tombol aksi edit dan hapus */
    .action-buttons {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* Tombol edit berwarna biru muda */
    .btn-edit {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 12px;
        background: #eff6ff;
        color: #003366;
        border-radius: 8px;
        font-size: 0.76rem;
        font-weight: 600;
        text-decoration: none;
        transition: background 0.2s ease;
        border: 1px solid #bfdbfe;
        white-space: nowrap;
    }

    /* Efek hover tombol edit */
    .btn-edit:hover {
        background: #dbeafe;
        text-decoration: none;
        color: #003366;
    }

    /* Tombol hapus berwarna merah muda */
    .btn-delete {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 12px;
        background: #fff1f2;
        color: #be123c;
        border-radius: 8px;
        font-size: 0.76rem;
        font-weight: 600;
        border: 1px solid #fecdd3;
        cursor: pointer;
        transition: background 0.2s ease;
        white-space: nowrap;
    }

    /* Efek hover tombol hapus */
    .btn-delete:hover {
        background: #ffe4e6;
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