---
title: Instalasi SID
layout: doc
---

# Mulai Instalasi
Ikuti beberapa langkah berikut:
- Unduh arsip SID, silakan unduh melalui laman berikut https://github.com/ataslangit/sistem-informasi-desa/releases.
- Ekstrak arsip yang diunduh tersebut.
- Letakkan pada root server
- Buat database
- Atur informasi database pada `donjo-app/config/database.php`
  ```php{1-4}
  $db['default']['hostname'] = 'localhost';
  $db['default']['username'] = 'root';
  $db['default']['password'] = '';
  $db['default']['database'] = 'sid3.10';
  $db['default']['dbdriver'] = 'mysqli';
  $db['default']['dbprefix'] = '';
  ```
  ::: warning
  Saat ini, pengaturan database `dbprefix` belum didukung.
  :::
- Jika sudah silakan simpan dan akses halaman awal situs, misal: http://example.com/
  Akan ditujukan pada halaman awal instalasi database.
