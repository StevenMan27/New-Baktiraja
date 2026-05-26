const fs = require('fs');
const path = require('path');

const dirs = ['galeri', 'informasi', 'penginapan'];
const basePath = 'A:/PA111/real/Proyek akhir 1 Real/resources/views/admin';

dirs.forEach(dir => {
    ['create.blade.php', 'edit.blade.php'].forEach(file => {
        const fullPath = path.join(basePath, dir, file);
        if (fs.existsSync(fullPath)) {
            let content = fs.readFileSync(fullPath, 'utf8');

            // Find the <input type="file" ... id="inputGambar" ... >
            const inputRegex = /<input type="file"[\s\S]*?name="gambar\[\]"[\s\S]*?id="inputGambar"[\s\S]*?>/;
            const match = content.match(inputRegex);
            
            if (match) {
                const inputTag = match[0];
                
                // Cek apakah sudah dibungkus
                if (content.includes('<div class="custom-file-upload mt-2">')) {
                     console.log("Already wrapped: " + fullPath);
                     return;
                }

                const newWrapper = `
<div class="custom-file-upload mt-2">
    <i class="fas fa-cloud-upload-alt icon"></i>
    <p>Klik atau Seret Gambar ke Sini</p>
    <small class="d-block mt-2">Format: JPG, PNG, WEBP | Max: 4MB per gambar | Maksimal 10 gambar</small>
    ${inputTag}
    <div class="preview-grid" id="previewGrid"></div>
</div>
`;
                // In create.blade.php we can replace the input + small text + preview grid
                const oldBlockRegex = new RegExp('<input type="file"[\\s\\S]*?name="gambar\\[\\]"[\\s\\S]*?id="inputGambar"[\\s\\S]*?>\\s*<small class="text-muted">.*?<\\/small>\\s*<div class="preview-grid" id="previewGrid"><\\/div>');
                
                if(content.match(oldBlockRegex)) {
                     content = content.replace(oldBlockRegex, newWrapper.trim());
                     console.log("Replaced full block in: " + fullPath);
                } else {
                     // For edit files or if format is different
                     content = content.replace(inputTag, newWrapper.trim().replace('<div class="preview-grid" id="previewGrid"></div>', ''));
                     console.log("Replaced input only in: " + fullPath);
                }

                fs.writeFileSync(fullPath, content);
            } else {
                console.log("No match found in: " + fullPath);
            }
        }
    });
});
