const fs = require('fs');
const path = require('path');
const dir = 'resources/views/geosite';
const files = fs.readdirSync(dir).filter(f => f.endsWith('.blade.php'));

let hasError = false;
files.forEach(file => {
    let content = fs.readFileSync(path.join(dir, file), 'utf8');
    let ifs = (content.match(/@if/g) || []).length;
    let endifs = (content.match(/@endif/g) || []).length;
    if (ifs !== endifs) {
        console.log(`ERROR: ${file} - @if: ${ifs}, @endif: ${endifs}`);
        hasError = true;
    }
});
if (!hasError) console.log("All files perfectly balanced!");
