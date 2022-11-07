---
title: Migrasi / Upgrade dari v3.11.x ke v4.5.x
layout: doc
---

# Migrasi / Upgrade dari v3.11.x ke v4.5.x
::: danger WAJIB
Harap lakukan backup terlebih dahulu untuk menghindari kesalahan saat melakukan migrasi.
:::

1. Replace direktori `donjo-app` & `donjo-sys` dengan versi yang ada pada `dev`.
   Kemungkinan level direktorinya diturunkan, lihat [struktur direktori](#sturktur-direktori)
2. Pindahkan direktori `assets` & `surat` ke direktori `public`.
3. Pastikan bahwa akses halaman utama (root) ada pada direktori `public`. Anda dapat merubah nama 
   direktori ini dengan nama lain, misal `public_html`.

# Sturktur Direktori
## Struktur Direktori Lama

```cmd
./hosting/
└-- public_html/ # (root)
    |-- assets/
    |-- donjo-app/
    |-- donjo-sys/
    |-- surat/
    |-- index.php
    |-- env
    |-- sid.install
    └-- .htaccess
```

## Struktur Direktori Baru
Berikut menggunakan contoh jika direktori `public` diganti dengan `public_html`
```cmd
./hosting/
└-- public_html/ # (root)
|   |-- assets/
|   |-- surat/
|   |-- index.php
|   └-- .htaccess
└-- donjo-app/
└-- donjo-sys/   
└-- env
└-- sid.install
```
::: tip SARAN
Anda juga dapat memasukkan direktori `donjo-app`, `donjo-sys`, `env`, dan `sid.install` kedalam direktori khusus.  
Jangan lupa untuk perbaiki path-nya didalam file `index.php` pada direktori `public`.
:::
