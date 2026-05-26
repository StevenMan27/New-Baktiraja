const fs = require('fs');
const path = require('path');
const dir = 'resources/views/geosite';
const files = fs.readdirSync(dir).filter(f => f.endsWith('.blade.php'));

const sejarahReplacement = `
<section id="sejarah" class="section">
    <div class="container">
        <div class="section-title" data-aos="fade-up">
            <h2>{{ $profil->deskripsi_1_judul ?? 'Judul Deskripsi' }}</h2>
            <div class="divider"></div>
        </div>
        <div class="sejarah-intro" style="margin-bottom: 50px; line-height: 1.8; color: #444; font-size: 0.95rem;">
            {!! nl2br(e($profil->deskripsi_1_teks ?? '')) !!}
        </div>

        <div class="sejarah-grid">
            @if($profil && $profil->deskripsi_2_judul)
            <div class="sejarah-item reverse" data-aos="fade-left">
                <div class="sejarah-image">
                    @php $img2 = (is_array($profil->deskripsi_2_gambar) && count($profil->deskripsi_2_gambar) > 0) ? asset('storage/' . $profil->deskripsi_2_gambar[0]) : asset('image/default-image.jpg'); @endphp
                    <img src="{{ $img2 }}" alt="Gambar">
                </div>
                <div class="sejarah-text">
                    <h4 style="color: var(--bi-blue); margin-bottom: 12px; font-family: 'Cormorant Garamond', serif;">{{ $profil->deskripsi_2_judul }}</h4>
                    <p>{!! nl2br(e($profil->deskripsi_2_teks)) !!}</p>
                </div>
            </div>
            @endif

            @if($profil && $profil->deskripsi_3_judul)
            <div class="sejarah-item" data-aos="fade-right">
                <div class="sejarah-image">
                    @php $img3 = (is_array($profil->deskripsi_3_gambar) && count($profil->deskripsi_3_gambar) > 0) ? asset('storage/' . $profil->deskripsi_3_gambar[0]) : asset('image/default-image.jpg'); @endphp
                    <img src="{{ $img3 }}" alt="Gambar">
                </div>
                <div class="sejarah-text">
                    <h4 style="color: var(--bi-blue); margin-bottom: 12px; font-family: 'Cormorant Garamond', serif;">{{ $profil->deskripsi_3_judul }}</h4>
                    <p>{!! nl2br(e($profil->deskripsi_3_teks)) !!}</p>
                </div>
            </div>
            @endif

            @if($profil && $profil->deskripsi_4_judul)
            <div class="sejarah-item reverse" data-aos="fade-left">
                <div class="sejarah-image">
                    @php $img4 = (is_array($profil->deskripsi_4_gambar) && count($profil->deskripsi_4_gambar) > 0) ? asset('storage/' . $profil->deskripsi_4_gambar[0]) : asset('image/default-image.jpg'); @endphp
                    <img src="{{ $img4 }}" alt="Gambar">
                </div>
                <div class="sejarah-text">
                    <h4 style="color: var(--bi-blue); margin-bottom: 12px; font-family: 'Cormorant Garamond', serif;">{{ $profil->deskripsi_4_judul }}</h4>
                    <p>{!! nl2br(e($profil->deskripsi_4_teks)) !!}</p>
                </div>
            </div>
            @endif

            @if($profil && $profil->deskripsi_5_judul)
            <div class="sejarah-item" data-aos="fade-right">
                <div class="sejarah-image">
                    @php $img5 = (is_array($profil->deskripsi_5_gambar) && count($profil->deskripsi_5_gambar) > 0) ? asset('storage/' . $profil->deskripsi_5_gambar[0]) : asset('image/default-image.jpg'); @endphp
                    <img src="{{ $img5 }}" alt="Gambar">
                </div>
                <div class="sejarah-text">
                    <h4 style="color: var(--bi-blue); margin-bottom: 12px; font-family: 'Cormorant Garamond', serif;">{{ $profil->deskripsi_5_judul }}</h4>
                    <p>{!! nl2br(e($profil->deskripsi_5_teks)) !!}</p>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>
`;

files.forEach(file => {
    let content = fs.readFileSync(path.join(dir, file), 'utf8');
    content = content.replace(/<section id="sejarah" class="section">[\s\S]*?<\/section>/, sejarahReplacement.trim());
    fs.writeFileSync(path.join(dir, file), content);
    console.log(`Updated ${file}`);
});
