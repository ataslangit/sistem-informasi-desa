# Artikel, Halaman & Galeri

Modul CMS dikelola di menu **CMS Portal** pada dashboard admin. Semua konten tampil di portal publik sesuai tema aktif.

## Artikel / Berita (`/admin/articles`)

Kelola berita, pengumuman, dan artikel desa.

### Field Utama

- **Judul, slug, konten** (WYSIWYG).
- **Kategori & tag** (`/admin/categories`).
- **Status**: draft / dipublikasikan.
- **Sampul — mode ganda (Dual-Mode)**:
  - Unggah berkas: `cover_image_file` (jpeg/png/jpg/webp/svg, maks 3 MB), disimpan di `storage/app/public/articles/`, diakses via `/storage/...`.
  - **atau** URL gambar eksternal: `cover_image` (maks 500 karakter).

### Di Portal Publik

- Daftar: `/berita` — arsip lengkap.
- Detail: `/berita/{slug}`.
- Pengumuman: `/pengumuman`.
- Per kategori: `/kategori/{slug}`.

::: tip
Saat mengganti sampul dengan berkas baru, berkas lama **otomatis dihapus** dari disk. Begitu pula saat artikel dihapus.
:::

## Halaman Statis (`/admin/pages`)

Untuk profil desa, visi-misi, struktur organisasi, dll. Ditampilkan di `/halaman/{slug}`. Konten melewati *sanitized typography rendering* — aman dari HTML berbahaya.

## Galeri (`/admin/galleries`)

1. Buat album (judul, slug, deskripsi, sampul — dual-mode seperti artikel).
2. Buka album → **Tambah Foto** (`image_file` maks 5 MB atau `image_url`).
3. Tampil di `/galeri` dan `/galeri/{slug}`.

Foto lama otomatis dibersihkan saat diganti/dihapus.

## Menu Navigasi (`/admin/menus`)

Kelola menu header portal: label, tautan (ke halaman statis atau rute), urutan, status aktif, serta **submenu bertingkat** (dropdown). Menu dibaca oleh helper `public_header_menus()` pada tema.

## Pengumuman vs Berita

Pengumuman adalah artikel dengan penanda khusus sehingga tampil terpisah di `/pengumuman` — gunakan untuk info resmi (bencana, jadwal layanan, rapat).
