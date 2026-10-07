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

## Deploy ke GitHub Pages

Hasil build ada di `docs/.vitepress/dist`. Alur yang disarankan:

1. Buat workflow GitHub Actions baru (mis. `docs.yml`) yang menjalankan:

```yaml
- uses: actions/checkout@v4
- uses: actions/setup-node@v4
  with: { node-version: 20 }
- run: npm ci
  working-directory: docs
- run: npm run build
  working-directory: docs
- uses: actions/upload-pages-artifact@v3
  with: { path: docs/.vitepress/dist }
- uses: actions/deploy-pages@v4
```

2. Jika repo di-deploy ke project page (`https://tima-codecraft.github.io/sidesa/`), set `base: '/sidesa/'` di `.vitepress/config.mts`.

::: tip
Alternatif tanpa Actions: commit folder hasil build ke branch `gh-pages` (mis. dengan `gh-pages -d docs/.vitepress/dist`).
:::

## Menambah Halaman Baru

1. Buat berkas `.md` di folder yang sesuai.
2. Daftarkan di `sidebar` → `.vitepress/config.mts`.
3. Jalankan `npm run build` untuk memverifikasi tidak ada tautan patah.
