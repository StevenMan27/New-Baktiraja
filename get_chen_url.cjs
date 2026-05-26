const chenErd = `graph TD
    %% Entitas (Persegi Panjang)
    Admin[USERS]
    Berita[BERITA]
    Informasi[INFORMASI]
    Galeri[GALERIS]
    Fasilitas[FASILITAS]
    Penginapan[PENGINAPAN]
    Umkm[UMKM]

    %% Relasi (Belah Ketupat)
    Rel1{Mengelola}

    %% Kardinalitas
    Admin ---|1| Rel1
    Rel1 ---|N| Berita
    Rel1 ---|N| Informasi
    Rel1 ---|N| Galeri
    Rel1 ---|N| Fasilitas
    Rel1 ---|N| Penginapan
    Rel1 ---|N| Umkm

    %% Atribut Admin (Oval)
    A_id([_id_])
    A_name([name])
    A_email([email])
    Admin --- A_id
    Admin --- A_name
    Admin --- A_email

    %% Atribut Konten (Oval)
    B_id([_id_])
    B_judul([judul/nama])
    B_geosite([geosite])
    
    Berita --- B_id
    Berita --- B_judul
    Berita --- B_geosite
    
    Umkm --- B_id
    Umkm --- B_judul
    Umkm --- B_geosite
    
    %% Catatan: Untuk menjaga agar diagram tidak terlalu berantakan, 
    %% beberapa entitas diwakilkan atribut intinya saja
`;

const base64Encode = (str) => {
    return Buffer.from(JSON.stringify({ code: str, mermaid: { theme: 'default' } })).toString('base64');
};

console.log("https://mermaid.ink/img/pako:" + require('zlib').deflateSync(JSON.stringify({code: chenErd})).toString('base64').replace(/\+/g, '-').replace(/\//g, '_'));
