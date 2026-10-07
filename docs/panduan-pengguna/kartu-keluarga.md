# Data Kartu Keluarga

Modul **Buku Induk Kartu Keluarga** dikelola di menu **Kependudukan → Kartu Keluarga** (`/admin/families`).

## Daftar KK

Halaman daftar menampilkan seluruh KK dengan pencarian nomor KK/nama kepala keluarga dan filter **Dusun**.

::: info Hak akses berbasis wilayah
Akun **Ketua RT** hanya melihat KK di RT-nya sendiri (*scoped access*). Jika Anda operator perangkat desa, seluruh data terlihat. Dasar hukum: kebutuhan informasi (*need-to-know*) sesuai UU PDP No. 27/2022.
:::

## Menambah KK

1. Klik **Tambah Kartu Keluarga**.
2. Isi:
   - **Nomor KK** — 16 digit, wajib angka, disimpan sebagai *string* (nol di depan aman).
   - **Kepala Keluarga** — pilih dari data penduduk.
   - **Alamat, RT, RW, Dusun, Kode Pos**.
   - **Status Ekonomi** & **Penerima Bansos** (untuk klasifikasi kelompok rentan).
3. **Simpan**.

## Detail & Anggota Keluarga

Halaman detail menampilkan daftar anggota (`residents` terkait) lengkap dengan status hubungan dalam keluarga. Dari sini Anda bisa:

- Menambah/mengedit anggota — arahkan ke [Data Penduduk](/panduan-pengguna/penduduk).
- **Mencetak Salinan KK** (PDF).

## Mencetak Salinan KK

Klik **Unduh/Cetak PDF** pada KK. Cetakan memuat:

- Kop **Salinan Kartu Keluarga (Register Desa)** — untuk arsip & verifikasi internal desa, **bukan** pengganti KK asli Disdukcapil (Permendagri 47/2016 / UU 24/2013).
- Klausul *disclaimer* resmi berbingkai.
- TTE/QR pengesahan oleh Kepala Desa.
- Jejak digital: *"Diunduh oleh [Nama User] pada [Waktu]"*.

Setiap unduhan tercatat di [Audit Log](/panduan-pengguna/audit-log) dengan event `FamilyPdfDownloaded`.

::: warning Kepatuhan
Jangan membagikan PDF KK ke pihak yang tidak berkepentingan. Akun RT hanya boleh mengunduh KK warga di RT-nya (otomatis dibatasi sistem).
:::

## Mengedit & Menghapus

- **Edit** — ubah data inti KK (kepala keluarga, alamat, status sosial-ekonomi).
- **Hapus** — hanya untuk data ganda/keliru; pastikan seluruh anggota sudah dipindahkan ke KK lain terlebih dahulu.
