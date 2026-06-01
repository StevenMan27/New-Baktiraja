@extends('layouts.admin')

@section('title', 'Manajemen Informasi')

@section('content')

{{-- Style khusus halaman Manajemen Informasi, selaras dengan design system GeoToba --}}
<style>

    /* ======================================
       STYLE UNIK HALAMAN INFORMASI
       (Style umum sudah ada di admin.blade.php)
       ====================================== */

    /* Card utama pembungkus tabel informasi */
    .informasi-card {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.07), 0 4px 16px rgba(0,0,0,0.04);
        overflow: hidden;
    }

    /* Padding konten di dalam card */
    .informasi-card-body {
        padding: 24px;
    }

    /* Tabel utama data informasi */
    .informasi-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.83rem;
    }

    /* Sel header tabel */
    .informasi-table thead th {
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
    .informasi-table tbody td {
        padding: 12px 14px;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
        vertical-align: middle;
    }

    /* Baris terakhir tabel tidak memiliki border bawah */
    .informasi-table tbody tr:last-child td {
        border-bottom: none;
    }

    /* Efek hover baris tabel */
    .informasi-table tbody tr:hover td {
        background: #f8fafc;
    }

    /* Pesan kosong saat tidak ada data */
    .informasi-table .empty-row td {
        text-align: center;
        color: #94a3b8;
        font-size: 0.82rem;
        padding: 36px 14px;
    }

    /* Gambar thumbnail informasi dengan object-fit cover agar proporsional */
    .informasi-thumb {
        width: 56px;
        height: 44px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        display: block;
    }

    /* Placeholder gambar kosong bila tidak ada foto */
    .informasi-thumb-empty {
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

    /* Wrapper judul dan tanggal di kolom judul - unik hanya di halaman ini */
    .judul-wrapper .judul-text {
        font-weight: 600;
        color: #0f172a;
        display: block;
    }

    /* Teks tanggal kecil di bawah judul */
    .judul-wrapper .tanggal-text {
        font-size: 0.72rem;
        color: #94a3b8;
        margin-top: 3px;
        display: block;
    }

</style>


{{-- Banner header halaman dengan ikon, deskripsi, dan tombol tambah --}}
<div class="page-banner">
    <div class="page-banner-left">
        <div class="page-banner-icon">
            <i class="fas fa-newspaper"></i>
        </div>
        <div class="page-banner-text">
            <h1>Manajemen Informasi</h1>
            <p>Kelola semua data informasi GeoToba Baktiraja</p>
        </div>
    </div>
    {{-- Tombol navigasi ke halaman tambah informasi --}}
    <a href="{{ route('admin.informasi.create') }}" class="btn-tambah">
        <i class="fas fa-plus"></i> Tambah Informasi
    </a>
</div>

{{-- Card pembungkus tabel --}}
<div class="informasi-card">
    <div class="informasi-card-body">

        {{-- Notifikasi sukses setelah operasi berhasil --}}
        @if(session('success'))
            <div class="alert-sukses">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        {{-- Wrapper scroll horizontal untuk responsivitas tabel --}}
        <div class="table-wrapper">
            <table class="informasi-table">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th width="80">Gambar</th>
                        <th>Judul</th>
                        <th width="150">Lokasi Geosite</th>
                        <th width="160">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Iterasi setiap item informasi, tampilkan pesan kosong bila tidak ada data --}}
                    @forelse($informasi as $item)
                    <tr>
                        {{-- Nomor urut baris --}}
                        <td><span class="row-number">{{ $loop->iteration }}</span></td>

                        {{-- Kolom thumbnail gambar pertama dari informasi --}}
                        <td>
                            @php $imgs = json_decode($item->gambar, true); $firstImg = is_array($imgs) ? ($imgs[0] ?? null) : $item->gambar; @endphp
                            @if($firstImg)
                                <img src="{{ str_starts_with($firstImg, 'data:') ? $firstImg : asset('storage/' . $firstImg) }}"
                                     class="informasi-thumb" alt="Gambar">
                            @else
                                <div class="informasi-thumb-empty"><i class="fas fa-image"></i></div>
                            @endif
                        </td>

                        {{-- Kolom judul dan tanggal dibuat --}}
                        <td>
                            <div class="judul-wrapper">
                                <span class="judul-text">{{ $item->judul }}</span>
                                <span class="tanggal-text">{{ $item->created_at->format('d M Y') }}</span>
                            </div>
                        </td>

                        {{-- Kolom lokasi geosite dengan format kata yang dirapikan --}}
                        <td>
                            <span class="badge-geosite">
                                {{ ucwords(str_replace('-', ' ', $item->geosite)) ?? '-' }}
                            </span>
                        </td>

                        {{-- Kolom tombol aksi edit dan hapus --}}
                        <td>
                            <div class="action-buttons">
                                {{-- Tombol menuju halaman edit informasi --}}
                                <a href="{{ route('admin.informasi.edit', $item->id) }}" class="btn-edit">
                                    <i class="fas fa-edit"></i> Edit
                                </a>

                                {{-- Form hapus informasi dengan konfirmasi sebelum submit --}}
                                <form action="{{ route('admin.informasi.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete">
                                        <i class="fas fa-trash-alt"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>

                    {{-- Baris pengganti saat data informasi kosong --}}
                    @empty
                    <tr class="empty-row">
                        <td colspan="5">
                            <i class="fas fa-database" style="font-size:1.5rem; color:#cbd5e1; display:block; margin-bottom:8px;"></i>
                            Belum ada data informasi. Silakan tambah data baru.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination Laravel di bawah tabel --}}
        <div class="pagination-wrapper">
            {{ $informasi->links() }}
        </div>

    </div>
</div>

@endsection