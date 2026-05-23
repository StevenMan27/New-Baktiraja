const fs = require('fs');
const path = require('path');

const dir = 'resources/views/geosite/';
const files = fs.readdirSync(dir).filter(f => f.endsWith('.blade.php')).map(f => path.join(dir, f));

for (const file of files) {
    let content = fs.readFileSync(file, 'utf8');
    
    // Fix location icon
    content = content.replace(/<div class="card-location">.*?\{\{ \\$item->lokasi \}\}<\/div>/g, '<div class="card-location">📍 {{ \\$item->lokasi }}</div>');
    
    // Fix contact icon
    content = content.replace(/<div class="card-contact">.*?\{\{ \\$item->kontak \}\}<\/div>/g, '<div class="card-contact">📞 {{ \\$item->kontak }}</div>');
    
    // Fix price icon
    content = content.replace(/<div class="card-price">.*?\{\{ \\$item->harga \}\}<\/div>/g, '<div class="card-price">💰 {{ \\$item->harga }}</div>');
    
    // Fix berita meta dot
    content = content.replace(/<div class="berita-meta">\{\{ \\$item->penulis \}\}.*?\{\{ \\$item->created_at->format\('d M Y'\) \}\}<\/div>/g, '<div class="berita-meta">{{ \\$item->penulis }} · {{ \\$item->created_at->format(\'d M Y\') }}</div>');

    fs.writeFileSync(file, content, 'utf8');
}
console.log('Fixed emojis successfully!');
