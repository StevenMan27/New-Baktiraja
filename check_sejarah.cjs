const fs = require('fs');
const path = require('path');
const dir = 'resources/views/geosite';
const files = fs.readdirSync(dir).filter(f => f.endsWith('.blade.php'));

files.forEach(file => {
    let content = fs.readFileSync(path.join(dir, file), 'utf8');
    let match = content.match(/<section id="sejarah"[\s\S]*?<\/section>/);
    if(match) {
        let sejarah = match[0];
        let items = (sejarah.match(/class="sejarah-item/g) || []).length;
        console.log(`${file}: ${items} sejarah-item(s)`);
    }
});
