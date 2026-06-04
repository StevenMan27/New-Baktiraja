const fs = require('fs');

const appContent = fs.readFileSync('resources/views/layouts/app.blade.php', 'utf8');
const homeContent = fs.readFileSync('resources/views/pages/home.blade.php', 'utf8');

const appStyleMatch = appContent.match(/<style>([\s\S]*?)<\/style>/);
const appCss = appStyleMatch ? appStyleMatch[1] : '';

const homeStyleMatch = homeContent.match(/<style>([\s\S]*?)<\/style>/);
const homeCss = homeStyleMatch ? homeStyleMatch[1] : '';

let totalCss = appCss + '\n' + homeCss;
totalCss = totalCss.replace(/\{\{\s*!empty.*?asset\("storage\/"\s*\.\s*\$homepage->.*?\)\s*:\s*"(.*?)"\s*\}\}/g, '$1');

fs.writeFileSync('figma_homepage.css', totalCss, 'utf8');

const htmlHead = `<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>Geosite Danau Toba - Figma Export</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="figma_homepage.css">
</head>
<body>
`;

const navbarMatch = appContent.match(/<nav[\s\S]*?<\/nav>/);
let navbarHtml = navbarMatch ? navbarMatch[0] : '';
navbarHtml = navbarHtml.replace(/\{\{ url\('(.*?)'\) \}\}/g, '$1');
navbarHtml = navbarHtml.replace(/\{\{ request\(\)->routeIs.*? \? 'active' : '' \}\}/g, '');
navbarHtml = navbarHtml.replace(/\{\{ asset\('(.*?)'\) \}\}/g, '$1');

let homeHtml = homeContent.replace(/<style>[\s\S]*?<\/style>/, '');
homeHtml = homeHtml.replace(/@extends.*?\n/, '');
homeHtml = homeHtml.replace(/@section.*?\n/, '');
homeHtml = homeHtml.replace(/@endsection/, '');

homeHtml = homeHtml.replace(/\{\{ \$homepage->.*? \?\? '(.*?)' \}\}/g, '$1');
homeHtml = homeHtml.replace(/\{\!\! \$homepage->.*? \?\? '(.*?)' \!\!\}/g, '$1');

const destinasiHtml = `
<div class="destinasi-item" data-aos="fade-up" data-aos-duration="1000">
    <div class="destinasi-image">
        <img src="/image/bakara/panatapan-bakara.jpg" alt="Panatapan Bakara">
    </div>
    <div class="destinasi-content">
        <div class="destinasi-number">01</div>
        <h3>Panatapan Bakara</h3>
        <div class="destinasi-location">Bakara, Humbang Hasundutan</div>
        <p class="destinasi-desc">Pemandangan indah Danau Toba dari ketinggian.</p>
        <div class="destinasi-tags">
            <span>Alam</span>
            <span>Danau</span>
        </div>
        <a href="#" class="destinasi-link">Jelajahi Lebih Lanjut &rarr;</a>
    </div>
</div>
<div class="destinasi-item reverse" data-aos="fade-up" data-aos-duration="1000">
    <div class="destinasi-image">
        <img src="/image/bakara/istana-sisingamangaraja.jpg" alt="Istana Sisingamangaraja">
    </div>
    <div class="destinasi-content">
        <div class="destinasi-number">02</div>
        <h3>Istana Sisingamangaraja</h3>
        <div class="destinasi-location">Baktiraja, Humbang Hasundutan</div>
        <p class="destinasi-desc">Tempat bersejarah peninggalan Raja Sisingamangaraja.</p>
        <div class="destinasi-tags">
            <span>Budaya</span>
            <span>Sejarah</span>
        </div>
        <a href="#" class="destinasi-link">Jelajahi Lebih Lanjut &rarr;</a>
    </div>
</div>
`;

homeHtml = homeHtml.replace(/@if\(isset.*?\)[\s\S]*?@foreach\(\$homepage->destinasis as \$index => \$dest\)[\s\S]*?@endforeach[\s\S]*?@endif/, destinasiHtml);

const mapsHtml = `
<div class="maps-location-item">
    <i class="fas fa-location-dot"></i>
    <span>Bakara</span>
</div>
<div class="maps-location-item">
    <i class="fas fa-location-dot"></i>
    <span>Tipang</span>
</div>
<div class="maps-location-item">
    <i class="fas fa-location-dot"></i>
    <span>Baktiraja</span>
</div>
`;
homeHtml = homeHtml.replace(/@php[\s\S]*?@endphp/, '');
homeHtml = homeHtml.replace(/\{\{-- Menampilkan.*?--\}\}/, '');
homeHtml = homeHtml.replace(/@foreach\(\$mapsButtons as \$btn\)[\s\S]*?@endforeach/, mapsHtml);

const footerMatch = appContent.match(/<footer[\s\S]*?<\/footer>/);
let footerHtml = footerMatch ? footerMatch[0] : '';
footerHtml = footerHtml.replace(/\{\{ url\('(.*?)'\) \}\}/g, '$1');
footerHtml = footerHtml.replace(/@php.*?@endphp/, '');
footerHtml = footerHtml.replace(/\{\{ explode.*? \?\? '(.*?)' \}\}/g, '$1');

const htmlTail = `
</body>
</html>
`;

const fullHtml = htmlHead + navbarHtml + homeHtml + footerHtml + htmlTail;

fs.writeFileSync('figma_homepage.html', fullHtml, 'utf8');

console.log('Done generating figma files.');
