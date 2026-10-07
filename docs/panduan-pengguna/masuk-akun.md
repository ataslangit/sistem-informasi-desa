# Masuk & Akun Pengguna

## Masuk ke Dashboard Admin

1. Buka `https://domain-anda/login`.
2. Masukkan **email atau username** dan **kata sandi**.
3. Klik **Masuk**. Pengguna dengan role `superadmin`, `kades`, `perangkat`, atau `rt` akan diarahkan ke `/admin/dashboard`.

Semua akun terotentikasi dapat mengelola [Profil & Kata Sandi](/panduan-pengguna/pengaturan) di menu profil (halaman `/profile`).

## Akun Demo (Hasil Seeder)

Saat instalasi dengan seeder, tersedia akun berikut — **kata sandi seluruh akun: `password`**:

| Email | Username | Role |
| --- | --- | --- |
| `admin@sidesa.id` | `superadmin` | Super Administrator |
| `kades@sidesa.id` | `kades` | Kepala Desa |
| `perangkat@sidesa.id` | `perangkat` | Perangkat Desa (Kasi Pelayanan) |
| `rt@sidesa.id` | `ketua_rt` | Ketua RT 001 / RW 002 |
| `warga@sidesa.id` | `warga` | Warga (Budi Santoso) |

::: danger Produksi
Hapus atau ganti seluruh kata sandi akun demo sebelum sistem dipakai nyata. Akun demo dibuat oleh `database/seeders/UserSeeder.php`.
:::

## Registrasi Akun Warga

Warga mendaftar sendiri melalui `/register`:

1. Isi data diri (nama, NIK, No KK, kontak, RT/RW).
2. Centang **persetujuan pemrosesan data pribadi** (explicit consent sesuai UU PDP No. 27/2022) — pendaftaran ditolak tanpa persetujuan.
3. Setelah akun aktif (divalidasi operator), warga dapat masuk dan mengajukan surat di portal layanan mandiri.

Alternatif: operator dapat membuatkan akun warga dari data penduduk lewat menu **Penduduk → Buat Akun** (`POST /admin/residents/{id}/create-account`).

## Lupa Kata Sandi / Akun Terkunci

Saat ini reset kata sandi dilakukan oleh **Superadmin** melalui **Admin → Pengguna** (`/admin/users`) — ubah kata sandi akun terkait.

## Keluar (Logout)

Klik menu profil → **Keluar**. Sesi diakhiri via `POST /logout`.
