const fs = require('fs');
const path = require('path');

const dir = 'resources/views/geosite/';
const files = fs.readdirSync(dir).filter(f => f.endsWith('.blade.php')).map(f => path.join(dir, f));

for (const file of files) {
    let content = fs.readFileSync(file, 'utf8');
    
    content = content.replace(/ðŸ“ /g, '📍');
    content = content.replace(/ðŸ“ž/g, '📞');
    content = content.replace(/ðŸ’°/g, '💰');
    content = content.replace(/A/g, '·');

    fs.writeFileSync(file, content, 'utf8');
}
console.log('Fixed emojis with blind replacement!');
