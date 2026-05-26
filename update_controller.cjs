const fs = require('fs');
const path = require('path');
const file = 'app/Http/Controllers/Admin/ProfilGeositeController.php';
let content = fs.readFileSync(file, 'utf8');

// 1. Update validation
const validationRegex = /'deskripsi_2_gambar\.\*' => 'nullable\|image\|mimes:jpeg,png,jpg,webp\|max:4096',/;
const extraValidation = `
            'deskripsi_2_gambar.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'deskripsi_3_judul' => 'nullable|string|max:255',
            'deskripsi_3_teks' => 'nullable|string',
            'deskripsi_3_gambar.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'deskripsi_4_judul' => 'nullable|string|max:255',
            'deskripsi_4_teks' => 'nullable|string',
            'deskripsi_4_gambar.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'deskripsi_5_judul' => 'nullable|string|max:255',
            'deskripsi_5_teks' => 'nullable|string',
            'deskripsi_5_gambar.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
`.trim();
content = content.replace(validationRegex, extraValidation);

// 2. Update except array
content = content.replace(/'deskripsi_2_gambar', 'tags'\]\);/, `'deskripsi_2_gambar', 'deskripsi_3_gambar', 'deskripsi_4_gambar', 'deskripsi_5_gambar', 'tags']);`);

// 3. Update File Handling logic
const imageHandlingSnippet = `
        // Handle Deskripsi 2 Gambar Upload
        if ($request->hasFile('deskripsi_2_gambar')) {
            if ($profil && is_array($profil->deskripsi_2_gambar)) {
                foreach ($profil->deskripsi_2_gambar as $oldPath) {
                    if ($oldPath && !str_starts_with($oldPath, 'data:')) Storage::disk('public')->delete($oldPath);
                }
            }
            $paths = [];
            foreach ($request->file('deskripsi_2_gambar') as $image) $paths[] = $image->store('profil', 'public');
            $data['deskripsi_2_gambar'] = $paths;
        }

        if ($request->hasFile('deskripsi_3_gambar')) {
            if ($profil && is_array($profil->deskripsi_3_gambar)) {
                foreach ($profil->deskripsi_3_gambar as $oldPath) {
                    if ($oldPath && !str_starts_with($oldPath, 'data:')) Storage::disk('public')->delete($oldPath);
                }
            }
            $paths = [];
            foreach ($request->file('deskripsi_3_gambar') as $image) $paths[] = $image->store('profil', 'public');
            $data['deskripsi_3_gambar'] = $paths;
        }

        if ($request->hasFile('deskripsi_4_gambar')) {
            if ($profil && is_array($profil->deskripsi_4_gambar)) {
                foreach ($profil->deskripsi_4_gambar as $oldPath) {
                    if ($oldPath && !str_starts_with($oldPath, 'data:')) Storage::disk('public')->delete($oldPath);
                }
            }
            $paths = [];
            foreach ($request->file('deskripsi_4_gambar') as $image) $paths[] = $image->store('profil', 'public');
            $data['deskripsi_4_gambar'] = $paths;
        }

        if ($request->hasFile('deskripsi_5_gambar')) {
            if ($profil && is_array($profil->deskripsi_5_gambar)) {
                foreach ($profil->deskripsi_5_gambar as $oldPath) {
                    if ($oldPath && !str_starts_with($oldPath, 'data:')) Storage::disk('public')->delete($oldPath);
                }
            }
            $paths = [];
            foreach ($request->file('deskripsi_5_gambar') as $image) $paths[] = $image->store('profil', 'public');
            $data['deskripsi_5_gambar'] = $paths;
        }
`;

// Replace the old deskripsi_2_gambar handler block
const fileRegex = /\/\/ Handle Deskripsi 2 Gambar Upload[\s\S]*?\$data\['deskripsi_2_gambar'\] = \$paths;\s*\}/;
content = content.replace(fileRegex, imageHandlingSnippet.trim());

fs.writeFileSync(file, content);
console.log('Controller updated.');
