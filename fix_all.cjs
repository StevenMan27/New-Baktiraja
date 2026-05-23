const fs = require('fs');
const path = require('path');

const dir = 'resources/views/geosite/';
const files = fs.readdirSync(dir).filter(f => f.endsWith('.blade.php')).map(f => path.join(dir, f));

for (const file of files) {
    let content = fs.readFileSync(file, 'utf8');
    
    // 1. Fix grid styling (UMKM sizes)
    content = content.replace('.berita-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 25px; }', '.berita-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; }');
    content = content.replace('.berita-img { height: 200px; overflow: hidden; }', '.berita-img { height: 160px; overflow: hidden; }');

    // Make sure we replace the old informasi inline styles with the berita grid style,
    // this was lost during the git restore.
    const oldInfoGrid = '<div style="margin-top: 40px; display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;">';
    const newInfoGrid = '<div class="berita-grid" style="margin-top: 25px;">';
    content = content.replace(oldInfoGrid, newInfoGrid);
    
    content = content.replace(/<div style="background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 5px 15px rgba\(0,0,0,0.08\); padding: 20px;">/g, '<div class="berita-card" data-aos="zoom-in">');
    content = content.replace(/<img src="\{\{ \$item->gambar && !str_starts_with\(\$item->gambar, 'data:'\) \? asset\('storage\/' . \$item->gambar\) : \$item->gambar \}\}" style="width: 100%; height: 200px; object-fit: cover; border-radius: 8px; margin-bottom: 15px;">/g, '<div class="berita-img">\n            <img src="{{ $item->gambar && !str_starts_with($item->gambar, \'data:\') ? asset(\'storage/\' . $item->gambar) : $item->gambar }}" alt="{{ $item->judul }}">\n        </div>');
    content = content.replace(/<h4 style="color: var\(--bi-blue\); margin-bottom: 10px; font-family: 'Cormorant Garamond', serif; font-size: 1.2rem;">\{\{ \$item->judul \}\}<\/h4>/g, '<div class="berita-content">\n            <h4>{{ $item->judul }}</h4>');
    content = content.replace(/<div style="font-size: 0.85rem; color: #555; line-height: 1.6;">\{!! \$item->konten !!\}<\/div>/g, '<div class="berita-excerpt">{!! $item->konten !!}</div>\n        </div>');

    // At this point, content has two berita-grids, one for berita, one for informasi.
    // Replace the empty messages.
    const beritaRegex = /<div class="berita-grid">([\s\S]*?)@forelse\(\$berita as \$item\)([\s\S]*?)@empty([\s\S]*?)@endforelse([\s\S]*?)<\/div>/;
    const infoRegex = /@if\(\$informasi_dinamis->count\(\) > 0\)([\s\S]*?)<div class="berita-grid" style="margin-top: 25px;">([\s\S]*?)@foreach\(\$informasi_dinamis as \$item\)([\s\S]*?)@endforeach([\s\S]*?)<\/div>([\s\S]*?)@endif/;

    const matchBerita = content.match(beritaRegex);
    const matchInfo = content.match(infoRegex);

    if (matchBerita && matchInfo) {
        let bCard = matchBerita[2].replace('Â·', '·'); // fix dot inside the match
        let iCard = matchInfo[3];

        let replacement = `@if($berita->count() == 0 && $informasi_dinamis->count() == 0)
    <div style="text-align:center;padding:2rem;color:#888;">
        <p>Belum ada Berita & Informasi untuk geosite ini.</p>
    </div>
@else
    @if($berita->count() > 0)
    <div class="berita-grid">
        @foreach($berita as $item)` + bCard + `@endforeach
    </div>
    @endif

    @if($informasi_dinamis->count() > 0)
    <div class="berita-grid" style="margin-top: 25px;">
        @foreach($informasi_dinamis as $item)` + iCard + `@endforeach
    </div>
    @endif
@endif`;

        content = content.replace(beritaRegex, replacement);
        content = content.replace(infoRegex, ''); // Remove the info block because it's included in the replacement
    }

    // Fix corrupted emojis introduced by powershell
    content = content.replace(/ðŸ“ /g, '📍');
    content = content.replace(/ðŸ“ž/g, '📞');
    content = content.replace(/ðŸ’°/g, '💰');
    content = content.replace(/Â·/g, '·');
    content = content.replace(/â€”/g, '—');
    
    fs.writeFileSync(file, content, 'utf8');
}
console.log('Fixed everything safely using Node!');
