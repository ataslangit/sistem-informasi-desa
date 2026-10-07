import { defineConfig } from 'vitepress'

// Konfigurasi dokumentasi SiDesa.
// Sesuaikan `base` dengan lokasi deploy GitHub Pages
// (misal: '/sistem-informasi-desa/' untuk project page).
export default defineConfig({
  lang: 'id-ID',
  title: 'Dokumentasi SiDesa',
  description:
    'Panduan resmi SiDesa - Sistem Informasi Desa: administrasi kependudukan, e-surat, CMS portal desa multi-tema, dan integrasi SIK.',
  base: '/',

  markdown: {
    languageAlias: {
      env: 'ini',
      cron: 'bash',
    },
  },

  head: [['meta', { name: 'theme-color', content: '#2563eb' }]],

  themeConfig: {
    nav: [
      { text: 'Beranda', link: '/' },
      { text: 'Panduan Pengguna', link: '/panduan-pengguna/' },
      { text: 'Panduan Pengembang', link: '/panduan-pengembang/' },
    ],

    sidebar: {
      '/panduan-pengguna/': [
        {
          text: 'Memulai',
          items: [
            { text: 'Pengenalan', link: '/panduan-pengguna/' },
            { text: 'Masuk & Akun Pengguna', link: '/panduan-pengguna/masuk-akun' },
          ],
        },
        {
          text: 'Manajemen Kependudukan',
          items: [
            { text: 'Data Kartu Keluarga', link: '/panduan-pengguna/kartu-keluarga' },
            { text: 'Data Penduduk', link: '/panduan-pengguna/penduduk' },
            { text: 'Mutasi & Laporan', link: '/panduan-pengguna/mutasi-laporan' },
          ],
        },
        {
          text: 'Layanan E-Surat',
          items: [
            { text: 'Template Surat', link: '/panduan-pengguna/template-surat' },
            { text: 'Alur Permohonan Surat', link: '/panduan-pengguna/permohonan-surat' },
            { text: 'Portal Layanan Mandiri Warga', link: '/panduan-pengguna/portal-warga' },
          ],
        },
        {
          text: 'CMS Portal Desa',
          items: [
            { text: 'Artikel, Halaman & Galeri', link: '/panduan-pengguna/konten' },
            { text: 'Menu & Tema Publik', link: '/panduan-pengguna/menu-tema' },
          ],
        },
        {
          text: 'Transparansi & Pelayanan Publik',
          items: [
            { text: 'APBDes', link: '/panduan-pengguna/apbdes' },
            { text: 'Peta & Aset Desa (GIS)', link: '/panduan-pengguna/gis' },
            { text: 'PPID Desa', link: '/panduan-pengguna/ppid' },
          ],
        },
        {
          text: 'Administrasi Sistem',
          items: [
            { text: 'Pengguna, Role & Hak Akses', link: '/panduan-pengguna/pengguna-role' },
            { text: 'Pengaturan Situs & TTE', link: '/panduan-pengguna/pengaturan' },
            { text: 'Audit Log', link: '/panduan-pengguna/audit-log' },
          ],
        },
      ],

      '/panduan-pengembang/': [
        {
          text: 'Memulai',
          items: [
            { text: 'Pengenalan', link: '/panduan-pengembang/' },
            { text: 'Instalasi', link: '/panduan-pengembang/instalasi' },
            { text: 'Wizard Instalasi Web', link: '/panduan-pengembang/wizard-instalasi' },
            { text: 'Konfigurasi Environment', link: '/panduan-pengembang/konfigurasi' },
          ],
        },
        {
          text: 'Arsitektur',
          items: [
            { text: 'Struktur Proyek', link: '/panduan-pengembang/struktur-proyek' },
            { text: 'Sistem Multi-Tema', link: '/panduan-pengembang/multi-tema' },
            { text: 'Role & Otorisasi', link: '/panduan-pengembang/otorisasi' },
          ],
        },
        {
          text: 'Pengembangan',
          items: [
            { text: 'Menjalankan & Menguji', link: '/panduan-pengembang/testing' },
            { text: 'Dokumentasi Ini (VitePress)', link: '/panduan-pengembang/docs-setup' },
            { text: 'Berkontribusi', link: '/panduan-pengembang/kontribusi' },
          ],
        },
        {
          text: 'Integrasi',
          items: [{ text: 'API SIK (Roadmap)', link: '/panduan-pengembang/api-sik' }],
        },
      ],
    },

    search: {
      provider: 'local',
      options: {
        translations: {
          button: { buttonText: 'Cari Dokumentasi', buttonAriaLabel: 'Cari Dokumentasi' },
          modal: {
            noResultsText: 'Tidak ada hasil ditemukan',
            resetButtonTitle: 'Hapus pencarian',
            footer: {
              selectText: 'pilih',
              navigateText: 'navigasi',
              closeText: 'tutup',
            },
          },
        },
      },
    },

    outline: { level: [2, 3], label: 'Di halaman ini' },
    docFooter: { prev: 'Sebelumnya', next: 'Selanjutnya' },
    lastUpdated: { text: 'Terakhir diperbarui' },
    editLink: {
      text: 'Edit halaman ini di GitHub',
      pattern: 'https://github.com/TIMA-Codecraft/sidesa/edit/develop/docs/:path',
    },

    footer: {
      message: 'Dokumentasi resmi proyek SiDesa',
      copyright: 'Lisensi GPL-3.0-or-later',
    },
  },
})
