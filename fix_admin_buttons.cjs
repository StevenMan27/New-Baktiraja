const fs = require('fs');
const path = require('path');

const baseDir = 'resources/views/admin/';
const filesToProcess = [
    'dashboard.blade.php',
    'galeri/index.blade.php',
    'berita/index.blade.php',
    'informasi/index.blade.php',
    'umkm/index.blade.php',
    'fasilitas/index.blade.php',
    'penginapan/index.blade.php'
];

for (const relPath of filesToProcess) {
    const file = path.join(baseDir, relPath);
    if (!fs.existsSync(file)) continue;
    
    let content = fs.readFileSync(file, 'utf8');

    // We will do replacements for the specific action patterns found in the files.
    // Dashboard UMKM
    content = content.replace(/<div class="btn-group">\s*<a href="\{\{ route\('admin\.umkm\.edit', \$item->id\) \}\}" class="btn-edit">Edit<\/a>[\s\S]*?<form action="\{\{ route\('admin\.umkm\.destroy', \$item->id\) \}\}" method="POST" class="d-inline" onsubmit="return confirm\('([^']+)'\)">[\s\S]*?@csrf[\s\S]*?@method\('DELETE'\)[\s\S]*?<button type="submit" class="btn-delete">Hapus<\/button>[\s\S]*?<\/form>\s*<\/div>/g, 
        `<div class="action-buttons">
                            <a href="{{ route('admin.umkm.edit', $item->id) }}" class="btn-edit"><i class="fas fa-edit"></i> Edit</a>
                            <form action="{{ route('admin.umkm.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('$1')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete"><i class="fas fa-trash-alt"></i> Hapus</button>
                            </form>
                        </div>`);

    // Dashboard Fasilitas
    content = content.replace(/<div class="btn-group">\s*<a href="\{\{ route\('admin\.fasilitas\.edit', \$item->id\) \}\}" class="btn-edit">Edit<\/a>[\s\S]*?<form action="\{\{ route\('admin\.fasilitas\.destroy', \$item->id\) \}\}" method="POST" class="d-inline" onsubmit="return confirm\('([^']+)'\)">[\s\S]*?@csrf[\s\S]*?@method\('DELETE'\)[\s\S]*?<button type="submit" class="btn-delete">Hapus<\/button>[\s\S]*?<\/form>\s*<\/div>/g, 
        `<div class="action-buttons">
                            <a href="{{ route('admin.fasilitas.edit', $item->id) }}" class="btn-edit"><i class="fas fa-edit"></i> Edit</a>
                            <form action="{{ route('admin.fasilitas.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('$1')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete"><i class="fas fa-trash-alt"></i> Hapus</button>
                            </form>
                        </div>`);

    // Dashboard Penginapan
    content = content.replace(/<div class="btn-group">\s*<a href="\{\{ route\('admin\.penginapan\.edit', \$item->id\) \}\}" class="btn-edit">Edit<\/a>[\s\S]*?<form action="\{\{ route\('admin\.penginapan\.destroy', \$item->id\) \}\}" method="POST" class="d-inline" onsubmit="return confirm\('([^']+)'\)">[\s\S]*?@csrf[\s\S]*?@method\('DELETE'\)[\s\S]*?<button type="submit" class="btn-delete">Hapus<\/button>[\s\S]*?<\/form>\s*<\/div>/g, 
        `<div class="action-buttons">
                            <a href="{{ route('admin.penginapan.edit', $item->id) }}" class="btn-edit"><i class="fas fa-edit"></i> Edit</a>
                            <form action="{{ route('admin.penginapan.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('$1')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete"><i class="fas fa-trash-alt"></i> Hapus</button>
                            </form>
                        </div>`);
                        
    // Galeri index
    content = content.replace(/<a href="\{\{ route\('admin\.galeri\.edit', \$g->id\) \}\}" class="btn btn-warning btn-sm">Edit<\/a>[\s\S]*?<form action="\{\{ route\('admin\.galeri\.destroy', \$g->id\) \}\}" method="POST" style="display:inline">[\s\S]*?@csrf[\s\S]*?@method\('DELETE'\)[\s\S]*?<button onclick="return confirm\('([^']+)'\)" class="btn btn-danger btn-sm">\s*Hapus\s*<\/button>[\s\S]*?<\/form>/g,
        `<div class="action-buttons">
                        <a href="{{ route('admin.galeri.edit', $g->id) }}" class="btn-edit"><i class="fas fa-edit"></i> Edit</a>
                        <form action="{{ route('admin.galeri.destroy', $g->id) }}" method="POST" class="d-inline" onsubmit="return confirm('$1')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete"><i class="fas fa-trash-alt"></i> Hapus</button>
                        </form>
                    </div>`);

    // Berita index
    content = content.replace(/<a href="\{\{ route\('admin\.berita\.edit', \$item->id\) \}\}" class="btn btn-sm btn-warning">Edit<\/a>[\s\S]*?<form action="\{\{ route\('admin\.berita\.destroy', \$item->id\) \}\}" method="POST" class="d-inline">[\s\S]*?@csrf[\s\S]*?@method\('DELETE'\)[\s\S]*?<button type="submit" class="btn btn-sm btn-danger" onclick="return confirm\('([^']+)'\)">Hapus<\/button>[\s\S]*?<\/form>/g,
        `<div class="action-buttons">
                            <a href="{{ route('admin.berita.edit', $item->id) }}" class="btn-edit"><i class="fas fa-edit"></i> Edit</a>
                            <form action="{{ route('admin.berita.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('$1')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete"><i class="fas fa-trash-alt"></i> Hapus</button>
                            </form>
                        </div>`);

    // Informasi index (which only has icons)
    content = content.replace(/<a href="\{\{ route\('admin\.informasi\.edit', \$item->id\) \}\}" class="btn btn-sm btn-warning">\s*<i class="fas fa-edit"><\/i>\s*<\/a>[\s\S]*?<form action="\{\{ route\('admin\.informasi\.destroy', \$item->id\) \}\}" method="POST" class="d-inline">[\s\S]*?@csrf[\s\S]*?@method\('DELETE'\)[\s\S]*?<button type="submit" class="btn btn-sm btn-danger" onclick="return confirm\('([^']+)'\)">\s*<i class="fas fa-trash"><\/i>\s*<\/button>[\s\S]*?<\/form>/g,
        `<div class="action-buttons">
                                <a href="{{ route('admin.informasi.edit', $item->id) }}" class="btn-edit"><i class="fas fa-edit"></i> Edit</a>
                                <form action="{{ route('admin.informasi.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('$1')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete"><i class="fas fa-trash-alt"></i> Hapus</button>
                                </form>
                            </div>`);

    // UMKM index
    content = content.replace(/<a href="\{\{ route\('admin\.umkm\.edit', \$item->id\) \}\}" class="btn btn-sm btn-warning" title="Edit">\s*<i class="fas fa-edit"><\/i> Edit\s*<\/a>[\s\S]*?<form action="\{\{ route\('admin\.umkm\.destroy', \$item->id\) \}\}" method="POST" class="d-inline" onsubmit="return confirm\('([^']+)'\)">[\s\S]*?@csrf[\s\S]*?@method\('DELETE'\)[\s\S]*?<button type="submit" class="btn btn-sm btn-danger" title="Hapus">\s*<i class="fas fa-trash"><\/i> Hapus\s*<\/button>[\s\S]*?<\/form>/g,
        `<div class="action-buttons">
                                <a href="{{ route('admin.umkm.edit', $item->id) }}" class="btn-edit"><i class="fas fa-edit"></i> Edit</a>
                                <form action="{{ route('admin.umkm.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('$1')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete"><i class="fas fa-trash-alt"></i> Hapus</button>
                                </form>
                            </div>`);

    // Fasilitas index
    content = content.replace(/<a href="\{\{ route\('admin\.fasilitas\.edit', \$item->id\) \}\}" class="btn btn-sm btn-warning" title="Edit">\s*<i class="fas fa-edit"><\/i> Edit\s*<\/a>[\s\S]*?<form action="\{\{ route\('admin\.fasilitas\.destroy', \$item->id\) \}\}" method="POST" class="d-inline" onsubmit="return confirm\('([^']+)'\)">[\s\S]*?@csrf[\s\S]*?@method\('DELETE'\)[\s\S]*?<button type="submit" class="btn btn-sm btn-danger" title="Hapus">\s*<i class="fas fa-trash"><\/i> Hapus\s*<\/button>[\s\S]*?<\/form>/g,
        `<div class="action-buttons">
                                <a href="{{ route('admin.fasilitas.edit', $item->id) }}" class="btn-edit"><i class="fas fa-edit"></i> Edit</a>
                                <form action="{{ route('admin.fasilitas.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('$1')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete"><i class="fas fa-trash-alt"></i> Hapus</button>
                                </form>
                            </div>`);

    // Penginapan index
    content = content.replace(/<a href="\{\{ route\('admin\.penginapan\.edit', \$item->id\) \}\}" class="btn btn-sm btn-warning" title="Edit">\s*<i class="fas fa-edit"><\/i> Edit\s*<\/a>[\s\S]*?<form action="\{\{ route\('admin\.penginapan\.destroy', \$item->id\) \}\}" method="POST" class="d-inline" onsubmit="return confirm\('([^']+)'\)">[\s\S]*?@csrf[\s\S]*?@method\('DELETE'\)[\s\S]*?<button type="submit" class="btn btn-sm btn-danger" title="Hapus">\s*<i class="fas fa-trash"><\/i> Hapus\s*<\/button>[\s\S]*?<\/form>/g,
        `<div class="action-buttons">
                                <a href="{{ route('admin.penginapan.edit', $item->id) }}" class="btn-edit"><i class="fas fa-edit"></i> Edit</a>
                                <form action="{{ route('admin.penginapan.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('$1')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete"><i class="fas fa-trash-alt"></i> Hapus</button>
                                </form>
                            </div>`);

    fs.writeFileSync(file, content, 'utf8');
    console.log(`Updated ${relPath}`);
}
