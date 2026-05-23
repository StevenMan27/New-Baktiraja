@extends('layouts.admin')

@section('title', 'Edit Fasilitas')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Edit Fasilitas</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.fasilitas.update', $data->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label>Nama Fasilitas</label>
                <input type="text" name="nama" class="form-control" value="{{ $data->nama }}" required>
            </div>
            
            <div class="mb-3">
                <label>Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="4" required>{{ $data->deskripsi }}</textarea>
            </div>
            
            <div class="mb-3">
                <label>Harga</label>
                <input type="text" name="harga" class="form-control" value="{{ $data->harga }}">
            </div>
            
            <div class="mb-3">
                <label>Urutan</label>
                <input type="number" name="urutan" class="form-control" value="{{ $data->urutan }}" required>
            </div>
            
            <div class="mb-3">
                <label>Gambar Saat Ini</label><br>
                @if($data->gambar)
                    <img src="{{ $data->gambar }}" width="100" class="mb-2">
                @else
                    <span class="text-muted">Tidak ada gambar</span>
                @endif
                <input type="file" name="gambar" class="form-control mt-2" accept="image/*" id="inputGambar">
                <div class="mt-2" id="previewContainer" style="display: none;">
                    <img id="previewImage" style="max-width: 150px; border-radius: 8px;">
                </div>
            </div>
            
            <div class="mb-3">
                <input type="checkbox" name="status" value="1" {{ $data->status ? 'checked' : '' }}> Aktifkan
            </div>
            
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="{{ route('admin.fasilitas.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>

<script>
    document.getElementById('inputGambar')?.addEventListener('change', function(e) {
        const file = e.target.files[0];
        const preview = document.getElementById('previewContainer');
        const previewImg = document.getElementById('previewImage');
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewImg.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection