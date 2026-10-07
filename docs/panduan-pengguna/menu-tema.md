# Menu & Tema Publik

## Menu Navigasi

Kelola di **CMS Portal → Menu** (`/admin/menus`).

| Kolom | Keterangan |
| --- | --- |
| Label | Teks menu |
| Tautan | URL eksternal atau pilih halaman statis |
| Induk (parent) | Membuat submenu/dropdown bertingkat |
| Urutan | `sort_order` menentukan posisi |
| Aktif | Menu nonaktif tidak tampil |

Perubahan langsung terlihat di header seluruh halaman portal.

## Mengganti Tema

Kelola di **CMS Portal → Tema** (`/admin/themes`).

Tema bawaan:

| Tema | Keterangan |
| --- | --- |
| `default` | Tema resmi bawaan, fitur lengkap |
| `emerald` | Minimalis, modern, responsif |

### Langkah

1. Pilih tema → **Simpan** (setting `active_theme` di tabel `settings`).
2. Lihat hasil di halaman publik. **Tidak perlu** mengubah kode atau build ulang.
3. Kembalikan ke `default` kapan saja bila ada masalah.

::: info
Dashboard admin **tidak terpengaruh** tema — hanya portal publik yang berubah. Detail teknis untuk pengembang: [Sistem Multi-Tema](/panduan-pengembang/multi-tema).
:::

## Pengaturan Situs Terkait

Identitas yang tampil di portal & kop surat diatur di **Pengaturan → Situs**: nama desa, kode desa, kecamatan, kabupaten, provinsi, alamat, telepon, email, judul & tagline situs, serta **logo desa** (dipakai pada PDF & kop).
