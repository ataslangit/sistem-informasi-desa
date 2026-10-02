# 🏛️ OpenDesa - Sistem Informasi Desa (SID)

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-005C84?style=for-the-badge&logo=mysql&logoColor=white)
![License: MIT](https://img.shields.io/badge/License-MIT-green.svg?style=for-the-badge)

**OpenDesa** adalah aplikasi Sistem Informasi Desa (SID) berbasis *open-source* yang dibangun menggunakan *framework* Laravel. Sistem ini dirancang sebagai platform administrasi kependudukan, pelayanan surat-menyurat mandiri, dan Content Management System (CMS) portal desa yang mendukung **multi-tema**. 

Sistem ini juga dilengkapi dengan API terintegrasi untuk menyinkronkan data agregat ke **Sistem Informasi Kecamatan (SIK)**.

---

## ✨ Fitur Utama

### 👥 1. Manajemen Kependudukan (Buku Induk)
*   Pencatatan biodata penduduk berbasis NIK dan Nomor KK.
*   Manajemen mutasi penduduk (Lahir, Wafat, Pindah, Datang).
*   Klasifikasi kelompok rentan, penerima bansos, dan status ekonomi.

### ✉️ 2. Layanan E-Surat
*   Generator otomatis surat pengantar (SKCK, SKTM, Domisili, dll).
*   Format surat baku yang siap cetak (PDF/Word).
*   Layanan mandiri: Warga dapat *login* dan mengajukan surat secara *online*.

### 🎨 3. CMS & Sistem Multi-Tema (Templating)
*   Website profil desa dinamis untuk publikasi berita, pengumuman, dan potensi desa.
*   **Dukungan Multi-Tema:** Antarmuka publik dapat diganti (layaknya WordPress) tanpa mengubah struktur kode *backend* maupun *dashboard* admin.
*   Manajemen aset (CSS/JS) yang terisolasi untuk setiap tema.

### 📊 4. Transparansi & Pemetaan
*   Modul publikasi infografis Anggaran Pendapatan dan Belanja Desa (APBDes).
*   Peta wilayah administratif desa (batas Dusun/RT/RW).

### 🔗 5. Integrasi SIK (Sistem Informasi Kecamatan)
*   Otomatisasi pengiriman laporan bulanan (agregat penduduk) ke server kecamatan.
*   *Endpoint* API yang aman dengan otentikasi *token-based*.

---

## 🛠️ Teknologi yang Digunakan

*   **Backend:** PHP 8.2+, Laravel 11.x
*   **Database:** MySQL 8.0+ atau PostgreSQL
*   **Frontend (Admin):** Tailwind CSS / Bootstrap 5 (Blade Components)
*   **Frontend (Tema Publik):** Laravel Blade (Dapat dikustomisasi penuh oleh pembuat tema)

---

## 📂 Struktur Sistem Tema

Proyek ini memisahkan secara tegas antara area **Admin** dan area **Publik (Tema)**. Jika Anda seorang desainer web yang ingin membuat tema baru, Anda hanya perlu beroperasi di dua direktori berikut:

1. **File Blade (HTML/Logika Tampilan):** `resources/views/themes/{nama_tema}/`
2. **Assets (CSS/JS/Gambar):** `public/themes/{nama_tema}/`

---

## 🚀 Panduan Instalasi (Development)

Pastikan sistem Anda telah terpasang **PHP >= 8.2**, **Composer**, dan **MySQL/MariaDB**.

**1. Clone Repositori**
```bash
git clone [https://github.com/username/opendesa.git](https://github.com/username/opendesa.git)
cd opendesa
