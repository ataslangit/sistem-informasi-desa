# Changelog

Semua perubahan penting pada SiDesa didokumentasikan di file ini.

Format mengikuti [Keep a Changelog](https://keepachangelog.com/id/1.1.0/) dan proyek ini menggunakan [Semantic Versioning](https://semver.org/lang/id/).

## [Unreleased]

### Added

- Sitemap XML dinamis di `/sitemap.xml` untuk beranda, berita, kategori, halaman statis, galeri, APBDes, peta, dan layanan PPID.
- `robots.txt` dinamis di `/robots.txt` yang mencantumkan URL sitemap dan memblokir area privat seperti admin, installer, layanan warga, serta verifikasi surat.
- Invalidasi cache sitemap otomatis saat konten, kategori, APBDes, atau dokumen PPID berubah.
- Feature test untuk sitemap, robots.txt, dan invalidasi cache.

### Changed

- `public/robots.txt` statis diganti dengan endpoint dinamis agar URL sitemap mengikuti domain instalasi desa.
