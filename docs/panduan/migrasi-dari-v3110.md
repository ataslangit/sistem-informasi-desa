---
title: Migrasi / Upgrade dari v3.x ke v4.x
layout: doc
---

# Migrasi / Upgrade dari v3.x ke v4.x
::: tip WAJIB
Harap lakukan backup terlebih dahulu untuk menghindari kesalahan saat melakukan migrasi.
:::

Cukup dengan me-replace berkas berikut:
- `donjo-app`
- `donjo-sys`
- `index.php`

Untuk pengaturan database, bisa dilakukan di file `.env`.\
Copy-paste file `env`, beri nama `.env` dan hapus tanda pagar (`#`) pada baris pengaturan yang dimaksud.\
File ini disediakan dimaksudkan agar mempermudah dalam migrasi selanjutnya.


::: warning PENTING
Jika ada pengaturan tambahan yang dilakukan secara mandiri, harap disesuaikan.
:::
