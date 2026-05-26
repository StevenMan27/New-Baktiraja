const fs = require('fs');
const path = require('path');

const file = 'A:/PA111/real/Proyek akhir 1 Real/resources/views/admin/profil/edit.blade.php';
let content = fs.readFileSync(file, 'utf8');

// Insert custom-file-upload css if not present
if (!content.includes('.custom-file-upload')) {
    const styleCss = `
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
`;
    content = content.replace(/@section\('content'\)/, "@section('content')\n" + styleCss);
}

// Replace bg_hero input
const heroInputRegex = /<input type="file" name="bg_hero"[\s\S]*?<div id="preview-hero"[^>]*><\/div>/;
const heroReplacement = `
<div class="custom-file-upload mt-2">
    <i class="fas fa-cloud-upload-alt icon"></i>
    <p>Klik atau Seret Gambar ke Sini</p>
    <small class="d-block mt-2">Format: JPG, PNG, WEBP | Disarankan rasio 16:9 atau lebar</small>
    <input type="file" name="bg_hero" class="form-control image-input" accept="image/*" data-preview-container="preview-hero">
    <div id="preview-hero" class="preview-grid"></div>
</div>
`;
content = content.replace(heroInputRegex, heroReplacement.trim());
content = content.replace(/<small class="text-muted d-block mt-1"><i class="fas fa-info-circle"><\/i> Biarkan kosong jika tidak ingin mengubah. Disarankan rasio 16:9 atau lebar \(resolusi tinggi\).<\/small>/g, '');

// Replace deskripsi loop input
const deskripsiInputRegex = /<input type="file" name="\{\{ \$gambarKey \}\}\[\]"[\s\S]*?<div id="preview-deskripsi-\{\{ \$i \}\}"[^>]*><\/div>/;
const deskripsiReplacement = `
<div class="custom-file-upload mt-2">
    <i class="fas fa-cloud-upload-alt icon"></i>
    <p>Klik atau Seret Gambar ke Sini</p>
    <small class="d-block mt-2">Format: JPG, PNG, WEBP | Max: 4MB per gambar</small>
    <input type="file" name="{{ $gambarKey }}[]" class="form-control image-input" accept="image/*" multiple data-preview-container="preview-deskripsi-{{ $i }}">
    <div id="preview-deskripsi-{{ $i }}" class="preview-grid"></div>
</div>
`;
content = content.replace(deskripsiInputRegex, deskripsiReplacement.trim());
content = content.replace(/<small class="text-muted d-block mt-1"><i class="fas fa-info-circle"><\/i> Bisa upload lebih dari satu gambar. Biarkan kosong jika tidak ingin mengubah.<\/small>/g, '');

fs.writeFileSync(file, content);
console.log("Updated profil edit");
