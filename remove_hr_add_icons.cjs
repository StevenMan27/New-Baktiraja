const fs = require('fs');
const path = require('path');

const baseDir = 'resources/views/admin';
const dirs = ['berita', 'fasilitas', 'galeri', 'informasi', 'penginapan', 'umkm'];
const files = ['create.blade.php', 'edit.blade.php'];

for (const d of dirs) {
    for (const f of files) {
        const filePath = path.join(baseDir, d, f);
        if (!fs.existsSync(filePath)) continue;
        
        let content = fs.readFileSync(filePath, 'utf8');
        
        // 1. Remove <hr> tags
        content = content.replace(/<hr\s*\/?>/g, '');

        // 2. Add icons to buttons if they don't have them
        // For btn-submit
        content = content.replace(/<button type="submit" class="btn-submit"([^>]*)>\s*(Simpan|Update)\s*<\/button>/g, 
            '<button type="submit" class="btn-submit"$1>\n                    <i class="fas fa-save"></i> $2\n                </button>');
            
        // For btn-cancel
        content = content.replace(/<a href="([^"]+)" class="btn-cancel"([^>]*)>\s*(Batal|Kembali)\s*<\/a>/g, 
            '<a href="$1" class="btn-cancel"$2>\n                    <i class="fas fa-arrow-left"></i> $3\n                </a>');

        fs.writeFileSync(filePath, content, 'utf8');
        console.log(`Processed ${d}/${f}`);
    }
}
