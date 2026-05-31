@extends('layouts.admin')

@section('title', 'Manajemen Berita')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0">📰 Daftar Berita</h5>
    <a href="{{ route('admin.berita.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Berita
    </a>
</div>

<div class="card">
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Gambar</th>
                    <th>Judul</th>
                    <th width="120">Lokasi Geosite</th>
                    <th>Penulis</th>
                                        <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($berita as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        @php $imgs = json_decode($item->gambar, true); $firstImg = is_array($imgs) ? ($imgs[0] ?? null) : $item->gambar; @endphp
                        @if($firstImg)
                            <img src="{{ str_starts_with($firstImg, 'data:') ? $firstImg : asset('storage/' . $firstImg) }}" width="50" height="50" style="object-fit: cover;">
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td>{{ $item->judul }}</td>
                                        <td>{{ $item->penulis ?? '-' }}</td>
                                        <td>
                        <div class="action-buttons">
                            <a href="{{ route('admin.berita.edit', $item->id) }}" class="btn-edit"><i class="fas fa-edit"></i> Edit</a>
                            <form action="{{ route('admin.berita.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete"><i class="fas fa-trash-alt"></i> Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center">Belum ada berita</td></tr>
                @endforelse
            </tbody>
        </table>
        {{ $berita->links() }}
    </div>
</div>
@endsection


