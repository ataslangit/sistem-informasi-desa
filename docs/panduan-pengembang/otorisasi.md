# Role & Otorisasi

SiDesa memakai RBAC (Role-Based Access Control) multi-guard dengan 5 role dan permission granular.

## Role Bawaan

Didefinisikan di `database/seeders/RoleAndPermissionSeeder.php`:

| Role | Label | Ringkasan Hak |
| --- | --- | --- |
| `superadmin` | Super Administrator | Seluruh permission + manajemen pengguna & matriks permission. |
| `kades` | Kepala Desa | Lihat penduduk, **persetujuan & TTE surat**, kelola konten, lihat laporan. |
| `perangkat` | Perangkat Desa | Operator: kelola KK/penduduk, proses surat, template surat, konten, laporan. |
| `rt` | Ketua RT | Akses admin terbatas: lihat penduduk wilayahnya, **verifikasi surat tingkat RT**. |
| `warga` | Warga | Hanya pengajuan surat mandiri di portal `/citizen`. |

## Daftar Permission

| Permission | Fungsi |
| --- | --- |
| `admin.access` | Masuk area `/admin` |
| `users.manage` | Kelola pengguna/role |
| `settings.manage` | Ubah pengaturan sistem |
| `residents.view` / `residents.manage` | Lihat / kelola data kependudukan |
| `letters.request` | Ajukan surat (warga) |
| `letters.verify_rt` | Verifikasi surat RT |
| `letters.process` | Proses verifikasi staf desa |
| `letters.approve` | Persetujuan & TTE Kepala Desa |
| `letters.manage_templates` | Kelola template surat |
| `contents.manage` | Kelola berita/halaman/galeri |
| `reports.view` | Lihat laporan statistik |

## Middleware

Didaftarkan di `app/Http/Kernel.php`:

| Alias | Kelas | Dipakai pada |
| --- | --- | --- |
| `admin` | `AdminAccess` | Seluruh prefix `/admin` |
| `role` | `EnsureUserHasRole` | `role:superadmin` (manajemen user/role) |
| `can` / permission | `EnsureUserHasPermission` | Check permission per menu/aksi |
| `redirect.installed` | `RedirectIfInstalled` | Rute `/install` |
| (global) | `RedirectIfNotInstalled` | Semua rute → redirect ke `/install` bila belum terpasang |

## Prinsip Keamanan (wajib untuk kontributor)

1. **Akses berbasis wilayah (need-to-know):** akun RT hanya melihat penduduk di RT-nya; implementasikan scope query, bukan hanya sembunyikan menu.
2. **Minimisasi paparan:** gunakan accessor `masked_nik` / `masked_family_card_number` untuk menampilkan NIK/No KK.
3. **Audit trail:** pembacaan data sensitif wajib tercatat (`ResidentViewed`, `FamilyViewed`, `FamilyPdfDownloaded`) via `ttpryg/audit-engine`.
4. Setiap route admin wajib minimal bermiddleware `['auth', 'admin']`.
5. Escape output Blade `{{ }}`; `{!! !!}` hanya untuk konten WYSIWYG yang sudah di-purify.

## Matriks Permission

Superadmin dapat mengelola matriks role ↔ permission di **Admin → Pengguna → Role** (`/admin/roles/{role}`).
