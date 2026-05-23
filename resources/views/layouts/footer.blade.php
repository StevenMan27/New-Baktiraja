<!-- FOOTER PREMIUM -->
<footer class="footer" data-aos="fade-up" data-aos-anchor="#footer-trigger">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-12 mb-4 footer-col">
                <h5 class="footer-title">Geo<span style="color: #c6a43b;">Toba</span></h5>
                <p style="font-size: 0.85rem; color: rgba(255,255,255,0.7); line-height: 1.6;">
                    {{ app()->getLocale() == 'id' ? 'Sistem Informasi Geosite Danau Toba - Menyajikan informasi lengkap tentang keindahan geologi dan budaya Batak di kawasan Danau Toba.' : 'Geosite Toba Information System - Presents complete information about the geological beauty and Batak culture in the Lake Toba area.' }}
                </p>
                <div class="social-icons">
                    <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-youtube"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-tiktok"></i></a>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-sm-6 col-6 mb-4 footer-col">
                <h5 class="footer-title">{{ app()->getLocale() == 'id' ? 'Tautan' : 'Quick Links' }}</h5>
                <ul class="footer-links">
                    <li><a href="{{ url('/') }}"><i class="fas fa-chevron-right"></i> {{ app()->getLocale() == 'id' ? 'Beranda' : 'Home' }}</a></li>
                    <li><a href="{{ url('/informasi') }}"><i class="fas fa-chevron-right"></i> {{ app()->getLocale() == 'id' ? 'Informasi' : 'Information' }}</a></li>
                    <li><a href="{{ url('/galeri') }}"><i class="fas fa-chevron-right"></i> {{ app()->getLocale() == 'id' ? 'Galeri' : 'Gallery' }}</a></li>
                    <li><a href="{{ url('/berita') }}"><i class="fas fa-chevron-right"></i> {{ app()->getLocale() == 'id' ? 'Berita' : 'News' }}</a></li>
                    <li><a href="{{ url('/kontak') }}"><i class="fas fa-chevron-right"></i> {{ app()->getLocale() == 'id' ? 'Kontak' : 'Contact' }}</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 col-6 mb-4 footer-col">
                <h5 class="footer-title">{{ app()->getLocale() == 'id' ? 'Destinasi' : 'Destinations' }}</h5>
                <ul class="footer-links">
                    <li><a href="{{ url('/destinasi/alam') }}"><i class="fas fa-chevron-right"></i> {{ app()->getLocale() == 'id' ? 'Destinasi Alam' : 'Natural Destinations' }}</a></li>
                    <li><a href="{{ url('/destinasi/buatan') }}"><i class="fas fa-chevron-right"></i> {{ app()->getLocale() == 'id' ? 'Destinasi Buatan' : 'Man-made Destinations' }}</a></li>
                    <li><a href="{{ url('/destinasi/budaya') }}"><i class="fas fa-chevron-right"></i> {{ app()->getLocale() == 'id' ? 'Destinasi Budaya' : 'Cultural Destinations' }}</a></li>
                    <li><a href="{{ url('/destinasi') }}"><i class="fas fa-chevron-right"></i> {{ app()->getLocale() == 'id' ? 'Semua Destinasi' : 'All Destinations' }}</a></li>
                </ul>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-12 mb-4 footer-col">
                <h5 class="footer-title">{{ app()->getLocale() == 'id' ? 'Kontak' : 'Contact Us' }}</h5>
                <ul class="footer-contact">
                    <li><i class="fas fa-map-marker-alt"></i> {{ app()->getLocale() == 'id' ? 'Danau Toba, Sumatera Utara' : 'Lake Toba, North Sumatra' }}</li>
                    <li><i class="fas fa-phone"></i> +62 812 3456 7890</li>
                    <li><i class="fas fa-envelope"></i> info@geotoba.com</li>
                    <li><i class="fas fa-clock"></i> {{ app()->getLocale() == 'id' ? 'Senin - Minggu : 08.00 - 18.00 WIB' : 'Monday - Sunday : 08:00 - 18:00 WIB' }}</li>
                </ul>
            </div>
        </div>
        <div class="copyright">
            <p>&copy; 2026 GeoToba - Geopark Danau Toba. {{ app()->getLocale() == 'id' ? 'Hak Cipta dilindungi.' : 'All rights reserved.' }}</p>
        </div>
    </div>
</footer>
