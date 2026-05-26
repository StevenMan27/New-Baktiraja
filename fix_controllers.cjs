const fs = require("fs");
const path = require("path");
const basePath = "A:/PA111/real/Proyek akhir 1 Real/app/Http/Controllers/Admin";

// Controllers yang harus single upload (BUKAN GaleriController)
const controllers = [
    "BeritaController.php",
    "FasilitasController.php",
    "InformasiController.php",
    "PenginapanController.php",
    "UmkmController.php"
];

controllers.forEach(file => {
    const fp = path.join(basePath, file);
    if (!fs.existsSync(fp)) { console.log("NOT FOUND: " + fp); return; }
    let c = fs.readFileSync(fp, "utf8");

    // Replace array upload logic with single file logic
    // Pattern: $paths = []; foreach ($request->file('gambar') as $image) { $paths[] = $image->store('...', 'public'); } $data['gambar'] = json_encode($paths);
    c = c.replace(
        /\$paths = \[\];\s*foreach \(\$request->file\('gambar'\) as \$image\) \{\s*\$paths\[\] = \$image->store\('([^']+)', 'public'\);\s*\}\s*\$data\['gambar'\] = json_encode\(\$paths\);/g,
        (match, folder) => {
            return `$path = $request->file('gambar')->store('${folder}', 'public');\n            $data['gambar'] = json_encode([$path]);`;
        }
    );

    fs.writeFileSync(fp, c);
    console.log("Fixed controller: " + file);
});
