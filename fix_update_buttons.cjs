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
        
        // Match btn-submit that DOES NOT contain <i 
        // We can do this by regexing the inner HTML
        content = content.replace(/<button([^>]*)class="btn-submit"([^>]*)>\s*(Simpan|Update)\s*<\/button>/g, 
            '<button$1class="btn-submit"$2>\n                    <i class="fas fa-save"></i> $3\n                </button>');

        fs.writeFileSync(filePath, content, 'utf8');
        console.log(`Processed ${d}/${f}`);
    }
}
