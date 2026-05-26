@extends('layouts.admin')

@section('title', 'Edit Profil Geosite')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0">⚙️ Edit Profil: {{ $nama_geosite }}</h5>
    <a href="{{ route('admin.profil.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.profil.update', $profil->geosite) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Judul Utama (Hero)</label>
                    <input type="text" name="judul_utama" class="form-control" value="{{ old('judul_utama', $profil->judul_utama) }}" placeholder="Contoh: PANATAPAN BAKARA">
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Sub Judul (Hero)</label>
                    <input type="text" name="sub_judul" class="form-control" value="{{ old('sub_judul', $profil->sub_judul) }}" placeholder="Contoh: Desa Bakara · Kec. Baktiraja">
                </div>
                
                <div class="col-md-12 mb-3">
                    <label class="form-label fw-bold">Gambar Latar Belakang (Hero)</label>
                    <input type="file" name="bg_hero" class="form-control" accept="image/*">
                    <small class="text-muted">Biarkan kosong jika tidak ingin mengubah. Disarankan rasio 16:9 atau lebar (resolusi tinggi).</small>
                    @if($profil->bg_hero && is_array($profil->bg_hero) && count($profil->bg_hero) > 0)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $profil->bg_hero[0]) }}" width="200" class="rounded border">
                        </div>
                    @endif
                </div>

                <hr class="my-4">
                <h5 class="mb-3">Bagian Deskripsi 1 (Tanpa Gambar)</h5>

                <div class="col-md-12 mb-3">
                    <label class="form-label fw-bold">Judul Deskripsi 1</label>
                    <input type="text" name="deskripsi_1_judul" class="form-control" value="{{ old('deskripsi_1_judul', $profil->deskripsi_1_judul) }}" placeholder="Contoh: Panorama Spektakuler Danau Toba">
                </div>

                <div class="col-md-12 mb-3">
                    <label class="form-label fw-bold">Teks Deskripsi 1</label>
                    <textarea name="deskripsi_1_teks" class="form-control" rows="4">{{ old('deskripsi_1_teks', $profil->deskripsi_1_teks) }}</textarea>
                </div>

                <hr class="my-4">
                <h5 class="mb-3">Bagian Deskripsi 2 (Dengan Gambar)</h5>

                <div class="col-md-12 mb-3">
                    <label class="form-label fw-bold">Judul Deskripsi 2</label>
                    <input type="text" name="deskripsi_2_judul" class="form-control" value="{{ old('deskripsi_2_judul', $profil->deskripsi_2_judul) }}" placeholder="Contoh: Spot Fotografi Lanskap Kelas Dunia">
                </div>

                <div class="col-md-12 mb-3">
                    <label class="form-label fw-bold">Teks Deskripsi 2</label>
                    <textarea name="deskripsi_2_teks" class="form-control" rows="4">{{ old('deskripsi_2_teks', $profil->deskripsi_2_teks) }}</textarea>
                </div>

                <div class="col-md-12 mb-3">
                    <label class="form-label fw-bold">Gambar Deskripsi 2</label>
                    <input type="file" name="deskripsi_2_gambar[]" class="form-control" accept="image/*" multiple>
                    <small class="text-muted">Bisa upload lebih dari satu gambar. Biarkan kosong jika tidak ingin mengubah.</small>
                    @if($profil->deskripsi_2_gambar && is_array($profil->deskripsi_2_gambar))
                        <div class="mt-2 d-flex gap-2 flex-wrap">
                            @foreach($profil->deskripsi_2_gambar as $img)
                                <img src="{{ asset('storage/' . $img) }}" width="150" height="100" class="rounded border" style="object-fit:cover;">
                            @endforeach
                        </div>
                    @endif
                </div>

                <hr class="my-4">
                <h5 class="mb-3">Informasi Praktis</h5>

                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Lokasi</label>
                    <input type="text" name="info_lokasi" class="form-control" value="{{ old('info_lokasi', $profil->info_lokasi) }}" placeholder="Contoh: Desa Bakara, Kec. Baktiraja">
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Jam Operasional</label>
                    <input type="text" name="info_jam" class="form-control" value="{{ old('info_jam', $profil->info_jam) }}" placeholder="Contoh: 06:00 - 18:00 WIB">
                </div>

                <div class="col-md-4 mb-3">
                    <label class="form-label fw-bold">Harga Tiket</label>
                    <input type="text" name="info_harga" class="form-control" value="{{ old('info_harga', $profil->info_harga) }}" placeholder="Contoh: Rp 5.000 - Rp 10.000">
                </div>

                <div class="col-md-12 mb-4">
                    <label class="form-label fw-bold">Tags</label>
                    <input type="text" name="tags" class="form-control" value="{{ is_array($profil->tags) ? implode(', ', $profil->tags) : old('tags') }}" placeholder="Contoh: Panorama Danau, Sunrise, Sunset, Spot Foto (pisahkan dengan koma)">
                    <small class="text-muted">Pisahkan setiap tag menggunakan tanda koma (,)</small>
                </div>
            </div>

            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Profil</button>
        </form>
    </div>
</div>
@endsection
