const fs = require('fs');
const path = require('path');
const dir = 'resources/views/geosite';
const files = fs.readdirSync(dir).filter(f => f.endsWith('.blade.php'));

const heroReplacement = `
@php
    $bgHero = ($profil && $profil->bg_hero && is_array($profil->bg_hero) && count($profil->bg_hero) > 0) 
        ? asset('storage/' . $profil->bg_hero[0]) 
        : asset('image/default-hero.jpg');
@endphp
<section class="hero" style="background: linear-gradient(rgba(0,51,102,0.6), rgba(0,51,102,0.7)), url('{{ $bgHero }}'); background-size: cover; background-position: center;">
    <div data-aos="fade-up">
        <h1 class="hero-title">{{ $profil->judul_utama ?? 'JUDUL UTAMA' }}</h1>
        <p class="hero-subtitle">{{ $profil->sub_judul ?? 'SUB JUDUL' }}</p>
    </div>
</section>
`;

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
                    @php
                        $descImg = (is_array($profil->deskripsi_2_gambar) && count($profil->deskripsi_2_gambar) > 0) 
                            ? asset('storage/' . $profil->deskripsi_2_gambar[0]) 
                            : asset('image/default-image.jpg');
                    @endphp
                    <img src="{{ $descImg }}" alt="Gambar Deskripsi">
                </div>
                <div class="sejarah-text">
                    <h4 style="color: var(--bi-blue); margin-bottom: 12px; font-family: 'Cormorant Garamond', serif;">{{ $profil->deskripsi_2_judul }}</h4>
                    <p>{!! nl2br(e($profil->deskripsi_2_teks)) !!}</p>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>
`;

const informasiReplacement = `
<section id="informasi" class="section bg-light">
    <div class="container">
        <div class="section-title" data-aos="fade-up">
            <h2>Informasi Praktis</h2>
            <div class="divider"></div>
        </div>
        <div class="info-praktis">
            <div class="info-praktis-grid">
                <div class="info-praktis-item">
                    <h4>LOKASI</h4>
                    <p>{{ $profil->info_lokasi ?? '-' }}</p>
                </div>
                <div class="info-praktis-item">
                    <h4>JAM OPERASIONAL</h4>
                    <p>{{ $profil->info_jam ?? '-' }}</p>
                </div>
                <div class="info-praktis-item">
                    <h4>HARGA TIKET</h4>
                    <p>{{ $profil->info_harga ?? '-' }}</p>
                </div>
            </div>
            <div class="tags">
                @if($profil && is_array($profil->tags))
                    @foreach($profil->tags as $tag)
                        <span class="tag">{{ $tag }}</span>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</section>
`;

files.forEach(file => {
    let content = fs.readFileSync(path.join(dir, file), 'utf8');
    
    // Replace Hero
    content = content.replace(/<section class="hero">[\s\S]*?<\/section>/, heroReplacement.trim());
    
    // Replace Sejarah
    content = content.replace(/<section id="sejarah" class="section">[\s\S]*?<\/section>/, sejarahReplacement.trim());
    
    // Replace Informasi
    // Be careful, it might grab everything up to the next </section>, but since we know it ends right before <section id="galeri">
    content = content.replace(/<section id="informasi" class="section bg-light">[\s\S]*?<\/section>/, informasiReplacement.trim());
    
    fs.writeFileSync(path.join(dir, file), content);
    console.log(`Updated ${file}`);
});
