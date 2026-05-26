const fs = require('fs');
const path = require('path');

const dirs = ['berita', 'fasilitas', 'galeri', 'informasi', 'penginapan', 'umkm'];
const basePath = 'A:/PA111/real/Proyek akhir 1 Real/resources/views/admin';

dirs.forEach(dir => {
    ['create.blade.php', 'edit.blade.php'].forEach(file => {
        const fullPath = path.join(basePath, dir, file);
        if (fs.existsSync(fullPath)) {
            let content = fs.readFileSync(fullPath, 'utf8');
            content = content.replace(/#0d6efd/g, '#003366');
            content = content.replace(/#0a58ca/g, '#c6a43b');
            fs.writeFileSync(fullPath, content);
            console.log("Updated colors in: " + fullPath);
        }
    });
});
