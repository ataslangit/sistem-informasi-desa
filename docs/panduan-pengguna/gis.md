# Peta & Aset Desa (Web GIS)

Menu **Peta & Aset** mengelola pemetaan wilayah administratif dan fasilitas desa, sesuai **Permendagri No. 1/2016** (Pengelolaan Aset Desa).

## Batas Wilayah (`/admin/boundaries`)

Kelola poligon/titik batas:

- **Dusun**, **RW**, **RT**, dan batas desa.
- Input geometri (koordinat) untuk divisualisasikan di peta publik.

Tersedia filter batas per jenis wilayah; publik melihatnya di **`/peta`**.

## Fasilitas & Aset Desa (`/admin/facilities`)

Titik lokasi infrastruktur dan fasilitas umum:

- Fasilitas umum (masjid, balai desa, sekolah, posyandu, dll).
- **Aset desa** dengan atribut yuridis:
  - **Status hak kepemilikan**: Tanah Kas Desa (TKD), Hibah, APBDes, dll.
  - **Kode register inventaris barang (KIB)** A s.d. F.

### Field Gambar (Dual-Mode)

Sama seperti modul konten: unggah berkas (`image_file`) **atau** masukkan `image_url` eksternal. Berkas lama otomatis dibersihkan saat diganti/dihapus.

## Tampilan Publik (`/peta`)

Peta interaktif menampilkan:

- Batas wilayah administratif desa (dusun/RW/RT).
- Lokasi fasilitas & aset beserta atributnya.

::: tip Akurasi
Koordinat diambil dari GPS/layanan pemetaan resmi. Untuk aset tanah, cocokkan dengan sertifikat/letter C sebelum input status hak kepemilikan.
:::
