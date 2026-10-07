# PPID Desa

Layanan **Pejabat Pengelola Informasi dan Dokumentasi (PPID)** mengimplementasikan standar keterbukaan informasi publik sesuai **UU No. 14/2008** dan **Perki No. 1/2018**.

## Struktur PPID

| Jabatan | Diisi oleh |
| --- | --- |
| Atasan PPID | Kepala Desa |
| PPID Desa | Sekretaris Desa |
| Petugas Pelayanan Informasi | Perangkat Desa |

Diatur di **PPID → Pengaturan** (`/admin/ppid-settings`).

## Dokumen Publik (`/admin/ppid-documents`)

Kelola Daftar Informasi Publik (DIP) dengan klasifikasi baku:

| Kategori | Label |
| --- | --- |
| `berkala` | Informasi Berkala |
| `setiap_saat` | Informasi Setiap Saat |
| `serta_merta` | Informasi Serta Merta |
| `dikecualikan` | Informasi Dikecualikan |

Dokumen bawaan: RKPDes, LPPD, realisasi APBDes, Perdes, SOP layanan, surat edaran darurat, dll. Field: judul, jenis, tahun, deskripsi, berkas (PDF), status terbit, jumlah unduhan.

### Harmonisasi KIP & PDP

::: warning Wajib
Dokumen yang memuat **data pribadi warga** (NIK, No KK, riwayat medis) **wajib disamarkan/dikecualikan** sebelum dipublikasikan ke DIP — prinsip UU PDP No. 27/2022. Gunakan kategori `dikecualikan` untuk dokumen yang tidak boleh dibuka publik.
:::

## Permohonan Informasi (Publik)

Warga mengajukan di **`/ppid/permohonan`**. Penomoran tiket otomatis:

- Permohonan: `INF-YYYYMMDD-XXXX`
- Keberatan: `KBR-YYYYMMDD-XXXX`

Status permohonan (`InformationRequest`):

| Status | Label |
| --- | --- |
| `submitted` | Menunggu Verifikasi |
| `processed` | Sedang Diproses PPID |
| `approved` | Disetujui / Selesai |
| `rejected` | Ditolak |

### Tracking & Keberatan

- Cek status via **`/ppid/tracking`** dengan nomor tiket.
- Jika permohonan ditolak atau belum dijawab sampai batas waktu, warga dapat mengajukan **keberatan** di `/ppid/keberatan/{ticket}` (tiket `KBR-...`).

## Proses di Dashboard Admin

| Menu | Aksi |
| --- | --- |
| **PPID → Permohonan** (`/admin/ppid-requests`) | Proses, setujui, atau tolak permohonan (dengan alasan) |
| **PPID → Keberatan** (`/admin/ppid-objections`) | Tanggapi keberatan |
| **PPID → Dokumen** | Kelola DIP & unduhan berkas |
| **PPID → Pengaturan** | Profil pejabat, maklumat pelayanan |

## Unduhan Dokumen Publik

Publik mengunduh di **`/ppid/dokumen`** → `/ppid/dokumen/{id}/download`. Jumlah unduhan tercatat per dokumen.
