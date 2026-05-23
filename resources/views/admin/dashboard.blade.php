@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
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

<!-- UMKM -->
<div class="card-table">
    <div class="card-header">
        <h5><i class="fas fa-store"></i> UMKM Terbaru</h5>
        <a href="{{ route('admin.umkm.create') }}" class="btn-primary">+ Tambah UMKM</a>
    </div>
    <div style="overflow-x: auto;">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Lokasi</th>
                    <th>Kontak</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php $umkmList = App\Models\Umkm::latest()->limit(5)->get(); @endphp
                @forelse($umkmList as $key => $item)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->lokasi ?? '-' }}</td>
                    <td>{{ $item->kontak ?? '-' }}</td>
                    <td><span class="badge {{ $item->status ? 'badge-success' : 'badge-danger' }}">{{ $item->status ? 'Aktif' : 'Tidak' }}</span></td>
                    <td>
                        <div class="btn-group">
                            <a href="{{ route('admin.umkm.edit', $item->id) }}" class="btn-edit">Edit</a>
                            <form action="{{ route('admin.umkm.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus UMKM {{ $item->nama }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="empty-state">📭 Belum ada data UMKM</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- FASILITAS -->
<div class="card-table">
    <div class="card-header">
        <h5><i class="fas fa-tools"></i> Fasilitas Terbaru</h5>
        <a href="{{ route('admin.fasilitas.create') }}" class="btn-primary">+ Tambah Fasilitas</a>
    </div>
    <div style="overflow-x: auto;">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Harga</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php $fasilitasList = App\Models\Fasilitas::latest()->limit(5)->get(); @endphp
                @forelse($fasilitasList as $key => $item)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->harga ?? 'Gratis' }}</td>
                    <td><span class="badge {{ $item->status ? 'badge-success' : 'badge-danger' }}">{{ $item->status ? 'Aktif' : 'Tidak' }}</span></td>
                    <td>
                        <div class="btn-group">
                            <a href="{{ route('admin.fasilitas.edit', $item->id) }}" class="btn-edit">Edit</a>
                            <form action="{{ route('admin.fasilitas.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus fasilitas {{ $item->nama }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <td><td colspan="5" class="empty-state">📭 Belum ada data Fasilitas</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- PENGINAPAN -->
<div class="card-table">
    <div class="card-header">
        <h5><i class="fas fa-hotel"></i> Penginapan Terbaru</h5>
        <a href="{{ route('admin.penginapan.create') }}" class="btn-primary">+ Tambah Penginapan</a>
    </div>
    <div style="overflow-x: auto;">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Harga</th>
                    <th>Kontak</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php $penginapanList = App\Models\Penginapan::latest()->limit(5)->get(); @endphp
                @forelse($penginapanList as $key => $item)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $item->nama }}</td>
                    <td>{{ $item->harga ?? '-' }}</td>
                    <td>{{ $item->kontak ?? '-' }}</td>
                    <td><span class="badge {{ $item->status ? 'badge-success' : 'badge-danger' }}">{{ $item->status ? 'Aktif' : 'Tidak' }}</span></td>
                    <td>
                        <div class="btn-group">
                            <a href="{{ route('admin.penginapan.edit', $item->id) }}" class="btn-edit">Edit</a>
                            <form action="{{ route('admin.penginapan.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus penginapan {{ $item->nama }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="empty-state">📭 Belum ada data Penginapan</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- QUICK ACTIONS -->
<div style="display: flex; flex-wrap: wrap; gap: 12px; margin-top: 16px;">
    <a href="{{ route('admin.galeri.create') }}" class="btn-primary"><i class="fas fa-plus-circle"></i> Galeri</a>
    <a href="{{ route('admin.berita.create') }}" class="btn-primary"><i class="fas fa-plus-circle"></i> Berita</a>
    <a href="{{ route('admin.informasi.create') }}" class="btn-primary"><i class="fas fa-plus-circle"></i> Informasi</a>
    <a href="{{ route('admin.umkm.create') }}" class="btn-primary"><i class="fas fa-plus-circle"></i> UMKM</a>
    <a href="{{ route('admin.fasilitas.create') }}" class="btn-primary"><i class="fas fa-plus-circle"></i> Fasilitas</a>
    <a href="{{ route('admin.penginapan.create') }}" class="btn-primary"><i class="fas fa-plus-circle"></i> Penginapan</a>
</div>
@endsection 