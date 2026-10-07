# Pengguna, Role & Hak Akses

Menu ini hanya terbuka untuk **Superadmin** (`/admin/users` dan `/admin/roles`).

## Pengguna (`/admin/users`)

| Aksi | Keterangan |
| --- | --- |
| Tambah | Buat akun: nama, username, email, kata sandi, role, status aktif |
| Edit | Ubah data & role |
| Toggle status | Aktif/nonaktifkan akun (`PATCH /admin/users/{id}/toggle-status`) |
| Hapus | Hapus akun (data warga terkait tidak ikut terhapus) |

## Role Bawaan

| Role | Kegunaan |
| --- | --- |
| `superadmin` | Akses penuh + manajemen pengguna/role |
| `kades` | Persetujuan & TTE surat, monitoring, konten |
| `perangkat` | Operator: kependudukan, proses surat, template, konten |
| `rt` | Verifikasi surat RT (terbatas pada wilayahnya) |
| `warga` | Layanan mandiri (tanpa akses `/admin`) |

## Matriks Permission (`/admin/roles/{role}`)

Superadmin dapat menambah/mengurangi permission per role melalui **Role → Ubah Permission**:

- `admin.access`, `users.manage`, `settings.manage`
- `residents.view`, `residents.manage`
- `letters.request`, `letters.verify_rt`, `letters.process`, `letters.approve`, `letters.manage_templates`
- `contents.manage`, `reports.view`

::: warning Hati-hati
Mencabut `admin.access` membuat role tersebut **tidak bisa masuk dashboard**. Selalu uji dengan akun percobaan setelah mengubah matriks.
:::

## Pembatasan Berbasis Wilayah

Akun RT otomatis dibatasi:

- Daftar & detail KK/penduduk hanya di RT/RW yang ditugaskan (field `rt`, `rw` pada user).
- Membuka KK di luar wilayahnya → **403** "Akses Ditolak".
- Hanya bisa memproses permohonan surat status `pending_rt`.

Pembatasan ini bersifat **query-level** (bukan sekadar sembunyikan menu), sesuai prinsip UU PDP.

## Rekomendasi Praktik

- Satu akun untuk satu orang; jangan berbagi akun operator.
- Aktifkan username unik untuk login selain email.
- Nonaktifkan akun saat pekerja berpindah tugas.
- Seluruh perubahan pengguna tercatat di [Audit Log](/panduan-pengguna/audit-log).
