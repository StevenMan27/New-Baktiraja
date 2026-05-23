const fs = require('fs');
const path = require('path');

const dir = 'resources/views/geosite/';
const files = fs.readdirSync(dir).filter(f => f.endsWith('.blade.php')).map(f => path.join(dir, f));

for (const file of files) {
    let content = fs.readFileSync(file, 'utf8');
    
    // Replace whatever corrupted character is between <div class="card-location"> and {{
    content = content.replace(/<div class="card-location">.*?\{\{/g, '<div class="card-location">📍 {{');
    
    fs.writeFileSync(file, content, 'utf8');
}
console.log('Fixed location icon safely using Node!');
