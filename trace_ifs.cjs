const fs = require('fs');
const path = require('path');
const fp = path.join('resources/views/geosite', 'air-terjun-janji.blade.php');
let content = fs.readFileSync(fp, 'utf8');

const lines = content.split('\n');
let ifCount = 0;
let endifCount = 0;
lines.forEach((line, i) => {
    let ifs = (line.match(/@if/g) || []).length;
    let endifs = (line.match(/@endif/g) || []).length;
    if (ifs > 0) { console.log(`Line ${i+1}: +${ifs} @if (Total: ${ifCount + ifs})`); }
    if (endifs > 0) { console.log(`Line ${i+1}: -${endifs} @endif (Total: ${endifCount + endifs})`); }
    ifCount += ifs;
    endifCount += endifs;
});
console.log(`Final - @if: ${ifCount}, @endif: ${endifCount}`);
