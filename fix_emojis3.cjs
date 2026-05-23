const fs = require('fs');
const path = require('path');

const dir = 'resources/views/geosite/';
const files = fs.readdirSync(dir).filter(f => f.endsWith('.blade.php')).map(f => path.join(dir, f));

for (const file of files) {
    let content = fs.readFileSync(file, 'utf8');
    
    // Explicit string replacements based on exact corrupted bytes
    // Since node reads it as utf8, powershell's corrupted bytes will appear as certain utf8 characters.
    // Let's use the exact corrupted bytes we saw in Node output earlier!
    content = content.replace(/ðŸ“ /g, '📍');
    content = content.replace(/ðŸ“ž/g, '📞');
    content = content.replace(/ðŸ’°/g, '💰');
    content = content.replace(/Â·/g, '·');

    fs.writeFileSync(file, content, 'utf8');
}
console.log('Fixed emojis with precise replacement!');
