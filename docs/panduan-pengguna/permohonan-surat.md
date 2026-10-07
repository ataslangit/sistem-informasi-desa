# Alur Permohonan Surat

Menu **E-Surat → Permohonan Surat** (`/admin/letter-requests`) adalah jantung pelayanan persuratan.

## Status & Alur Persetujuan

```
Warga/Operator ajukan
        ↓
  ┌─ pending_rt ──── Menunggu Verifikasi RT/RW
  ↓ (verify-rt / bypass-rt)
  ├─ pending_staff ─ Menunggu Verifikasi Staf Desa
  ↓ (verify-staff)
  ├─ pending_kades ─ Menunggu TTE Kepala Desa
  ↓ (approve-kades)
  └─ approved ────── Selesai & Disahkan → PDF + QR
        ↘ rejected   Ditolak (oleh staf/kades, dengan alasan)
```

| Status | Label | Aksi yang boleh dilakukan |
| --- | --- | --- |
| `pending_rt` | Menunggu Verifikasi RT/RW | Verifikasi oleh RT/perangkat |
| `pending_staff` | Menunggu Verifikasi Staf Desa | Verifikasi staf (perangkat) |
| `pending_kades` | Menunggu TTE Kades | Persetujuan + TTE Kepala Desa |
| `approved` | Selesai & Disahkan | Unduh PDF |
| `rejected` | Ditolak | Lihat alasan, warga bisa ajukan ulang |

### Siapa yang memproses?

- **Ketua RT** (`letters.verify_rt`) — verifikasi pengantar di tingkat RT.
- **Perangkat Desa** (`letters.process`) — cek berkas, verifikasi staf.
- **Kepala Desa** (`letters.approve`) — persetujuan akhir + TTE elektronik.
- **Superadmin** — dapat memproses pada status mana pun (termasuk *bypass* RT).

## Langkah Operator

1. Buka **E-Surat → Permohonan Surat**; filter antrean berdasarkan status.
2. Klik permohonan untuk melihat detail: pemohon, template, isian field, dan dokumen.
3. Proses sesuai status Anda:
   - **Verifikasi RT** — cocokkan data pemohon dengan wilayah RT.
   - **Verifikasi Staf** — pastikan berkas/kelengkapan.
   - **Setujui & TTE** — Kepala Desa; sistem menomori surat, menandatangani, dan men-generate QR.
   - **Tolak** — wajib mengisi alasan; status menjadi `rejected`.
4. **Unduh PDF** — dokumen sudah berisi nomor surat, QR verifikasi, dan identitas desa.

## Verifikasi Keaslian Surat

Setiap PDF memuat QR Code yang menautkan ke:

```
https://domain-anda/verify/letter/{qr_token}
```

Pihak ketiga (mis. penerima surat) cukup memindai QR untuk memastikan surat asli dan melihat statusnya — tanpa membuka data pribadi lain.

## Batasan Pemrosesan

`LetterRequest::canBeProcessedBy()` memastikan:

- Permohonan yang sudah `approved`/`rejected` **tidak** bisa diproses ulang.
- Aksi sesuai permission role masing-masing (lihat [Role & Otorisasi](/panduan-pengembang/otorisasi)).

## Unduh PDF Massal

Saat ini unduhan bersifat per-permohonan (`/admin/letter-requests/{id}/pdf`). Portal warga juga menyediakan unduhan mandiri di [Portal Warga](/panduan-pengguna/portal-warga).
