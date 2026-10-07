# Berkontribusi

Kontribusi untuk pengembangan SiDesa sangat terbuka — bug fix, fitur, tema baru, maupun dokumentasi.

## Alur Kerja

1. *Fork* dan *clone* repositori.
2. Buat branch fitur dari `develop`:

```bash
git checkout develop
git checkout -b feature/fitur-keren
```

3. Kembangkan perubahan. Patuhi [konvensi kode](/panduan-pengembang/struktur-proyek#konvensi-kode) dan [AGENTS.md](https://github.com/TIMA-Codecraft/sidesa/blob/develop/AGENTS.md).
4. Jalankan quality gate:

```bash
./vendor/bin/pint
php artisan test
```

5. *Commit* dengan pesan deskriptif berbahasa Indonesia, *push*, lalu buat **Pull Request** ke `develop`.

## Pedoman PR

- Satu topik per PR; hindari mencampur refactor besar dengan fitur baru.
- Sertakan deskripsi: masalah, solusi, langkah uji.
- Perubahan yang memengaruhi skema database wajib menyertakan *migration* (bukan edit migration lama yang sudah jalan di produksi).
- Perubahan UI publik wajib diuji pada **kedua tema** (`default` dan `emerald`).
- Perubahan yang menyentuh data PII/kepatuhan hukum harus menunjukkan dampaknya pada audit log & masking.

## Menambah Fitur Admin Baru

1. Route di `routes/web.php` dalam grup `/admin` (middleware `['auth', 'admin']`).
2. Controller di `app/Http/Controllers/Admin/`.
3. View di `resources/views/admin/`.
4. Tambahkan entri sidebar di `resources/views/admin/layouts/app.blade.php`.
5. Permission baru (jika perlu) di `RoleAndPermissionSeeder` + matriks di `/admin/roles`.
6. Test di `tests/Feature/`.

## Dokumentasi

Dokumentasi ini ditulis dalam Markdown + [VitePress](https://vitepress.dev). Panduan cara menjalankannya: [Dokumentasi Ini](/panduan-pengembang/docs-setup). Setiap perubahan fitur besar harus memperbarui halaman terkait.

## Lisensi

Kontribusi didistribusikan di bawah [GPL-3.0-or-later](https://github.com/TIMA-Codecraft/sidesa/blob/develop/LICENSE).
