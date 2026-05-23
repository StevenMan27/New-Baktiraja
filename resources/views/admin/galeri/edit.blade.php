@extends('layouts.admin')

@section('title', 'Edit Galeri')

@section('content')
<style>
    .preview-image { max-width: 200px; border-radius: 8px; }
    .current-image { border: 2px solid #c6a43b; padding: 5px; display: inline-block; }
</style>

<div class="card">
    <div class="card-header">
        <h5><i class="fas fa-edit me-2"></i> Edit Galeri</h5>
    </div>

    <div class="card-body">
        <form action="{{ route('admin.galeri.update', $galeri->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Judul</label>
                    <input type="text" name="judul" class="form-control"
                        value="{{ old('judul', $galeri->judul) }}" required>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Geosite</label>
                    <select name="geosite" class="form-control" required>
                        <option value="">-- Pilih Geosite --</option>
                        @foreach($geositeList as $slug => $label)
                            <option value="{{ $slug }}" {{ (old('geosite', $galeri->geosite) == $slug) ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>



                <div class="col-md-12 mb-3">
                    <label>Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" required>{{ $galeri->deskripsi }}</textarea>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Gambar Sekarang</label><br>
                    <div class="current-image">
                        <img src="{{ $galeri->gambar }}" class="preview-image">
                    </div>

                    <input type="file" name="gambar" class="form-control mt-2" id="inputGambar">
                    <img id="previewImage" class="preview-image mt-2" style="display:none;">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Lokasi</label>
                    <input type="text" name="lokasi" class="form-control"
                        value="{{ $galeri->lokasi }}">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Tanggal</label>
                    <input type="date" name="tanggal_foto" class="form-control"
                        value="{{ $galeri->tanggal_foto }}">
                </div>

                <div class="col-md-6 mb-3">
                    <input type="checkbox" name="status" value="1"
                        {{ $galeri->status ? 'checked' : '' }}> Aktif
                </div>
            </div>

            <button class="btn btn-warning">Update</button>
            <a href="{{ route('admin.galeri.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>

<script>
document.getElementById('inputGambar').addEventListener('change', function(e){
    const reader = new FileReader();
    reader.onload = function(event){
        const img = document.getElementById('previewImage');
        img.src = event.target.result;
        img.style.display = 'block';
    }
    reader.readAsDataURL(e.target.files[0]);
});
</script>
@endsection