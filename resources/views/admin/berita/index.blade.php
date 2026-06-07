@extends('layouts.admin')

@section('title', 'Manajemen Berita')

@section('content')

<style>

    /* ======================================
       STYLE UNIK HALAMAN BERITA
       (Style umum sudah ada di admin.blade.php)
       ====================================== */

    /* Card utama pembungkus tabel berita */
    .berita-card {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.07), 0 4px 16px rgba(0,0,0,0.04);
        overflow: hidden;
    }

    /* Padding konten di dalam card */
    .berita-card-body {
        padding: 24px;
    }

    /* Tabel utama data berita */
    .berita-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.83rem;
    }

    /* Sel header tabel */
    .berita-table thead th {
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
    .berita-table tbody td {
        padding: 12px 14px;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
        vertical-align: middle;
    }

    /* Baris terakhir tabel tidak memiliki border bawah */
    .berita-table tbody tr:last-child td {
        border-bottom: none;
    }

    /* Efek hover baris tabel */
    .berita-table tbody tr:hover td {
        background: #f8fafc;
    }

    /* Pesan kosong saat tidak ada data */
    .berita-table .empty-row td {
        text-align: center;
        color: #94a3b8;
        font-size: 0.82rem;
        padding: 32px 14px;
    }

    /* Gambar thumbnail berita dengan object-fit cover agar proporsional */
    .berita-thumb {
        width: 56px;
        height: 44px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        display: block;
    }

    /* Placeholder gambar kosong bila tidak ada foto */
    .berita-thumb-empty {
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

    /* Teks judul berita */
    .judul-text {
        font-weight: 500;
        color: #0f172a;
    }

    /* Teks penulis berita */
    .penulis-text {
        color: #64748b;
        font-size: 0.8rem;
    }

</style>

<div class="page-banner">
    <div class="page-banner-left">
        <div class="page-banner-icon">
            <i class="fas fa-newspaper"></i>
        </div>
        <div class="page-banner-text">
            <h1>Manajemen Berita</h1>
            <p>Kelola semua artikel dan berita GeoToba Baktiraja</p>
        </div>
    </div>
    {{-- Tombol navigasi ke halaman tambah berita --}}
    <a href="{{ route('admin.berita.create') }}" class="btn-tambah">
        <i class="fas fa-plus"></i> Tambah Berita
    </a>
</div>

<div class="berita-card">
    <div class="berita-card-body">

        {{-- Notifikasi sukses setelah operasi berhasil --}}
        @if(session('success'))
            <div class="alert-sukses">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        {{-- Wrapper scroll horizontal untuk responsivitas tabel --}}
        <div class="table-wrapper">
            <table class="berita-table">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th width="80">Gambar</th>
                        <th>Judul</th>
                        <th width="140">Lokasi Geosite</th>
                        <th width="120">Penulis</th>
                        <th width="160">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    
                    @forelse($berita as $item)
                    <tr>
                        {{-- Nomor urut baris --}}
                        <td><span class="row-number">{{ $loop->iteration }}</span></td>

                        {{-- Kolom thumbnail gambar pertama dari berita --}}
                        <td>
                            @php $imgs = json_decode($item->gambar, true); $firstImg = is_array($imgs) ? ($imgs[0] ?? null) : $item->gambar; @endphp
                            @if($firstImg)
                                <img src="{{ str_starts_with($firstImg, 'data:') ? $firstImg : asset('storage/' . $firstImg) }}"
                                     class="berita-thumb" alt="Gambar">
                            @else
                                <div class="berita-thumb-empty"><i class="fas fa-image"></i></div>
                            @endif
                        </td>

                        {{-- Kolom judul berita --}}
                        <td><span class="judul-text">{{ $item->judul }}</span></td>

                        {{-- Kolom lokasi geosite dengan format kata yang dirapikan --}}
                        <td>
                            <span class="badge-geosite">
                                {{ ucwords(str_replace('-', ' ', $item->geosite)) ?? '-' }}
                            </span>
                        </td>

                        {{-- Kolom nama penulis berita --}}
                        <td><span class="penulis-text">{{ $item->penulis ?? '-' }}</span></td>

                        
                        <td>
                            <div class="action-buttons">
                                {{-- Tombol menuju halaman edit berita --}}
                                <a href="{{ route('admin.berita.edit', $item->id) }}" class="btn-edit">
                                    <i class="fas fa-edit"></i> Edit
                                </a>

                                {{-- Form hapus berita dengan konfirmasi sebelum submit --}}
                                <form action="{{ route('admin.berita.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete">
                                        <i class="fas fa-trash-alt"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>

                    {{-- Baris pengganti saat data berita kosong --}}
                    @empty
                    <tr class="empty-row">
                        <td colspan="6">
                            <i class="fas fa-newspaper" style="font-size:1.5rem; color:#cbd5e1; display:block; margin-bottom:8px;"></i>
                            Belum ada berita
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination Laravel di bawah tabel --}}
        <div class="pagination-wrapper">
            {{ $berita->links() }}
        </div>

    </div>
</div>

@endsection