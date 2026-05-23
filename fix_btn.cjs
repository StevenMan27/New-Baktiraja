const fs = require('fs');
const files = [
    'resources/views/admin/informasi/create.blade.php',
    'resources/views/admin/informasi/edit.blade.php',
    'resources/views/admin/penginapan/create.blade.php',
    'resources/views/admin/penginapan/edit.blade.php'
];

files.forEach(f => {
    let content = fs.readFileSync(f, 'utf8');
    content = content.replace(/class="btn btn-primary"/g, 'class="btn-submit"');
    fs.writeFileSync(f, content);
});
console.log('Fixed button classes');
