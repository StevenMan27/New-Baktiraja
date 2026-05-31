@extends('layouts.admin')

@section('title', 'Data Galeri')

@section('content')
<style>
    .card-header .btn-primary { background-color: #0b5ed7 !important; border-color: #0a58ca !important; }
    .card-header .btn-primary:hover { background-color: #094eb3 !important; border-color: #084298 !important; }
</style>
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h5>Data Galeri</h5>
        <a href="{{ route('admin.galeri.create') }}" class="btn btn-primary">Tambah</a>
    </div>

    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <tr>
                <th width="50">No</th>
                <th width="80">Gambar</th>
                <th>Judul</th>
                
                <th>Aksi</th>
            </tr>

            @foreach($galeris as $i => $g)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>
                    @php $imgs = json_decode($g->gambar, true); $firstImg = is_array($imgs) ? ($imgs[0] ?? null) : $g->gambar; @endphp
                    <img src="{{ $firstImg && str_starts_with($firstImg, 'data:') ? $firstImg : ($firstImg ? asset('storage/' . $firstImg) : '') }}"
                         width="60">
                </td>
                <td>{{ $g->judul }}</td>
                <td>{{ $g->kategori }}</td>
                <td>
                    <div class="action-buttons">
                        <a href="{{ route('admin.galeri.edit', $g->id) }}" class="btn-edit"><i class="fas fa-edit"></i> Edit</a>
                        <form action="{{ route('admin.galeri.destroy', $g->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete"><i class="fas fa-trash-alt"></i> Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
</div>
@endsection 



