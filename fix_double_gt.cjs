const fs = require("fs");
const path = require("path");
const basePath = "A:/PA111/real/Proyek akhir 1 Real/resources/views/admin";
const targets = [
    "berita/create.blade.php","berita/edit.blade.php",
    "fasilitas/create.blade.php","fasilitas/edit.blade.php",
    "informasi/create.blade.php","informasi/edit.blade.php",
    "penginapan/create.blade.php","penginapan/edit.blade.php",
    "umkm/create.blade.php","umkm/edit.blade.php",
];
targets.forEach(rel => {
    const fp = path.join(basePath, rel);
    if (!fs.existsSync(fp)) return;
    let c = fs.readFileSync(fp, "utf8");
    // Fix double >> 
    c = c.replace(/>\s*>/g, ">");
    fs.writeFileSync(fp, c);
    console.log("Fixed >>: " + rel);
});
