import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import { viteStaticCopy } from "vite-plugin-static-copy";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/js/login.js",
            ],
            refresh: true,
        }),

        viteStaticCopy({
            targets: [
                { src: "node_modules/font-awesome/css/font-awesome.min.css", dest: "vendors/fontawesome/css" },
                { src: "node_modules/font-awesome/fonts", dest: "vendors/fontawesome" },
            ],
        }),
    ],
});
