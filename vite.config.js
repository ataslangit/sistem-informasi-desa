import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
// import { viteStaticCopy } from "vite-plugin-static-copy";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/js/script.js",
                "resources/scss/bootstrap.scss",
            ],
            refresh: true,
        }),
        /*
        viteStaticCopy({
            targets: [
                { src: "node_modules/bootstrap/dist/js/bootstrap.bundle.min.*", dest: "vendors/bootstrap" },
            ],
        }),
        */
    ],
});
