# Audit Log

Menu **Audit Log** (`/admin/audit-logs`) menampilkan rekam jejak sistem dari paket [`ttpryg/audit-engine`](https://github.com/ttpryg/audit-engine). Menjadi bukti pertanggungjawaban pelayanan dan kepatuhan UU PDP No. 27/2022.

## Yang Tercatat

| Peristiwa | Event (contoh) | Keterangan |
| --- | --- | --- |
| Perubahan data | create/update/delete | Perubahan record oleh user tertentu |
| Melihat data penduduk | `ResidentViewed` | Saat detail biodata dibuka |
| Melihat data KK | `FamilyViewed` | Saat detail KK dibuka |
| Unduh PDF KK | `FamilyPdfDownloaded` | Termasuk identitas pengunduh & waktu |
| Autentikasi & akses | login, akses menu | Jejak siapa masuk kapan |

## Cara Membaca

Halaman daftar: filter tanggal/pencarian, lalu klik baris untuk **detail** — pelaku (user), aksi, objek, waktu, dan perubahan nilai (before/after bila tersedia).

## Untuk Siapa?

- **Superadmin/Kades** — pemantauan dan audit internal.
- **Pengawas/inspektorat** — bukti jejak digital layanan desa.

::: tip Retensi
Berkas PDF KK selalu memuat jejak digital pengunduh pada footer — meski PDF beredar luas, sumber unduhan tetap terlacak.
:::

## Rekomendasi

- Tinjau log mingguan, khususnya event akses data kependudukan oleh akun RT.
- Jangan pernah menghapus record audit secara manual dari database.
- Laporkan anomali (akun tidak dikenal, akses di luar jam layanan) ke superadmin.
