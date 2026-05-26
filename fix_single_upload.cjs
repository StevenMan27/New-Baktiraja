const fs = require("fs");
const path = require("path");

const basePath = "A:/PA111/real/Proyek akhir 1 Real/resources/views/admin";

// CRUD yang harus SINGLE upload (bukan galeri)
const targets = [
    "berita/create.blade.php",
    "berita/edit.blade.php",
    "fasilitas/create.blade.php",
    "fasilitas/edit.blade.php",
    "informasi/create.blade.php",
    "informasi/edit.blade.php",
    "penginapan/create.blade.php",
    "penginapan/edit.blade.php",
    "umkm/create.blade.php",
    "umkm/edit.blade.php",
];

targets.forEach(rel => {
    const fullPath = path.join(basePath, rel);
    if (!fs.existsSync(fullPath)) { console.log("NOT FOUND: " + fullPath); return; }

    let content = fs.readFileSync(fullPath, "utf8");

    // 1. Hapus atribut multiple dari name="gambar[]"
    content = content.replace(/<input([^>]*name="gambar\[\]"[^>]*)multiple([^>]*)>/g, (match, before, after) => {
        return `<input${before}${after}>`.replace(/\s{2,}/g, " ").trimEnd() + ">";
    });

    // 2. Ubah name="gambar[]" jadi name="gambar" (tanpa bracket) supaya single
    content = content.replace(/name="gambar\[\]"/g, 'name="gambar"');

    // 3. Update info teks (hapus "Maksimal 10 gambar")
    content = content.replace(/Format: JPG, PNG, WEBP \| Max: 4MB per gambar \| Maksimal 10 gambar/g,
        "Format: JPG, PNG, WEBP | Maks. 4MB");

    // 4. Update validasi JS: hapus cek files.length > 10 dan loop foreach
    // Replace loop forEach dengan single file handling
    content = content.replace(
        /if \(files\.length > 10\) \{ alert\('Maksimal 10 gambar!'\); this\.value = ''; return; \}\s*Array\.from\(files\)\.forEach\(file => \{/g,
        "const file = files[0];\nif (file) {\n        {"
    );

    // Tutup forEach yang diganti
    content = content.replace(/\}\);\n(\s*\}\);\n\s*<\/script>)/g, "}\n$1");

    fs.writeFileSync(fullPath, content);
    console.log("Fixed: " + rel);
});
