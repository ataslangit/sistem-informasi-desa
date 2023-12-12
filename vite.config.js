import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/main.scss",
                "resources/js/main/app.js"
            ],
            refresh: true,
        }),
    ],
});
