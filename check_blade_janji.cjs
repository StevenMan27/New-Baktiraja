const fs = require('fs');
const path = require('path');
const fp = path.join('resources/views/geosite', 'air-terjun-janji.blade.php');
let content = fs.readFileSync(fp, 'utf8');

let ifs = (content.match(/@if/g) || []).length;
let endifs = (content.match(/@endif/g) || []).length;
let foreachs = (content.match(/@foreach/g) || []).length;
let endforeachs = (content.match(/@endforeach/g) || []).length;
let forelses = (content.match(/@forelse/g) || []).length;
let endforelses = (content.match(/@empty|@endforelse/g) || []).length;

console.log(`@if: ${ifs}, @endif: ${endifs}`);
console.log(`@foreach: ${foreachs}, @endforeach: ${endforeachs}`);
console.log(`@forelse: ${forelses}`);
