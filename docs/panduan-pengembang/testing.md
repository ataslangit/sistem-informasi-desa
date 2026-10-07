# Menjalankan & Menguji

## Perintah Harian

```bash
php artisan serve        # server dev (http://localhost:8000)
npm run dev              # build asset admin (Vite)
composer dump-autoload   # setelah menambah class
./vendor/bin/pint        # format kode PSR-12 (Laravel Pint)
php artisan test         # jalankan seluruh test
```

## Menjalankan Test Tertentu

```bash
php artisan test --filter=LetterManagementTest
php artisan test tests/Feature/PdpComplianceAndDataProtectionTest.php
```

## Konfigurasi Test

`phpunit.xml` memakai konfigurasi environment test. Test integrasi membutuhkan **MySQL 8** (bukan SQLite) karena menguji query spesifik MySQL.

```bash
# contoh environment test
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_DATABASE=sidesa_test
DB_USERNAME=root
DB_PASSWORD=password
```

> CI GitHub Actions menjalankan migrasi + seeder otomatis sebelum test.

## Peta Test

| Kelompok Test | File | Cakupan |
| --- | --- | --- |
| RBAC & Auth | `AuthAndRbacTest`, `UserAndRoleManagementTest` | Login, guard, permission matrix |
| Kependudukan | `PopulationManagementTest` | CRUD KK/penduduk, validasi NIK 16 digit |
| E-Surat | `LetterManagementTest` | Template, alur approval, PDF |
| Warga | `CitizenRegistrationAndAccountTest` | Registrasi & consent UU PDP |
| CMS | `ContentEngineIntegrationTest`, `MenuManagementTest`, `SiteSettingManagementTest` | Artikel, menu, settings |
| APBDes & GIS | `BudgetAndGisIntegrationTest`, `BudgetPermendagriComplianceTest`, `VillageAssetGisPermendagriComplianceTest` | Kepatuhan Permendagri |
| PPID | `PpidKipComplianceTest` | UU 14/2008 & Perki 1/2018 |
| Privasi | `PdpComplianceAndDataProtectionTest` | Masking, scoped access RT, audit trail |
| TTE | `CertifiedDigitalSignatureTteComplianceTest` | Alur TTE/BSrE |
| Installer | `InstallerWorkflowTest` | Wizard instalasi |
| Lainnya | `AuditEngineIntegrationTest`, `WilayahApiIntegrationTest`, `CustomErrorPagesTest`, `AdminSidebarBadgeCountTest`, `AppVersionHelperTest` | — |

## CI (GitHub Actions)

Workflow: `.github/workflows/ci.yml` — berjalan pada `push`/`pull_request` ke branch `develop`.

- **Matriks PHP:** 8.1, 8.2, 8.3, 8.4, 8.5
- **Service:** MySQL 8.0 (health check otomatis)
- **Langkah:** composer install → npm build → `key:generate` → `migrate --seed` → `php artisan test`

::: tip Checklist sebelum PR
Jalankan lokal: `./vendor/bin/pint` lalu `php artisan test`. Pastikan hijau di seluruh matriks PHP.
:::
