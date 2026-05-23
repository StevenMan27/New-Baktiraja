import os
import glob
import re

files = glob.glob('resources/views/geosite/*.blade.php')

old_grid_css = r'.berita-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 25px; }'
new_grid_css = r'.berita-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; }'

old_img_css = r'.berita-img { height: 200px; overflow: hidden; }'
new_img_css = r'.berita-img { height: 160px; overflow: hidden; }'

old_info_html = r'''<div style="margin-top: 40px; display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;">
    @foreach( as )
    <div style="background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.08); padding: 20px;">
        @if(->gambar)
            <img src="{{ ->gambar && !str_starts_with(->gambar, 'data:') ? asset('storage/' . ->gambar) : ->gambar }}" style="width: 100%; height: 200px; object-fit: cover; border-radius: 8px; margin-bottom: 15px;">
        @endif
        <h4 style="color: var(--bi-blue); margin-bottom: 10px; font-family: 'Cormorant Garamond', serif; font-size: 1.2rem;">{{ ->judul }}</h4>
        <div style="font-size: 0.85rem; color: #555; line-height: 1.6;">{!! ->konten !!}</div>
    </div>
    @endforeach
</div>'''

new_info_html = r'''<div class="berita-grid" style="margin-top: 25px;">
    @foreach( as )
    <div class="berita-card" data-aos="zoom-in">
        @if(->gambar)
        <div class="berita-img">
            <img src="{{ ->gambar && !str_starts_with(->gambar, 'data:') ? asset('storage/' . ->gambar) : ->gambar }}" alt="{{ ->judul }}">
        </div>
        @endif
        <div class="berita-content">
            <h4>{{ ->judul }}</h4>
            <div class="berita-excerpt">{!! ->konten !!}</div>
        </div>
    </div>
    @endforeach
</div>'''

for file in files:
    with open(file, 'r', encoding='utf-8') as f:
        content = f.read()
        
    content = content.replace(old_grid_css, new_grid_css)
    content = content.replace(old_img_css, new_img_css)
    content = content.replace(old_info_html, new_info_html)
    
    with open(file, 'w', encoding='utf-8') as f:
        f.write(content)

print("Replaced in all 8 files successfully!")
