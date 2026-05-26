const fs = require('fs');
const path = require('path');
const dir = 'app/Models';
const files = fs.readdirSync(dir).filter(f => f.endsWith('.php'));

files.forEach(file => {
    let content = fs.readFileSync(path.join(dir, file), 'utf8');
    let className = (content.match(/class\s+(\w+)/) || [])[1];
    let fillable = (content.match(/\$fillable\s*=\s*\[([\s\S]*?)\];/) || [])[1];
    let table = (content.match(/\$table\s*=\s*['"]([^'"]+)['"]/) || [])[1];
    
    if (fillable) {
        fillable = fillable.replace(/['"\s]/g, '').split(',').filter(x => x);
    }
    console.log(`Model: ${className}`);
    if (table) console.log(`Table: ${table}`);
    console.log(`Fillable: ${fillable}`);
    console.log('---');
});
