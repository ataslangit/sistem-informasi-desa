# Struktur Proyek

```
sistem-informasi-desa/
├── app/
│   ├── Helpers/theme.php          # Helper multi-tema (theme_view, theme_asset, dll.)
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/             # Back-office /admin/*
│   │   │   ├── Auth/              # Login & registrasi warga
│   │   │   ├── Citizen/           # Portal layanan mandiri /citizen/*
│   │   │   ├── Public/            # Portal publik (berita, peta, PPID, verifikasi)
│   │   │   └── InstallerController.php
│   │   ├── Middleware/            # admin, role, redirect.installed, dll.
│   │   └── Kernel.php             # Pendaftaran middleware
│   ├── Models/
│   └── Services/                  # Logika bisnis (InstallerService, WilayahService, ...)
├── bootstrap/app.php
├── config/                        # app, letters, tte, installer, sanctum, ...
├── database/
│   ├── migrations/
│   └── seeders/                   # DatabaseSeeder + 10 seeder modular
├── public/
│   ├── assets_admin/              # Aset dashboard admin
│   └── themes/{nama_tema}/        # Aset tema publik
├── resources/views/
│   ├── admin/                     # Blade dashboard admin (statis)
│   ├── citizen/                   # Portal warga
│   ├── pdf/                       # Template cetak (DomPDF)
│   └── themes/{nama_tema}/        # Blade tema publik (dinamis)
├── routes/
│   ├── web.php                    # Seluruh rute web (publik, admin, citizen, ppid, install)
│   └── api.php                    # Endpoint API (SIK)
├── storage/app|framework|logs
├── tests/
│   ├── Feature/                   # 20+ test integrasi (RBAC, surat, PPID, PDP, ...)
│   └── Unit/
├── .docker/                       # Dockerfile PHP & konfigurasi Nginx
├── docker-compose.yml
└── docs/                          # Dokumentasi VitePress ini
```

## Peta Rute Utama

| Prefix | Middleware | Isi |
| --- | --- | --- |
| `/install` | `redirect.installed` | Wizard instalasi web |
| `/` | publik | Berita, galeri, APBDes, peta, verifikasi surat QR |
| `/ppid` | publik | PPID: dokumen, permohonan, tracking, keberatan |
| `/login`, `/register` | `guest` | Otentikasi & registrasi warga |
| `/citizen/*` | `auth` | Layanan mandiri warga (permohonan surat) |
| `/admin/*` | `auth`, `admin` | Dashboard back-office (lihat [Role & Otorisasi](/panduan-pengembang/otorisasi)) |
| `/admin/users`, `/admin/roles` | `role:superadmin` | Manajemen pengguna & matriks permission |

## Konvensi Kode

Mengikuti [AGENTS.md](https://github.com/ataslangit/sistem-informasi-desa/blob/develop/AGENTS.md):

- **PSR-12**, strict type declaration + return type hint wajib.
- Penamaan kelas/variabel/fungsi/tabel: **Bahasa Inggris** (`Resident`, `getResidentByNik()`).
- Komentar business logic, pesan error, dan teks UI: **Bahasa Indonesia**.
- Logika kompleks di `Services`/`Actions`, bukan di controller (*Fat Controller* dilarang).
- Query via Eloquent/Query Builder; **dilarang** `DB::raw()` dengan input pengguna.
- NIK & No KK selalu `VARCHAR(16)` string.

## Testing

```bash
php artisan test
```

Detail di [Menjalankan & Menguji](/panduan-pengembang/testing).
