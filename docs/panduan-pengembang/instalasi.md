# Instalasi

SiDesa dapat dijalankan dengan dua cara: **native (lokal)** atau **Docker Compose**.

::: info Versi
Berdasarkan `composer.json`: PHP `^8.1` dan Laravel `^10.10`. Pastikan Anda berada di branch `develop`.
:::

---

## Opsi 1: Instalasi Lokal (Native)

### 1. Clone Repositori

```bash
# SSH (rekomendasi)
git clone git@github.com:ataslangit/sistem-informasi-desa.git

# atau HTTPS
git clone https://github.com/ataslangit/sistem-informasi-desa.git

cd sistem-informasi-desa
git checkout develop
```

### 2. Pasang Dependensi

```bash
composer install
npm install
```

### 3. Konfigurasi Environment

```bash
cp .env.example .env
php artisan key:generate
```

Sesuaikan koneksi database pada `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sidesa
DB_USERNAME=root
DB_PASSWORD=
```

Detail seluruh variabel dibahas di [Konfigurasi Environment](/panduan-pengembang/konfigurasi).

### 4. Migrasi Database & Seeder

```bash
php artisan migrate --seed
```

Seeder menghasilkan:

- 5 role (`superadmin`, `kades`, `perangkat`, `rt`, `warga`) beserta permission-nya.
- Akun demo (password semua akun: `password`).
- Data dummy kependudukan, template surat, konten, menu, APBDes/Peta, dan PPID.

### 5. Build Asset & Jalankan Server

```bash
# terminal 1 — server aplikasi
php artisan serve

# terminal 2 — build asset admin (Vite/Tailwind)
npm run dev
```

Buka `http://localhost:8000` (atau `http://localhost:8000/install` untuk [wizard instalasi](/panduan-pengembang/wizard-instalasi)).

---

## Opsi 2: Docker Compose

Konfigurasi Docker tersedia di `docker-compose.yml` (dua service: `app` PHP-FPM dan `web` Nginx).

```bash
git clone git@github.com:ataslangit/sistem-informasi-desa.git
cd sistem-informasi-desa

cp .env.example .env
docker compose up -d --build
```

Setup dependensi dan migrasi di dalam container:

```bash
docker compose exec app composer install
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate --seed
```

| Variabel | Default | Keterangan |
| --- | --- | --- |
| `APP_PORT` | `8080` | Port Nginx di host |
| `DB_HOST` | `host.docker.internal` | Alamat database yang berjalan di luar container (host machine) |

Aplikasi dapat diakses di `http://localhost:8080`.

::: tip Catatan
Container `app` menggunakan `extra_hosts: host.docker.internal` agar dapat menjangkau MariaDB/MySQL yang berjalan di luar container. Ubah `DB_HOST` pada `.env` jika database ikut dikemas sebagai service terpisah.
:::

---

## Langkah Selanjutnya

- Login pertama kali → lihat [Masuk & Akun Pengguna](/panduan-pengguna/masuk-akun).
- Ganti data demo → [Data Kartu Keluarga](/panduan-pengguna/kartu-keluarga) dan [Data Penduduk](/panduan-pengguna/penduduk).
- Mengembangkan tema → [Sistem Multi-Tema](/panduan-pengembang/multi-tema).
