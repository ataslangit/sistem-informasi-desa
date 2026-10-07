# Panduan Pengguna (Operator & Admin Desa)

Bagian ini adalah panduan langkah-demi-langkah untuk **aparatur desa** yang mengoperasikan SiDesa sehari-hari: operator pelayanan, Kepala Desa, Ketua RT, dan pengelola konten portal.

## Siapa yang Menggunakan Apa?

| Peran | Login ke | Tugas Utama |
| --- | --- | --- |
| Superadmin | `/admin` | Konfigurasi sistem, pengguna, role |
| Kepala Desa | `/admin` | Monitoring, persetujuan & TTE surat |
| Perangkat Desa (operator) | `/admin` | Input KK/penduduk, proses surat, kelola konten |
| Ketua RT | `/admin` | Verifikasi surat warga di wilayahnya |
| Warga | `/login` → portal warga | Ajukan surat mandiri, pantau status |

## Peta Modul Dashboard (`/admin`)

| Menu | Isi |
| --- | --- |
| Dashboard | Statistik & badge antrean |
| Kependudukan | Kartu Keluarga, Penduduk, Mutasi, Laporan |
| E-Surat | Permohonan surat, Template, Pengaturan TTE |
| CMS Portal | Artikel, Kategori, Halaman, Menu, Galeri, Tema |
| APBDes | Anggaran & item belanja |
| Peta & Aset | Batas wilayah, fasilitas/aset desa |
| PPID | Dokumen, Permohonan, Keberatan, Pengaturan |
| Pengaturan | Situs, Pengguna & Role, Audit Log |

## Alur Kerja Pelayanan Sehari-hari

1. Warga mengajukan surat (portal `/citizen` atau manual oleh operator).
2. **Ketua RT** memverifikasi di menu Permohonan Surat.
3. **Perangkat Desa** memeriksa berkas & memverifikasi.
4. **Kepala Desa** menyetujui + TTE elektronik.
5. Dokumen PDF dengan QR Code diunduh/dicetak; warga dapat memindai QR untuk verifikasi keaslian.

Mulai dari: [Masuk & Akun Pengguna](/panduan-pengguna/masuk-akun).
