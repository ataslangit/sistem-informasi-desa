# Template Surat

Menu **E-Surat → Template Surat** (`/admin/letter-templates`) mengelola format surat baku desa.

## Template Bawaan (Seeder)

| Kode | Nama |
| --- | --- |
| `SKTM` | Surat Keterangan Tidak Mampu |
| `SKCK` | Surat Pengantar SKCK |
| `DOMISILI` | Surat Keterangan Domisili |
| `SKU` | Surat Keterangan Usaha |
| `SKPWNI` | Surat Keterangan Pindah (SKPWNI) |

## Komponen Template

- **Kode & Nama** — kode dipakai pada nomor surat.
- **Format Nomor** (`number_format`) — pola placeholder nomor otomatis.
- **Konten (`content_template`)** — badan surat HTML dengan placeholder dinamis.
- **Field tambahan** — isian wajib saat permohonan (mis. SKU: nama usaha, lokasi usaha, sejak kapan).
- **Status aktif** — template nonaktif tidak muncul di form warga.

## Placeholder Konten

Diisi otomatis sistem saat surat dibuat (`LetterService::parseTemplateContent`):

| Placeholder | Isi |
| --- | --- |
| `[NAMA_DESA]`, `[NAMA_KECAMATAN]`, `[NAMA_KABUPATEN]`, `[NAMA_PROVINSI]` | Dari Pengaturan Situs |
| `[NAMA]`, `[NIK]`, `[NO_KK]` | Data pemohon |
| `[TEMPAT_TANGGAL_LAHIR]`, `[JENIS_KELAMIN]`, `[AGAMA]`, `[STATUS_KAWIN]` | Biodata |
| `[PENDIDIKAN]`, `[PEKERJAAN]`, `[KEWARGANEGARAAN]` | Biodata |
| `[ALAMAT]`, `[RT]`, `[RW]`, `[DUSUN]` | Dari KK |
| `[KEPERLUAN]` | Keperluan pemohon |
| `[NOMOR_SURAT]`, `[TANGGAL_SURAT]` | Hasil generate |

Placeholder field tambahan (mis. `[NAMA_USAHA]`) ditambahkan otomatis sesuai definisi field template.

## Placeholder Format Nomor

Format nomor surat (`LetterService::generateLetterNumber`):

```
{klasifikasi}/{nomor:3}/{kode}/Ds/{tahun}
```

| Placeholder | Arti |
| --- | --- |
| `{klasifikasi}` | Kode klasifikasi bidang surat |
| `{nomor}` / `{nomor:N}` | Nomor urut surat disetujui tahun berjalan, padding `N` digit (default 3) |
| `{kode}` | Kode template surat |
| `{bulan}`, `{bulan_romawi}`, `{tahun}` | Tanggal penerbitan |
| `{desa}` | Kode desa (setting `letter_village_code`) |

## Membuat Template Baru

1. Klik **Tambah Template**.
2. Isi kode unik, nama, format nomor, dan konten HTML dengan placeholder di atas.
3. Tambahkan definisi field tambahan bila perlu (nama, label, tipe input, wajib/tidak).
4. **Preview** dulu via tombol *preview* (`/admin/letter-templates/{id}/preview`) sebelum mengaktifkan.
5. Aktifkan template agar tersedia bagi warga.

::: warning
Selalu uji hasil PDF: pastikan placeholder terisi semua (tanda `-` berarti data warga belum lengkap — lengkapi dulu di modul Penduduk).
:::
