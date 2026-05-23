@extends('layouts.admin')

@section('title', 'Data Galeri')

@section('content')
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
                <th>No</th>
                <th>Gambar</th>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Aksi</th>
            </tr>

            @foreach($galeris as $i => $g)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>
                    <img src="{{ $g->gambar }}"
                         width="60">
                </td>
                <td>{{ $g->judul }}</td>
                <td>{{ $g->kategori }}</td>
                <td>
                    <a href="{{ route('admin.galeri.edit', $g->id) }}" class="btn btn-warning btn-sm">Edit</a>

                    <form action="{{ route('admin.galeri.destroy', $g->id) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Hapus?')" class="btn btn-danger btn-sm">
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
</div>
@endsection 