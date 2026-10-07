# Mutasi & Laporan Kependudukan

## Mutasi Penduduk

Menu **Kependudukan → Mutasi** (`/admin/mutations`) mencatat perpindahan status penduduk.

### Tipe Mutasi

| Tipe | Label | Data Tambahan |
| --- | --- | --- |
| `birth` | Kelahiran | Tanggal, keterangan |
| `death` | Kematian | Tanggal, alasan |
| `moved_out` | Pindah Keluar | Alamat tujuan (provinsi → desa), alasan, jumlah anggota pindah, nomor referensi |
| `moved_in` | Pindah Datang | Alamat asal, alasan, nomor referensi |

### Langkah Input

1. Klik **Tambah Mutasi**.
2. Pilih penduduk yang bersangkutan.
3. Pilih tipe mutasi; form akan menampilkan isian khusus (mis. alamat tujuan untuk pindah keluar — lengkapi sampai tingkat desa via dropdown API Wilayah).
4. Isi tanggal kejadian, alasan, dan nomor referensi surat pindah (jika ada).
5. **Simpan**.

Setiap entri tercatat di audit trail (`created_by`).

## Laporan Statistik

Menu **Kependudukan → Laporan** (`/admin/reports/population`) menampilkan agregat:

- Jumlah KK & penduduk (aktif).
- Distribusi usia, jenis kelamin, pendidikan, pekerjaan.
- Kelompok rentan & penerima bansos (dari status ekonomi KK).

::: tip
Laporan ini adalah basis data yang dikirim ke SIK pada [Fase Integrasi API](/panduan-pengembang/api-sik). Data yang diolah bersifat **agregat**, bukan individu.
:::

## Dashboard

Halaman `/admin/dashboard` merangkum statistik desa dan **badge antrean** (mis. jumlah surat menunggu verifikasi RT/staf/kades, permohonan PPID baru) agar aparatur tahu pekerjaan menumpuk.
