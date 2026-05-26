@extends('layouts.admin')

@section('title', 'Edit Profil Geosite')

@section('content')

<style>
    .custom-file-upload { border: 2px dashed #003366; border-radius: 12px; padding: 30px; text-align: center; background-color: #f8f9fa; position: relative; cursor: pointer; transition: all 0.3s ease; }
    .custom-file-upload:hover { background-color: #e9ecef; border-color: #c6a43b; }
    .custom-file-upload input[type="file"] { position: absolute; top: 0; left: 0; width: 100%; height: 100%; opacity: 0; cursor: pointer; z-index: 2; }
    .custom-file-upload .icon { font-size: 3rem; color: #003366; margin-bottom: 15px; }
    .custom-file-upload p { margin: 0; font-size: 1.1rem; font-weight: 600; color: #495057; }
    .custom-file-upload small { color: #6c757d; }
    .preview-grid { display: flex; flex-wrap: wrap; gap: 15px; margin-top: 20px; justify-content: center; position: relative; z-index: 3; pointer-events: none; }
    .preview-grid > * { pointer-events: auto; }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0 text-dark fw-bold">⚙️ Edit Profil: <span class="text-primary">{{ $nama_geosite }}</span></h5>
    <a href="{{ route('admin.profil.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<form action="{{ route('admin.profil.update', $profil->geosite) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <!-- HERO SECTION -->
    <div class="card mb-4 shadow-sm border-0 rounded-3">
        <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
            <h5 class="mb-0 text-primary fw-bold"><i class="fas fa-home me-2"></i> Bagian Utama (Hero)</h5>
        </div>
        <div class="card-body px-4 pt-3 pb-4">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold text-secondary">Judul Utama</label>
                    <input type="text" name="judul_utama" class="form-control form-control-lg" value="{{ old('judul_utama', $profil->judul_utama) }}" placeholder="Contoh: PANATAPAN BAKARA">
                </div>
                
                <div class="col-md-6">
                    <label class="form-label fw-bold text-secondary">Sub Judul</label>
                    <input type="text" name="sub_judul" class="form-control form-control-lg" value="{{ old('sub_judul', $profil->sub_judul) }}" placeholder="Contoh: Desa Bakara · Kec. Baktiraja">
                </div>
                
                <div class="col-md-12 mt-4">
                    <label class="form-label fw-bold text-secondary">Gambar Latar Belakang (Hero)</label>
                    <div class="custom-file-upload mt-2">
    <i class="fas fa-cloud-upload-alt icon"></i>
    <p>Klik atau Seret Gambar ke Sini</p>
    <small class="d-block mt-2">Format: JPG, PNG, WEBP | Disarankan rasio 16:9 atau lebar</small>
    <input type="file" name="bg_hero" class="form-control image-input" accept="image/*" data-preview-container="preview-hero">
    <div id="preview-hero" class="preview-grid"></div>
</div>

                    @if($profil->bg_hero && is_array($profil->bg_hero) && count($profil->bg_hero) > 0)
                        <div class="mt-3 bg-light p-3 rounded border">
                            <p class="text-muted mb-2 fw-semibold"><small>Gambar Saat Ini:</small></p>
                            <img src="{{ asset('storage/' . $profil->bg_hero[0]) }}" width="250" class="rounded shadow-sm border" style="object-fit:cover;">
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- DESKRIPSI 1 -->
    <div class="card mb-4 shadow-sm border-0 rounded-3">
        <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
            <h5 class="mb-0 text-primary fw-bold"><i class="fas fa-align-left me-2"></i> Bagian Deskripsi 1 (Tanpa Gambar)</h5>
        </div>
        <div class="card-body px-4 pt-3 pb-4">
            <div class="row g-3">
                <div class="col-md-12">
                    <label class="form-label fw-bold text-secondary">Judul Deskripsi 1</label>
                    <input type="text" name="deskripsi_1_judul" class="form-control" value="{{ old('deskripsi_1_judul', $profil->deskripsi_1_judul) }}" placeholder="Contoh: Panorama Spektakuler Danau Toba">
                </div>

                <div class="col-md-12">
                    <label class="form-label fw-bold text-secondary">Teks Deskripsi 1</label>
                    <textarea name="deskripsi_1_teks" class="form-control" rows="5" placeholder="Tuliskan teks deskripsi utama di sini...">{{ old('deskripsi_1_teks', $profil->deskripsi_1_teks) }}</textarea>
                </div>
            </div>
        </div>
    </div>

    <!-- DESKRIPSI 2-5 (LOOP) -->
    @for($i = 2; $i <= 5; $i++)
    @php
        $judulKey = "deskripsi_{$i}_judul";
        $teksKey = "deskripsi_{$i}_teks";
        $gambarKey = "deskripsi_{$i}_gambar";
    @endphp
    <div class="card mb-4 shadow-sm border-0 rounded-3">
        <div class="card-header bg-white border-bottom-0 pt-4 pb-0 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 text-primary fw-bold"><i class="fas fa-images me-2"></i> Bagian Deskripsi {{ $i }} (Dengan Gambar)</h5>
            <span class="badge bg-light text-secondary border">Opsional</span>
        </div>
        <div class="card-body px-4 pt-3 pb-4">
            <div class="row g-3">
                <div class="col-md-12">
                    <label class="form-label fw-bold text-secondary">Judul Deskripsi {{ $i }}</label>
                    <input type="text" name="{{ $judulKey }}" class="form-control" value="{{ old($judulKey, $profil->$judulKey) }}" placeholder="Judul untuk bagian ini">
                </div>

                <div class="col-md-12">
                    <label class="form-label fw-bold text-secondary">Teks Deskripsi {{ $i }}</label>
                    <textarea name="{{ $teksKey }}" class="form-control" rows="4" placeholder="Tuliskan penjelasan untuk bagian ini...">{{ old($teksKey, $profil->$teksKey) }}</textarea>
                </div>

                <div class="col-md-12 mt-4">
                    <label class="form-label fw-bold text-secondary">Gambar Deskripsi {{ $i }}</label>
                    <div class="custom-file-upload mt-2">
    <i class="fas fa-cloud-upload-alt icon"></i>
    <p>Klik atau Seret Gambar ke Sini</p>
    <small class="d-block mt-2">Format: JPG, PNG, WEBP | Max: 4MB per gambar</small>
    <input type="file" name="{{ $gambarKey }}[]" class="form-control image-input" accept="image/*" multiple data-preview-container="preview-deskripsi-{{ $i }}">
    <div id="preview-deskripsi-{{ $i }}" class="preview-grid"></div>
</div>

                    @if($profil->$gambarKey && is_array($profil->$gambarKey))
                        <div class="mt-3 bg-light p-3 rounded border">
                            <p class="text-muted mb-2 fw-semibold"><small>Gambar Saat Ini:</small></p>
                            <div class="d-flex gap-3 flex-wrap">
                                @foreach($profil->$gambarKey as $img)
                                    <div class="position-relative">
                                        <img src="{{ asset('storage/' . $img) }}" width="160" height="110" class="rounded shadow-sm border" style="object-fit:cover;">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endfor

    <!-- INFORMASI PRAKTIS -->
    <div class="card mb-5 shadow-sm border-0 rounded-3">
        <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
            <h5 class="mb-0 text-primary fw-bold"><i class="fas fa-info-circle me-2"></i> Informasi Praktis & Tags</h5>
        </div>
        <div class="card-body px-4 pt-3 pb-4">
            <div class="row g-4">
                <div class="col-md-4">
                    <label class="form-label fw-bold text-secondary">Lokasi</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="fas fa-map-marker-alt text-secondary"></i></span>
                        <input type="text" name="info_lokasi" class="form-control" value="{{ old('info_lokasi', $profil->info_lokasi) }}" placeholder="Desa Bakara...">
                    </div>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-bold text-secondary">Jam Operasional</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="fas fa-clock text-secondary"></i></span>
                        <input type="text" name="info_jam" class="form-control" value="{{ old('info_jam', $profil->info_jam) }}" placeholder="06:00 - 18:00 WIB">
                    </div>
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-bold text-secondary">Harga Tiket</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="fas fa-ticket-alt text-secondary"></i></span>
                        <input type="text" name="info_harga" class="form-control" value="{{ old('info_harga', $profil->info_harga) }}" placeholder="Rp 5.000">
                    </div>
                </div>

                <div class="col-md-12 mt-4">
                    <label class="form-label fw-bold text-secondary">Tags Pencarian</label>
                    <input type="text" name="tags" class="form-control form-control-lg" value="{{ is_array($profil->tags) ? implode(', ', $profil->tags) : old('tags') }}" placeholder="Panorama Danau, Sunrise, Sunset...">
                    <small class="text-muted d-block mt-1"><i class="fas fa-info-circle"></i> Pisahkan setiap kata kunci menggunakan tanda koma (,)</small>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end mb-5">
        <a href="{{ route('admin.profil.index') }}" class="btn btn-light border px-4 py-2 me-2">Batal</a>
        <button type="submit" class="btn btn-primary px-5 py-2 fw-bold shadow-sm"><i class="fas fa-save me-2"></i> Simpan Semua Perubahan</button>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const imageInputs = document.querySelectorAll('.image-input');
    
    imageInputs.forEach(input => {
        input.addEventListener('change', function(event) {
            const containerId = this.getAttribute('data-preview-container');
            const previewContainer = document.getElementById(containerId);
            
            // Bersihkan preview sebelumnya
            previewContainer.innerHTML = '';
            
            if (this.files && this.files.length > 0) {
                // Tambahkan label "Preview Baru"
                const previewLabel = document.createElement('p');
                previewLabel.className = 'text-primary mb-2 w-100 fw-semibold';
                previewLabel.innerHTML = '<small><i class="fas fa-eye me-1"></i> Pratinjau Gambar Baru:</small>';
                previewContainer.appendChild(previewLabel);

                Array.from(this.files).forEach(file => {
                    if (file.type.startsWith('image/')) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const imgWrap = document.createElement('div');
                            imgWrap.className = 'position-relative';
                            
                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.className = 'rounded shadow-sm border border-primary';
                            img.style.width = '160px';
                            img.style.height = '110px';
                            img.style.objectFit = 'cover';
                            
                            imgWrap.appendChild(img);
                            previewContainer.appendChild(imgWrap);
                        }
                        reader.readAsDataURL(file);
                    }
                });
            }
        });
    });
});
</script>
@endsection
