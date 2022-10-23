export default {
    title: 'Sistem Informasi Desa',
    description: 'Menuju desa digital',
    base: '/sistem-informasi-desa/',
    lang: 'id-ID',
    themeConfig: {
        nav: [
            { text: 'Panduan', link: '/panduan/' },
            { text: 'Changelog', link: '/changelog/' },
        ],
        socialLinks: [
            { icon: 'github', link: 'https://github.com/ataslangit/sistem-informasi-desa' }
        ],
        sidebar: {
            '/panduan/': sidebarGuide(),
            '/changelog/': sidebarChangelog()
        },
        footer: {
            copyright: 'Copyright © 2009 - 2016 Combine Resource Institution<br> Copyright © 2022 Atas Langit'
        },
        editLink: {
            pattern: 'https://github.com/ataslangit/sistem-informasi-desa/edit/dev/docs/:path',
            text: "Ubah laman ini"
        },
        lastUpdated: true,
    }
}

function sidebarGuide() {
    return [
        {
            text: 'Selamat Datang',
            collapsible: true,
            items: [
                { text: 'Tentang SID', link: '/panduan/' },
                { text: 'Persyaratan Server', link: '/panduan/persyaratan-server' },
                { text: 'Memulai SID', link: '/panduan/mulai' },
                { text: 'Changelog', link: '/changelog/' },
            ]
        },
        {
            text: 'Migrasi/Upgrade',
            collapsible: true,
            items: [
                {
                    text: 'Migrasi dari v3.10-CRI',
                    link: '/panduan/migrasi-dari-v310-cri'
                }
            ]
        }
    ]
}

function sidebarChangelog() {
    return [
        {
            text: 'Log Perubahan',
            collapsible: false,
            items: [
                { text: 'v3.11.0 (terbaru)', link: '/changelog/3-11-0' },
                { text: 'v3.10-CRI', link: '/changelog/3-10-cri' },
            ]
        },
    ]
}
