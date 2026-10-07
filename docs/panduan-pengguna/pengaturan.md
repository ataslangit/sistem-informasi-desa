# Pengaturan Situs & TTE

## Pengaturan Situs (`/admin/settings`)

Mengelola identitas desa dan parameter portal (tersimpan di tabel `settings` per kunci + grup).

### Grup: Desa (`village`)

| Kunci | Fungsi |
| --- | --- |
| `village_name` | Nama desa — tampil di portal, kop surat, PDF |
| `village_code` | Kode desa (untuk nomor surat) |
| `subdistrict_name`, `district_name`, `province_name` | Nama kecamatan/kabupaten/provinsi |
| `village_address`, `postal_code` | Alamat & kode pos |
| `village_phone`, `village_email` | Kontak |

### Grup: Umum (`general`)

| Kunci | Fungsi |
| --- | --- |
| `app_title`, `app_tagline` | Judul & tagline situs publik |
| Logo desa | Dipakai pada header portal & PDF (helper `village_logo()`) |

### Grup: Tema (`theme`)

`active_theme` — tema publik aktif. Dijelaskan di [Menu & Tema](/panduan-pengguna/menu-tema).

## Pengaturan TTE (`/admin/tte-settings`)

Konfigurasi **Tanda Tangan Elektronik tersertifikasi (PSrE/BSrE BSSN)** untuk pengesahan surat Kepala Desa.

| Field | Sumber |
| --- | --- |
| Provider | `TTE_DEFAULT_PROVIDER` (default `bsre_bssn`) |
| Endpoint & API key | `TTE_BSRE_URL`, `TTE_BSRE_API_KEY` |
| Client ID & passphrase | `TTE_BSRE_CLIENT_ID`, `TTE_BSRE_PASSPHRASE` |
| Mode sandbox | `TTE_BSRE_SANDBOX` |
| TSA URL | `TTE_BSRE_TSA_URL` |

::: warning Batasan Wewenang TTE
Kewenangan TTE dokumen kependudukan negara (KK nasional) ada pada **Kadisdukcapil via SIAK Terpusat** (Permendagri 109/2019). TTE/QR di SiDesa hanya **pengesahan Kepala Desa atas kebenaran salinan data desa** — bukan pengganti dokumen resmi negara.
:::

Ganti nilai demo dengan kredensial PSrE resmi sebelum produksi. Detail variabel: [Konfigurasi Environment](/panduan-pengembang/konfigurasi#tanda-tangan-elektronik-tte-bsre-bssn).

## Profil & Kata Sandi Sendiri

Semua pengguna (termasuk warga) dapat mengelola data diri di `/profile`:

- Ubah nama & informasi kontak.
- Ganti kata sandi (password lama wajib diisi).
