export default {
    title: 'Sistem Informasi Desa',
    description: 'Menuju desa digital',
    base: '/sistem-informasi-desa/',
    themeConfig: {
        socialLinks: [
            { icon: 'github', link: 'https://github.com/ataslangit/sistem-informasi-desa' }
        ],
        nav: [
            { text: 'Tentang SID', link: '/tentang' },
            { text: 'Panduan', link: '/panduan/index' },
        ],
        footer: {
            copyright: 'Copyright © 2009 - 2016 Combine Resource Institution<br> Copyright © 2022 Atas Langit'
        },
        editLink: {
            pattern: 'https://github.com/ataslangit/sistem-informasi-desa/edit/dev/docs/:path',
            text: "Ubah laman ini"
        },
        lastUpdatedText: 'Updated Date'
    }
}
