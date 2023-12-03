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
                url: pageData.relativePath.replace(/\.md$/, ".html"),
                lastmod: pageData.lastUpdated,
            });
    },

    buildEnd: ({ outDir }) => {
        const sitemap = new SitemapStream({
            hostname: "https://ataslangit.github.io/",
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
                { text: "v4.0.0 ke v4.5.x", link: "/panduan/migrasi-400-450" },
                {
                    text: "v3.11.0 ke v4.0.0",
                    link: "/panduan/migrasi-dari-v3110",
                },
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
                // { text: "dev (pengembangan)", link: "/changelog/dev" },
                { text: "v4.5.4 (terbaru)", link: "/changelog/454" },
                { text: "v4.5.3", link: "/changelog/453" },
                { text: "v4.5.2", link: "/changelog/452" },
                { text: "v4.5.1", link: "/changelog/451" },
                { text: "v4.5.0", link: "/changelog/450" },
                { text: "v4.0.0", link: "/changelog/4-0-0" },
                { text: "v3.11.0", link: "/changelog/3-11-0" },
                { text: "v3.10-CRI", link: "/changelog/3-10-cri" },
            ],
        },
    ];
}
