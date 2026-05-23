@extends('layouts.admin')

@section('title', 'Tambah UMKM')

@section('content')
<div class="card">
    <div class="card-header">
        <h5>Tambah UMKM</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.umkm.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label>Nama UMKM</label>
                <input type="text" name="nama" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="4" required></textarea>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Lokasi</label>
                    <input type="text" name="lokasi" class="form-control">
                </div>
                <div class="col-md-6 mb-3">
                    <label>Kontak</label>
                    <input type="text" name="kontak" class="form-control">
                </div>
            </div>
            <div class="mb-3">
                <label>Urutan</label>
                <input type="number" name="urutan" class="form-control" required>
                <small class="text-muted">Semakin kecil angka, semakin atas tampilannya</small>
            </div>
            <div class="mb-3">
                <label>Gambar</label>
                <input type="file" name="gambar" class="form-control" accept="image/*" id="inputGambar">
                <div class="mt-2" id="previewContainer" style="display: none;">
                    <img id="previewImage" style="max-width: 150px; border-radius: 8px;">
                    <small class="text-muted">Preview gambar yang akan diupload</small>
                </div>
            </div>
            <div class="mb-3">
                <input type="checkbox" name="status" value="1" checked> Aktifkan
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
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
        } else {
            preview.style.display = 'none';
        }
    });
</script>
@endsection