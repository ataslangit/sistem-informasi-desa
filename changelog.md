## SID 4.0.0
### Perubahan
- Menggunakan CodeIgniter 3.1.13.

### Perbaikan
- Tidak perlu pemanggilan `session_start()` pada constructor, sudah dipanggil lewat autoloader.
- beberapa session yang tidak tersedia sebelumnya membuat error.
- Query DB pada `side.right.php` menggunakan fungsi pemanggilan yang kadaluarsa.

## SID 3.04
Rilis pertama, berdasarkan informasi dari sumber kode.
