const fs = require('fs');
const path = require('path');
const dir = 'resources/views/geosite';
const files = fs.readdirSync(dir).filter(f => f.endsWith('.blade.php'));

function wrapCards(content, section, arrayName, itemName, cardClass, imgClass, titleField) {
    // Regex to find the entire loop block
    const loopRegex = new RegExp(`@forelse\\(\\$${arrayName} as \\$${itemName}\\)([\\s\\S]*?)@empty`, 'g');
    
    return content.replace(loopRegex, (match, loopBody) => {
        // Find the card opening tag
        const cardRegex = new RegExp(`(<div class="${cardClass}"[^>]*>)`);
        const cardMatch = loopBody.match(cardRegex);
        if (!cardMatch) return match;
        
        const cardHtml = loopBody.trim();
        
        // We need to replace ImageHelper::getFirstImage($item->gambar) with $img
        let newCardHtml = cardHtml.replace(/\{\{\s*\\App\\Helpers\\ImageHelper::getFirstImage\(\$item->gambar\)\s*\}\}/g, '{{ $img }}');
        
        // Remove the @if($item->gambar) around the image div if it exists
        // E.g. @if($item->gambar)\n<div class="umkm-img">...</div>\n@endif
        // We'll just replace $item->gambar checks with $img checks, but since we are iterating over $images, $img is always truthy
        newCardHtml = newCardHtml.replace(/@if\(\$item->gambar\)/g, '');
        newCardHtml = newCardHtml.replace(/@endif/g, '');
        // Clean up empty lines left by @if/@endif removal
        newCardHtml = newCardHtml.replace(/^\s*[\r\n]/gm, '');

        let noImgCard = cardHtml.replace(/@if\(\$item->gambar\)[^@]*@endif/g, '');
        
        const replacement = `
    @php $images = \\App\\Helpers\\ImageHelper::getAllImages($${itemName}->gambar); @endphp
    @if(count($images) > 0)
        @foreach($images as $img)
        ${newCardHtml}
        @endforeach
    @else
        ${noImgCard}
    @endif
`;
        return `@forelse($${arrayName} as $${itemName})` + replacement + `\n    @empty`;
    });
}

function wrapGaleri(content) {
    const loopRegex = /@forelse\(\$galeri as \$item\)([\s\S]*?)@empty/g;
    return content.replace(loopRegex, (match, loopBody) => {
        let newCardHtml = loopBody.replace(/\{\{\s*\\App\\Helpers\\ImageHelper::getFirstImage\(\$item->gambar\)\s*\}\}/g, '{{ $img }}');
        
        const replacement = `
    @php $images = \\App\\Helpers\\ImageHelper::getAllImages($item->gambar); @endphp
    @foreach($images as $img)
${newCardHtml}
    @endforeach
`;
        return `@forelse($galeri as $item)` + replacement + `    @empty`;
    });
}

function wrapBerita(content) {
    // Berita has @foreach($berita as $item) instead of forelse
    const loopRegex = /@foreach\(\$berita as \$item\)([\s\S]*?)@endforeach/g;
    return content.replace(loopRegex, (match, loopBody) => {
        if (!loopBody.includes('berita-card')) return match; // skip if not the right loop
        
        let newCardHtml = loopBody.trim();
        newCardHtml = newCardHtml.replace(/\{\{\s*\\App\\Helpers\\ImageHelper::getFirstImage\(\$item->gambar\)\s*\}\}/g, '{{ $img }}');
        newCardHtml = newCardHtml.replace(/@if\(\$item->gambar\)/g, '');
        newCardHtml = newCardHtml.replace(/@endif/g, '');
        newCardHtml = newCardHtml.replace(/^\s*[\r\n]/gm, '');
        
        let noImgCard = loopBody.trim().replace(/@if\(\$item->gambar\)[^@]*@endif/g, '');
        
        const replacement = `
        @php $images = \\App\\Helpers\\ImageHelper::getAllImages($item->gambar); @endphp
        @if(count($images) > 0)
            @foreach($images as $img)
            ${newCardHtml}
            @endforeach
        @else
            ${noImgCard}
        @endif
`;
        return `@foreach($berita as $item)` + replacement + `        @endforeach`;
    });
}

function wrapInformasi(content) {
    // Informasi has @foreach($informasi_dinamis as $item)
    const loopRegex = /@foreach\(\$informasi_dinamis as \$item\)([\s\S]*?)@endforeach/g;
    return content.replace(loopRegex, (match, loopBody) => {
        if (!loopBody.includes('berita-card')) return match;
        
        let newCardHtml = loopBody.trim();
        newCardHtml = newCardHtml.replace(/\{\{\s*\\App\\Helpers\\ImageHelper::getFirstImage\(\$item->gambar\)\s*\}\}/g, '{{ $img }}');
        newCardHtml = newCardHtml.replace(/@if\(\$item->gambar\)/g, '');
        newCardHtml = newCardHtml.replace(/@endif/g, '');
        newCardHtml = newCardHtml.replace(/^\s*[\r\n]/gm, '');
        
        let noImgCard = loopBody.trim().replace(/@if\(\$item->gambar\)[^@]*@endif/g, '');
        
        const replacement = `
    @php $images = \\App\\Helpers\\ImageHelper::getAllImages($item->gambar); @endphp
    @if(count($images) > 0)
        @foreach($images as $img)
        ${newCardHtml}
        @endforeach
    @else
        ${noImgCard}
    @endif
`;
        return `@foreach($informasi_dinamis as $item)` + replacement + `    @endforeach`;
    });
}

files.forEach(file => {
    const fp = path.join(dir, file);
    let content = fs.readFileSync(fp, 'utf8');
    const before = content;
    
    content = wrapGaleri(content);
    content = wrapCards(content, 'umkm', 'umkm', 'item', 'umkm-card', 'umkm-img', 'nama');
    content = wrapCards(content, 'penginapan', 'penginapan', 'item', 'penginapan-card', 'penginapan-img', 'nama');
    content = wrapCards(content, 'fasilitas', 'fasilitas', 'item', 'fasilitas-item', 'fasilitas-img', 'nama');
    content = wrapBerita(content);
    content = wrapInformasi(content);
    
    if (content !== before) {
        fs.writeFileSync(fp, content);
        console.log('Processed: ' + file);
    }
});
console.log('Done');
