# API SIK (Roadmap)

::: warning Status: Dalam Pengembangan
Modul ini masih pada **Fase 6** pada [roadmap proyek](https://github.com/ataslangit/sistem-informasi-desa/blob/develop/todo.md) — belum diimplementasikan. Halaman ini mendokumentasikan rancangan agar integrator Kecamatan dapat mempersiapkan sisi server mereka.
:::

## Tujuan

Menyinkronkan **data agregat** (bukan data individu warga) dari SiDesa ke Sistem Informasi Kecamatan (SIK):

- Statistik kependudukan (jumlah KK, penduduk per usia/jenis kelamin, mutasi bulanan).
- Laporan progres bulanan desa.

Data sensitif (NIK, No KK, nama individu) **tidak pernah** dikirim melalui API ini — sesuai prinsip *data minimization* UU PDP No. 27/2022.

## Rencana Endpoint

| Method | Endpoint | Fungsi |
| --- | --- | --- |
| `GET` | `/api/v1/statistics` | Data agregat kependudukan desa |
| `POST` | `/api/v1/reports/monthly` | Kirim laporan bulanan ke server kecamatan |

## Keamanan

- Autentikasi **Bearer Token** via [Laravel Sanctum](https://laravel.com/docs/sanctum) (sudah terpasang di `composer.json`, konfigurasi di `config/sanctum.php`).
- Token dibuat per-desain perangkat dan di-*scope* hanya untuk endpoint agregat.
- Seluruh request log-nya masuk ke audit trail.

## Format Respons (Konvensi Proyek)

```json
{
  "success": true,
  "message": "Laporan bulanan berhasil diterima",
  "data": {
    "period": "2026-09",
    "total_families": 412,
    "total_residents": 1580
  }
}
```

Kegagalan menggunakan struktur sama dengan `success: false` dan pesan deskriptif berbahasa Indonesia.

## Sinkronisasi Terjadwal

Rencananya memakai Laravel Task Scheduler (`app/Console/Kernel` / `routes/console.php`) dengan cron server:

```cron
* * * * * cd /path-to-app && php artisan schedule:run >> /dev/null 2>&1
```

## Kontribusi

Jika Anda mengembangkan endpoint ini, wajib menyertakan:

1. Test fitur (mis. `SilkIntegrationTest`).
2. Dokumentasi endpoint aktual di halaman ini.
3. Pastikan tidak ada field PII individu dalam payload.
