const fs = require('fs');
const path = require('path');
const file = 'resources/views/admin/profil/edit.blade.php';
let content = fs.readFileSync(file, 'utf8');

const regex = /<hr class="my-4">\s*<h5 class="mb-3">Bagian Deskripsi 2[\s\S]*?<\/div>\s*<\/div>/;

const newHTML = `
                @for($i = 2; $i <= 5; $i++)
                @php
                    $judulKey = "deskripsi_${i}_judul";
                    $teksKey = "deskripsi_${i}_teks";
                    $gambarKey = "deskripsi_${i}_gambar";
                @endphp
                <hr class="my-4">
                <h5 class="mb-3">Bagian Deskripsi {{ $i }} (Dengan Gambar)</h5>

                <div class="col-md-12 mb-3">
                    <label class="form-label fw-bold">Judul Deskripsi {{ $i }}</label>
                    <input type="text" name="{{ $judulKey }}" class="form-control" value="{{ old($judulKey, $profil->$judulKey) }}">
                </div>

                <div class="col-md-12 mb-3">
                    <label class="form-label fw-bold">Teks Deskripsi {{ $i }}</label>
                    <textarea name="{{ $teksKey }}" class="form-control" rows="4">{{ old($teksKey, $profil->$teksKey) }}</textarea>
                </div>

                <div class="col-md-12 mb-3">
                    <label class="form-label fw-bold">Gambar Deskripsi {{ $i }}</label>
                    <input type="file" name="{{ $gambarKey }}[]" class="form-control" accept="image/*" multiple>
                    <small class="text-muted">Bisa upload lebih dari satu gambar. Biarkan kosong jika tidak ingin mengubah.</small>
                    @if($profil->$gambarKey && is_array($profil->$gambarKey))
                        <div class="mt-2 d-flex gap-2 flex-wrap">
                            @foreach($profil->$gambarKey as $img)
                                <img src="{{ asset('storage/' . $img) }}" width="150" height="100" class="rounded border" style="object-fit:cover;">
                            @endforeach
                        </div>
                    @endif
                </div>
                @endfor
`;

content = content.replace(regex, newHTML.trim());
fs.writeFileSync(file, content);
console.log('Edit view updated.');
