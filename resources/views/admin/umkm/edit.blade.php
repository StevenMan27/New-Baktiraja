@extends('layouts.admin')

@section('title', 'Edit UMKM')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Edit UMKM</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.umkm.update', $data->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="mb-3">
                <label class="form-label">Nama UMKM</label>
                <input type="text" name="nama" class="form-control" value="{{ $data->nama }}" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="4" required>{{ $data->deskripsi }}</textarea>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Lokasi</label>
                    <input type="text" name="lokasi" class="form-control" value="{{ $data->lokasi }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Kontak</label>
                    <input type="text" name="kontak" class="form-control" value="{{ $data->kontak }}">
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Urutan</label>
                <input type="number" name="urutan" class="form-control" value="{{ $data->urutan }}" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Gambar Saat Ini</label><br>
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
            <a href="{{ route('admin.umkm.index') }}" class="btn btn-secondary">Batal</a>
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