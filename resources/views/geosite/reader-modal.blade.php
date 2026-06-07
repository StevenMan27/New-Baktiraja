

<style>
    /* ========== FULL SCREEN MODAL READER ========== */
    #fullReader {
        position: fixed;
        top: 100%;
        left: 0;
        width: 100%;
        height: 100%;
        background: white;
        z-index: 99999;
        transition: top 0.7s cubic-bezier(0.86, 0, 0.07, 1);
        overflow-y: auto;
        visibility: hidden;
    }

    #fullReader.active {
        top: 0;
        visibility: visible;
    }

    .progress-container {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: rgba(0,0,0,0.01);
        z-index: 100;
    }

    .progress-bar {
        height: 4px;
        background: linear-gradient(90deg, #c6a43b 0%, #e8c45a 100%);
        width: 0%;
        transition: width 0.1s ease;
    }

    .reader-nav {
        padding: 20px 5%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: rgba(255,255,255,0.95);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        position: sticky;
        top: 0;
        z-index: 99;
        border-bottom: 1px solid rgba(0,0,0,0.05);
    }

    .reader-logo {
        font-family: 'Playfair Display', serif;
        font-size: 1.35rem;
        font-weight: 700;
        color: #003366;
    }

    .reader-logo span {
        color: #c6a43b;
    }

    .btn-close-reader {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: #f8f9fa;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.3s ease;
        color: #1e293b;
        font-size: 0.85rem;
    }

    .btn-close-reader:hover {
        background: #003366;
        color: white;
        transform: rotate(90deg);
    }

    .reader-content-wrap {
        max-width: 850px;
        margin: 0 auto;
        padding: 40px 30px 60px;
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.6s ease 0.2s;
    }

    #fullReader.active .reader-content-wrap {
        opacity: 1;
        transform: translateY(0);
    }

    .reader-header {
        text-align: center;
        margin-bottom: 40px;
    }

    .reader-category {
        display: inline-block;
        background: rgba(198, 164, 59, 0.08);
        color: #a88a32;
        padding: 5px 16px;
        border-radius: 30px;
        font-size: 0.7rem;
        font-weight: 700;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        margin-bottom: 16px;
    }

    .reader-title-display {
        font-family: 'Playfair Display', serif;
        font-size: 2.5rem;
        line-height: 1.25;
        color: #003366;
        margin: 16px 0 20px;
        font-weight: 700;
    }

    .reader-divider {
        width: 50px;
        height: 2px;
        background: #c6a43b;
        margin: 20px auto;
    }

    .reader-meta {
        display: flex;
        justify-content: center;
        gap: 24px;
        font-size: 0.82rem;
        color: #64748b;
        flex-wrap: wrap;
        padding-bottom: 20px;
        border-bottom: 1px solid #f8f9fa;
        margin-bottom: 10px;
    }

    .reader-meta span {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .reader-hero-img {
        width: 100%;
        height: auto;
        border-radius: 16px;
        margin: 30px 0 40px;
        box-shadow: 0 16px 40px rgba(0,0,0,0.12);
        display: block;
    }

    .reader-hero-img[src=""] {
        display: none;
    }

    .reader-article-body {
        font-family: 'Inter', sans-serif;
        font-size: 1rem;
        line-height: 1.9;
        color: #2c3e50;
        text-align: left;
    }

    .reader-article-body p {
        margin-bottom: 1.4rem;
        text-align: justify;
    }

    .reader-article-body h1,
    .reader-article-body h2,
    .reader-article-body h3,
    .reader-article-body h4 {
        color: #003366;
        font-family: 'Playfair Display', serif;
        font-weight: 700;
        line-height: 1.35;
        margin: 1.8rem 0 0.8rem;
    }

    .reader-article-body h2 {
        font-size: 1.5rem;
        border-left: 3px solid #c6a43b;
        padding-left: 12px;
    }

    .reader-article-body img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin: 20px auto;
        display: block;
    }

    .reader-footer {
        margin: 60px 0 0;
        text-align: center;
        border-top: 1px solid #eee;
        padding-top: 40px;
        display: flex;
        justify-content: center;
        gap: 15px;
    }

    .btn-back-reader {
        background: #003366;
        color: white;
        padding: 12px 32px;
        border-radius: 40px;
        border: none;
        font-size: 12px;
        letter-spacing: 1px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    
    .btn-back-reader:hover {
        background: #c6a43b;
        color: #003366;
        transform: translateY(-3px);
    }
    
    .btn-share-reader {
        background: transparent;
        color: #003366;
        padding: 11px 28px;
        border-radius: 40px;
        border: 2px solid #003366;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    
    .btn-share-reader:hover {
        background: #003366;
        color: white;
        transform: translateY(-3px);
    }
</style>

<div id="fullReader">
    <div class="progress-container">
        <div class="progress-bar" id="myBar"></div>
    </div>
    <div class="reader-nav">
        <div class="reader-logo">Geo<span>Toba</span></div>
        <button class="btn-close-reader" onclick="closeReader()" title="Tutup artikel">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <div class="reader-content-wrap">
        <div class="reader-header">
            <span class="reader-category" id="r-category">BERITA</span>
            <h1 id="r-title" class="reader-title-display"></h1>
            <div class="reader-divider"></div>
            <div class="reader-meta" id="r-meta"></div>
        </div>
        <img id="r-img" src="" class="reader-hero-img" alt="">
        <div id="r-content" class="reader-article-body"></div>
        <div class="reader-footer">
            <button class="btn-back-reader" onclick="closeReader()">
                <i class="fas fa-arrow-left"></i> Kembali
            </button>
            <button class="btn-share-reader" onclick="bagikanArtikel()">
                <i class="fas fa-share-alt"></i> Bagikan Artikel
            </button>
        </div>
    </div>
</div>

<script>
    // Data berita dan informasi tersedia dari halaman geosite
    const beritaData = @json($berita ?? []);
    const informasiData = @json($informasi_dinamis ?? []);

    async function openReader(id, type = 'berita') {
        const dataList = type === 'berita' ? beritaData : informasiData;
        const item = dataList.find(x => x.id === id);
        if (!item) return;

        let imgSrc = '';
        if (item.gambar && item.gambar.trim() !== '') {
            try {
                const gambarArr = JSON.parse(item.gambar);
                const firstImg = Array.isArray(gambarArr) ? gambarArr[0] : gambarArr;
                if (firstImg && firstImg.trim() !== '') {
                    if (firstImg.startsWith('data:image') || firstImg.startsWith('http')) {
                        imgSrc = firstImg;
                    } else {
                        imgSrc = '{{ asset("storage") }}/' + firstImg;
                    }
                }
            } catch (e) {
                if (item.gambar.startsWith('data:image') || item.gambar.startsWith('http')) {
                    imgSrc = item.gambar;
                } else {
                    imgSrc = '{{ asset("storage") }}/' + item.gambar;
                }
            }
        }

        document.getElementById('r-title').innerText = item.judul;
        document.getElementById('r-content').innerHTML = item.konten;
        document.getElementById('r-category').innerText = type.toUpperCase();

        const imgEl = document.getElementById('r-img');
        if (imgSrc) {
            imgEl.src = imgSrc;
            imgEl.style.display = 'block';
        } else {
            imgEl.src = '';
            imgEl.style.display = 'none';
        }

        const tgl = new Date(item.created_at);
        const tanggalFormatted = tgl.toLocaleDateString('id-ID', {
            day: 'numeric', month: 'long', year: 'numeric'
        });
        document.getElementById('r-meta').innerHTML = `
            <span><i class="far fa-calendar"></i> ${tanggalFormatted}</span>
            <span><i class="far fa-user"></i> ${item.penulis || 'Admin GeoToba'}</span>
            <span><i class="far fa-eye"></i> <span id="modalViews">${(item.views || 0).toLocaleString()}</span> dibaca</span>
        `;

        const reader = document.getElementById('fullReader');
        reader.classList.add('active');
        document.body.style.overflow = 'hidden';
        reader.scrollTop = 0;
        document.getElementById('myBar').style.width = '0%';

        // Increment view count via API
        try {
            const apiEndpoint = type === 'berita' ? '/api/berita/' : '/api/informasi/';
            const response = await fetch(apiEndpoint + id + '/view', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            });
            const data = await response.json();
            if (data.success) {
                const modalViews = document.getElementById('modalViews');
                if (modalViews) modalViews.innerText = data.views.toLocaleString();
            }
        } catch (err) {
            console.error('Gagal memperbarui jumlah pembaca:', err);
        }
    }

    function closeReader() {
        const reader = document.getElementById('fullReader');
        reader.classList.remove('active');
        document.body.style.overflow = 'auto';
    }

    function bagikanArtikel() {
        const title = document.getElementById('r-title').innerText;
        const url   = window.location.href;

        if (navigator.share) {
            navigator.share({
                title: title,
                text: 'Baca artikel menarik seputar GeoToba terbaru ini:',
                url: url
            }).catch(err => console.log('Share dibatalkan oleh pengguna'));
        } else {
            navigator.clipboard.writeText(url).then(() => {
                alert('Tautan artikel berhasil disalin ke clipboard!');
            }).catch(() => {
                alert('Salin tautan berikut: ' + url);
            });
        }
    }

    const readerElement = document.getElementById('fullReader');
    if (readerElement) {
        readerElement.addEventListener('scroll', function () {
            const winScroll  = readerElement.scrollTop;
            const height     = readerElement.scrollHeight - readerElement.clientHeight;
            const scrolled   = height > 0 ? (winScroll / height) * 100 : 0;
            const progressBar = document.getElementById('myBar');
            if (progressBar) {
                progressBar.style.width = scrolled + '%';
            }
        });
    }

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            if (readerElement && readerElement.classList.contains('active')) {
                closeReader();
            }
        }
    });
</script>
