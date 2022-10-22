export default {
    title: 'Sistem Informasi Desa',
    description: 'Menuju desa digital',
    base: '/sistem-informasi-desa/',
    lang: 'id-ID',
    themeConfig: {
        socialLinks: [
            { icon: 'github', link: 'https://github.com/ataslangit/sistem-informasi-desa' }
        ],
        nav: [
            { text: 'Panduan', link: '/panduan/' },
        ],
        sidebar: {
            '/panduan/': sidebarGuide()
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
