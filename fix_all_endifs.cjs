const fs = require('fs');
const path = require('path');
const dir = 'resources/views/geosite';
const files = fs.readdirSync(dir).filter(f => f.endsWith('.blade.php'));

files.forEach(file => {
    const fp = path.join(dir, file);
    let content = fs.readFileSync(fp, 'utf8');

    let ifs = (content.match(/@if/g) || []).length;
    let endifs = (content.match(/@endif/g) || []).length;
    
    if (ifs !== endifs) {
        console.log(`Mismatch in ${file} - @if: ${ifs}, @endif: ${endifs}`);
        
        // Let's find exactly where the @if was missing.
        // It's probably the same issue: missing @endif right before </div></section> for the Berita block.
        // Our previous regex was:
        // content = content.replace(/(@endif\s*)<\/div><\/section>\s*<section id="rekomendasi"/g, '$1@endif\n</div></section>\n\n<section id="rekomendasi"');
        // Let's just blindly add an @endif if we know it's missing at the end of the berita section.
        
        // Let's do a more robust replace that just looks for the end of the berita section.
        // The berita section ends with </div></section> right before <section id="rekomendasi" or <section id="maps"
        
        // Actually, we can just replace:
        // @endif
        // </div></section>
        // with
        // @endif
        // @endif
        // </div></section>
        // for the first occurrence that happens after the `berita-grid`.
        
        content = content.replace(/(@endif[\s\r\n]*)<\/div><\/section>([\s\r\n]*<section id="rekomendasi")/, '$1@endif\n</div></section>$2');
        fs.writeFileSync(fp, content);
        console.log(`Fixed ${file}`);
    }
});
console.log('Done checking all files.');
