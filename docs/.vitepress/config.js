import { createWriteStream } from "node:fs";
import { resolve } from "node:path";
import { SitemapStream } from "sitemap";

const links = [];

export default {
    title: "Sistem Informasi Desa",
    description: "Menuju desa digital",
    // base: "/sistem-informasi-desa/",
    lang: "id-ID",
    themeConfig: {
        nav: [
            { text: "Panduan", link: "/panduan/" },
            { text: "Changelog", link: "/changelog/" },
        ],
        socialLinks: [
            {
                icon: "github",
                link: "https://github.com/ataslangit/sistem-informasi-desa",
            },
        ],
        sidebar: {
            "/panduan/": sidebarGuide(),
            "/changelog/": sidebarChangelog(),
        },
        footer: {
            copyright:
                "Copyright © 2009 - 2016 Combine Resource Institution<br> Copyright © 2022 Atas Langit",
        },
        editLink: {
            pattern:
                "https://github.com/ataslangit/sistem-informasi-desa/edit/dev/docs/:path",
            text: "Perbarui laman ini",
        },
        lastUpdatedText: "Diperbarui pada:",
    },
    lastUpdated: true,

    transformHtml: (_, id, { pageData }) => {
        if (!/[\\/]404\.html$/.test(id))
            links.push({
                // you might need to change this if not using clean urls mode
                url: pageData.relativePath.replace(/((^|\/)index)?\.md$/, "$2"),
                lastmod: pageData.lastUpdated,
            });
    },

    buildEnd: ({ outDir }) => {
        const sitemap = new SitemapStream({
            hostname: "https://ataslangit.github.io/sistem-informasi-desa/",
        });
        const writeStream = createWriteStream(resolve(outDir, "sitemap.xml"));
        sitemap.pipe(writeStream);
        links.forEach((link) => sitemap.write(link));
        sitemap.end();
    },
};

function sidebarGuide() {
    return [
        {
            text: "Selamat Datang",
            collapsible: true,
            items: [
                { text: "Tentang SID", link: "/panduan/" },
                {
                    text: "Persyaratan Server",
                    link: "/panduan/persyaratan-server",
                },
                { text: "Memulai SID", link: "/panduan/mulai" },
                { text: "Changelog", link: "/changelog/" },
            ],
        },
        {
            text: "Migrasi/Upgrade",
            collapsible: true,
            items: [
                {
                    text: "v3.10-CRI ke v3.11.0",
                    link: "/panduan/migrasi-dari-v310-cri",
                },
            ],
        },
    ];
}

function sidebarChangelog() {
    return [
        {
            text: "Log Perubahan",
            collapsible: false,
            items: [
                { text: "dev (pengambangan)", link: "/changelog/dev" },
                { text: "v3.11.0 (terbaru)", link: "/changelog/3-11-0" },
                { text: "v3.10-CRI", link: "/changelog/3-10-cri" },
            ],
        },
    ];
}
