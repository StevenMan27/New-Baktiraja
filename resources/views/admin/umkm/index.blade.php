@extends('layouts.admin')

@section('title', 'Manajemen UMKM')

@section('content')

{{-- Style khusus halaman Manajemen UMKM, selaras dengan design system GeoToba --}}
<style>

    /* Wrapper judul halaman di bagian atas konten */
    .page-heading {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }

    /* Teks judul utama halaman */
    .page-heading h1 {
        font-size: 1.3rem;
        font-weight: 700;
        color: #0f172a;
        margin: 0;
    }

    /* Teks subjudul kecil di bawah judul utama */
    .page-heading p {
        font-size: 0.78rem;
        color: #94a3b8;
        margin: 3px 0 0;
    }

    /* Tombol tambah data dengan gradient biru sesuai brand GeoToba */
    .btn-tambah {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: linear-gradient(135deg, #003366, #1a4a7a);
        color: #ffffff;
        padding: 9px 18px;
        border-radius: 10px;
        font-size: 0.82rem;
        font-weight: 600;
        text-decoration: none;
        transition: opacity 0.2s ease, transform 0.2s ease;
        border: none;
        cursor: pointer;
    }

    /* Efek hover tombol tambah, sedikit terangkat */
    .btn-tambah:hover {
        opacity: 0.88;
        transform: translateY(-1px);
        color: #ffffff;
        text-decoration: none;
    }

    /* Card utama pembungkus tabel UMKM */
    .umkm-card {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.07), 0 4px 16px rgba(0,0,0,0.04);
        overflow: hidden;
    }

    /* Padding konten di dalam card */
    .umkm-card-body {
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

    /* Tabel utama data UMKM */
    .umkm-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.83rem;
    }

    /* Sel header tabel */
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

    /* Sel data tabel */
    .umkm-table tbody td {
        padding: 12px 14px;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
        vertical-align: middle;
    }

    /* Baris terakhir tabel tidak memiliki border bawah */
    .umkm-table tbody tr:last-child td {
        border-bottom: none;
    }

    /* Efek hover baris tabel */
    .umkm-table tbody tr:hover td {
        background: #f8fafc;
    }

    /* Pesan kosong saat tidak ada data */
    .umkm-table .empty-row td {
        text-align: center;
        color: #94a3b8;
        font-size: 0.82rem;
        padding: 36px 14px;
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

    /* Gambar thumbnail UMKM dengan object-fit cover agar proporsional */
    .umkm-thumb {
        width: 56px;
        height: 44px;
        object-fit: cover;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        display: block;
    }

    /* Placeholder gambar kosong bila tidak ada foto */
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

    /* Teks nama UMKM */
    .nama-text {
        font-weight: 600;
        color: #0f172a;
    }

    /* Teks lokasi UMKM */
    .lokasi-text {
        color: #64748b;
        font-size: 0.8rem;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    /* Ikon lokasi di samping teks */
    .lokasi-text i {
        color: #94a3b8;
        font-size: 0.75rem;
    }

    /* Teks kontak UMKM */
    .kontak-text {
        color: #64748b;
        font-size: 0.8rem;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    /* Ikon kontak di samping teks */
    .kontak-text i {
        color: #94a3b8;
        font-size: 0.75rem;
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

    /* Wrapper pagination di bawah tabel */
    .pagination-wrapper {
        margin-top: 20px;
        display: flex;
        justify-content: flex-end;
    }

</style>

{{-- Bagian judul halaman dan tombol tambah --}}
<div class="page-heading">
    <div>
        <h1>Manajemen UMKM</h1>
        <p>Kelola semua data UMKM GeoToba Baktiraja</p>
    </div>
    {{-- Tombol navigasi ke halaman tambah UMKM --}}
    <a href="{{ route('admin.umkm.create') }}" class="btn-tambah">
        <i class="fas fa-plus"></i> Tambah UMKM
    </a>
</div>

{{-- Card pembungkus tabel --}}
<div class="umkm-card">
    <div class="umkm-card-body">

        {{-- Notifikasi sukses setelah operasi berhasil --}}
        @if(session('success'))
            <div class="alert-sukses">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        {{-- Wrapper scroll horizontal untuk responsivitas tabel --}}
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
                    {{-- Iterasi setiap item UMKM, tampilkan pesan kosong bila tidak ada data --}}
                    @forelse($data as $item)
                    <tr>
                        {{-- Nomor urut baris --}}
                        <td><span class="row-number">{{ $loop->iteration }}</span></td>

                        {{-- Kolom thumbnail gambar UMKM --}}
                        <td>
                            @php $imgs = json_decode($item->gambar, true); $firstImg = is_array($imgs) ? ($imgs[0] ?? null) : $item->gambar; @endphp
                            @if($firstImg && str_starts_with($firstImg, 'data:'))
                                <img src="{{ $firstImg }}" class="umkm-thumb" alt="Gambar">
                            @else
                                <div class="umkm-thumb-empty"><i class="fas fa-store"></i></div>
                            @endif
                        </td>

                        {{-- Kolom nama UMKM --}}
                        <td><span class="nama-text">{{ $item->nama }}</span></td>

                        {{-- Kolom lokasi UMKM --}}
                        <td>
                            <span class="lokasi-text">
                                <i class="fas fa-map-marker-alt"></i>
                                {{ $item->lokasi ?? '-' }}
                            </span>
                        </td>

                        {{-- Kolom kontak UMKM --}}
                        <td>
                            <span class="kontak-text">
                                <i class="fas fa-phone"></i>
                                {{ $item->kontak ?? '-' }}
                            </span>
                        </td>

                        {{-- Kolom tombol aksi edit dan hapus --}}
                        <td>
                            <div class="action-buttons">
                                {{-- Tombol menuju halaman edit UMKM --}}
                                <a href="{{ route('admin.umkm.edit', $item->id) }}" class="btn-edit">
                                    <i class="fas fa-edit"></i> Edit
                                </a>

                                {{-- Form hapus UMKM dengan konfirmasi nama sebelum submit --}}
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

                    {{-- Baris pengganti saat data UMKM kosong --}}
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

        {{-- Pagination Laravel di bawah tabel --}}
        <div class="pagination-wrapper">
            {{ $data->links() }}
        </div>

    </div>
</div>

@endsection