# Sistem Multi-Tema

Arsitektur multi-tema adalah fitur inti SiDesa: tampilan portal publik dapat diganti sepenuhnya tanpa menyentuh dashboard admin maupun kode backend.

## Lokasi File

| Jenis | Path |
| --- | --- |
| Blade tema publik | `resources/views/themes/{nama_tema}/` |
| Aset tema (CSS/JS/gambar) | `public/themes/{nama_tema}/` |
| Blade admin (statis, TIDAK di-tema) | `resources/views/admin/` |
| Aset admin | `public/assets_admin/` |

Tema bawaan: **`default`** dan **`emerald`**.

## Helper Wajib

Helper didefinisikan di `app/Helpers/theme.php` (di-autoload otomatis via `composer.json`):

```php
// URL aset statis tema aktif — WAJIB dipakai di Blade tema, bukan asset()
echo theme_asset('css/style.css');
// → http://.../themes/emerald/css/style.css

// Render view milik tema aktif, fallback otomatis ke tema default
return theme_view('ppid.index');

// Nama tema aktif (dari tabel settings: active_theme)
$theme = active_theme();

// Layout master tema
$layout = theme_layout(); // themes.{tema}.layouts.app
```

::: warning Jangan lakukan ini
Jangan memanggil `asset('themes/default/...')` secara hard-coded — link akan patah ketika admin mengganti tema. Selalu gunakan `theme_asset()`.
:::

## Struktur Tema Minimal

```
resources/views/themes/{nama_tema}/
├── layouts/
│   └── app.blade.php        # Layout master (extend dari theme_layout())
├── partials/
│   ├── header.blade.php     # Nav — pakai public_header_menus()
│   └── footer.blade.php
├── home.blade.php
├── articles/  pages/  galleries/  ppid/  ...
public/themes/{nama_tema}/
├── css/  js/  images/
```

## Membuat Tema Baru

1. Salin tema default sebagai kerangka:

```bash
cp -r resources/views/themes/default resources/views/themes/harapan
cp -r public/themes/default public/themes/harapan
```

2. Sesuaikan Blade & aset. Setiap view yang **tidak** tersedia otomatis jatuh ke `themes.default.*` (fallback), jadi Anda bisa bertahap.

3. Daftarkan/fungsikan aset dengan `theme_asset()`.

4. Aktifkan tema melalui dashboard: **Admin → CMS Portal → Tema** (`/admin/themes`), atau ubah setting `active_theme`.

5. Uji seluruh halaman publik: berita, halaman statis, galeri, APBDes, peta, PPID, dan form permohonan.

## Daftar View Publik yang Didukung

Saat ini tema menyediakan: `home`, artikel (`articles.index/show/announcements/category`), `pages.show`, galeri, APBDes, peta, PPID (`ppid.index`, dokumen, permohonan, tracking, keberatan), auth, serta portal warga.

## Kontrak untuk Desainer Pihak Ketiga

- Hanya **Blade + CSS/JS biasa** — tanpa framework frontend wajib.
- Jangan ubah file di luar folder tema sendiri.
- Nama tema = nama folder (huruf kecil, tanpa spasi).
- Uji fallback: hapus sementara satu view dan pastikan halaman tetap tampil memakai tema default.
