@extends('layouts.admin')

@section('title', 'Manajemen UMKM')

@section('content')

{{-- Style halaman Manajemen UMKM --}}
<style>

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

    .page-banner-left {
        display: flex;
        align-items: center;
        gap: 20px;
        position: relative;
        z-index: 1;
    }

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

    .page-banner-icon i {
        color: #ffffff;
        font-size: 1.3rem;
    }

    .page-banner-text h1 {
        font-size: 1.35rem;
        font-weight: 700;
        color: #ffffff;
        margin: 0 0 5px;
        letter-spacing: -0.2px;
    }

    .page-banner-text p {
        font-size: 0.8rem;
        color: rgba(255,255,255,0.7);
        margin: 0;
    }

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

    .btn-tambah:hover {
        background: rgba(255,255,255,0.25);
        transform: translateY(-1px);
        color: #ffffff;
        text-decoration: none;
    }

    .umkm-card {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.07), 0 4px 16px rgba(0,0,0,0.04);
        overflow: hidden;
    }

    .umkm-card-body {
        padding: 24px;
    }

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

    .alert-sukses i {
        font-size: 0.95rem;
        color: #22c55e;
        flex-shrink: 0;
    }

    .table-wrapper {
        overflow-x: auto;
    }

    .umkm-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.83rem;
    }

    .umkm-table thead th {
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

    .umkm-table tbody td {
        padding: 12px 14px;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
        vertical-align: middle;
    }

    .umkm-table tbody tr:last-child td {
        border-bottom: none;
    }

    .umkm-table tbody tr:hover td {
        background: #f8fafc;
    }

    .umkm-table .empty-row td {
        text-align: center;
        color: #94a3b8;
        font-size: 0.82rem;
        padding: 36px 14px;
    }

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

    .umkm-thumb {
        width: 56px;
        height: 44px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        display: block;
    }

    .umkm-thumb-empty {
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

    .nama-text {
        font-weight: 600;
        color: #0f172a;
    }

    .lokasi-text {
        color: #64748b;
        font-size: 0.8rem;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .lokasi-text i {
        color: #94a3b8;
        font-size: 0.75rem;
    }

    .kontak-text {
        color: #64748b;
        font-size: 0.8rem;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .kontak-text i {
        color: #94a3b8;
        font-size: 0.75rem;
    }

    .action-buttons {
        display: flex;
        align-items: center;
        gap: 8px;
    }

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

    .btn-edit:hover {
        background: #dbeafe;
        text-decoration: none;
        color: #003366;
    }

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

    .btn-delete:hover {
        background: #ffe4e6;
    }

    .pagination-wrapper {
        margin-top: 20px;
        display: flex;
        justify-content: flex-end;
    }

</style>

{{-- Banner header dengan ikon toko, judul, dan tombol tambah UMKM --}}
<div class="page-banner">
    <div class="page-banner-left">
        <div class="page-banner-icon">
            <i class="fas fa-store"></i>
        </div>
        <div class="page-banner-text">
            <h1>Manajemen UMKM</h1>
            <p>Kelola semua data UMKM GeoToba Baktiraja</p>
        </div>
    </div>
    <a href="{{ route('admin.umkm.create') }}" class="btn-tambah">
        <i class="fas fa-plus"></i> Tambah UMKM
    </a>
</div>

{{-- Card tabel UMKM dengan notifikasi sukses, tabel data, dan pagination --}}
{{-- Iterasi $data dengan forelse; tampilkan baris kosong bila tidak ada UMKM --}}
<div class="umkm-card">
    <div class="umkm-card-body">

        @if(session('success'))
            <div class="alert-sukses">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        <div class="table-wrapper">
            <table class="umkm-table">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th width="80">Gambar</th>
                        <th>Nama</th>
                        <th>Lokasi</th>
                        <th>Kontak</th>
                        <th width="160">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $item)
                    <tr>
                        <td><span class="row-number">{{ $loop->iteration }}</span></td>

                        <td>
                            @php $imgs = json_decode($item->gambar, true); $firstImg = is_array($imgs) ? ($imgs[0] ?? null) : $item->gambar; @endphp
                            @if($firstImg && str_starts_with($firstImg, 'data:'))
                                <img src="{{ $firstImg }}" class="umkm-thumb" alt="Gambar">
                            @else
                                <div class="umkm-thumb-empty"><i class="fas fa-store"></i></div>
                            @endif
                        </td>

                        <td><span class="nama-text">{{ $item->nama }}</span></td>

                        <td>
                            <span class="lokasi-text">
                                <i class="fas fa-map-marker-alt"></i>
                                {{ $item->lokasi ?? '-' }}
                            </span>
                        </td>

                        <td>
                            <span class="kontak-text">
                                <i class="fas fa-phone"></i>
                                {{ $item->kontak ?? '-' }}
                            </span>
                        </td>

                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.umkm.edit', $item->id) }}" class="btn-edit">
                                    <i class="fas fa-edit"></i> Edit
                                </a>

                                <form action="{{ route('admin.umkm.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus UMKM {{ $item->nama }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete">
                                        <i class="fas fa-trash-alt"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>

                    @empty
                    <tr class="empty-row">
                        <td colspan="6">
                            <i class="fas fa-store" style="font-size:1.5rem; color:#cbd5e1; display:block; margin-bottom:8px;"></i>
                            Belum ada data UMKM
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination-wrapper">
            {{ $data->links() }}
        </div>

    </div>
</div>

@endsection