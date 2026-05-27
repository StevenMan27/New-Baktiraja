@extends('layouts.admin')

@section('title', 'Konfigurasi Homepage')

@section('content')

<style>
    /* Menggunakan dropzone kustom yang sudah standar di admin */
    .custom-file-upload {
        border: 2px dashed #003366;
        border-radius: 12px;
        padding: 30px;
        text-align: center;
        background-color: #f8f9fa;
        position: relative;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .custom-file-upload:hover {
        background-color: #e9ecef;
        border-color: #c6a43b;
    }
    .custom-file-upload input[type="file"] {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
        z-index: 2;
    }
    .custom-file-upload .icon {
        font-size: 3rem;
        color: #003366;
        margin-bottom: 15px;
    }
    .custom-file-upload p {
        margin: 0;
        font-size: 1.1rem;
        font-weight: 600;
        color: #495057;
    }
    .custom-file-upload small {
        color: #6c757d;
    }
    .preview-grid { display: flex; flex-wrap: wrap; gap: 15px; margin-top: 20px; justify-content: center; position: relative; z-index: 3; pointer-events: none; }
    .preview-item { pointer-events: auto; }
    .preview-item img, .preview-item video { width: 150px; height: 150px; object-fit: cover; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); border: 2px solid #fff; }
    
    .current-images { display: flex; flex-wrap: wrap; gap: 15px; margin-top: 10px; margin-bottom: 20px; }
    .current-images img, .current-images video { width: 150px; height: 150px; object-fit: cover; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); border: 2px solid #bbb; }
</style>

<div class="card mb-4">
    <div class="card-header bg-white pt-4 pb-3">
        <h5 class="mb-0 text-primary fw-bold"><i class="fas fa-home me-2"></i> Konfigurasi Halaman Utama (Homepage)</h5>
    </div>

    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('admin.homepage.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Hero Section -->
            <h6 class="fw-bold mt-2 text-secondary border-bottom pb-2">Bagian Hero (Banner Atas)</h6>
            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <label>Judul Utama (HTML diizinkan, cth: &lt;br&gt;)</label>
                    <input type="text" name="hero_title" class="form-control" value="{{ old('hero_title', $homepage->hero_title ?? 'BAKARA · TIPANG<br>BAKTIRAJA') }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label>Sub-Judul</label>
                    <input type="text" name="hero_subtitle" class="form-control" value="{{ old('hero_subtitle', $homepage->hero_subtitle ?? 'Kawasan Wisata Geopark Danau Toba') }}">
                </div>

                <div class="col-md-12 mb-3">
                    <label>Gambar Slide Hero (Gabungan, Maksimal 6 Gambar Sekaligus)</label>
                    <div class="current-images">
                        @for($i = 1; $i <= 6; $i++)
                            @php $slideField = 'hero_slide_'.$i; @endphp
                            @if($homepage->$slideField)
                                <img src="{{ asset('storage/' . $homepage->$slideField) }}" alt="Slide {{ $i }}" style="width: 150px; height: 100px;">
                            @endif
                        @endfor
                    </div>
                    <div class="custom-file-upload mt-2">
                        <i class="fas fa-images icon"></i>
                        <p>Klik di sini untuk mengunggah hingga 6 Gambar sekaligus</p>
                        <small class="d-block mt-2 text-danger">*Catatan: Mengunggah gambar baru akan menggantikan/menimpa kumpulan gambar slide yang lama secara keseluruhan.</small>
                        <input type="file" name="hero_slides[]" class="form-control image-input" accept="image/*" multiple data-preview-container="preview-hero-slides">
                        <div id="preview-hero-slides" class="preview-grid"></div>
                    </div>
                </div>
            </div>

            <!-- Stats Section -->
            <h6 class="fw-bold mt-4 text-secondary border-bottom pb-2">Bagian Statistik</h6>
            <div class="row mb-4">
                @for($i = 1; $i <= 4; $i++)
                    @php 
                        $numField = 'stat_'.$i.'_num'; 
                        $labelField = 'stat_'.$i.'_label';
                        $defaultNum = ['8', '3', '74.000', '15+'][$i-1];
                        $defaultLabel = ['DESTINASI', 'KATEGORI', 'TAHUN SEJARAH', 'WARISAN BUDAYA'][$i-1];
                    @endphp
                    <div class="col-md-3 mb-3">
                        <label>Angka Stat {{ $i }}</label>
                        <input type="text" name="{{ $numField }}" class="form-control mb-2" value="{{ old($numField, $homepage->$numField ?? $defaultNum) }}">
                        <label>Label Stat {{ $i }}</label>
                        <input type="text" name="{{ $labelField }}" class="form-control" value="{{ old($labelField, $homepage->$labelField ?? $defaultLabel) }}">
                    </div>
                @endfor
            </div>

            <!-- About Section -->
            <h6 class="fw-bold mt-4 text-secondary border-bottom pb-2">Bagian Tentang (About)</h6>
            <div class="row mb-4">
                <div class="col-md-12 mb-3">
                    <label>Judul About</label>
                    <input type="text" name="about_title" class="form-control" value="{{ old('about_title', $homepage->about_title ?? 'Bakara · Tipang · Baktiraja') }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label>Paragraf 1</label>
                    <textarea name="about_text_1" class="form-control" rows="4">{{ old('about_text_1', $homepage->about_text_1 ?? 'Kawasan wisata di Kabupaten Humbang Hasundutan, Sumatera Utara, yang menyimpan kekayaan alam, sejarah, dan budaya Batak yang luar biasa. Terdiri dari 8 destinasi unggulan yang tersebar di tiga desa: Bakara, Tipang, dan Baktiraja.') }}</textarea>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Paragraf 2</label>
                    <textarea name="about_text_2" class="form-control" rows="4">{{ old('about_text_2', $homepage->about_text_2 ?? 'Dari panorama Danau Toba di Panatapan Bakara, jejak perjuangan Raja Sisingamangaraja di Istana Sisingamangaraja, hingga khasiat penyembuhan Aek Sipangolu, setiap sudut kawasan ini menyimpan cerita dan keindahan yang tak terlupakan.') }}</textarea>
                </div>
                <div class="col-md-12 mb-3">
                    <label>Video About (MP4)</label>
                    @if($homepage->about_video)
                        <div class="current-images">
                            <video src="{{ asset('storage/' . $homepage->about_video) }}" controls></video>
                        </div>
                    @endif
                    <div class="custom-file-upload mt-2">
                        <i class="fas fa-video icon"></i>
                        <p>Upload Video Baru (Biarkan kosong jika tidak diganti)</p>
                        <input type="file" name="about_video" class="form-control" accept="video/mp4,video/webm">
                    </div>
                </div>
            </div>

            <!-- Judul Seksi -->
            <h6 class="fw-bold mt-4 text-secondary border-bottom pb-2">Judul-Judul Bagian</h6>
            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <label>Judul Destinasi</label>
                    <input type="text" name="destinasi_title" class="form-control" value="{{ old('destinasi_title', $homepage->destinasi_title ?? 'Destinasi Unggulan') }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label>Sub-judul Destinasi</label>
                    <input type="text" name="destinasi_subtitle" class="form-control" value="{{ old('destinasi_subtitle', $homepage->destinasi_subtitle ?? '8 destinasi wisata di kawasan Bakara · Tipang · Baktiraja') }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label>Judul Peta Lokasi</label>
                    <input type="text" name="maps_title" class="form-control" value="{{ old('maps_title', $homepage->maps_title ?? 'Lokasi 3 Kawasan Wisata') }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label>Sub-judul Peta Lokasi</label>
                    <input type="text" name="maps_subtitle" class="form-control" value="{{ old('maps_subtitle', $homepage->maps_subtitle ?? 'Bakara · Tipang · Baktiraja - Kabupaten Humbang Hasundutan') }}">
                </div>
            </div>

            <!-- CTA Section -->
            <h6 class="fw-bold mt-4 text-secondary border-bottom pb-2">Bagian Call To Action (Bawah)</h6>
            <div class="row mb-4">
                <div class="col-md-12 mb-3">
                    <label>Judul CTA</label>
                    <input type="text" name="cta_title" class="form-control" value="{{ old('cta_title', $homepage->cta_title ?? 'Mulai Petualangan Anda') }}">
                </div>
                <div class="col-md-12 mb-3">
                    <label>Teks CTA</label>
                    <textarea name="cta_text" class="form-control" rows="2">{{ old('cta_text', $homepage->cta_text ?? 'Temukan keajaiban alam, sejarah perjuangan Sisingamangaraja, dan kearifan lokal Batak di kawasan Bakara · Tipang · Baktiraja.') }}</textarea>
                </div>
            </div>

            <!-- 8 Destinasi Section -->
            <h6 class="fw-bold mt-5 text-secondary border-bottom pb-2">Konfigurasi 8 Destinasi (Tampil Selang-Seling)</h6>
            @foreach($homepage->destinasis as $dest)
            <div class="card bg-light border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h6 class="fw-bold text-primary mb-3"># Destinasi {{ $dest->urutan }}</h6>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label>Gambar Destinasi {{ $dest->urutan }}</label>
                            @if($dest->gambar)
                                <div class="current-images">
                                    <img src="{{ asset('storage/' . $dest->gambar) }}" alt="Destinasi {{ $dest->urutan }}">
                                </div>
                            @endif
                            <div class="custom-file-upload mt-2" style="padding: 15px;">
                                <i class="fas fa-image icon" style="font-size: 2rem;"></i>
                                <p style="font-size: 0.9rem;">Upload Gambar {{ $dest->urutan }}</p>
                                <input type="file" name="destinasi_gambar[{{ $dest->id }}]" class="form-control image-input" accept="image/*" data-preview-container="preview-dest-{{$dest->id}}">
                                <div id="preview-dest-{{$dest->id}}" class="preview-grid"></div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label>Teks Nomor (cth: 01 — PANORAMA)</label>
                                    <input type="text" name="destinasi[{{ $dest->id }}][nomor_teks]" class="form-control" value="{{ old('destinasi.'.$dest->id.'.nomor_teks', $dest->nomor_teks) }}">
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label>Judul Destinasi</label>
                                    <input type="text" name="destinasi[{{ $dest->id }}][judul]" class="form-control" value="{{ old('destinasi.'.$dest->id.'.judul', $dest->judul) }}">
                                </div>
                                <div class="col-md-12 mb-2">
                                    <label>Lokasi (Teks Kecil)</label>
                                    <input type="text" name="destinasi[{{ $dest->id }}][lokasi]" class="form-control" value="{{ old('destinasi.'.$dest->id.'.lokasi', $dest->lokasi) }}">
                                </div>
                                <div class="col-md-12 mb-2">
                                    <label>Deskripsi Singkat</label>
                                    <textarea name="destinasi[{{ $dest->id }}][deskripsi]" class="form-control" rows="2">{{ old('destinasi.'.$dest->id.'.deskripsi', $dest->deskripsi) }}</textarea>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label>Tags (Pisahkan dengan koma, cth: Alam,Sejuk)</label>
                                    <input type="text" name="destinasi[{{ $dest->id }}][tags]" class="form-control" value="{{ old('destinasi.'.$dest->id.'.tags', $dest->tags) }}">
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label>Link Tujuan Tombol (Jelajahi Lebih Lanjut)</label>
                                    <select name="destinasi[{{ $dest->id }}][link]" class="form-control">
                                        <option value="">Pilih Halaman Geosite...</option>
                                        <option value="/geosite/aek-sipangolu" {{ old('destinasi.'.$dest->id.'.link', $dest->link) == '/geosite/aek-sipangolu' ? 'selected' : '' }}>Aek Sipangolu</option>
                                        <option value="/geosite/aek-sitio-tio" {{ old('destinasi.'.$dest->id.'.link', $dest->link) == '/geosite/aek-sitio-tio' ? 'selected' : '' }}>Aek Sitio-tio</option>
                                        <option value="/geosite/air-terjun-janji" {{ old('destinasi.'.$dest->id.'.link', $dest->link) == '/geosite/air-terjun-janji' ? 'selected' : '' }}>Air Terjun Janji</option>
                                        <option value="/geosite/desa-wisata-tipang" {{ old('destinasi.'.$dest->id.'.link', $dest->link) == '/geosite/desa-wisata-tipang' ? 'selected' : '' }}>Desa Tipang</option>
                                        <option value="/geosite/gonting" {{ old('destinasi.'.$dest->id.'.link', $dest->link) == '/geosite/gonting' ? 'selected' : '' }}>Gonting</option>
                                        <option value="/geosite/istana-sisingamangaraja" {{ old('destinasi.'.$dest->id.'.link', $dest->link) == '/geosite/istana-sisingamangaraja' ? 'selected' : '' }}>Istana Sisingamangaraja</option>
                                        <option value="/geosite/panatapan-bakara" {{ old('destinasi.'.$dest->id.'.link', $dest->link) == '/geosite/panatapan-bakara' ? 'selected' : '' }}>Panatapan Bakara</option>
                                        <option value="/geosite/tombak-sulu-sulu" {{ old('destinasi.'.$dest->id.'.link', $dest->link) == '/geosite/tombak-sulu-sulu' ? 'selected' : '' }}>Tombak Sulu-sulu</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

            <div class="d-flex gap-2 mt-4">
                <button class="btn btn-primary px-4 py-2" style="background:#003366; border:none; border-radius:50px;">
                    <i class="fas fa-save me-2"></i> Simpan Konfigurasi
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Script live preview standar untuk file input image
    document.querySelectorAll('.image-input').forEach(input => {
        input.addEventListener('change', function(e) {
            const containerId = this.getAttribute('data-preview-container');
            const container = document.getElementById(containerId);
            container.innerHTML = '';
            const files = e.target.files;
            
            if (files && files.length > 0) {
                Array.from(files).forEach(file => {
                    const reader = new FileReader();
                    reader.onload = function(ev) {
                        const imgContainer = document.createElement('div');
                        imgContainer.className = 'preview-item';
                        const img = document.createElement('img');
                        img.src = ev.target.result;
                        imgContainer.appendChild(img);
                        container.appendChild(imgContainer);
                    }
                    reader.readAsDataURL(file);
                });
            }
        });
    });
</script>

@endsection
