const fs = require('fs');
const path = require('path');

const dirs = ['berita', 'fasilitas', 'galeri', 'informasi', 'penginapan', 'umkm'];
const basePath = 'A:/PA111/real/Proyek akhir 1 Real/resources/views/admin';

dirs.forEach(dir => {
    ['create.blade.php', 'edit.blade.php'].forEach(file => {
        const fullPath = path.join(basePath, dir, file);
        if (fs.existsSync(fullPath)) {
            let content = fs.readFileSync(fullPath, 'utf8');

            // Kita tambahkan CSS custom-file-upload di bagian atas file jika belum ada
            if (!content.includes('.custom-file-upload')) {
                const styleCss = `
<style>
    .custom-file-upload {
        border: 2px dashed #0d6efd;
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
        border-color: #0a58ca;
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
        color: #0d6efd;
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
    .preview-grid { 
        display: flex; flex-wrap: wrap; gap: 15px; margin-top: 20px; justify-content: center; position: relative; z-index: 3; pointer-events: none;
    }
    .preview-item { pointer-events: auto; }
    .preview-item img { width: 120px; height: 120px; object-fit: cover; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); border: 2px solid #fff; }
</style>
`;
                content = content.replace(/@section\('content'\)/, "@section('content')\n" + styleCss);
            }

            // Replace standard input block with new Dropzone block
            // Remove old style if it exists
            content = content.replace(/<style>\s*\.preview-grid[\s\S]*?<\/style>/, '');

            const inputRegex = /<input type="file" name="gambar\[\]".*?id="inputGambar".*?>/;
            const match = content.match(inputRegex);
            
            if (match) {
                const inputTag = match[0];
                
                // We construct the new wrapper
                const newWrapper = `
<div class="custom-file-upload mt-2">
    <i class="fas fa-cloud-upload-alt icon"></i>
    <p>Klik atau Seret Gambar ke Sini</p>
    <small class="d-block mt-2">Format: JPG, PNG, WEBP | Max: 4MB per gambar | Maksimal 10 gambar</small>
    ${inputTag}
    <div class="preview-grid" id="previewGrid"></div>
</div>
`;
                // Replace input tag, small text, and empty preview grid
                // Find start of input, replace up to <div class="preview-grid" id="previewGrid"></div>
                const oldBlockRegex = /<input type="file" name="gambar\[\]"[\s\S]*?<div class="preview-grid" id="previewGrid"><\/div>/;
                if(content.match(oldBlockRegex)) {
                     content = content.replace(oldBlockRegex, newWrapper.trim());
                } else {
                     // For edit.blade.php which might have existing images, we do a softer replace
                     // Actually edit has @if($item->gambar) above or below it.
                     // Let's just replace the inputTag itself and its surrounding formatting if possible
                     content = content.replace(inputTag, newWrapper.trim().replace('<div class="preview-grid" id="previewGrid"></div>', ''));
                }
            }

            fs.writeFileSync(fullPath, content);
            console.log("Updated: " + fullPath);
        }
    });
});
