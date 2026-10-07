# Portal Layanan Mandiri Warga

Portal warga memungkinkan warga **mengajukan surat tanpa datang ke kantor desa**.

## Untuk Warga

### 1. Registrasi & Login

- Daftar di `/login` → **Daftar Akun** (`/register`).
- Isi data diri + centang **persetujuan pemrosesan data pribadi** (wajib, UU PDP No. 27/2022).
- Akun diverifikasi desa (opsional: dibuatkan langsung oleh operator lewat menu Penduduk → *Buat Akun*).

### 2. Ajukan Surat

1. Login → menu **Layanan Surat** (`/citizen/letters`).
2. Klik **Ajukan Surat Baru** (`/citizen/letters/create`).
3. Pilih **template surat yang aktif** (SKTM, SKCK, Domisili, SKU, SKPWNI, dll.).
4. Isi field tambahan yang diminta (mis. SKU: data usaha).
5. **Kirim** — permohonan masuk status `pending_rt`.

### 3. Pantau Status

Di daftar permohonan, status tampil real-time:

| Status | Arti |
| --- | --- |
| Menunggu Verifikasi RT/RW | Menunggu Ketua RT |
| Menunggu Verifikasi Staf Desa | RT sudah verifikasi, menunggu operator |
| Menunggu TTE Kades | Menunggu persetujuan Kepala Desa |
| Selesai & Disahkan | Surat siap diunduh |
| Ditolak | Lihat alasan penolakan |

### 4. Unduh PDF

Setelah **Selesai & Disahkan**, klik **Unduh PDF** (`/citizen/letters/{id}/pdf`). Dokumen berisi QR verifikasi — bisa ditunjukkan ke pihak yang menerima surat.

## Untuk Operator Desa

- **Membuatkan permohonan atas nama warga**: gunakan menu admin [Permohonan Surat](/panduan-pengguna/permohonan-surat) — data pemohon diambil dari Buku Induk.
- **Memberi akses**: buatkan akun lewat Penduduk → *Buat Akun*, atau ACC registrasi mandiri.
- **Memantau antrean**: badge dashboard menunjukkan jumlah permohonan per status.

## Privasi & Keamanan

- Warga hanya melihat **permohonannya sendiri** (query berdasarkan `resident_id`/user terkait).
- Data pribadi pemohon tidak pernah diekspos ke warga lain.
- Aktivitas pengunduhan tercatat di audit trail desa.
