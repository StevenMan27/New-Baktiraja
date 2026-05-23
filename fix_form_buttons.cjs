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
        
        // 1. Replace any button with style="background: #c6a43b..." and "Simpan" or "Update" to use class="btn-submit"
        // Just replace the whole button tag if it contains "Simpan" or "Update"
        // Actually, just regex the class of submit buttons:
        content = content.replace(/class="btn btn-primary"([^>]*)>Simpan<\/button>/g, 'class="btn-submit"$1>Simpan</button>');
        content = content.replace(/class="btn btn-primary"([^>]*)>Update<\/button>/g, 'class="btn-submit"$1>Update</button>');
        
        content = content.replace(/class="btn btn-warning"([^>]*)>Update<\/button>/g, 'class="btn-submit"$1>Update</button>');

        content = content.replace(/<button type="submit" class="btn" style="background: #c6a43b; border: none; color: white;">\s*<i class="fas fa-save me-2"><\/i> (Simpan|Update)\s*<\/button>/g, 
            '<button type="submit" class="btn-submit">\n                    <i class="fas fa-save me-2"></i> $1\n                </button>');

        // 2. Replace any <a ...>Batal</a> or <a ...>Kembali</a> using btn-secondary
        content = content.replace(/class="btn btn-secondary"([^>]*)>(Batal|Kembali)<\/a>/g, 'class="btn-cancel"$1>$2</a>');
        
        content = content.replace(/class="btn btn-secondary">\s*<i class="fas fa-arrow-left me-2"><\/i> (Batal|Kembali)\s*<\/a>/g, 
            'class="btn-cancel">\n                    <i class="fas fa-arrow-left me-2"></i> $1\n                </a>');

        fs.writeFileSync(filePath, content, 'utf8');
        console.log(`Updated ${d}/${f}`);
    }
}
