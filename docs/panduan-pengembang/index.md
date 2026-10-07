# Panduan Pengembang

Bagian ini ditujukan untuk developer yang ingin **menginstal, mengembangkan, dan berkontribusi** pada SiDesa.

## Prasyarat

| Komponen | Versi |
| --- | --- |
| PHP | >= 8.1 (ekstensi: `pdo_mysql`, `mbstring`, `openssl`, `tokenizer`, `xml`, `curl`, `fileinfo`, `gd`, `zip`, `bcmath`) |
| Composer | >= 2.x |
| Node.js & npm | Node 18+ (dipakai untuk build asset & dokumentasi) |
| Database | MySQL 8.0+ / MariaDB |
| Opsional | Docker & Docker Compose |

## Alur Cepat

```bash
git clone git@github.com:TIMA-Codecraft/sidesa.git
cd sidesa
composer install && npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve   # terminal 1
npm run dev         # terminal 2
```

Akses `http://localhost:8000`, atau gunakan [wizard instalasi web](/panduan-pengembang/wizard-instalasi) di `/install`.

## Daftar Halaman

- [Instalasi](/panduan-pengembang/instalasi) — mode native dan Docker Compose.
- [Wizard Instalasi Web](/panduan-pengembang/wizard-instalasi) — pemasangan lewat peramban ala WordPress.
- [Konfigurasi Environment](/panduan-pengembang/konfigurasi) — variabel `.env` penting.
- [Struktur Proyek](/panduan-pengembang/struktur-proyek) — peta direktori & konvensi kode.
- [Sistem Multi-Tema](/panduan-pengembang/multi-tema) — cara menulis tema publik baru.
- [Role & Otorisasi](/panduan-pengembang/otorisasi) — RBAC, permission, middleware.
- [Menjalankan & Menguji](/panduan-pengembang/testing) — PHPUnit dan GitHub Actions CI.
- [API SIK](/panduan-pengembang/api-sik) — rencana integrasi dengan kecamatan.
