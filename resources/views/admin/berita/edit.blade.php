@extends('layouts.admin')

@section('title', 'Edit Berita')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Edit Berita</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.berita.update', $berita->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label>Judul</label>
                <input type="text" name="judul" class="form-control" value="{{ $berita->judul }}" required>
            </div>
            
            <div class="mb-3">
                <label>Penulis</label>
                <input type="text" name="penulis" class="form-control" value="{{ $berita->penulis }}">
            </div>
            
            <div class="mb-3">
                <label>Konten</label>
                <textarea name="konten" class="form-control" rows="10" required>{{ $berita->konten }}</textarea>
            </div>
            
            <div class="mb-3">
                <label>Gambar Saat Ini</label><br>
                @if($berita->gambar)
                    <img src="{{ $berita->gambar }}" width="100">
                @else
                    <span class="text-muted">Tidak ada gambar</span>
                @endif
                <input type="file" name="gambar" class="form-control mt-2" accept="image/*">
            </div>
            
            <div class="mb-3">
                <input type="checkbox" name="status" value="1" {{ $berita->status ? 'checked' : '' }}> Aktifkan
            </div>
            
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.berita.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection