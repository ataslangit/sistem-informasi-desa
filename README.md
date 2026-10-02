# 🏛️ SiDesa - Sistem Informasi Desa (SID)

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-005C84?style=for-the-badge&logo=mysql&logoColor=white)
![License: GPL v3](https://img.shields.io/badge/License-GPLv3-blue.svg?style=for-the-badge)

**SiDesa** adalah aplikasi Sistem Informasi Desa (SID) berbasis *open-source* yang dibangun menggunakan *framework* Laravel. Sistem ini dirancang sebagai platform administrasi kependudukan, pelayanan surat-menyurat mandiri, dan Content Management System (CMS) portal web desa yang mendukung **multi-tema**. 

Sistem ini juga dilengkapi dengan API terintegrasi untuk menyinkronkan data agregat ke **Sistem Informasi Kecamatan (SIK)**.

---

## ✨ Fitur Utama

### 👥 1. Manajemen Kependudukan (Buku Induk)
*   Pencatatan biodata penduduk berbasis NIK dan Nomor KK (16 digit).
*   Manajemen mutasi penduduk (Lahir, Wafat, Pindah, Datang).
*   Klasifikasi kelompok rentan, penerima bansos, dan status ekonomi.

### ✉️ 2. Layanan E-Surat
*   Generator otomatis surat pengantar (SKCK, SKTM, Domisili, dll).
*   Format surat baku yang siap cetak (PDF/Word).
*   Layanan mandiri: Warga dapat *login* dan mengajukan surat secara *online*.

### 🎨 3. CMS & Sistem Multi-Tema (Templating)
*   Website profil desa dinamis untuk publikasi berita, pengumuman, dan potensi desa.
*   **Dukungan Multi-Tema:** Antarmuka publik dapat diganti secara modular tanpa mengubah struktur kode *backend* maupun *dashboard* admin.
*   Manajemen aset (CSS/JS/Gambar) terisolasi untuk setiap tema.

### 📊 4. Transparansi & Pemetaan
*   Modul publikasi infografis Anggaran Pendapatan dan Belanja Desa (APBDes).
*   Peta wilayah administratif desa (batas Dusun/RT/RW).

### 🔗 5. Integrasi SIK (Sistem Informasi Kecamatan)
*   Otomatisasi pengiriman laporan bulanan (agregat penduduk) ke server kecamatan.
*   *Endpoint* API yang aman dengan otentikasi *token-based*.

---

## 🛠️ Teknologi yang Digunakan

*   **Backend:** PHP 8.2+, Laravel 10.x / 11.x
*   **Database:** MySQL 8.0+ / MariaDB
*   **Frontend (Admin):** Tailwind CSS / Bootstrap 5, Alpine.js (Blade Components)
*   **Frontend (Tema Publik):** Laravel Blade murni (dapat dikustomisasi penuh oleh pembuat tema)
*   **Containerization:** Docker & Docker Compose

---

## 📂 Struktur Sistem Tema

Proyek ini memisahkan secara tegas antara area **Admin** dan area **Publik (Tema)**. Jika Anda seorang desainer web yang ingin membuat atau memodifikasi tema publik:

1. **File Blade (Tampilan/Layout):** `resources/views/themes/{nama_tema}/`
2. **Assets (CSS/JS/Gambar):** `public/themes/{nama_tema}/`
3. **Helper Asset:** Gunakan fungsi `theme_asset('path/to/file')` saat memuat aset statis tema.

---

## 🚀 Panduan Instalasi (Development)

Pastikan lingkungan lokal Anda memenuhi persyaratan:
*   PHP >= 8.2 (dengan ekstensi `pdo_mysql`, `mbstring`, `openssl`, `tokenizer`, `xml`, `curl`)
*   Composer >= 2.x
*   Node.js & NPM
*   MySQL / MariaDB (atau gunakan Docker)

### Opsi 1: Instalasi Lokal (Native)

**1. Clone Repositori**
```bash
# Menggunakan SSH (Rekomendasi)
git clone git@github.com:ataslangit/sistem-informasi-desa.git

# Atau menggunakan HTTPS
git clone https://github.com/ataslangit/sistem-informasi-desa.git

cd sistem-informasi-desa
```

**2. Pasang Dependensi**
```bash
composer install
npm install
```

**3. Konfigurasi Environment**
```bash
cp .env.example .env
php artisan key:generate
```
Sesuaikan konfigurasi database dan variabel lainnya pada berkas `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sidesa
DB_USERNAME=root
DB_PASSWORD=
```

**4. Migrasi Database & Seeder**
```bash
php artisan migrate --seed
```

**5. Jalankan Aplikasi**
```bash
# Jalankan server aplikasi Laravel
php artisan serve

# Pada terminal terpisah, jalankan build asset
npm run dev
```
Akses aplikasi melalui peramban di: `http://localhost:8000`

---

### Opsi 2: Menggunakan Docker Compose

Jika Anda ingin menjalankan aplikasi di dalam container Docker:

**1. Clone & Masuk Direktori**
```bash
git clone git@github.com:ataslangit/sistem-informasi-desa.git
cd sistem-informasi-desa
```

**2. Siapkan File Environment**
```bash
cp .env.example .env
```

**3. Jalankan Container**
```bash
docker compose up -d --build
```

**4. Setup Dependensi & Kunci Aplikasi di Container**
```bash
docker compose exec app composer install
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate --seed
```

Aplikasi dapat diakses melalui port yang dikonfigurasi (default: `http://localhost:8080`).

---

## 🤝 Berkontribusi

Kontribusi untuk pengembangan SiDesa sangat terbuka!

1. *Fork* repositori ini.
2. Buat *branch* fitur baru (`git checkout -b feature/FiturKeren`).
3. *Commit* perubahan Anda (`git commit -m 'Menambahkan fitur keren'`).
4. *Push* ke *branch* (`git push origin feature/FiturKeren`).
5. Buat *Pull Request*.

---

## 📄 Lisensi
 
Proyek **SiDesa** didistribusikan di bawah lisensi [GNU General Public License v3.0 (GPL-3.0)](LICENSE).
