# Data Penduduk

Modul **Buku Induk Penduduk** dikelola di menu **Kependudukan → Penduduk** (`/admin/residents`).

## Menambah Penduduk

1. Klik **Tambah Penduduk**.
2. Isi data inti:
   - **NIK** — tepat 16 digit angka, validasi format, disimpan sebagai string.
   - **Nama lengkap**, tempat/tanggal lahir, jenis kelamin, gol. darah.
   - **Agama, status kawin, hubungan keluarga, pendidikan, pekerjaan, kewarganegaraan**.
   - **KK induk** — pilih kartu keluarga tempat penduduk terdaftar.
   - Nama ayah/ibu.
3. **Simpan**.

## Pencarian & Filter

- Pencarian kata kunci mencocokkan **NIK** dan **nama**.
- Filter status penduduk (aktif/mutasi) dan wilayah.

::: tip Tampilan data terbatas
Di daftar, NIK ditampilkan dalam bentuk **termasking** (`320101********0001`) melalui accessor `masked_nik` untuk meminimalkan paparan data pribadi. NIK penuh hanya tampil pada detail kepada pengguna yang berwenang.
:::

## Detail Penduduk

Halaman detail memuat biodata lengkap, relasi keluarga, dan riwayat. Setiap kali detail dibuka, sistem mencatat audit trail **`ResidentViewed`** — siapa membuka data siapa dan kapan.

### Buat Akun Login untuk Warga

Klik **Buat Akun** (`POST /admin/residents/{id}/create-account`) untuk memberikan akses portal layanan mandiri kepada penduduk tersebut. Setelah akun aktif, warga bisa login dan [mengajukan surat sendiri](/panduan-pengguna/portal-warga).

## Mengedit & Menghapus

- **Edit** — perbaiki data; perubahan tercatat di audit log (perubahan oleh user).
- **Hapus** — untuk data ganda. Penduduk yang sudah menjadi kepala keluarga sebaiknya tidak dihapus sebelum kepindahan KK.

## Data Sensitif — Aturan Wajib

- NIK & No KK **tidak pernah** diprint di tempat umum selain dokumen resmi berdisclaimer.
- Jangan menyalin NIK ke spreadsheet yang dibagikan luas.
- Pembatalan/hapus data mengikuti retensi UU PDP — hubungi superadmin untuk kebutuhan penghapusan permanen.
