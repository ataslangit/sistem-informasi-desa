# Konfigurasi Environment

Seluruh konfigurasi rahasia dan lingkungan berada di berkas `.env` (contoh lengkap: `.env.example`). Jangan pernah meng-commit `.env` ke repositori.

## Variabel Inti

| Variabel | Default | Keterangan |
| --- | --- | --- |
| `APP_NAME` | `SiDesa` | Nama aplikasi (tampil di judul & PDF). |
| `APP_URL` | `http://localhost` | URL publik; penting untuk link PDF & QR verifikasi. |
| `APP_DEBUG` | `true` | Set `false` di produksi. |
| `APP_TIMEZONE` | `Asia/Jakarta` | Zona waktu; helper `timezone_label()` menghasilkan label WIB/WITA/WIT. |
| `DB_*` | — | Koneksi MySQL (`DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`). |
| `SESSION_DRIVER` | `file` | Penyimpanan sesi. |
| `CACHE_DRIVER` | `file` | Cache; data wilayah di-cache minimal 24 jam. |
| `FILESYSTEM_DISK` | `local` | Unggahan media memakai disk `public` (symlink `storage:link`). |

## E-Surat

| Variabel | Fungsi |
| --- | --- |
| `LETTER_DEFAULT_NUMBER_FORMAT` | Format nomor surat otomatis. |
| `LETTER_NUMBER_PADDING` | Panjang padding nomor urut. |

## Tanda Tangan Elektronik (TTE BSrE BSSN)

Digunakan oleh modul [Pengaturan Situs & TTE](/panduan-pengguna/pengaturan) — konfigurasi lengkap ada di `config/tte.php`:

| Variabel | Keterangan |
| --- | --- |
| `TTE_DEFAULT_PROVIDER` | Provider TTE (`bsre_bssn`). |
| `TTE_BSRE_URL` | Endpoint tanda tangan PDF BSrE. |
| `TTE_BSRE_API_KEY` | API key PSrE. |
| `TTE_BSRE_CLIENT_ID` | ID klien terdaftar. |
| `TTE_BSRE_PASSPHRASE` | Passphrase kunci privat. |
| `TTE_BSRE_SANDBOX` | `true` untuk mode sandbox. |
| `TTE_BSRE_TSA_URL` | Time Stamp Authority (`https://tsa.bssn.go.id`). |

::: warning Produksi
Ganti seluruh nilai demo (`demo_bsre_api_key_sidesa`, dll.) dengan kredensial PSrE resmi sebelum TTE dipakai untuk dokumen nyata. TTE di sini berfungsi sebagai **pengesahan salinan data desa oleh Kepala Desa**, bukan dokumen kependudukan negara.
:::

## Mail (Opsional)

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.example.com
MAIL_PORT=587
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@desa.id"
MAIL_FROM_NAME="SiDesa"
```

## Checklist Produksi

- [ ] `APP_DEBUG=false`
- [ ] `APP_URL` = domain final (https)
- [ ] Kredensial database unik & user DB bukan `root`
- [ ] `storage:link` dijalankan agar unggahan media publik terjangkau
- [ ] Kredensial TTE diganti dari nilai demo
- [ ] Backup database terjadwal (cron)
