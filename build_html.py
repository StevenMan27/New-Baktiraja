import re
import os

app_blade_path = 'resources/views/layouts/app.blade.php'
home_blade_path = 'resources/views/pages/home.blade.php'

with open(app_blade_path, 'r', encoding='utf-8') as f:
    app_content = f.read()

with open(home_blade_path, 'r', encoding='utf-8') as f:
    home_content = f.read()

app_style_match = re.search(r'<style>(.*?)</style>', app_content, re.DOTALL)
app_css = app_style_match.group(1) if app_style_match else ''

home_style_match = re.search(r'<style>(.*?)</style>', home_content, re.DOTALL)
home_css = home_style_match.group(1) if home_style_match else ''

total_css = app_css + '\n' + home_css
total_css = re.sub(r'\{\{\s*!empty.*?asset\(\"storage/\"\s*\.\s*\$homepage->.*?\)\s*:\s*\"(.*?)\"\s*\}\}', r'\1', total_css)

with open('figma_homepage.css', 'w', encoding='utf-8') as f:
    f.write(total_css)

html_head = '''<!DOCTYPE html>
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
'''

navbar_match = re.search(r'<nav.*?</nav>', app_content, re.DOTALL)
navbar_html = navbar_match.group(0) if navbar_match else ''
navbar_html = re.sub(r'\{\{ url\(\'(.*?)\'\) \}\}', r'\1', navbar_html)
navbar_html = re.sub(r'\{\{ request\(\)->routeIs.*? \? \'active\' : \'\' \}\}', r'', navbar_html)
navbar_html = re.sub(r'\{\{ asset\(\'(.*?)\'\) \}\}', r'\1', navbar_html)

home_html = re.sub(r'<style>.*?</style>', '', home_content, flags=re.DOTALL)
home_html = re.sub(r'@extends.*?\n', '', home_html)
home_html = re.sub(r'@section.*?\n', '', home_html)
home_html = re.sub(r'@endsection', '', home_html)

home_html = re.sub(r'\{\{ \$homepage->.*? \?\? \'(.*?)\' \}\}', r'\1', home_html)
home_html = re.sub(r'\{\!\! \$homepage->.*? \?\? \'(.*?)\' \!\!\}\}', r'\1', home_html)

destinasi_html = '''
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
'''

home_html = re.sub(r'@if\(isset.*?\)[\s\S]*?@foreach\(\$homepage->destinasis as \$index => \$dest\)[\s\S]*?@endforeach[\s\S]*?@endif', destinasi_html, home_html)

maps_html = '''
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
'''
home_html = re.sub(r'@php[\s\S]*?@endphp', '', home_html)
home_html = re.sub(r'\{\{-- Menampilkan.*?--\}\}', '', home_html)
home_html = re.sub(r'@foreach\(\$mapsButtons as \$btn\)[\s\S]*?@endforeach', maps_html, home_html)

footer_match = re.search(r'<footer.*?>[\s\S]*?</footer>', app_content)
footer_html = footer_match.group(0) if footer_match else ''
footer_html = re.sub(r'\{\{ url\(\'(.*?)\'\) \}\}', r'\1', footer_html)
footer_html = re.sub(r'@php.*?@endphp', '', footer_html)
footer_html = re.sub(r'\{\{ explode.*? \?\? \'(.*?)\' \}\}', r'\1', footer_html)

html_tail = '''
</body>
</html>
'''

full_html = html_head + navbar_html + home_html + footer_html + html_tail

with open('figma_homepage.html', 'w', encoding='utf-8') as f:
    f.write(full_html)

print("Generated figma_homepage.html and figma_homepage.css successfully!")
