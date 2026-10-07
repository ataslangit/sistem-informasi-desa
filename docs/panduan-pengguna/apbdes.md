# APBDes (Transparansi Anggaran)

Menu **APBDes → Anggaran** (`/admin/budgets`) mengelola Anggaran Pendapatan dan Belanja Desa sesuai **Permendagri No. 20/2018**.

## Struktur Data

Satu record **Anggaran** per tahun, terdiri atas tiga pos **Item**:

| Posisi | Tipe | Contoh |
| --- | --- | --- |
| Pendapatan | `revenue` | Dana Desa, ADD, PAD, transfer lain |
| Belanja | `expenditure` | 5 bidang belanja baku |
| Pembiayaan | `financing` | SiLPA (penerimaan), Penyertaan Modal BUMDes (pengeluaran) |

Setiap item memiliki **anggaran** (`budgeted_amount`) dan **realisasi** (`realized_amount`).

## 5 Bidang Belanja Baku

Sistem mengelompokkan belanja ke lima bidang resmi:

1. Penyelenggaraan Pemerintahan
2. Pelaksanaan Pembangunan
3. Pembinaan Kemasyarakatan
4. Pemberdayaan Masyarakat
5. Penanggulangan Bencana/Darurat

Pengelompokan otomatis dipakai untuk visualisasi infografis (lihat test `BudgetPermendagriComplianceTest`).

## Langkah Input

1. **Tambah Anggaran** — pilih tahun anggaran.
2. Buka detail anggaran → **Tambah Item**:
   - Pilih pos (pendapatan/belanja/pembiayaan).
   - Isi nama, kode, anggaran, realisasi.
   - Untuk belanja: pilih bidang/sub-bidang baku.
3. Edit atau hapus item bila ada revisi APBDes.
4. Publikasikan (status publish) — anggaran tampil di portal.

## Tampilan Publik

Anggaran tampil di **`/apbdes`** berupa:

- Ringkasan pendapatan, belanja, pembiayaan (anggaran vs realisasi).
- Grafik komposisi per bidang.
- Tabel rincian item.

::: tip
Nominal cukup diisi dalam rupiah bulat; sistem menjumlahkan agregat. Pastikan total pendapatan − belanja = pembiayaan agar laporan valid.
:::
