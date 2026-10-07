# Wizard Instalasi Web

SiDesa memiliki wizard instalasi berbasis peramban yang terinspirasi dari WordPress Installer. Wizard ini aktif selama berkas kunci `storage/installed` **belum ada** — begitu terbentuk, seluruh rute diarahkan ke halaman utama (`RedirectIfNotInstalled`).

## Akses

Setelah `composer install` dan `.env` tersedia, buka:

```
http://localhost:8000/install
```

## Alur Wizard

| Tahap | Rute | Fungsi |
| --- | --- | --- |
| 1. Pemeriksaan | `/install` | Cek versi PHP (min. `8.1.0`), ekstensi wajib, dan kesiapan direktori `storage/` + `bootstrap/cache` (lihat `config/installer.php`). |
| 2. Database | `/install/database` | Form kredensial DB + tombol uji koneksi (`testDatabaseConnection`). |
| 3. Setup Desa | `/install/setup` | Identitas desa, pemilihan wilayah (Provinsi → Kabupaten → Kecamatan → Desa) via API Wilayah. |
| 4. Proses | `/install/process` | Menulis `.env` (`updateEnvironment`), `key:generate`, `migrate`, lalu menjalankan seeder inti: `RoleAndPermissionSeeder`, `SettingSeeder`, `LetterTemplateSeeder`, `MenuSeeder`. |
| 5. Selesai | `/install/completed` | Membuat berkas kunci `storage/installed` berisi metadata instalasi. |

Opsional pada tahap setup, wizard juga menjalankan seeder data contoh (`ResidentAndFamilySeeder`, `ContentSeeder`, `VillageBudgetAndMapSeeder`, `PpidSeeder`).

## Reset / Instal Ulang

Hapus berkas kunci untuk mengaktifkan kembali wizard:

```bash
rm storage/installed
```

::: warning Hati-hati
Wizard akan menimpa nilai `DB_*` pada `.env` dengan input form. Jalankan hanya di lingkungan yang Anda kendalikan penuh.
:::

## Mode Simulasi (Testing)

`config/installer.php` menyediakan flag `simulate_uninstalled` untuk memaksa aplikasi berpura-pura belum terpasang — dipakai oleh test `tests/Feature/InstallerWorkflowTest.php`.
