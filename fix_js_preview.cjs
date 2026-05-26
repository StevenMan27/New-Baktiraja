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

const cleanJS = `
<script>
    document.getElementById('inputGambar').addEventListener('change', function(e) {
        const grid = document.getElementById('previewGrid');
        grid.innerHTML = '';
        const file = e.target.files[0];
        if (!file) return;
        if (file.size > 4 * 1024 * 1024) {
            alert('Gambar "' + file.name + '" melebihi batas maksimal 4MB!');
            this.value = '';
            return;
        }
        const reader = new FileReader();
        reader.onload = function(ev) {
            const item = document.createElement('div');
            item.className = 'preview-item';
            item.innerHTML = '<img src="' + ev.target.result + '" alt="Preview">';
            grid.appendChild(item);
        };
        reader.readAsDataURL(file);
    });
</script>
`;

targets.forEach(rel => {
    const fp = path.join(basePath, rel);
    if (!fs.existsSync(fp)) return;
    let c = fs.readFileSync(fp, "utf8");

    // Hapus seluruh blok <script>...</script> yang ada
    c = c.replace(/<script>[\s\S]*?<\/script>/g, "");

    // Tambahkan JS bersih sebelum @endsection
    c = c.replace(/@endsection\s*$/, cleanJS + "\n@endsection");

    fs.writeFileSync(fp, c);
    console.log("Fixed JS in: " + rel);
});
