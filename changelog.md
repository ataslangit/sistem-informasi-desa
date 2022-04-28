## SID dev
### Perubahan
- Menggunakan composer dan public folder demi kemudahan dan keamanan
- Format kode
- Hapus konstruktor kosong
- Penyesuaian SID v3.10 dari CRI

### Penambahan
- Menggunakan `.env` untuk pengaturan basic
- Lisensi

### Perbaikan
- `base_url()` secara default adalah dynamic, sekarang dapat diatur berupa static lewat `.env`.

## SID 4.0.0
### Perubahan
- Menggunakan CodeIgniter 3.1.13.
- Hapus direktori `script`.

### Perbaikan
- Tidak perlu pemanggilan `session_start()` pada constructor, sudah dipanggil lewat autoloader.
- beberapa session yang tidak tersedia sebelumnya membuat error.
- Query DB pada `side.right.php` menggunakan fungsi pemanggilan yang kadaluarsa.

### Penambahan
- Konstanta untuk informasi versi aplikasi.

## SID 3.04
Rilis pertama, berdasarkan informasi dari sumber kode.
