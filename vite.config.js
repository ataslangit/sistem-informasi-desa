import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import { viteStaticCopy } from "vite-plugin-static-copy";
import path from 'path'

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/login.scss",
                "resources/scss/main.scss",
                "resources/js/app.js"
            ],
            refresh: true,
        }),

        viteStaticCopy({
            targets: [
                { src: "node_modules/datatables.net-bs5/css/dataTables.bootstrap5.min.css", dest: "plugins/datatables" },
                { src: "node_modules/datatables.net-bs5/js/dataTables.bootstrap5.min.js", dest: "plugins/datatables" },
                { src: "node_modules/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css", dest: "plugins/datatables" },
                { src: "node_modules/datatables.net-responsive-bs5/js/responsive.bootstrap5.min.js", dest: "plugins/datatables" },
                { src: "node_modules/datatables.net-responsive/js/dataTables.responsive.min.js", dest: "plugins/datatables" },
                { src: "node_modules/datatables.net/js/jquery.dataTables.min.js", dest: "plugins/datatables" },
                { src: "node_modules/jquery/dist/jquery.min.js", dest: "plugins/jquery" },
            ],
        }),
    ],
});
