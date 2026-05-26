const cdm = `classDiagram
    class Admin {
        Nama
        Email
        Password
    }
    class KontenGeosite {
        <<abstract>>
        Geosite
        Status
    }
    class Berita {
        Judul
        Slug
        Konten
        Gambar
        Penulis
        Views
    }
    class Informasi {
        Judul
        Slug
        Konten
        Gambar
        Urutan
    }
    class Galeri {
        Judul
        Deskripsi
        Gambar
        Lokasi
        Tanggal Foto
    }
    class Fasilitas {
        Nama
        Deskripsi
        Harga
        Gambar
        Urutan
    }
    class Penginapan {
        Nama
        Deskripsi
        Harga
        Kontak
        Gambar
        Urutan
    }
    class UMKM {
        Nama
        Deskripsi
        Lokasi
        Kontak
        Gambar
        Urutan
    }
    
    KontenGeosite <|-- Berita
    KontenGeosite <|-- Informasi
    KontenGeosite <|-- Galeri
    KontenGeosite <|-- Fasilitas
    KontenGeosite <|-- Penginapan
    KontenGeosite <|-- UMKM
    Admin "1" --> "*" KontenGeosite : Mengelola`;

const erd = `erDiagram
    users ||--o{ berita : "Manage"
    users ||--o{ informasi : "Manage"
    users ||--o{ galeris : "Manage"
    users ||--o{ fasilitas : "Manage"
    users ||--o{ penginapan : "Manage"
    users ||--o{ umkm : "Manage"

    users {
        string name
        string email
    }
    berita {
        string judul
        string slug
        string geosite
    }
    informasi {
        string judul
        string slug
        string geosite
    }
    galeris {
        string judul
        string lokasi
        string geosite
    }
    fasilitas {
        string nama
        string harga
        string geosite
    }
    penginapan {
        string nama
        string harga
        string geosite
    }
    umkm {
        string nama
        string lokasi
        string geosite
    }`;

const pdm = `erDiagram
    users {
        bigint id PK
        varchar name
        varchar email
        timestamp email_verified_at
        varchar password
        varchar remember_token
        timestamp created_at
        timestamp updated_at
    }

    berita {
        bigint id PK
        varchar judul
        varchar slug
        longtext konten
        longtext gambar
        varchar penulis
        int views
        tinyint status
        varchar geosite
        timestamp created_at
        timestamp updated_at
    }

    informasi {
        bigint id PK
        varchar judul
        varchar slug
        longtext konten
        longtext gambar
        int urutan
        tinyint status
        varchar geosite
        timestamp created_at
        timestamp updated_at
    }

    galeris {
        bigint id PK
        varchar geosite
        varchar judul
        text deskripsi
        longblob gambar
        timestamp created_at
        timestamp updated_at
        varchar lokasi
        date tanggal_foto
        tinyint status
    }

    fasilitas {
        bigint id PK
        varchar nama
        text deskripsi
        longtext gambar
        varchar harga
        tinyint status
        varchar geosite
        int urutan
        timestamp created_at
        timestamp updated_at
    }

    penginapan {
        bigint id PK
        varchar nama
        text deskripsi
        longtext gambar
        varchar harga
        varchar kontak
        tinyint status
        varchar geosite
        int urutan
        timestamp created_at
        timestamp updated_at
    }

    umkm {
        bigint id PK
        varchar nama
        text deskripsi
        longtext gambar
        varchar lokasi
        varchar kontak
        tinyint status
        varchar geosite
        int urutan
        timestamp created_at
        timestamp updated_at
    }`;

const base64Encode = (str) => {
    return Buffer.from(JSON.stringify({ code: str, mermaid: { theme: 'default' } })).toString('base64');
};

console.log("CDM:");
console.log("https://mermaid.ink/img/pako:" + require('zlib').deflateSync(JSON.stringify({code: cdm})).toString('base64').replace(/\+/g, '-').replace(/\//g, '_'));

console.log("ERD:");
console.log("https://mermaid.ink/img/pako:" + require('zlib').deflateSync(JSON.stringify({code: erd})).toString('base64').replace(/\+/g, '-').replace(/\//g, '_'));

console.log("PDM:");
console.log("https://mermaid.ink/img/pako:" + require('zlib').deflateSync(JSON.stringify({code: pdm})).toString('base64').replace(/\+/g, '-').replace(/\//g, '_'));
