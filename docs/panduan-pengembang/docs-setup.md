# Dokumentasi Ini (VitePress)

Dokumentasi SiDesa dibangun dengan [VitePress](https://vitepress.dev) dan berada di folder `docs/` — terpisah dari instalasi Node aplikasi Laravel agar konfigurasi Vite keduanya tidak saling bentrok.

## Struktur

```
docs/
├── package.json              # dependensi terpisah (hanya vitepress)
├── .vitepress/
│   └── config.mts            # nav, sidebar, pencarian, editLink
├── index.md                  # halaman landing (hero + features)
├── panduan-pengguna/         # panduan operator/admin desa
└── panduan-pengembang/       # panduan developer (halaman ini)
```

## Perintah

```bash
cd docs
npm install        # sekali saat awal
npm run dev        # server dev + hot reload  → http://localhost:5173
npm run build      # build produksi ke docs/.vitepress/dist
npm run preview    # pratinjau hasil build
```

## Konvensi Penulisan

- Bahasa Indonesia, istilah teknis tetap dalam Bahasa Inggris (*italic*/code).
- Frontmatter minimal: judul halaman = `# H1` pertama.
- Tautan internal antar-halaman: path relatif absolut root docs, contoh `[Instalasi](/panduan-pengembang/instalasi)` (tanpa `.md`).
- Komponen VitePress yang sering dipakai: `::: info`, `::: tip`, `::: warning`, `::: danger`.
- Per baris sidebar yang ditambahkan di `.vitepress/config.mts` harus punya file Markdown-nya — build akan **gagal** jika tautan patah (itu disengaja).

## Otomasi Deploy (CI/CD)

Dokumentasi ini otomatis di-build dan di-deploy ke GitHub Pages menggunakan GitHub Actions (`.github/workflows/docs.yml`) setiap kali ada *push* pada branch `develop` atau `master` yang mengubah berkas di folder `docs/`.

## Menambah Halaman Baru

1. Buat berkas `.md` di folder yang sesuai.
2. Daftarkan di `sidebar` → `.vitepress/config.mts`.
3. Jalankan `npm run build` untuk memverifikasi tidak ada tautan patah.
